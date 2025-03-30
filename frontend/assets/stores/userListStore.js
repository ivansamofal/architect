// src/stores/userListStore.js
import { defineStore } from 'pinia';

export const useUserListStore = defineStore('userList', {
    state: () => ({
        users: [],
    }),
    actions: {
        async fetchUsers() {
            try {
                const response = await fetch('http://localhost/api/v1/profiles');
                this.users = await response.json();
            } catch (error) {
                console.error('Ошибка при получении пользователей:', error);
            }
        },
    },
});
