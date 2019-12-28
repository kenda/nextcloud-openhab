<template>
	<div v-if="config.item" class="entry" :title="config.item.name">
		<span>{{ config.label }}</span>
		<span class="value" :style="{ color: config.valuecolor }">{{ config.item.state }}</span>
	</div>
</template>

<script>

export default {
	name: 'SwitchWidget',
	props: {
		config: {
			type: Object,
			required: true,
		},
	},
}
</script>
