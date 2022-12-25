<template>
	<div id="openhab" class="section">
		<h2 class="d-flex">
			Openhab Viewer&nbsp;
			<figure v-if="loading" class="icon-loading loading" />
			<figure v-if="!loading && success" class="icon-checkmark success" />
		</h2>

		<h3>{{t('openhab', 'Server settings')}}</h3>
		<fieldset class="d-flex">
			<label class="d-flex"><input type="radio" v-model="settings['server.type']" value="myopenhab" @change="onChange" />myopenhab.org</label>&nbsp;
			<label class="d-flex"><input type="radio" v-model="settings['server.type']" value="custom" @change="onChange" />{{t('openhab', 'custom')}}</label>
		</fieldset>

		<fieldset v-if="settings['server.type'] === 'custom'">
			<label class="d-flex">{{t('openhab', 'Server URL')}}:&nbsp;
				<input v-model="settings['server.url']"
					type="text"
					@blur="onChange">
			</label>
		</fieldset>

		<fieldset v-if="settings['server.type'] === 'custom'">
			<label class="d-flex">{{t('openhab', 'Ignore SSL issues?')}}&nbsp;
				<input v-model="settings['server.ignoreSSL']"
					type="checkbox"
					@change="onChange">
			</label>
		</fieldset>

		<fieldset v-if="settings['server.type'] === 'myopenhab'">
			<label class="d-flex">{{t('openhab', 'Username')}}:&nbsp;
				<input v-model="settings['server.username']"
					type="text"
					@blur="onChange">
			</label>
		</fieldset>

		<fieldset v-if="settings['server.type'] === 'myopenhab'">
			<label class="d-flex">{{t('openhab', 'Password')}}:&nbsp;
				<input v-model="settings['server.password']"
					type="password"
					@blur="onChange">
			</label>
		</fieldset>

		<h3>{{t('openhab', 'Additional settings')}}</h3>
		<fieldset>
			<label class="d-flex">{{t('openhab', 'Refresh interval')}}:&nbsp;
				<input v-model="settings['server.interval']"
					type="number"
					@blur="onChange">
				{{t('openhab', 'seconds')}}
			</label>
		</fieldset>
	</div>
</template>

<script>
import { loadSettings } from './utils/settings';

const SETTINGS = [
	'server.type',
	'server.url',
	'server.username',
	'server.password',
	'server.ignoreSSL',
	'server.interval',
]

export default {
	name: 'Settings',
	data: function() {
		return {
			settings: SETTINGS.reduce((obj, key) => ({ ...obj, [key]: '' }), {}),
			loading: false,
			success: false,
			error: '',
			timeout: null,
		}
	},
	watch: {
		error(error) {
			if (!error) return
			OC.Notification.showTemporary(error)
		},
	},
	async created() {
		try {
			this.settings = await loadSettings(SETTINGS);

			// set initial value of server mode
			if (!this.settings['server.type']) {
				this.settings['server.type'] = 'custom';
				this.setValue('server.type', 'custom');
			}
		} catch (e) {
			this.error = this.t('openhab', 'Failed to load settings')
			throw e
		}
	},
	methods: {
		onChange() {
			if (this.timeout) {
				clearTimeout(this.timeout)
			}
			this.timeout = setTimeout(() => {
				this.submit()
			}, 1000)
		},
		async submit() {
			this.loading = true
			for (const setting in this.settings) {
				this.setValue(setting, this.settings[setting])
			}
			this.loading = false
			this.success = true
			setTimeout(() => { this.success = false }, 3000)
		},
		async setValue(setting, value) {
			try {
				await new Promise((resolve, reject) => {
					OCP.AppConfig.setValue('openhab', setting, value, {
						success: resolve,
						error: reject,
					})}
				)
			} catch (e) {
				this.error = this.t('openhab', 'Failed to save settings')
				throw e
			}
		},
	},
}
</script>
<style scoped>
	.d-flex {
		display: flex;
		align-items: center;
	}

	input[type='text'], input[type='password'] {
		width: 250px;
	}

	h3 {
		font-weight: bold;
	}
</style>
