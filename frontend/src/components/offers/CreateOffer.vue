<template>
  <GenericForm
      title="Cadastro de Oferta"
      :fields="fields"
      submit-text="Adicionar Oferta"
      :serviceFunction="createOffer"
      redirect-route="/offers"
      :initialValues="initialValues"
  />
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import GenericForm from '../GenericForm.vue'
import { createOffer } from "../../services/offersService.js"
import { fetchProducts } from '../../services/productsService.js'

export default {
  components: { GenericForm },
  setup() {
    const initialValues = ref({ title: '', products: [] })
    const productsOptions = ref([])

    const fetchProductsOptions = async () => {
      try {
        const response = await fetchProducts()
        productsOptions.value = response.data.map(product => ({
          label: product.title,
          value: product.id
        }))
      } catch (error) {
        console.error('Erro ao buscar produtos', error)
      }
    }

    onMounted(() => {
      fetchProductsOptions()
    })

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
    ])

    return { fields, createOffer, initialValues }
  }
}
</script>
