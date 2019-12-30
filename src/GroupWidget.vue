<template>
	<div class="group-widget">
		<span class="group-header" @click="expand = !expand">
			<i v-if="config.widgets.length"
				class="toggle-icon"
				:class="{ 'icon-triangle-e': expand === false, 'icon-triangle-s': expand === true }" />{{ label }}
		</span>
		<div v-show="expand" v-if="config.widgets.length">
			<Widget v-for="widget in config.widgets" :key="widget.widgetid" :config="widget" />
		</div>
	</div>
</template>

<script>
import ItemService from './ItemService'

export default {
	name: 'GroupWidget',
	props: {
		config: {
			type: Object,
			required: true,
		},
	},
	data: function() {
		return {
			expand: false,
		}
	},
	computed: {
		label: function() {
			return ItemService.getLabel(this.config.label, this.config.title)
		},
		value: function() {
			return ItemService.getValue(this.config.label, this.config.item.state)
		},
	},
	beforeCreate: function() {
		this.$options.components.Widget = require('./Widget.vue').default
	},
}
</script>

<style scoped>
.group-widget {
  flex: 1;
}
.group-header {
  cursor: pointer;
}
.toggle-icon {
  display: inline-block;
  width: 12px;
}
</style>
