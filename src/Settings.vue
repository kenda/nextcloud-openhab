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
import axios from '@nextcloud/axios';
import { showError } from '@nextcloud/dialogs'
import { generateUrl } from '@nextcloud/router'

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
			timeout: null,
		}
	},
	async created() {
		try {
			const response = await axios.get(generateUrl('/apps/openhab/settings'))
			this.settings = response.data;

			// set initial value of server mode
			if (!this.settings['server.type']) {
				this.settings['server.type'] = 'custom';
				this.setValue('server.type', 'custom');
			}
		} catch (e) {
			showError(this.t('openhab', 'Failed to load settings'))
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
			try {
				await axios.put(generateUrl('/apps/openhab/settings'), this.settings)
				this.success = true;
			} catch (e) {
				showError(this.t('openhab', 'Failed to save settings'))
				throw e
			}
			this.loading = false
			setTimeout(() => { this.success = false }, 3000)
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
