require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
import Print from 'vue-print-nb'
import vuetify from './vuetify'
import VueHtmlToPaper from 'vue-html-to-paper';


const vuetifyCss = require('vuetify/dist/vuetify.min.css')
const options_ = {
    name: '_blank',
    specs: [
        'fullscreen=no',
        'titlebar=no',
        'scrollbars=yes'
    ],
    styles: [
        vuetifyCss
    ]
}


Vue.use(VueRouter);
Vue.use(Print);
Vue.use(VueHtmlToPaper, options_);

const routes = [
	{path: '/app', component: require('./pages/Sell.vue').default},
	{path: '/sell', component: require('./pages/Sell.vue').default},
	{path: '/stocks', component: require('./pages/Stocks.vue').default},
	{path: '/stocks-out', component: require('./pages/OutStcoks.vue').default},
	{path: '/stocks-in', component: require('./pages/InStock.vue').default},
	{path: '/add-stock', component: require('./pages/AddToStock.vue').default},
	{path: '/workers', component: require('./pages/Workers.vue').default},
	{path: '/report', component: require('./pages/Report.vue').default},
	{path: '/profile', component: require('./pages/Profile.vue').default},
	{path: '/overall-report', component: require('./pages/OverallReport.vue').default},
	{path: '/item/show/:id', component: require('./pages/Stock.vue').default},
]


Vue.component('cart', require('./components/CartComponent.vue').default);
Vue.component('add-worker', require('./components/AddWorkerComponent.vue').default);

const router = new VueRouter({
	routes: routes,
	mode: "history"
})

const app = new Vue({
    vuetify,
	router
}).$mount('#app')



