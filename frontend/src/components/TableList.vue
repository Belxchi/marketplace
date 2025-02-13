<template>
  <div class="overflow-x-auto">
    <table v-if="items.length > 0" class="w-full border-collapse border border-gray-300">
      <thead class="bg-gray-100 text-left">
        <tr>
          <slot name="thead"></slot>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id" class="hover:bg-gray-50">
          <slot name="tbody" :item="item"></slot>
        </tr>
      </tbody>
    </table>
    <div v-else class="text-center py-8 bg-gray-50 border border-gray-300 rounded-md">
      <p class="text-gray-600">Nenhum registro encontrado</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TableList',
  props: {
    items: {
      type: Array,
      required: true
    }
  }
};
</script>
