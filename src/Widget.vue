<template>
	<div>
		<div v-if="!config.linkedPage">
			<FrameWidget v-if="config.type === 'Frame'" :config="config" />
			<TextWidget v-if="config.type === 'Text'" :config="config" class="entry-wrapper" />
			<SwitchWidget v-if="config.type === 'Switch'" :config="config" class="entry-wrapper" />
			<!--<GroupWidget v-if="config.type === 'Group'" :config="config" class="entry-wrapper" />-->
		</div>
		<div v-if="config.linkedPage" class="entry-wrapper group-wrapper">
			<div @click="expand = !expand" class="group-header">
				<i v-if="config.linkedPage.widgets.length"
					class="toggle-icon"
					:class="{ 'icon-triangle-e': expand === false, 'icon-triangle-s': expand === true }" />
				<TextWidget v-if="config.type === 'Text'" :config="config" />
				<SwitchWidget v-if="config.type === 'Switch'" :config="config" />
				<span v-else>{{ config.label }}</span>
			</div>
			<div v-show="expand" v-if="config.linkedPage.widgets.length">
				<Widget v-for="widget in config.linkedPage.widgets" :key="widget.widgetid" :config="widget" />
			</div>
		</div>
	</div>
</template>

<script>
import FrameWidget from './FrameWidget'
import GroupWidget from './GroupWidget'
import SwitchWidget from './SwitchWidget'
import TextWidget from './TextWidget'

export default {
	name: 'Widget',
	components: {
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
	data: function() {
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

.entry .value {
	font-weight: bold;
	margin-left: 30px;
}
.toggle-icon {
  display: inline-block;
  width: 12px;
}
</style>
