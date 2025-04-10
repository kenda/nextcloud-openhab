<template>
	<div class="chart-widget">
		<canvas :id="config.item.name" width="300" height="200" />
	</div>
</template>

<script>
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'
import { Chart, Colors, CategoryScale, LineController, LineElement, PointElement, Legend, LinearScale, TimeScale, Title } from 'chart.js'
import 'chartjs-adapter-date-fns'

import ItemService from './ItemService'

export default {
	name: 'ChartWidget',
	props: {
		config: {
			type: Object,
			required: true,
		},
	},
	data() {
		return {
			data: null,
		}
	},
	computed: {
		label() {
			return ItemService.getLabel(this.config.label)
		},
	},
	async mounted() {
		if (this.config.item.type === 'Group') {
			const itemDetails = await axios.get(generateUrl('/apps/openhab/items/') + this.config.item.name)
			const persistencePromises = itemDetails.data.members.map(groupMember => axios.get(generateUrl('/apps/openhab/persistence/') + groupMember.name))
			const persistenceData = await Promise.all(persistencePromises)
			const datasets = persistenceData.map(persistenceItem => {
				const data = persistenceItem.data.data.map(item => ({ x: item.time, y: item.state }))

				return {
					data,
					label: persistenceItem.data.name,
					fill: false,
					pointRadius: 0,
					borderWidth: 2,
				}
			})
			this.createChart(this.config.item.name, itemDetails.data.label, datasets)
		} else {
			const response = await axios.get(generateUrl('/apps/openhab/persistence/') + this.config.item.name)
			const data = response.data.data.map(item => ({ x: item.time, y: item.state }))
			this.createChart(this.config.item.name, this.label, [{
		  data,
		  label: this.label,
		  fill: false,
		  pointRadius: 0,
		  borderWidth: 2,
			}])
		}
	},
	methods: {
		createChart(chartId, label, datasets) {
			Chart.register(Colors, CategoryScale, Legend, LineController, LineElement, PointElement, LinearScale, TimeScale, Title)

			const ctx = document.getElementById(chartId)
			const chart = new Chart(ctx, {
				type: 'line',
				data: {
					datasets,
				},
				options: {
					scales: {
						x: {
							type: 'time',
							time: {
								unit: 'hour',
							},
							grid: {
							  display: false,
							},
						},
					},
					plugins: {
					  legend: {
					    display: false,
					  },
					  title: {
					  display: true,
					  text: label || chartId,
						},
				  },
					tooltips: {
						intersect: false,
						mode: 'index',
					},
				},
			})
			return chart
		},
	},
}
</script>

<style>
.chart-widget {
  max-width: 300px;
}
</style>
