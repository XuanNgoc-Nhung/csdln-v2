require('./bootstrap');
window.Vue = require('vue');
Vue.component('quan-ly-nguoi-dung', require('./components/hethong/nguoiDung/index').default);
new Vue({
    el: '#app'
});
