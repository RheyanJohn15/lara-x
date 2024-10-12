<script setup>
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import Button from 'primevue/button';

//State Variables
const route = useRoute();
const projectId = ref(route.params.id);


//Funtions
function GoTo() {
    window.location.href = "/";
}


//OnMount
onMounted(() => {

});
</script>

<template>
    <div class="card">
        <div class="title mb-6">
            <p class="mb-4 text-4xl font-bold">
                UI/UX Technology
            </p>
            <p class="text-2xl text-gray-400 font-light">
                Select a UI/UX technology that suits your need wethere a css framework or a js framework or native
                frontend
            </p>
        </div>

        <div class="card" v-if="projectId">
           
        </div>

        <div v-else>
            <div class="w-full flex items-center justify-center flex-col gap-4">
                <img :src="'/assets/images/no-project.svg'" class="w-1/5" alt="no project">
                <h1 class="text-gray-400 text-4xl">No Project Selected</h1>
                <h2 class="text-gray-400">Select a project first in the project list to edit its info</h2>
                <Button label="Go to project list" @click="GoTo" severity="success" raised />
            </div>
        </div>
    </div>
</template>
