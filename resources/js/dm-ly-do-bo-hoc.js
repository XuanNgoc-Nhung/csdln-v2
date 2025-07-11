require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-ly-do-bo-hoc', require('./components/danhmuc/LyDoBoHoc').default);
new Vue({
    el: '#app'
});
