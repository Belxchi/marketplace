import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  { path: '/', redirect: '/products' },
  { path: '/products', component: () => import('../pages/Products.vue') },
  { path: '/products/add', component: () => import('../components/products/CreateProduct.vue') },
  { path: '/products/edit/:id', component: () => import('../components/products/UpdateProduct.vue') },
  { path: '/offers', component: () => import('../pages/Offers.vue') },
  { path: '/offers/add', component: () => import('../components/offers/CreateOffer.vue') },
  { path: '/offers/edit/:id', component: () => import('../components/offers/UpdateOffer.vue') },
  { path: '/sales', component: () => import('../pages/Sales.vue') },
  { path: '/sales/add', component: () => import('../components/sales/CreateSale.vue') },
  { path: '/sales/edit/:id', component: () => import('../components/sales/UpdateSale.vue') },
  { path: '/units-sold', name: 'UnitsSold', component: () => import('../components/units/UnitsSoldList.vue') }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
