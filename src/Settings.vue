<template>
	<div id="openhab" class="section">
		<h2 class="d-flex">
			Openhab Viewer&nbsp;
			<figure v-if="loading" class="icon-loading loading" />
			<figure v-if="!loading && success" class="icon-checkmark success" />
		</h2>

		<fieldset>
			<label class="d-flex">{{t('openhab', 'Server URL')}}&nbsp;
				<input v-model="settings['server.url']"
					type="text"
					@input="onChange">
			</label>
		</fieldset>

		<fieldset>
			<label class="d-flex">{{t('openhab', 'Ignore SSL issues?')}}&nbsp;
				<input v-model="settings['server.ignoreSSL']"
					type="checkbox"
					@input="onChange">
			</label>
		</fieldset>
	</div>
</template>

<script>
const SETTINGS = [
	'server.url',
	'server.ignoreSSL',
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
		settings: 'submit',
		error(error) {
			if (!error) return
			OC.Notification.showTemporary(error)
		},
	},
	async created() {
		try {
			for (const setting of SETTINGS) {
				this.settings[setting] = await this.getValue(setting)
				if (['true', 'false'].includes(this.settings[setting])) {
					this.settings[setting] = (this.settings[setting] === 'true')
				}
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
				await new Promise((resolve, reject) =>
					OCP.AppConfig.setValue('openhab', setting, value, {
						success: resolve,
						error: reject,
					})
				)
			} catch (e) {
				this.error = this.t('openhab', 'Failed to save settings')
				throw e
			}
		},
		async getValue(setting) {
			try {
				const resDocument = await new Promise((resolve, reject) =>
					OCP.AppConfig.getValue('openhab', setting, null, {
						success: resolve,
						error: reject,
					})
				)
				if (resDocument.querySelector('status').textContent !== 'ok') {
					this.error = this.t('openhab', 'Failed to load settings')
					console.error('Failed request', resDocument)
					return
				}
				const dataEl = resDocument.querySelector('data')
				return dataEl.firstElementChild.textContent
			} catch (e) {
				this.error = this.t('openhab', 'Failed to load settings')
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

	input[type='text'] {
		width: 250px;
	}
</style>
