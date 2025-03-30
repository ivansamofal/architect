<template>
  <div>
    <h2>User list:</h2>
    <ul>
      <li v-for="user in userListStore.users" :key="user.id">
        <router-link :to="{ name: 'User', params: { id: user.id }, state: { user } }">
          {{ user.name }} {{ user.surname }} ({{ user.userIdentifier }})
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
import { useUserListStore } from '../../stores/userListStore';
import User from "./User.vue";

export default {
  name: 'Users',
  components: {User},
  setup() {
    const userListStore = useUserListStore();
    // Загружаем пользователей при монтировании компонента, если они ещё не загружены
    if (userListStore.users.length === 0) {
      userListStore.fetchUsers();
    }
    return { userListStore };
  },
};
</script>
