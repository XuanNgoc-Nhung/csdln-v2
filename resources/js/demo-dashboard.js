require('./bootstrap');
window.Vue = require('vue');
Vue.component('demo-dashboard', require('./components/bieudo/demo').default);
new Vue({
    el: '#app'
});
