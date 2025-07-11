require('./bootstrap');
window.Vue = require('vue');
Vue.component('cap-nhat-doi-tac-truong', require('./components/hethong/capNhatDoiTacTruong.vue').default);
new Vue({
    el: '#app'
});
