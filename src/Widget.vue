<template>
	<div>
		<div v-if="!config.linkedPage">
			<FrameWidget v-if="config.type === 'Frame'" :config="config" />
			<TextWidget v-if="config.type === 'Text'" :config="config" class="entry-wrapper" />
			<SwitchWidget v-if="config.type === 'Switch'" :config="config" class="entry-wrapper" />
			<GroupWidget v-if="config.type === 'Group'" :config="config" class="entry-wrapper" />
		</div>
		<div v-if="config.linkedPage" class="entry-wrapper">
			<GroupWidget :config="config.linkedPage" />
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
}
</script>

<style>
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
</style>
