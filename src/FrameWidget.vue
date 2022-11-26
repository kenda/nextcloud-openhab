<template>
	<div class="frame" v-if="config.widgets && config.widgets.length">
		<h2 v-if="config.label">
			{{ config.label }}
		</h2>
		<Widget v-for="widget in config.widgets" :key="widget.widgetid" :config="widget" />
	</div>
</template>

<script>

export default {
	name: 'FrameWidget',
	props: {
		config: {
			type: Object,
			required: true,
		},
	},
	beforeCreate: function() {
		this.$options.components.Widget = require('./Widget.vue').default
	},
}
</script>

<style scoped>
.frame {
	border: 1px solid #ccc;
	box-shadow: 0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);
	color: #616161;
	margin: 10px;
	padding: 10px;
}

.frame h2 {
	font-weight: 500;
}
</style>
