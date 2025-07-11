require('./../bootstrap');
window.Vue = require('vue');
Vue.component('ioc-bieu-do-can-bo', require('./../components/ioc/BieuDoCanBo').default);
new Vue({
    el: '#app'
});
