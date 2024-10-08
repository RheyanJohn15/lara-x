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
                    name: 'project_list',
                    component: () => import('@/Views/Pages/ProjectList.vue')
                },
                {
                    path: '/automationprocess/projectinfo',
                    name: 'project_info',
                    component: () => import('@/Views/Pages/Automation/ProjectInfo.vue')
                },
                {
                    path: '/automationprocess/uiuxtechnology',
                    name: 'ui_ux_technology',
                    component: () => import('@/Views/Pages/Automation/UITechnology.vue')
                },
                {
                    path: '/automationprocess/loginpagetemplate',
                    name: 'login_template',
                    component: () => import('@/Views/Pages/Automation/LoginTemplate.vue')
                },
                {
                    path: '/automationprocess/accountsandroles',
                    name: 'account_roles',
                    component: () => import('@/Views/Pages/Automation/AccountRoles.vue')
                },
                {
                    path: '/automationprocess/databaseschema',
                    name: 'database_schema',
                    component: () => import('@/Views/Pages/Automation/DatabaseSchema.vue')
                },
                {
                    path: '/automationprocess/managementfeature',
                    name: 'management_feature',
                    component: () => import('@/Views/Pages/Automation/ManagementFeature.vue')
                },
                {
                    path: '/automationprocess/customization',
                    name: 'customization',
                    component: () => import('@/Views/Pages/Automation/Customization.vue')
                },
                {
                    path: '/automationprocess/exportapplication',
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
                    path: '/automationprocess/activitylog',
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
    ]
});

export default router;
