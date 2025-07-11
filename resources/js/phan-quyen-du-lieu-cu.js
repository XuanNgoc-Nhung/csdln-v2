require('./bootstrap');
window.Vue = require('vue');
Vue.component('phan-quyen-du-lieu-cu', require('./components/quanlydongbo/pq_du_lieu_cu/PhanQuyenDuLieuCu').default);
import store from './components/quanlydongbo/pq_du_lieu_cu/pq_du_lieu_cu_store';
new Vue({
    el: '#app', store
});
