import api from './api';

export const fetchSales = () => api.get('/sales');
export const getSaleById = (id) => api.get(`/sales/${id}`);
export const createSale = (saleData) => api.post('/sales', saleData);
export const updateSale = (id, saleData) => api.put(`/sales/${id}`, saleData);
export const deleteSale = (id) => api.delete(`/sales/${id}`);
