require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-to-thon', require('./components/danhmuc/ToThon/Index').default);
new Vue({
    el: '#app'
});
