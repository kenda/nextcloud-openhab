<template>
	<div>
		<FrameWidget v-if="config.type === 'Frame'" :config="config" />
		<TextWidget v-if="config.type === 'Text'" :config="config" class="entry" />
		<SwitchWidget v-if="config.type === 'Switch'" :config="config" class="entry" />
		<!--<Widget v-if="config.type === 'Group'" :config="config" />-->
	</div>
</template>

<script>
import FrameWidget from './FrameWidget'
import SwitchWidget from './SwitchWidget'
import TextWidget from './TextWidget'

export default {
	name: 'Widget',
	components: {
		FrameWidget,
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
.entry {
	border-bottom: 1px solid #eee;
	display: flex;
	justify-content: space-between;
	padding: 10px;
}

.entry .value {
	font-weight: bold;
	margin-left: 30px;
}
</style>
