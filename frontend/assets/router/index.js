import { createRouter, createWebHistory } from 'vue-router';
import Users from '../vue/components/Users.vue';
import User from '../vue/components/User.vue';

const routes = [
    { path: '/', name: 'Users', component: Users },
    { path: '/user/:id', name: 'User', component: User, props: route => ({ user: route.state && route.state.user }) },
];

const router = createRouter({
    history: createWebHistory(), // Использует HTML5 history API
    routes,
});

export default router;
