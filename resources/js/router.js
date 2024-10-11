import { createRouter, createWebHistory } from 'vue-router';
import AppLayout from '@/Views/Components/AppLayout.vue';
import { isAuthenticated } from '@/Services/helper';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: AppLayout,
            children: [
                {
                    path: '/',
                    name: 'project_list',
                    component: () => import('@/Views/Pages/ProjectList.vue')
                },
                {
                    path: '/automationprocess/projectinfo/:id?',
                    name: 'project_info',
                    component: () => import('@/Views/Pages/Automation/ProjectInfo.vue')
                },
                {
                    path: '/automationprocess/uiuxtechnology/:id?',
                    name: 'ui_ux_technology',
                    component: () => import('@/Views/Pages/Automation/UITechnology.vue')
                },
                {
                    path: '/automationprocess/loginpagetemplate/:id?',
                    name: 'login_template',
                    component: () => import('@/Views/Pages/Automation/LoginTemplate.vue')
                },
                {
                    path: '/automationprocess/accountsandroles/:id?',
                    name: 'account_roles',
                    component: () => import('@/Views/Pages/Automation/AccountRoles.vue')
                },
                {
                    path: '/automationprocess/databaseschema/:id?',
                    name: 'database_schema',
                    component: () => import('@/Views/Pages/Automation/DatabaseSchema.vue')
                },
                {
                    path: '/automationprocess/managementfeature/:id?',
                    name: 'management_feature',
                    component: () => import('@/Views/Pages/Automation/ManagementFeature.vue')
                },
                {
                    path: '/automationprocess/customization/:id?',
                    name: 'customization',
                    component: () => import('@/Views/Pages/Automation/Customization.vue')
                },
                {
                    path: '/automationprocess/exportapplication/:id?',
                    name: 'export_project',
                    component: () => import('@/Views/Pages/Automation/ExportProject.vue')
                },
                {
                    path: '/settings',
                    name: 'settings',
                    component: () => import('@/Views/Pages/Settings/Settings.vue')
                },
                {
                    path: '/settings/accountlist',
                    name: 'account_list',
                    component: () => import('@/Views/Pages/Settings/AccountList.vue')
                },
                {
                    path: '/activitylog',
                    name: 'activity_logs',
                    component: () => import('@/Views/Pages/Settings/ActivityLog.vue')
                },
            ]
        },

        {
            path: '/auth/login',
            name: 'login',
            component: () => import('@/Views/Pages/Auth/Login.vue')
        },
        {
            path: '/404-not-authorized',
            name: 'NotFound',
            component: () => import('@/Views/Pages/Auth/NotFound.vue')
        }
    ]
});

router.beforeEach(async (to, from, next) => {

    const requiresAuth = !['login', 'NotFound'].includes(to.name);
    const auth =  await isAuthenticated();

    if (requiresAuth && !auth) {
        next({ name: 'NotFound' });
    } else {
        next();
    }
});

export default router;
