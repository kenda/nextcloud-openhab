import Vue from 'vue'
import Settings from './Settings.vue'

Vue.prototype.t = t
Vue.prototype.n = n

export default new Vue({
	el: '#openhab',
	render: h => h(Settings),
})
