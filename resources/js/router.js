import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'Dashboard',
            component: () => import('@/Views/Pages/Dashboard.vue')
        },
        {
            path: '/profile',
            name: 'Profile',
            component: () => import('@/Views/Pages/Profile.vue')
        },
    ]
});

export default router;
