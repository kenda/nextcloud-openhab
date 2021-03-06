<template>
	<div id="content">
		<AppNavigation>
			<ul>
				<AppNavigationItem
					v-for="sitemap in sitemaps"
					:key="sitemap.name"
					:item="navEntry(sitemap)" />
			</ul>
		</AppNavigation>
		<AppContent>
			<div v-if="currentSitemap">
				<Widget v-for="widget in currentSitemap.homepage.widgets" :key="widget.widgetid" :config="widget" />
			</div>
			<div v-else id="emptycontent">
				<h2 v-if="sitemaps.length">
					Select a sitemap
				</h2>
				<h2 v-if="!sitemaps || !sitemaps.length">
					No sitemaps found. Check your config or create a sitemap.
				</h2>
			</div>
		</AppContent>
	</div>
</template>

<script>
import {
	AppContent,
	AppNavigation,
	AppNavigationItem,
} from 'nextcloud-vue'

import axios from '@nextcloud/axios'

import Widget from './Widget'

export default {
	name: 'MainView',
	components: {
		AppContent,
		AppNavigation,
		AppNavigationItem,
		Widget,
	},
	data: function() {
		return {
			currentSitemap: null,
			request: null,
			sitemaps: [],
		}
	},
	computed: {
		navEntry() {
			return (sitemap) => {
				return {
					text: sitemap.label,
					action: () => this.open(sitemap.name),
				}
			}
		},
	},
	async mounted() {
		if (this.$route.params.sitemap) {
			this.load(this.$route.params.sitemap)
		}

		try {
			const response = await axios.get(OC.generateUrl('/apps/openhab/sitemaps'))
			this.sitemaps = response.data
		} catch (e) {
			console.error(e)
			OCP.Toast.error(t('openhab', 'Could not fetch sitemaps'))
		}
		this.loading = false
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
			const fetchData = async() => {
				const response = await axios.get(OC.generateUrl('/apps/openhab/sitemaps/' + sitemap))
				this.currentSitemap = response.data
			}

			this.request = setInterval(fetchData, 300000) // 5 minutes
			fetchData()
		},
	},
}
</script>
<style scoped>
	#app-content > div {
		width: 100%;
		padding: 5px;
		display: flex;
		flex-grow: 1;
		flex-wrap: wrap;
	}

	#emptycontent {
		justify-content: center;
	}
</style>
