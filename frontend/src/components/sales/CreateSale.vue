<template>
  <GenericForm
    v-if="isReady"
    title="Cadastro de Venda"
    :fields="fields"
    submit-text="Adicionar Venda"
    :serviceFunction="createSale"
    redirect-route="/sales"
    :initialValues="initialValues"
  />
  <div v-else class="flex justify-center items-center h-24">
    <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
    </svg>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import GenericForm from '../GenericForm.vue';
import { createSale } from '../../services/salesService.js';
import { fetchOffers } from '../../services/offersService.js';

export default {
  components: { GenericForm },
  setup() {
    const initialValues = ref({ title: '', offer_id: '', offer_quantity: '', sale_date: '' });
    const offersOptions = ref([]);
    const isReady = ref(false);

    const fetchOffersOptions = async () => {
      try {
        const response = await fetchOffers();
        offersOptions.value = response.data.map(offer => ({
          label: offer.title,
          value: offer.id
        }));
        isReady.value = true;
      } catch (error) {
        console.error('Erro ao buscar ofertas', error);
      }
    };

    onMounted(() => {
      fetchOffersOptions();
    });

    const fields = computed(() => [
      {
        model: 'title',
        label: 'Nome da Venda',
        type: 'text',
        placeholder: 'Ex: Venda de Inverno',
        required: true
      },
      {
        model: 'offer_id',
        label: 'Selecione a Oferta',
        type: 'singleSelect',
        placeholder: 'Digite para buscar uma oferta',
        options: offersOptions.value,
        required: true,
        searchable: true,
        clearOnSelect: false
      },
      {
        model: 'offer_quantity',
        label: 'Quantidade da Oferta',
        type: 'number',
        placeholder: 'Quantidade',
        required: true
      },
      {
        model: 'sale_date',
        label: 'Data da Venda',
        type: 'date',
        required: true
      }
    ]);

    return { fields, createSale, initialValues, isReady };
  }
};
</script>