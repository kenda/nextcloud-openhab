import Vue from 'vue'
import DashboardWidget from './DashboardWidget'

Vue.prototype.t = t
Vue.prototype.n = n
Vue.prototype.OCA = OCA

document.addEventListener('DOMContentLoaded', () => {
    OCA.Dashboard.register('openhab', (el) => {
        const View = Vue.extend(DashboardWidget)
        const vm = new View({
            propsData: {},
        }).$mount(el)
    })
})
