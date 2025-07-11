require('./bootstrap');
window.Vue = require('vue');
Vue.component('sao-luu-du-lieu', require('./components/hethong/SaoLuuDuLieu').default);
new Vue({
    el: '#app'
});
