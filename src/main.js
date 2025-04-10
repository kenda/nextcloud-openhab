import Vue from 'vue'
import App from './App.vue'
import router from './router.js'

Vue.prototype.t = t
Vue.prototype.n = n

export default new Vue({
	el: '#content',
	router,
	render: h => h(App),
})
