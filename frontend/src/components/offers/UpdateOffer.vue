<template>
  <GenericForm
      v-if="isReady"
      title="Editar Oferta"
      :fields="fields"
      submit-text="Atualizar Oferta"
      :serviceFunction="updateOfferWrapper"
      redirect-route="/offers"
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
import { ref, computed, onMounted } from 'vue'
import GenericForm from '../GenericForm.vue'
import { updateOffer, getOfferById } from "../../services/offersService.js"
import { fetchProducts } from '../../services/productsService.js'
import { useRoute } from 'vue-router'

export default {
  components: { GenericForm },
  setup() {
    const route = useRoute();
    const offerId = route.params.id;
    const initialValues = ref({ title: '', products: [] });
    const productsOptions = ref([]);
    const isReady = ref(false);

    const fetchProductsOptions = async () => {
      try {
        const response = await fetchProducts();
        productsOptions.value = response.data.map(product => ({
          label: product.title,
          value: product.id
        }));
      } catch (error) {
        console.error('Erro ao buscar produtos', error);
      }
    };

    const loadOffer = async () => {
      try {
        const response = await getOfferById(offerId);
        initialValues.value = response.data;
      } catch (error) {
        console.error('Erro ao carregar a oferta', error);
      }
    };

    const loadData = async () => {
      await Promise.all([fetchProductsOptions(), loadOffer()]);
      isReady.value = true;
    };

    onMounted(() => {
      loadData();
    });

    const fields = computed(() => [
      {
        model: 'title',
        label: 'Nome da Oferta',
        type: 'text',
        placeholder: 'Ex: Queima de estoque',
        required: true
      },
      {
        model: 'products',
        label: 'Selecione os Produtos e Quantidades',
        type: 'productsWithQuantity',
        placeholder: 'Selecione o produto',
        required: true,
        options: productsOptions.value
      }
    ]);

    const updateOfferWrapper = (values) => {
      return updateOffer(offerId, values);
    };

    return { fields, updateOfferWrapper, initialValues, isReady };
  }
};
</script>
