import { createApp } from 'vue';
import App from './vue/App.vue';
import router from './router';
import { createPinia } from 'pinia';

const pinia = createPinia();
const app = createApp(App); // создаем экземпляр приложения

app.use(router);
app.use(pinia);
app.mount('#app');

console.log(4);
