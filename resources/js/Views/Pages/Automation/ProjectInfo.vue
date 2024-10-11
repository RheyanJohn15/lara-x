<script setup>
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import Button from 'primevue/button';
import ProgressSpinner from 'primevue/progressspinner';
import Image from 'primevue/image';
import FileUpload from 'primevue/fileupload';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const token = ref(csrfToken);
const route = useRoute();
const projectId = ref(route.params.id);
const loadingData = ref(true);
const src = ref('/assets/images/Logo.png');
const selectedFile = ref(null);

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
    }

    loadingData.value = false;
}

function onFileSelect(event) {
    selectedFile.value = event.files[0];
    const reader = new FileReader();

    reader.onload = (e) => {
        src.value = e.target.result;
    };

    if (selectedFile.value) {
        reader.readAsDataURL(selectedFile.value);
    }
}

async function uploadPhoto() {
    const formData = new FormData();
    formData.append('_token', token.value);
    formData.append('id', projectId.value);

    // Append the selected file to the FormData
    if (selectedFile.value) {
        formData.append('file', selectedFile.value);
    } else {
        console.error('No file selected.');
        return; // Exit if no file is selected
    }

    try {
        const response = await fetch('/api/post/pro', {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();
        console.log('Upload success:', data);
    } catch (error) {
        console.error('Upload failed:', error);
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

           <div class="w-full grid grid-cols-3">

                <form @submit.prevent="uploadPhoto" class="flex items-center justify-center flex-col gap-4">
                    <input type="hidden" name="_token" v-model="token">
                    <input type="hidden" name="id" v-model="projectId">
                    <Image v-if="src" :src="src" alt="Image" width="250" height="250" preview />
                    <FileUpload
                        name="demo[]"
                        mode="basic"
                        accept="image/*"
                        @select="onFileSelect"
                        customUpload
                        auto
                        severity="secondary"
                        class="p-button-outlined"
                    />
                    <Button type="submit" label="Upload" />
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
