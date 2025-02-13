<template>
  <div id="app" class="flex">
    <Sidebar :is-open="isSidebarOpen" @toggle-sidebar="isSidebarOpen = !isSidebarOpen" />
    <main 
      :class="{
        'ml-64': isSidebarOpen, 
        'ml-16': !isSidebarOpen
      }" 
      class="flex-1 transition-all duration-300 p-4"
    >
      <router-view />
    </main>
  </div>
</template>

<script>
import Sidebar from './components/Sidebar.vue';

export default {
  name: 'App',
  components: {
    Sidebar
  },
  data() {
    return {
      isSidebarOpen: true
    };
  }
};
</script>

<style>
#app {
  min-height: 100vh;
}

main {
  min-width: 0;
}
</style>
