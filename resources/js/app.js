require('./bootstrap');

window.Vue = require('vue');

Vue.component('task-management', require('./components/Task.vue').default);
Vue.component('task-list', require('./components/List.vue').default);

const app = new Vue({
    el: '#app',
});
