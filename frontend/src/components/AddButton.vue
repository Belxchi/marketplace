<template>
    <a :href="route" class="bg-[#008b5c] text-white px-4 py-2 rounded-md hover:bg-[#008b5c]">
      {{ text }}
    </a>
  </template>
  
  <script>
  export default {
    name: 'AddButton',
    props: {
      route: {
        type: String,
        required: true
      },
      text: {
        type: String,
        default: 'Adicionar'
      }
    }
  }
  </script>