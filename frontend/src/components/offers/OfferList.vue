<template>
  <div class="p-4">
    <div class="flex justify-between items-center mb-4 border-b pb-4 border-gray-300">
      <h1 class="text-xl font-bold mb-4">Listagem de Ofertas</h1>
      <AddButton route="/offers/add" />
    </div>

    <TableList :items="offers">
      <template #thead>
        <th class="border border-gray-300 px-4 py-2">ID</th>
        <th class="border border-gray-300 px-4 py-2">Nome da Oferta</th>
        <th class="border border-gray-300 px-4 py-2">Ações</th>
      </template>
      <template #tbody="{ item }">
        <td class="border border-gray-300 px-4 py-2">{{ item.id }}</td>
        <td class="border border-gray-300 px-4 py-2">{{ item.title }}</td>
        <ActionButtons :editRoute="`/offers/edit/${item.id}`" :onDelete="() => removeOffer(item)" />
      </template>
    </TableList>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { fetchOffers, deleteOffer } from '../../services/offersService.js';
import { useToast } from 'vue-toastification';
import TableList from '../TableList.vue';
import AddButton from '../../components/AddButton.vue';
import ActionButtons from '../../components/ActionButtons.vue';
export default {
  components: { TableList, AddButton, ActionButtons },
  setup() {
    const toast = useToast();
    const offers = ref([]);

    const loadOffers = async () => {
      const { data } = await fetchOffers();
      offers.value = data;
    };

    const removeOffer = async (offer) => {
      try {
        const response = await deleteOffer(offer.id);
        toast.success(response.message || 'Oferta excluída com sucesso!', { timeout: 5000 });
        await loadOffers();
      } catch (error) {
        toast.error(error.response?.data?.message || 'Erro ao excluir a oferta. Tente novamente.', { timeout: 5000 });
      }
    };

    onMounted(loadOffers);

    return { offers, removeOffer };
  },
};
</script>
