<template>
	<div v-if="config.item" class="entry" :title="config.item.name">
		<span>{{ label }}</span>
		<span class="value" :style="{ color: config.valuecolor }">{{ value }}</span>
	</div>
</template>

<script>
import ItemService from './ItemService.js'

export default {
	name: 'SwitchWidget',
	props: {
		config: {
			type: Object,
			required: true,
		},
	},
	computed: {
		label() {
			return ItemService.getLabel(this.config.label)
		},
		value() {
			return ItemService.getValue(this.config.label, this.config.item.state)
		},
	},
}
</script>
