<template>
	<div class="chart-widget">
		<canvas :id="config.item.name" width="300" height="200" />
	</div>
</template>

<script>

import axios from '@nextcloud/axios'
import Chart from 'chart.js'

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
		const response = await axios.get(OC.generateUrl('/apps/openhab/persistence/') + this.config.item.name)
		const data = response.data.data.map(item => ({ t: item.time, y: item.state }))
		this.createChart(this.config.item.name, data)
	},
	methods: {
		createChart(chartId, data) {
			const ctx = document.getElementById(chartId)
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
						xAxes: [{
							type: 'time',
							time: {
								unit: 'hour',
							},
							gridLines: {
								display: false,
							},
						}],
						responsive: false,
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
