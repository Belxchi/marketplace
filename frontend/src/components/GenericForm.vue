<template>
  <div class="p-4">
    <h1 class="text-xl font-bold mb-4 border-b pb-4 border-gray-300">{{ title }}</h1>
    <div v-if="!formReady" class="flex justify-center items-center h-24">
      <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
    </svg>
    </div>
    <Form
        :initial-values="initialValues"
        @submit="onSubmit"
        @invalid-submit="onInvalidSubmit"
        :validation-schema="schema"
        class="space-y-4"
        @keydown.enter.prevent
        v-if="formReady"
    >
      <div v-for="field in fields" :key="field.model" class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">
          {{ field.label }}
          <ErrorMessage :name="field.model" v-slot="{ message }">
            <span v-if="message" class="text-xs italic text-red-500"> - {{ message }}</span>
          </ErrorMessage>
        </label>

        <template v-if="field.type === 'text' || field.type === 'number' || field.type === 'date'">
          <Field
              :name="field.model"
              :type="field.type"
              :placeholder="field.placeholder"
              class="border border-gray-300 rounded-md px-3 py-2 w-full focus:ring-2 focus:ring-blue-500"
          />
        </template>

        <template v-else-if="field.type === 'select'">
          <Field
              as="select"
              :name="field.model"
              class="border border-gray-300 rounded-md px-3 py-2 w-full focus:ring-2 focus:ring-blue-500"
          >
            <option v-for="option in field.options" :key="option.value" :value="option.value">
              {{ option.label }}
            </option>
          </Field>
        </template>

        <template v-else-if="field.type === 'multiselect'">
          <Field :name="field.model" v-slot="{ field: fieldProps, errors }">
            <VueMultiselect
                ref="multiselect"
                v-bind="fieldProps"
                v-model:modelValue="fieldProps.value"
                :options="field.options"
                :multiple="true"
                :close-on-select="false"
                :clear-on-select="true"
                :preserve-search="false"
                :placeholder="field.placeholder"
                label="label"
                track-by="value"
                class="border border-gray-300 rounded-md"
                :select-on-key="[13, 9]"
                :select-on-enter="true"
                @keydown.enter.stop
                @update:modelValue="onMultiselectUpdate"
                @search-change="handleSearchChange"
                @focus="handleFocus"
            />
            <div v-if="errors.length" class="text-red-500 text-xs mt-1">{{ errors[0] }}</div>
          </Field>
        </template>

        <template v-else-if="field.type === 'productsWithQuantity'">
          <Field :name="field.model" v-slot="{ field: fieldProps, errors }">
            <div>
              <div class="flex space-x-2 mb-4">
                <VueMultiselect
                    v-model="selectedProduct"
                    :options="field.options"
                    placeholder="Digite para buscar um produto"
                    label="label"
                    track-by="value"
                    class="w-64"
                    :clear-on-select="true"
                    :searchable="true"
                    :select-on-key="[13, 9]"
                    :select-on-enter="true"
                    @keydown.enter.stop
                />
                <input
                    type="number"
                    v-model.number="selectedQuantity"
                    min="1"
                    class="border border-gray-300 rounded-md px-3 py-2"
                    placeholder="Quantidade"
                />
                <button
                    type="button"
                    @click="addProduct(fieldProps.value)"
                    class="bg-green-500 text-white px-3 py-2 rounded-lg hover:bg-green-600 transition duration-300 shadow-md hover:shadow-lg flex items-center gap-2 cursor-pointer"
                >
                  Adicionar
                </button>
              </div>
              <div v-if="fieldProps.value.length > 0">
                <table class="min-w-full table-fixed border border-gray-200 rounded-md">
                  <thead class="bg-gray-50">
                  <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2">
                      Produto
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                      Quantidade
                    </th>
                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                      Ações
                    </th>
                  </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200">
                  <tr
                      v-for="(item, index) in fieldProps.value"
                      :key="index"
                      class="hover:bg-gray-50"
                  >
                    <td class="px-4 py-2">
                      {{ item.label }}
                    </td>
                    <td class="px-4 py-2">
                      <input
                          type="number"
                          v-model.number="item.quantity"
                          min="1"
                          class="border border-gray-300 rounded-md px-2 py-1 w-20"
                      />
                    </td>
                    <td class="px-4 py-2 flex items-center justify-center gap-2">
                      <button
                          type="button"
                          @click.prevent="removeProduct(fieldProps.value, index)"
                          class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition duration-300 shadow-md hover:shadow-lg flex items-center gap-2 cursor-pointer"
                      >
                        <span class="text-sm"><i class="fas fa-trash-alt"></i></span>
                      </button>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </Field>
        </template>

        <template v-else-if="field.type === 'singleSelect'">
          <Field :name="field.model" v-slot="{ field: fieldProps, handleChange }">
            <VueMultiselect
              v-model="selectedOffer"
              :options="field.options"
              :placeholder="field.placeholder"
              label="label"
              track-by="value"
              class="w-full"
              :clear-on-select="field.clearOnSelect"
              :searchable="field.searchable"
              :multiple="false"
              :select-on-key="[13, 9]"
              :select-on-enter="true"
              @keydown.enter.stop
              @update:modelValue="value => {
                if (value) {
                  fieldProps.value = value.value;
                  handleChange(value.value);
                } else {
                  fieldProps.value = '';
                  handleChange('');
                }
              }"
            />
          </Field>
        </template>
      </div>
      <div class="flex justify-end mt-6">
        <button
            type="submit"
            :disabled="submitting"
            class="bg-[#008b5c] text-white px-4 py-2 rounded-md hover:bg-[#008b5c] transition-colors disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
        >
          {{ submitText }}
        </button>
      </div>
    </Form>
  </div>
