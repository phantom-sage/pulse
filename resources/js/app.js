require('./bootstrap');

require('alpinejs');

window.Vue = require('vue');

Vue.component('search-medicine', require('./components/SearchMedicine.vue').default);

const app = new Vue({
    el: '#app'
});
