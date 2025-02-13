<template>
  <GenericForm
      v-if="isReady"
      title="Editar Produto"
      :fields="fields"
      submit-text="Atualizar Produto"
      :serviceFunction="updateProductWrapper"
      redirect-route="/products"
      :initialValues="productData"
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
import { getProductById, updateProduct } from '../../services/productsService'
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

export default {
  components: { GenericForm },
  setup() {
    const route = useRoute()
    const productData = ref({})
    const isReady = ref(false)
    
    const fields = [
      {
        model: 'title',
        label: 'Nome do Produto',
        type: 'text',
        placeholder: 'Ex: Bicicleta',
        required: true
      }
    ]

    const loadProduct = async () => {
      try {
        const response = await getProductById(route.params.id)
        productData.value = response.data
        isReady.value = true
      } catch (error) {
        console.error('Erro ao carregar o produto', error)
      }
    }

    const updateProductWrapper = (values) => {
      return updateProduct(productData.value.id, values)
    }

    onMounted(() => {
      loadProduct()
    })

    return { fields, productData, updateProductWrapper, isReady }
  }
}
</script>
