<script setup>
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import { ref, onMounted } from 'vue';

import Textarea from 'primevue/textarea';
import FloatLabel from 'primevue/floatlabel';

import { help } from '@/Services/helper';
import { useToast } from 'primevue/usetoast';

const projectName = ref('');
const projectDescription = ref('');
const saving = ref(false);
const display = ref(false);
const projectList = ref([]);  

const toast = useToast();
function open() {
    display.value = true;
}

async function save() {
    saving.value = true;
    const response = await fetch(`/api/post/projects/add`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(help.dataBuilder(['name', 'description'], [projectName.value, projectDescription.value]))
    });

    const result = await response.json();

    help.parseData(result, toast);
    saving.value = false;
    display.value = false;

    projectName.value = '';
    projectDescription.value = '';

    loadProjects();
}

async function loadProjects() {
    const response = await fetch('/api/get/projects/list', { method: "GET", headers: { "Content-Type": "application/json" } });
    const data = await response.json();

    projectList.value = data.data;

    console.log(projectList.value); // Verify if data is fetched correctly
}

onMounted(() => {
    loadProjects();
});
</script>

<template>
    <div className="card">
        <div class="flex justify-between w-full mb-6">
            <div class="title ">
                <p class="mb-4 text-4xl font-bold ">
                    Project List
                </p>
                <p class="text-2xl text-gray-400 font-light ">
                    All Jumpstarted Project
                </p>
            </div>
            <div>
                <Button icon="pi pi-plus" @click="open" label="Add Project" raised />
            </div>
        </div>

        <div class="grid grid-cols-5 gap-4">
            <div v-for="project in projectList" :key="project.pi_id" class="m-auto overflow-hidden rounded-lg shadow-lg cursor-pointer h-90 w-60">
                <a href="#" class="block w-full h-full">
                    <img alt="Project photo" :src="'/assets/images/Logo.png'" class="object-cover w-full max-h-40" />
                    <div class="w-full p-4">
                        <p class="mb-2 text-xl font-medium">{{ project.pi_name }}</p>
                        <p class="font-light text-md">{{ project.pi_description }}</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Add Project Modal -->
    <Dialog header="Add Project" v-model:visible="display" :breakpoints="{ '960px': '75vw' }" :style="{ width: '30vw' }" :modal="true">
        <form id="addProjectForm" class="card flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <FloatLabel variant="on">
                    <InputText id="projectName" class="w-full" v-model="projectName" />
                    <label for="projectName">Project Name</label>
                </FloatLabel>
            </div>
            <div class="flex flex-col gap-2">
                <FloatLabel variant="on">
                    <Textarea id="projectDescription" class="w-full" v-model="projectDescription" rows="5" cols="30" style="resize: none" />
                    <label for="projectDescription">Project Description</label>
                </FloatLabel>
            </div>
        </form>
        <template #footer>
            <Button type="button" label="Save Project" icon="pi pi-plus" :loading="saving" @click="save" />
        </template>
    </Dialog>
</template>
