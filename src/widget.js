import Vue from 'vue'
import DashboardWidget from './DashboardWidget.vue'

Vue.prototype.t = t
Vue.prototype.n = n
Vue.prototype.OCA = OCA

document.addEventListener('DOMContentLoaded', () => {
	OCA.Dashboard.register('openhab', (el) => {
		const View = Vue.extend(DashboardWidget)
		new View({
			propsData: {},
		}).$mount(el)
	})
})
