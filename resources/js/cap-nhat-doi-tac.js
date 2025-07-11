require('./bootstrap');
window.Vue = require('vue');
Vue.component('cap-nhat-doi-tac', require('./components/hethong/CapNhatDoiTac').default);
new Vue({
    el: '#app'
});
