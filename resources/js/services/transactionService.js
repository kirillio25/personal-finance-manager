import axios from 'axios';

export const getTransactions = () => {
    return axios.get('/api/transactions');
};

export const addTransaction = (transaction) => {
    return axios.post('/api/transactions', transaction);
};

export const updateTransaction = (id, transaction) => {
    return axios.put(`/api/transactions/${id}`, transaction);
};

export const deleteTransaction = (id) => {
    return axios.delete(`/api/transactions/${id}`);
};
