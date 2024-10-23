import { createApp } from 'vue';
import Alpine from 'alpinejs';
import { createRouter, createWebHistory } from 'vue-router';
import TransactionsTable from './components/TransactionsTable.vue';
import Dashboard from './components/Dashboard.vue';

const routes = [
    { path: '/', component: Dashboard },
  { path: '/transactions', component: TransactionsTable },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

const app = createApp({});
app.use(router);
app.mount('#app');

window.Alpine = Alpine;

Alpine.start();
