<template>
	<div class="entry">
		<span>{{ label }}</span>
		<span class="value" :style="{ color: config.valuecolor }">{{ value }}</span>
	</div>
</template>

<script>
import ItemService from './ItemService.js'

export default {
	name: 'TextWidget',
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
			return ItemService.getValue(this.config.label, this.config.item ? this.config.item.state : '')
		},
	},
}
</script>
