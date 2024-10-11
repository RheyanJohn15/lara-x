<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([
    {
        label: 'Home',
        items: [{ label: 'Project List', icon: 'pi pi-fw pi-folder-open', to: '/' }]
    },
    {
        label: 'Jumpstart Automation Process',
        items: [
            { label: 'Project Info', icon: 'pi pi-fw pi-info-circle', to: '/automationprocess/projectinfo' },
            { label: 'UI/UX Technology', icon: 'pi pi-fw pi-palette', to: '/automationprocess/uiuxtechnology' },
            { label: 'Login Page Templates', icon: 'pi pi-fw pi-lock', to: '/automationprocess/loginpagetemplate' },
            { label: 'Accounts & Roles', icon: 'pi pi-fw pi-users', to: '/automationprocess/accountsandroles', class: 'rotated-icon' },
            { label: 'Database Schema', icon: 'pi pi-fw pi-database', to: '/automationprocess/databaseschema' },
            { label: 'Management Feature', icon: 'pi pi-fw pi-list', to: '/automationprocess/managementfeature' },
            { label: 'Customization', icon: 'pi pi-fw pi-pencil', to: '/automationprocess/customization' },
            { label: 'Export Application', icon: 'pi pi-fw pi-download', to: '/automationprocess/exportapplication' },
        ]
    },

    {
        label: 'App Settings',
        icon: 'pi pi-fw pi-briefcase',
        to: '/pages',
        items: [
            {
                label: 'Settings',
                icon: 'pi pi-fw pi-cog',
                to: '/settings'
            },
            {
                label: 'Account List',
                icon: 'pi pi-fw pi-user',
                to: '/settings/accountlist'
            },

            {
                label: 'Activity Logs',
                icon: 'pi pi-fw pi-history',
                to: '/activitylog'
            },
        ]
    },
//     {
//     label: 'Support',
//     icon: 'pi pi-fw pi-question-circle',
//     items: [
//         { label: 'Documentation', icon: 'pi pi-fw pi-book', to: '/help/documentation' },
//         { label: 'FAQ', icon: 'pi pi-fw pi-info', to: '/help/faq' },
//         { label: 'Contact Support', icon: 'pi pi-fw pi-envelope', to: '/help/contact' },
//     ]
// },
]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
