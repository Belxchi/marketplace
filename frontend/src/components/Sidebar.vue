<template>
  <aside
      :class="{'w-64': isOpen, 'w-16': !isOpen}"
      class="h-screen bg-white text-black fixed transition-all duration-300 ease-in-out flex flex-col shadow-lg">
    <div class="flex items-center p-4 border-b border-gray-700">
      <img v-if="isOpen" src="/src/assets/gestor-seller-logo.png" alt="Logo" class="h-10">
      <button @click="$emit('toggle-sidebar')" class="p-2 text-white bg-[#008b5c] hover:bg-[#008b5c] ml-auto rounded">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>
    </div>

    <nav class="mt-4 flex-1">
      <ul>
        <li class="mb-2">
          <router-link to="/products"
                       class="flex items-center p-3 hover:bg-[#008b5c] hover:text-white transition-colors"
                       >
            <svg class="w-6 h-6 " fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 7h18M3 7l3-4h12l3 4M3 7l18 0M5 21V10H19V21H5z"
                    stroke-linecap="round"
                    stroke-linejoin="round"></path>
            </svg>
            <span v-if="isOpen" class="ml-3">Produtos</span>
          </router-link>
        </li>
        <li class="mb-2">
          <router-link to="/offers"
                       class="flex items-center p-3 hover:bg-[#008b5c] hover:text-white transition-colors"
                       >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2v6l6-4-6-4zM22 12c0-5.52-4.48-10-10-10S2 6.48 2 12s4.48 10 10 10 10-4.48 10-10z"
                    stroke-linecap="round"
                    stroke-linejoin="round"></path>
            </svg>
            <span v-if="isOpen" class="ml-3">Ofertas</span>
          </router-link>
        </li>

        <li class="mb-2">
          <router-link to="/sales"
                       class="flex items-center p-3 hover:bg-[#008b5c] hover:text-white transition-colors"
                       >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                  d="M12 1v22m-4-6c0 2.21 1.79 4 4 4s4-1.79 4-4-1.79-4-4-4-4-1.79-4-4 1.79-4 4-4 4 1.79 4 4"
                  stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span v-if="isOpen" class="ml-3">Vendas</span>
          </router-link>
        </li>
        <li class="mb-2">
          <router-link to="/units-sold"
                       class="flex items-center p-3 hover:bg-[#008b5c] hover:text-white transition-colors"
                       >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" 
                    stroke-linecap="round" 
                    stroke-linejoin="round"/>
            </svg>
            <span v-if="isOpen" class="ml-3">Unidades Vendidas</span>
          </router-link>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script>
export default {
  name: "Sidebar",
  props: {
    isOpen: Boolean
  }
};
</script>
