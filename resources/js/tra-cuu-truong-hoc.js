require('./bootstrap');
window.Vue = require('vue');
Vue.component('tra-cuu-truong-hoc', require('./components/tracuu/truongHoc/index').default);
new Vue({
    el: '#app'
});
