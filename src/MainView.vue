<template>
	<NcContent app-name="openhab">
		<NcAppNavigation>
			<ul>
				<NcAppNavigationItem v-for="sitemap in sitemaps"
					:key="sitemap.name"
					:name="sitemap.label"
					@click="open(sitemap.name)"
				/>
			</ul>
		</NcAppNavigation>
		<NcAppContent id="app-content">
			<div v-if="currentSitemap">
				<Widget v-for="widget in currentSitemap.homepage.widgets" :key="widget.widgetid" :config="widget" />
			</div>
			<div v-else id="emptycontent">
				<h2 v-if="sitemaps && sitemaps.length">
					{{ t('openhab', 'Select a sitemap') }}
				</h2>
				<h2 v-if="!sitemaps || !sitemaps.length">
					{{ t('openhab', 'No sitemaps found. Check your config or create a sitemap.') }}
				</h2>
			</div>
		</NcAppContent>
	</NcContent>
</template>

<script>
import axios from '@nextcloud/axios'
import { showError } from '@nextcloud/dialogs'
import { generateUrl } from '@nextcloud/router'
import {
	NcAppContent,
	NcAppNavigation,
	NcAppNavigationItem,
	NcContent,
} from '@nextcloud/vue'

import Widget from './Widget.vue'

export default {
	name: 'MainView',
	components: {
		NcAppContent,
		NcAppNavigation,
		NcAppNavigationItem,
		NcContent,
		Widget,
	},
	data() {
		return {
			currentSitemap: null,
			request: null,
			sitemaps: [],
		}
	},
	async mounted() {
		if (this.$route.params.sitemap) {
			this.load(this.$route.params.sitemap)
		}

		try {
			const response = await axios.get(generateUrl('/apps/openhab/sitemaps'))
			this.sitemaps = response.data
		} catch (e) {
			console.error(e)
			showError(t('openhab', 'Could not fetch sitemaps'))
		}
		this.loading = false
	},
	async created() {
		try {
			const response = await axios.get(generateUrl('/apps/openhab/settings'))
			this.settings = response.data
		} catch (e) {
			showError(t('openhab', 'Failed to load settings'))
			throw e
		}
	},
	beforeDestroy() {
		clearInterval(this.request)
	},
	methods: {
		open(sitemap) {
			this.$router.push({ name: 'details', params: { sitemap } })

			this.load(sitemap)
		},
		load(sitemap) {
			if (this.request) {
				clearInterval(this.request)
			}
			const fetchData = async () => {
				const response = await axios.get(generateUrl('/apps/openhab/sitemaps/' + sitemap))
				this.currentSitemap = response.data
			}

			const interval = this.settings['server.interval'] ? this.settings['server.interval'] * 1000 : 300000 // 5 minutes
			this.request = setInterval(fetchData, interval)
			fetchData()
		},
	},
}
</script>
<style scoped>
	#app-content > div {
		width: 100%;
		padding: 5px;
		padding-left: 48px;
		display: flex;
		flex-grow: 1;
		flex-wrap: wrap;
	}

	#emptycontent {
		justify-content: center;
	}
</style>
