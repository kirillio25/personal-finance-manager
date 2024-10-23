<template>
    <div class="container py-4">
        <h1 class="text-center mb-4">Транзакции</h1>

        <button class="btn btn-primary mb-3" @click="goBack">Назад</button>

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <label for="period" class="form-label">Фильтр по периоду:</label>
                <input type="month" v-model="selectedPeriod" @change="filterTransactions" class="form-control w-auto">
            </div>
            <div>
                <button class="btn btn-primary" @click="openAddModal">Добавить транзакцию</button>
            </div>
        </div>

        <div class="mb-4 d-flex justify-content-between">
            <p>Общая сумма доходов: <strong>{{ totalIncome }} ₽</strong></p>
            <p>Общая сумма расходов: <strong>{{ totalExpenses }} ₽</strong></p>
        </div>

        <table class="table table-hover table-bordered">
            <thead class="table-light">
            <tr>
                <th>Категория</th>
                <th>Сумма</th>
                <th>Дата</th>
                <th>Описание</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="transaction in filteredTransactions" :key="transaction.id">
                <td>{{ transaction.category }}</td>
                <td>{{ transaction.amount }} ₽</td>
                <td>{{ formatDate(transaction.transaction_date) }}</td>
                <td>{{ transaction.description || 'Без описания' }}</td>
                <td>
                    <button class="btn btn-warning btn-sm me-2" @click="openEditModal(transaction)">Редактировать</button>
                    <button class="btn btn-danger btn-sm" @click="deleteTransaction(transaction.id)">Удалить</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Добавить транзакцию</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addTransaction">
                            <div class="mb-3">
                                <label for="category" class="form-label">Категория</label>
                                <select v-model="newTransaction.category" class="form-control" required>
                                    <option value="доход">Доход</option>
                                    <option value="расход">Расход</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Сумма</label>
                                <input type="number" v-model="newTransaction.amount" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Дата</label>
                                <input type="date" v-model="newTransaction.transaction_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <input type="text" v-model="newTransaction.description" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно для редактирования транзакции -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Редактировать транзакцию</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateTransaction">
                            <div class="mb-3">
                                <label for="category" class="form-label">Категория</label>
                                <select v-model="currentTransaction.category" class="form-control" required>
                                    <option value="доход">Доход</option>
                                    <option value="расход">Расход</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Сумма</label>
                                <input type="number" v-model="currentTransaction.amount" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Дата</label>
                                <input type="date" v-model="currentTransaction.transaction_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <input type="text" v-model="currentTransaction.description" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            transactions: [],
            filteredTransactions: [],
            newTransaction: {
                category: 'доход',
                amount: '',
                transaction_date: '',
                description: ''
            },
            currentTransaction: {
                category: 'доход',
                amount: '',
                transaction_date: '',
                description: ''
            },
            editMode: false,
            selectedPeriod: '',
            totalIncome: 0,
            totalExpenses: 0
        };
    },
    mounted() {
        this.getTransactions();
    },
    methods: {
        goBack() {
            window.history.back(); // Возвращает пользователя на предыдущую страницу
        },
        getTransactions() {
            axios.get('/api/transactions')
                .then(response => {
                    this.transactions = response.data.transactions;
                    this.filteredTransactions = this.transactions;
                    this.calculateTotals();
                })
                .catch(error => {
                    console.error('Ошибка при получении транзакций:', error);
                });
        },
        addTransaction() {
            axios.post('/api/transactions', this.newTransaction)
                .then(response => {
                    this.transactions.push(response.data.transaction);
                    this.filterTransactions();
                    this.calculateTotals();
                    this.newTransaction = { category: 'доход', amount: '', transaction_date: '', description: '' };
                    this.closeModal('addModal');
                })
                .catch(error => {
                    console.error('Ошибка при добавлении транзакции:', error);
                });
        },
        openAddModal() {
            this.newTransaction = { category: 'доход', amount: '', transaction_date: '', description: '' };
            const modal = new bootstrap.Modal(document.getElementById('addModal'));
            modal.show();
        },
        openEditModal(transaction) {
            this.currentTransaction = { ...transaction };
            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        },
        updateTransaction() {
            axios.put(`/api/transactions/${this.currentTransaction.id}`, this.currentTransaction)
                .then(response => {
                    const index = this.transactions.findIndex(t => t.id === this.currentTransaction.id);
                    if (index !== -1) {
                        this.transactions[index] = response.data.transaction;
                    }
                    this.filterTransactions();
                    this.calculateTotals();
                    this.closeModal('editModal');
                })
                .catch(error => {
                    console.error('Ошибка при обновлении транзакции:', error);
                });
        },
        deleteTransaction(id) {
            axios.delete(`/api/transactions/${id}`)
                .then(() => {
                    this.transactions = this.transactions.filter(transaction => transaction.id !== id);
                    this.filterTransactions();
                    this.calculateTotals();
                })
                .catch(error => {
                    console.error('Ошибка при удалении транзакции:', error);
                });
        },
        closeModal(modalId) {
            const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
            modal.hide();
        },
        filterTransactions() {
            if (this.selectedPeriod) {
                this.filteredTransactions = this.transactions.filter(transaction => {
                    const transactionDate = new Date(transaction.transaction_date);
                    const selectedDate = new Date(this.selectedPeriod);
                    return transactionDate.getMonth() === selectedDate.getMonth() && transactionDate.getFullYear() === selectedDate.getFullYear();
                });
            } else {
                this.filteredTransactions = this.transactions;
            }
            this.calculateTotals();
        },
        calculateTotals() {
            this.totalIncome = this.filteredTransactions
                .filter(t => t.category === 'доход')
                .reduce((sum, transaction) => sum + parseFloat(transaction.amount), 0);

            this.totalExpenses = this.filteredTransactions
                .filter(t => t.category === 'расход')
                .reduce((sum, transaction) => sum + parseFloat(transaction.amount), 0);

            // Форматируем итоговые суммы без нулей после запятой
            this.totalIncome = this.formatAmount(this.totalIncome);
            this.totalExpenses = this.formatAmount(this.totalExpenses);
        },
        formatAmount(amount) {
            return parseFloat(amount) % 1 === 0 ? parseInt(amount) : amount.toFixed(2); // Округляем к целому, если нет дробной части
        },
        formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(date).toLocaleDateString('ru-RU', options);
        }
    }
};
</script>

