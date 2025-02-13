<template>
  <div class="container mx-auto">
    <OfferList />
  </div>
</template>

<script>
import OfferList from '../components/offers/OfferList.vue';

export default {
  name: 'Offers',
  components: {
    OfferList
  },
};
</script>
