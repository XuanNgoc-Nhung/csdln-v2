require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-dan-toc', require('./components/danhmuc/DanToc').default);
new Vue({
    el: '#app'
});
