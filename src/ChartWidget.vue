<template>
	<div class="chart-widget">
		<canvas :id="config.item.name" width="300" height="200" />
	</div>
</template>

<script>
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'
import { Chart, CategoryScale, LineController, LineElement, PointElement, Legend, LinearScale, TimeScale, Title } from 'chart.js'
import 'chartjs-adapter-date-fns';

import ItemService from './ItemService'

export default {
	name: 'ChartWidget',
	props: {
		config: {
			type: Object,
			required: true,
		},
	},
	data: function() {
		return {
			data: null,
		}
	},
	computed: {
		label: function() {
			return ItemService.getLabel(this.config.label)
		},
	},
	async mounted() {
		const response = await axios.get(generateUrl('/apps/openhab/persistence/') + this.config.item.name)
		const data = response.data.data.map(item => ({ x: item.time, y: item.state }))
		this.createChart(this.config.item.name, data)
	},
	methods: {
		createChart(chartId, data) {
			Chart.register(CategoryScale, Legend, LineController, LineElement, PointElement, LinearScale, TimeScale, Title);

			const ctx = document.getElementById(chartId)
console.log(data);
			const chart = new Chart(ctx, {
				type: 'line',
				data: {
					datasets: [{
						data,
						label: this.label,
						fill: false,
						pointRadius: 0,
						borderColor: '#0082c9',
						borderWidth: 2,
					}],
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
