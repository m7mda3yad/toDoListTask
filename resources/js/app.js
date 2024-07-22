require('./bootstrap');

import Vue from 'vue';
import TaskManager from './components/TaskManager.vue';

new Vue({
  render: h => h(TaskManager),
}).$mount('#app');


