<template>
  <GenericForm
    v-if="isReady"
    title="Editar Venda"
    :fields="fields"
    submit-text="Atualizar Venda"
    :serviceFunction="updateSaleWrapper"
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
import GenericForm from '../GenericForm.vue'
import { getSaleById, updateSale } from '../../services/salesService'
import { fetchOffers } from '../../services/offersService'
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'

export default {
  components: { GenericForm },
  setup() {
    const route = useRoute()
    const initialValues = ref({ title: '', offer_id: '', offer_quantity: '', sale_date: '' })
    const offersOptions = ref([])
    const isReady = ref(false)

    const fetchOffersOptions = async () => {
      try {
        const response = await fetchOffers()
        offersOptions.value = response.data.map(offer => ({
          label: offer.title,
          value: offer.id
        }))
      } catch (error) {
        console.error('Erro ao buscar ofertas', error)
      }
    }

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
    ])

    const loadSale = async () => {
      try {
        const response = await getSaleById(route.params.id)
        console.log(response.data)
        initialValues.value = {
          title: response.data.offer.title,
          offer_id: response.data.offer_id,
          offer_quantity: response.data.offer_quantity,
          sale_date: response.data.sale_date
        }
      } catch (error) {
        console.error('Erro ao carregar a venda', error)
      }
    }

    const loadData = async () => {
      await fetchOffersOptions()
      await loadSale()
      isReady.value = true
    }

    const updateSaleWrapper = async (values) => {
      return await updateSale(route.params.id, values)
    }

    onMounted(() => {
      loadData()
    })

    return { fields, initialValues, updateSaleWrapper, isReady }
  }
}
</script>
