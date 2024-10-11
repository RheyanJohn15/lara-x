<script setup>
import { useRoute } from 'vue-router';
import { ref } from 'vue';
import Button from 'primevue/button';

const route = useRoute();
const projectId = ref(route.params.id);

function GoTo(){
    window.location.href = "/";
}
</script>

<template>
    <div class="card">
        <div class="title mb-6">
            <p class="mb-4 text-4xl font-bold">
                Account & Roles
            </p>
            <p class="text-2xl text-gray-400 font-light">
               Configure the entity that can access your app and there roles in the application
            </p>
        </div>

        <div v-if="projectId">
            <p class="text-xl font-semibold">
                Editing Project with ID: {{ projectId }}
            </p>
            <div class="grid grid-cols-5 gap-4">
                <div class="m-auto overflow-hidden rounded-lg shadow-lg cursor-pointer h-90 w-60 md:w-80">
                    <p class="text-xl font-medium">Project Details for ID: {{ projectId }}</p>
                </div>
            </div>
        </div>

        <div v-else>
            <div class="w-full flex items-center justify-center flex-col gap-4">
                <img :src="'/assets/images/no-project.svg'" class="w-1/5" alt="no project">
                <h1 class="text-gray-400 text-4xl">No Project Selected</h1>
                <h2 class="text-gray-400">Select a project first in the project list to edit its info</h2>
                <Button label="Go to project list" @click = "GoTo" severity="success" raised />
            </div>
        </div>
    </div>
</template>
