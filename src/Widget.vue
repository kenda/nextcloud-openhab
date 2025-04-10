<template>
	<div>
		<div v-if="!config.linkedPage">
			<FrameWidget v-if="config.type === 'Frame'" :config="config" />
			<TextWidget v-if="config.type === 'Text'" :config="config" class="entry-wrapper" />
			<SwitchWidget v-if="config.type === 'Switch'" :config="config" class="entry-wrapper" />
			<ChartWidget v-if="config.type === 'Chart'" :config="config" class="entry-wrapper" />
			<ColorpickerWidget v-if="config.type === 'Colorpicker'" :config="config" class="entry-wrapper" />
			<GroupWidget v-if="config.type === 'Group'" :config="config" class="entry-wrapper" />
		</div>
		<div v-if="config.linkedPage" class="entry-wrapper group-wrapper">
			<div class="group-header" @click="expand = !expand">
				<i v-if="config.linkedPage.widgets.length"
					class="toggle-icon"
					:class="{ 'icon-triangle-e': expand === false, 'icon-triangle-s': expand === true }"
				/>
				<TextWidget v-if="config.type === 'Text'" :config="config" />
				<SwitchWidget v-else-if="config.type === 'Switch'" :config="config" />
				<GroupWidget v-else-if="config.type === 'Group'" :config="config" />
				<span v-else>{{ config.label }}</span>
			</div>
			<div v-if="expand && config.linkedPage.widgets.length">
				<Widget v-for="widget in config.linkedPage.widgets" :key="widget.widgetid" :config="widget" />
			</div>
		</div>
	</div>
</template>

<script>
import ChartWidget from './ChartWidget.vue'
import ColorpickerWidget from './ColorpickerWidget.vue'
import FrameWidget from './FrameWidget.vue'
import GroupWidget from './GroupWidget.vue'
import SwitchWidget from './SwitchWidget.vue'
import TextWidget from './TextWidget.vue'

export default {
	name: 'Widget',
	components: {
		ChartWidget,
		ColorpickerWidget,
		FrameWidget,
		GroupWidget,
		SwitchWidget,
		TextWidget,
	},
	props: {
		config: {
			type: Object,
			required: true,
		},
	},
	data() {
		return {
			expand: false,
		}
	},
}
</script>

<style>
.group-wrapper {
	display: flex;
	flex-direction: column;
}

.group-header {
	cursor: pointer;
	display: flex;
}

.entry-wrapper {
	border-bottom: 1px solid #eee;
	display: flex;
	padding: 10px;
}

.entry {
	display: flex;
	flex: 1;
	justify-content: space-between;
}

.entry .label {
	display: flex;
	align-items: center;
}

.entry .value {
	display: flex;
	align-items: center;
	font-weight: bold;
	margin-left: 30px;
}

.toggle-icon {
	display: inline-block;
	width: 12px;
}
</style>
