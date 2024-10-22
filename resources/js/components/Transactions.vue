<template>
    <div>
      <h1>Управление финансами</h1>

      <!-- Карточка с кнопкой "Посмотреть" -->
    <div class="col-md-6">
      <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
          <div class="d-flex align-items-center mb-3">
            <span class="me-3" style="font-size: 2rem;">&#x1F4C8;</span>
            <h5 class="card-title mb-0">Транзакции</h5>
          </div>
          <p class="card-text">Просмотр транзакций</p>
          <router-link to="/transactions" class="btn btn-outline-primary">Посмотреть</router-link> <!-- Ссылка на страницу транзакций -->
        </div>
      </div>
    </div>
  
      <!-- Фильтр по периоду -->
      <div class="mb-4">
        <label>Начало периода:</label>
        <input type="date" v-model="filters.start_date" />
        <label>Конец периода:</label>
        <input type="date" v-model="filters.end_date" />
        <button @click="getTransactions">Фильтр</button>
      </div>

      
  
      <!-- Суммы доходов и расходов -->
      <div class="mb-4">
        <h3>Суммы:</h3>
        <p>Доходы: {{ totalIncome }}</p>
        <p>Расходы: {{ totalExpense }}</p>
      </div>
  
      <!-- Список транзакций -->
      <table class="table">
        <thead>
          <tr>
            <th>Категория</th>
            <th>Сумма</th>
            <th>Дата</th>
            <th>Описание</th>
            <th>Действия</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="transaction in transactions" :key="transaction.id">
            <td>{{ transaction.category }}</td>
            <td>{{ transaction.amount }}</td>
            <td>{{ transaction.transaction_date }}</td>
            <td>{{ transaction.description }}</td>
            <td>
              <button @click="editTransaction(transaction)">Редактировать</button>
              <button @click="deleteTransaction(transaction.id)">Удалить</button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Добавление новой транзакции -->
      <div>
        <h3>Добавить транзакцию</h3>
        <form @submit.prevent="saveTransaction">
          <div>
            <label>Категория:</label>
            <select v-model="form.category" required>
              <option value="доход">Доход</option>
              <option value="расход">Расход</option>
            </select>
          </div>
          <div>
            <label>Сумма:</label>
            <input type="number" v-model="form.amount" required />
          </div>
          <div>
            <label>Дата:</label>
            <input type="date" v-model="form.transaction_date" required />
          </div>
          <div>
            <label>Описание:</label>
            <input type="text" v-model="form.description" />
          </div>
          <button type="submit">Сохранить</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        transactions: [],
        totalIncome: 0,
        totalExpense: 0,
        filters: {
          start_date: "",
          end_date: "",
        },
        form: {
          category: "доход",
          amount: 0,
          description: "",
          transaction_date: "",
        },
      };
    },
    methods: {
      getTransactions() {
        axios
          .get("/api/transactions", { params: this.filters })
          .then((response) => {
            this.transactions = response.data.transactions;
            this.totalIncome = response.data.totalIncome;
            this.totalExpense = response.data.totalExpense;
          });
      },
      saveTransaction() {
        axios.post("/api/transactions", this.form).then((response) => {
          this.getTransactions(); // Обновляем список после добавления
          this.resetForm();
        });
      },
      editTransaction(transaction) {
        this.form = { ...transaction }; // Загружаем данные для редактирования
      },
      deleteTransaction(id) {
        axios.delete(`/api/transactions/${id}`).then((response) => {
          this.getTransactions(); // Обновляем список после удаления
        });
      },
      resetForm() {
        this.form = {
          category: "доход",
          amount: 0,
          description: "",
          transaction_date: "",
        };
      },
    },
    mounted() {
      this.getTransactions();
    },
  };
  </script>
  