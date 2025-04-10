<template>
	<div class="entry">
		<span class="label">{{ label }}</span>
		<span class="value">
			<input class="action-input__input"
				type="color"
				:value="color"
				disabled="disabled"
			>
			{{ state }}
		</span>
	</div>
</template>

<script>
import ItemService from './ItemService.js'
import { HSLToRGB, RGBToHex } from './utils/colors.js'

export default {
	name: 'ColorpickerWidget',
	props: {
		config: {
			type: Object,
			required: true,
		},
	},
	computed: {
		state() {
			if (this.config.item) {
				const hsl = this.config.item.state.split(',')
				return +hsl[2] === 0 ? 'OFF' : 'ON'
			} else {
				return 'OFF'
			}
		},
		color() {
			return this.config.item ? RGBToHex(...HSLToRGB(...this.config.item.state.split(','))) : '#000000'
		},
		label() {
			return ItemService.getLabel(this.config.label)
		},
		value() {
			return ItemService.getValue(this.config.label, this.config.item ? this.config.item.state : '')
		},
	},
}
</script>
<style scoped>
	input[type=color]:disabled {
		cursor: not-allowed;
		opacity: unset;
	}
</style>
