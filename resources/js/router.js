import { createRouter, createWebHistory } from 'vue-router';
import AppLayout from '@/Views/Components/AppLayout.vue';
const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: AppLayout,
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: () => import('@/Views/Pages/Dashboard.vue')
                },

            ]
        },
    ]
});

export default router;
