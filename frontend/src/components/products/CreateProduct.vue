<template>
  <GenericForm
      title="Cadastro de Produto"
      :fields="fields"
      submit-text="Adicionar Produto"
      :serviceFunction="createProduct"
      redirect-route="/products"
  />
</template>

<script>
import GenericForm from '../GenericForm.vue';
import { createProduct } from "../../services/productsService";

export default {
  components: { GenericForm },
  setup() {
    const fields = [
      {
        model: 'title',
        label: 'Nome do Produto',
        type: 'text',
        placeholder: 'Ex: Bicicleta',
        required: true
      }
    ];

    return { fields, createProduct };
  }
};
</script>
