<template>
    <div>
      <h1>Все транзакции</h1>
      <table class="table">
        <thead>
          <tr>
            <th>Категория</th>
            <th>Сумма</th>
            <th>Дата</th>
            <th>Описание</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="transaction in transactions" :key="transaction.id">
            <td>{{ transaction.category }}</td>
            <td>{{ transaction.amount }}</td>
            <td>{{ transaction.transaction_date }}</td>
            <td>{{ transaction.description }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        transactions: [], // Массив для хранения транзакций
      };
    },
    mounted() {
      this.getTransactions(); // Получаем данные при монтировании компонента
    },
    methods: {
      getTransactions() {
        // Запрашиваем данные с API
        axios.get('/api/transactions')
          .then(response => {
            console.log(1);
            this.transactions = response.data.transactions; // Сохраняем данные
          })
          .catch(error => {
            console.error('Ошибка при получении транзакций:', error);
          });
      }
    }
  };
  </script>
  