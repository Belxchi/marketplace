<template>
    <td class="border border-gray-300 px-4 py-2 flex gap-2">
        <a :href="editRoute"
            class="bg-yellow-500 text-white px-3 py-2 rounded-lg hover:bg-yellow-600 transition duration-300 shadow-md hover:shadow-lg flex items-center gap-2 cursor-pointer">
            <span class="text-sm"><i class="fas fa-pencil-alt"></i></span>
        </a>
        <button @click="onDelete"
              class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition duration-300 shadow-md hover:shadow-lg flex items-center gap-2 cursor-pointer">
            <span class="text-sm"><i class="fas fa-trash-alt"></i></span>
        </button>
    </td>
  </template>
  
  <script>
  export default {
    name: 'ActionButtons',
    props: {
      editRoute: {
        type: String,
        required: true
      },
      onDelete: {
        type: Function,
        required: true
      }
    }
  }
  </script>