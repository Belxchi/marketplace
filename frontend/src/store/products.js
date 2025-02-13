import { defineStore } from 'pinia';
import { fetchProducts } from '../services/api';

export const useProductStore = defineStore('productStore', {
  state: () => ({
    products: [],
  }),
  actions: {
    async loadProducts() {
      const { data } = await fetchProducts();
      this.products = data;
    },
  },
});
