<template>
  <div>
    <h2>User details:</h2>
    <div v-if="user && user.name && user.surname">
      <p><strong>Name:</strong> {{ user.name }}</p>
      <p><strong>Surname:</strong> {{ user.surname }}</p>
      <p><strong>Email:</strong> {{ user.userIdentifier }}</p>
    </div>
    <div v-else>
      Loading...
    </div>
    <router-link to="/">← Back to list</router-link>
  </div>
</template>

<!--<script setup>-->
<!--const props = defineProps({-->
<!--  user: {-->
<!--    type: Object,-->
<!--    required: true,-->
<!--  },-->
<!--});-->
<!--</script>-->

<script>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import { useUserStore } from '../../stores/userStore';

// const userStore = useUserStore();

export default {
  name: 'User',
  props: {
    user: {
      type: Object,
      required: false,
      default: null
    }
  },
  setup() {
    const route = useRoute();
    const userStore = useUserStore();

    // Если данные не загружены, вызываем fetchUser
    if (!userStore.id && route.params.id) {
      userStore.fetchUser(route.params.id);
    }

    // computed, которое возвращает данные: сначала проверяем route.state, если нет – данные из userStore
    const userData = computed(() => ({
      id: userStore.id,
      name: userStore.name,
      surname: userStore.surname,
      countryName: userStore.countryName,
      cityName: userStore.cityName,
      isAuthenticated: userStore.isAuthenticated,
      userIdentifier: userStore.userIdentifier,
    }));

    return { user: userData };
  }
};
</script>
