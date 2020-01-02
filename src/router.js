import Vue from 'vue'
import Router from 'vue-router'
import MainView from './MainView'
import { generateUrl } from 'nextcloud-router'

Vue.use(Router)

export default new Router({
	base: generateUrl('/apps/openhab'),
	linkActiveClass: 'active',
	routes: [
		{
			path: '/',
			name: 'overview',
			component: MainView,
		},
		{
			path: '/sitemaps/:sitemap',
			name: 'details',
			component: MainView,
		},
	],
})
