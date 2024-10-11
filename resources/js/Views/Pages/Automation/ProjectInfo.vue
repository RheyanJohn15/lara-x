<script setup>
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import Button from 'primevue/button';
import ProgressSpinner from 'primevue/progressspinner';
import Image from 'primevue/image';
import { useToast } from 'primevue/usetoast';
import { help } from "@/Services/helper";
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const token = ref(csrfToken);
const route = useRoute();
const projectId = ref(route.params.id);
const loadingData = ref(true);
const src = ref('/assets/images/Logo.png');
const toast = useToast();
const uploading  = ref(false);
function GoTo() {
    window.location.href = "/";
}

onMounted(() => {
    loadProject();
});

async function loadProject() {
    const response = await fetch(`/api/get/projects/info?id=${projectId.value}`, {
        method: "GET",
        headers: { "Content-Type": "application/json" }
    });

    const result = await response.json();

    if (result.data == null) {
        projectId.value = "";
    }else{
        src.value = `/ProjectLogos/${result.data.pi_logo}`;
    }

    loadingData.value = false;


}

function fileChange(event){
    const file = event.target.files[0];
      if (file) {
        src.value = URL.createObjectURL(file);
      }
}

async function uploadPhoto() {
    uploading.value = true;
    const formData = new FormData();
    formData.append('_token', token.value);
    formData.append('id', projectId.value);
    const fileInput = document.querySelector('input[name="file"]');
    const file = fileInput.files[0];
    if (file) {
        formData.append('file', file);
    }

    try {
        const response = await fetch('/api/post/projects/uploadlogo', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

       help.parseData(result, toast);
       uploading.value = false;
    } catch (error) {
        console.error('Error:', error);
    }
}

</script>

<template>
    <div class="card">
        <div class="title mb-6">
            <p class="mb-4 text-4xl font-bold">
                Project Information/Settings
            </p>
            <p class="text-2xl text-gray-400 font-light">
                Edit a projects Information, define your projects to easily identify its purpose
            </p>
        </div>

        <div v-if="projectId">
           <div v-if="loadingData" class="flex items-center justify-center flex-col w-full h-[50vh]">
            <ProgressSpinner />
            <h1>Please Wait......</h1>
           </div>

           <div v-if="!loadingData" class="w-full grid grid-cols-4">

                <form @submit.prevent="uploadPhoto" class="flex items-center justify-center flex-col gap-4" enctype="multipart/form-data">
                    <input type="hidden" name="_token" v-model="token">
                    <input type="hidden" name="id" v-model="projectId">
                    <Image v-if="src" :src="src" alt="Image" width="250" height="250" preview />
                    <div>
                    <input @change="fileChange" class="block w-full mb-5 text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="file" type="file">
                    </div>
                    <Button :loading="uploading" type="submit" label="Upload" />
                </form>
           </div>
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
