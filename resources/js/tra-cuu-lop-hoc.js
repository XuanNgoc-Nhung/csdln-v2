require('./bootstrap');
window.Vue = require('vue');
Vue.component('tra-cuu-lop-hoc', require('./components/tracuu/lopHoc/index').default);
new Vue({
    el: '#app'
});
