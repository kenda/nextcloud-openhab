import Vue from 'vue'
import Settings from './Settings'

Vue.prototype.t = t
Vue.prototype.n = n
Vue.prototype.OC = OC
Vue.prototype.OCA = OCA

export default new Vue({
	el: '#openhab',
	render: h => h(Settings),
})
