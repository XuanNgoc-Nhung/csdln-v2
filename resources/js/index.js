require('./bootstrap');
window.Vue = require('vue');
Vue.component('index', require('./components/Index').default);
new Vue({
    el: '#app'
});
