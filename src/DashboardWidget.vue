<template>
	<div id="dashboard-openhab">
		<select @change="open">
			<option :value="null">{{t('openhab', 'Select a sitemap')}}</option>
			<option
				v-for="sitemap in sitemaps"
				:selected="currentSitemap && currentSitemap.name === sitemap.name"
				:value="sitemap.name">
				{{sitemap.label}}
			</option>
		</select>
		<div v-if="currentSitemap">
			<Widget v-for="widget in currentSitemap.homepage.widgets" :key="widget.widgetid" :config="widget" />
		</div>
		<div v-else>
			<p v-if="!sitemaps || !sitemaps.length">
				{{t('openhab', 'No sitemaps found. Check your config or create a sitemap.')}}
			</p>
		</div>
	</div>
</template>

<script>
	import axios from '@nextcloud/axios'
	import { showError } from '@nextcloud/dialogs'
	import { generateUrl } from '@nextcloud/router'
	import Widget from './Widget'

	export default {
		name: 'DashboardWidget',
		components: {
			Widget,
		},
		data: function() {
			return {
				currentSitemap: null,
				request: null,
				sitemaps: [],
			}
		},
		async mounted() {
			try {
				const response = await axios.get(generateUrl('/apps/openhab/sitemaps'))
				this.sitemaps = response.data
			} catch (e) {
				console.error(e)
				showError(t('openhab', 'Could not fetch sitemaps'))
			}

			const lastSitemap = localStorage.getItem('ohv:dashboard:lastSitemap');
			if (lastSitemap) {
				this.load(lastSitemap);
			}
		},
		async created() {
		    try {
				const response = await axios.get(generateUrl('/apps/openhab/settings'))
				this.settings = response.data;
    		} catch (e) {
    			showError(t('openhab', 'Failed to load settings'))
			    throw e
		    }
	    },
		beforeDestroy() {
		    clearInterval(this.request)
	    },
		methods: {
			open(ev) {
				const {value} = ev.target;
				if (value) {
					this.load(value);
					localStorage.setItem('ohv:dashboard:lastSitemap', value);
				}
			},
			load(sitemap) {
				if (this.request) {
    				clearInterval(this.request);
    			}
				const fetchData = async() => {
					const response = await axios.get(generateUrl('/apps/openhab/sitemaps/' + sitemap))
					this.currentSitemap = response.data
				}

                const interval = this.settings['server.interval'] ? this.settings['server.interval'] * 1000 : 300000; // 5 minutes
                this.request = setInterval(fetchData, interval)
				fetchData()
			},
		},
	}
</script>
<style scoped>
	#dashboard-openhab {
		align-items: center;
		display: flex;
		flex-direction: column;
		height: 100%;
		overflow-y: auto;
	}
</style>
