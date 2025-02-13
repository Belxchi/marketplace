<template>
  <div class="p-4">
    <div class="flex justify-between items-center mb-4 border-b pb-4 border-gray-300">
      <h1 class="text-xl font-bold mb-4">Relatório de Unidades Vendidas por Produto</h1>
    </div>

    <!-- Cards de Totalizadores -->
    <div class="grid grid-cols-3 gap-4 mb-6">
      <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
        <h3 class="text-gray-500 text-sm">Total de Unidades Vendidas</h3>
        <p class="text-2xl font-bold">{{ totalUnits }}</p>
      </div>
      
      <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
        <h3 class="text-gray-500 text-sm">Produto Mais Vendido</h3>
        <p class="text-2xl font-bold">{{ topProduct }}</p>
      </div>

      <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
        <h3 class="text-gray-500 text-sm">Total de Produtos</h3>
        <p class="text-2xl font-bold">{{ totalProducts }}</p>
      </div>
    </div>

    <!-- Gráfico -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow-md">
      <Bar :data="chartData" :options="chartOptions" class="h-48" />
    </div>

    <!-- Tabela -->
    <div class="bg-white rounded-lg shadow-md">
      <TableList :items="unitsSold">
        <template #thead>
          <th class="border border-gray-300 px-4 py-2">ID</th>
          <th class="border border-gray-300 px-4 py-2">Produto</th>
          <th class="border border-gray-300 px-4 py-2">Quantidade Total Vendida</th>
        </template>

        <template #tbody="{ item }">
          <td class="border border-gray-300 px-4 py-2">{{ item.id }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ item.product }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ item.quantity }}</td>
        </template>
      </TableList>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import { fetchUnitsSold } from '../../services/unitsSoldService';
import TableList from '../TableList.vue';
import { Bar } from 'vue-chartjs';
import { 
  Chart as ChartJS, 
  CategoryScale, 
  LinearScale, 
  BarElement, 
  Title, 
  Tooltip, 
  Legend 
} from 'chart.js';

ChartJS.register(
  CategoryScale, 
  LinearScale, 
  BarElement, 
  Title, 
  Tooltip, 
  Legend
);

export default {
  components: { TableList, Bar },
  setup() {
    const unitsSold = ref([]);

    const totalUnits = computed(() => {
      return unitsSold.value.reduce((acc, item) => acc + Number(item.quantity), 0);
    });

    const topProduct = computed(() => {
      if (!unitsSold.value.length) return '-';
      return unitsSold.value.reduce((prev, current) => 
        Number(prev.quantity) > Number(current.quantity) ? prev : current
      ).product;
    });

    const totalProducts = computed(() => unitsSold.value.length);

    const chartData = computed(() => ({
      labels: unitsSold.value.map(item => item.product),
      datasets: [{
        label: 'Unidades Vendidas',
        data: unitsSold.value.map(item => Number(item.quantity)),
        backgroundColor: 'rgba(59, 130, 246, 0.5)'
      }]
    }));

    const chartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    };

    const loadUnitsSold = async () => {
      try {
        const { data } = await fetchUnitsSold();
        unitsSold.value = data;
      } catch (error) {
        console.error('Erro ao carregar unidades vendidas:', error);
      }
    };

    onMounted(loadUnitsSold);

    return { 
      unitsSold, 
      totalUnits,
      topProduct,
      totalProducts,
      chartData,
      chartOptions
    };
  }
};
</script> 