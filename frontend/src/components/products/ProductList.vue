<template>
  <div class="p-4">
    <div class="flex justify-between items-center mb-4 border-b pb-4 border-gray-300">
      <h1 class="text-xl font-bold mb-4">Listagem de Produtos</h1>
      <AddButton route="/products/add" />
    </div>

    <TableList :items="products">
      <template #thead>
        <th class="border border-gray-300 px-4 py-2">ID</th>
        <th class="border border-gray-300 px-4 py-2">Nome do Produto</th>
        <th class="border border-gray-300 px-4 py-2">Ações</th>
      </template>

      <template #tbody="{ item }">
        <td class="border border-gray-300 px-4 py-2">{{ item.id }}</td>
        <td class="border border-gray-300 px-4 py-2">{{ item.title }}</td>
        <ActionButtons :editRoute="`/products/edit/${item.id}`" :onDelete="() => removeProduct(item)" />
      </template>
    </TableList>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { fetchProducts, deleteProduct } from '../../services/productsService';
import { useToast } from 'vue-toastification';
import TableList from '../../components/TableList.vue';
import AddButton from '../../components/AddButton.vue';
import ActionButtons from '../../components/ActionButtons.vue';
export default {
  components: { TableList, AddButton, ActionButtons },
  setup() {
    const toast = useToast();
    const products = ref([]);

    const loadProducts = async () => {
      const { data } = await fetchProducts();
      products.value = data;
    };

    const removeProduct = async (product) => {
      try {
        const response = await deleteProduct(product.id);
        toast.success(response.message || 'Produto excluído com sucesso!', {
          timeout: 5000,
        });
        await loadProducts();
      } catch (error) {
        toast.error(error.response.data.message || 'Erro ao excluir o produto. Tente novamente.', {
          timeout: 5000,
        });
      }
    };

    onMounted(loadProducts);

    return { products, removeProduct };
  },
};
</script>