</template>

<script>
import { computed, nextTick, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'
import { ErrorMessage, Field, Form, useForm } from 'vee-validate'
import * as yup from 'yup'
import VueMultiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'

export default {
  props: {
    title: { type: String, required: true },
    fields: {
      type: Array,
      required: true,
      validator: (fields) =>
          fields.every(field => 'model' in field && 'label' in field && 'type' in field)
    },
    submitText: { type: String, default: 'Salvar' },
    serviceFunction: { type: Function, required: true },
    redirectRoute: { type: String, default: '/' },
    initialValues: { type: Object, default: () => ({}) }
  },
  components: { Form, Field, ErrorMessage, VueMultiselect },
  setup(props) {
    const selectedProduct = ref('')
    const selectedQuantity = ref(1)
    const multiselect = ref(null)
    const router = useRouter()
    const route = useRoute()
    const toast = useToast()
    const submitting = ref(false)
    const formReady = ref(true)
    const { resetForm } = useForm()
    const selectedOffer = ref('')

    const handleSearchChange = () => {
      if (multiselect.value && multiselect.value.$refs.search) {
        multiselect.value.$refs.search.focus()
      }
    }

    const handleFocus = () => {
      if (multiselect.value && multiselect.value.$refs.search) {
        multiselect.value.$refs.search.focus()
      }
    }

    const onMultiselectUpdate = (value) => {
      if (multiselect.value && typeof multiselect.value.clearSearch === 'function') {
        multiselect.value.clearSearch()
      }
    }

    const addProduct = (fieldValue) => {
      if (selectedProduct.value && selectedQuantity.value > 0) {
        const exists = fieldValue.find(item => item.value === selectedProduct.value.value)
        if (exists) {
          exists.quantity += selectedQuantity.value
        } else {
          fieldValue.push({
            value: selectedProduct.value.value,
            label: selectedProduct.value.label,
            quantity: selectedQuantity.value
          })
        }
        selectedProduct.value = ''
        selectedQuantity.value = 1
      }
    }

    const removeProduct = (fieldValue, index) => {
      fieldValue.splice(index, 1)
    }

    const schema = computed(() => {
      const shape = {}
      props.fields.forEach(field => {
        if (field.required) {
          if (field.type === 'number') {
            shape[field.model] = yup
                .number()
                .typeError(`${field.label} deve ser um número`)
                .required(`${field.label} é obrigatório`)
          } else if (field.type === 'date') {
            shape[field.model] = yup
                .date()
                .typeError(`${field.label} deve ser uma data válida`)
                .required(`${field.label} é obrigatório`)
          } else if (field.type === 'multiselect' || field.type === 'productsWithQuantity') {
            shape[field.model] = yup.array().min(1, `${field.label} é obrigatório`)
          } else {
            shape[field.model] = yup.string().required(`${field.label} é obrigatório`)
          }
        } else {
          if (field.type === 'number') {
            shape[field.model] = yup.number()
          } else if (field.type === 'date') {
            shape[field.model] = yup.date()
          } else if (field.type === 'multiselect' || field.type === 'productsWithQuantity') {
            shape[field.model] = field.required
                ? yup.array().min(1, `${field.label} é obrigatório`)
                : yup.array()
          } else {
            shape[field.model] = yup.string()
          }
        }
      })
      return yup.object().shape(shape)
    })

    const onSubmit = async (values) => {
      if (submitting.value) return
      submitting.value = true
      try {
        const response = await props.serviceFunction(values)
        toast.success(response.data.message || 'Cadastro realizado com sucesso!')
        router.push(props.redirectRoute)
      } catch (error) {
        toast.error(error.response?.data?.message || 'Erro ao salvar os dados.')
        submitting.value = false
      }
    }

    const onInvalidSubmit = () => {
      toast.error('Preencha todos os campos obrigatórios')
    }

    watch(() => props.initialValues, async (newValues) => {
      if (newValues && Object.keys(newValues).length > 0) {
        await nextTick();
        resetForm({ values: { ...newValues } });

        props.fields.forEach(field => {
          if (field.type === 'singleSelect' && newValues[field.model]) {
            const option = field.options.find(opt => opt.value === newValues[field.model]);
            if (option) {
              selectedOffer.value = option;
            }
          }
        });
      }
    }, { deep: true, immediate: true });

    return {
      schema,
      onSubmit,
      onInvalidSubmit,
      submitting,
      formReady,
      multiselect,
      handleSearchChange,
      handleFocus,
      onMultiselectUpdate,
      selectedProduct,
      selectedQuantity,
      addProduct,
      removeProduct,
      selectedOffer
    }
  }
}
</script>
