<template>
  <div class="container mx-auto">
    <SaleList />
  </div>
</template>

<script>
import SaleList from '../components/sales/SaleList.vue';

export default {
  name: 'Sales',
  components: {
    SaleList
  },
};
</script>
