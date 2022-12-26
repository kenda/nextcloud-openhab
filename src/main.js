import Vue from 'vue'
import App from './App'
import router from './router'

Vue.prototype.t = t
Vue.prototype.n = n

export default new Vue({
	el: '#content',
	router,
	render: h => h(App),
})
