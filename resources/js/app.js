import { createApp } from 'vue';
import './bootstrap';
import Alpine from 'alpinejs';


import { createRouter, createWebHistory } from 'vue-router'; 
import Transactions from './components/Transactions.vue';
import TransactionsPage from './components/TransactionsPage.vue';

const routes = [
    { path: '/', component: Transactions },
    { path: '/transactions', component: TransactionsPage }, 
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
