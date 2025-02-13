import api from './api';

export const fetchOffers = () => api.get('/offers');
export const getOfferById = (id) => api.get(`/offers/${id}`);
export const createOffer = (offerData) => api.post('/offers', offerData);
export const updateOffer = (id, offerData) => api.put(`/offers/${id}`, offerData);
export const deleteOffer = (id) => api.delete(`/offers/${id}`);