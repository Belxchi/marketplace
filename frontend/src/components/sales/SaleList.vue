<template>
  <div class="p-4">
    <div class="flex justify-between items-center mb-4 border-b pb-4 border-gray-300">
      <h1 class="text-xl font-bold mb-4">Listagem de Vendas</h1>
      <AddButton route="/sales/add" />
    </div>

    <TableList :items="sales">
      <template #thead>
        <th class="border border-gray-300 px-4 py-2">ID</th>
        <th class="border border-gray-300 px-4 py-2">Nome da Oferta</th>
        <th class="border border-gray-300 px-4 py-2">Quantidade Vendida</th>
        <th class="border border-gray-300 px-4 py-2">Ações</th>
      </template>

      <template #tbody="{ item }">
        <td class="border border-gray-300 px-4 py-2">{{ item.id }}</td>
        <td class="border border-gray-300 px-4 py-2">{{ item.offer.title }}</td>
        <td class="border border-gray-300 px-4 py-2">{{ item.offer_quantity }}</td>
        <ActionButtons :editRoute="`/sales/edit/${item.id}`" :onDelete="() => removeSale(item)" />
      </template>
    </TableList>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { fetchSales, deleteSale } from '../../services/salesService';
import { useToast } from 'vue-toastification';
import TableList from '../../components/TableList.vue';
import AddButton from '../../components/AddButton.vue';
import ActionButtons from '../../components/ActionButtons.vue';

export default {
  components: { TableList, AddButton, ActionButtons },
  setup() {
    const toast = useToast();
    const sales = ref([]);

    const loadSales = async () => {
      const { data } = await fetchSales();
      sales.value = data;
    };

    const removeSale = async (sale) => {
      try {
        const response = await deleteSale(sale.id);
        toast.success(response.message || 'Venda excluída com sucesso!', {
          timeout: 5000,
        });
        await loadSales();
      } catch (error) {
        toast.error('Erro ao excluir a venda. Tente novamente.', {
          timeout: 5000,
        });
      }
    };

    onMounted(loadSales);

    return { sales, removeSale };
  },
};
</script>
