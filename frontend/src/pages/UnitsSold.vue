<template>
  <div class="container mx-auto">
    <h1 class="text-xl font-bold mb-4">Unidades Vendidas</h1>
    <table class="w-full border">
      <thead>
      <tr class="bg-gray-200">
        <th class="p-2">ID</th>
        <th class="p-2">Produto</th>
        <th class="p-2">Quantidade Vendida</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="unit in unitsSold" :key="unit.id">
        <td class="p-2">{{ unit.id }}</td>
        <td class="p-2">{{ unit.product }}</td>
        <td class="p-2">{{ unit.quantity }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { fetchUnitsSold } from '../services/unitsSoldService';

export default {
  name: 'UnitsSold',
  setup() {
    const unitsSold = ref([]);

    const loadUnitsSold = async () => {
      try {
        const { data } = await fetchUnitsSold();
        unitsSold.value = data;
      } catch (error) {
        console.error('Erro ao carregar unidades vendidas:', error);
      }
    };

    onMounted(loadUnitsSold);

    return { unitsSold };
  },
};
</script>
