import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
    state: () => ({
        id: 0,
        name: "",
        surname: "",
        countryName: "",
        cityName: "",
        isAuthenticated: false,
        userIdentifier: ""
    }),
    actions: {
        async fetchUser(id) {
            try {
                const response = await fetch(`http://localhost/api/v1/profiles/${id}`);
                const data = await response.json();
                // Обновляем отдельные поля
                this.id = data.id;
                this.name = data.name;
                this.surname = data.surname;
                this.countryName = data.countryName || "";
                this.cityName = data.cityName || "";
                this.userIdentifier = data.userIdentifier;
                // Если требуется, выставляем флаг аутентификации
                this.isAuthenticated = true;
            } catch (error) {
                console.error('Ошибка при получении пользователя:', error);
            }
        },
    },
});
