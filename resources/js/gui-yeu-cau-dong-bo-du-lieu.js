require('./bootstrap');
window.Vue = require('vue');
Vue.component('gui-yeu-cau-dong-bo-du-lieu', require('./components/quanlydongbo/GuiYeuCauDongBoDuLieu').default);
new Vue({
    el: '#app'
});
