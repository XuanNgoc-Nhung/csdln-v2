require('./bootstrap');
window.Vue = require('vue');
Vue.component('dashboard-school', require('./components/bieudo/DashBoardSchool').default);
new Vue({
    el: '#app'
});
