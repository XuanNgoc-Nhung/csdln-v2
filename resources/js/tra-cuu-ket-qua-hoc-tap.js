require('./bootstrap');
window.Vue = require('vue');
Vue.component('tra-cuu-ket-qua-hoc-tap', require('./components/tracuu/TraCuuKetQuaHocTap').default);
new Vue({
    el: '#app'
});
