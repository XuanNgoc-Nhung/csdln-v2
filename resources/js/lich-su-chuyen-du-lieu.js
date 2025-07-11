require('./bootstrap');
window.Vue = require('vue');
Vue.component('lich-su-chuyen-du-lieu', require('./components/quantrihethong/LichSuChuyenDuLieu/index').default);
import store from './components/quantrihethong/store';
new Vue({
    el: '#app',
    store
});
