<script setup>
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import { ref, onMounted } from 'vue';
import Textarea from 'primevue/textarea';
import FloatLabel from 'primevue/floatlabel';
import ProgressSpinner from 'primevue/progressspinner';
import { help } from '@/Services/helper';
import { useToast } from 'primevue/usetoast';

const projectName = ref('');
const projectDescription = ref('');
const saving = ref(false);
const display = ref(false);
const projectList = ref([]);
const displayConfirmationDelete = ref(false);
const projectId = ref('');
const toast = useToast();
const empty = ref(false);
const deleteLoading = ref(false);
const projectLoading = ref(true);

function open() {
    display.value = true;
}

async function save() {
    saving.value = true;
    const response = await fetch(`/api/post/projects/add`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: help.dataBuilder(['name', 'description'], [projectName.value, projectDescription.value])
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

    empty.value = data.data.length == 0;
    projectList.value = data.data;
}

onMounted(async() => {
    await loadProjects();
    projectLoading.value = false;
});

function confirmDelete(id){
    displayConfirmationDelete.value = true;
    projectId.value = id;
}

function closeConfirmDelete(){
    displayConfirmationDelete.value = false;
}

async function confirmDeleteProject(){
    deleteLoading.value = true;

    const response = await fetch('/api/post/projects/delete',{
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: help.dataBuilder(['id'], [projectId.value])
    });
    const result = await response.json();

    help.parseData(result, toast);
    deleteLoading.value = false;
    displayConfirmationDelete.value = false;
    loadProjects();
}

</script>
<style scoped>
.project-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.project-card:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.project-card-enter-active {
    transition: transform 0.4s ease-in-out;
}

.project-card-enter-from {
    transform: scale(0.8);
}

.project-card-leave-active {
    transition: transform 0.4s ease-in-out;
    opacity: 0;
}

.project-card-leave-to {
    transform: scale(0.8);
    opacity: 0;
}
</style>

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
        <Dialog header="Delete Project?" v-model:visible="displayConfirmationDelete" :style="{ width: '350px' }" :modal="true">
            <div class="flex items-center justify-center">
                <i class="pi pi-exclamation-triangle mr-4" style="font-size: 2rem" />
                <span>This action is ireversable! Proceed with caution</span>
            </div>
            <template #footer>
                <Button label="No" icon="pi pi-times" @click="closeConfirmDelete" text severity="secondary" />
                <Button label="Confirm" icon="pi pi-check" @click="confirmDeleteProject" severity="danger" :loading="deleteLoading" outlined />
            </template>
        </Dialog>

        <div v-if="projectLoading" class="flex items-center justify-center flex-col w-full h-[50vh]">
                <ProgressSpinner />
                <h1>Please Wait......</h1>
            </div>

        <transition-group v-if="!empty" name="project-card" tag="div" class="grid grid-cols-5 gap-4">
            <div v-for="project in projectList" :key="project.pi_id"
                class="m-auto overflow-hidden rounded-lg shadow-lg cursor-pointer h-90 w-full project-card">
                <a :href="`/automationprocess/projectinfo/${project.pi_id}`" class="block w-full h-full">
                    <img alt="Project photo" :src="'/assets/images/Logo.png'" class="object-cover w-full max-h-40" />
                    <div class="w-full p-4">
                        <p class="mb-2 text-xl font-medium">{{ project.pi_name }}</p>
                        <p class="font-light text-md">{{ project.pi_description }}</p>
                    </div>

                </a>
                <div class="w-full flex justify-end p-2">
                    <Button @click="confirmDelete(project.pi_id)" icon="pi pi-trash" severity="danger" aria-label="Cancel" />
                </div>
            </div>
        </transition-group>

        <div class="w-full h-[60vh] flex items-center justify-center flex-col" v-if="empty">
            <img :src="'/assets/images/empty.svg'" alt="no project" class="w-1/5">
            <p class="text-xl">This container is empty..... add some projects</p>
        </div>

    </div>

    <!-- Add Project Modal -->
    <Dialog header="Add Project" v-model:visible="display" :breakpoints="{ '960px': '75vw' }" :style="{ width: '30vw' }"
        :modal="true">
        <form id="addProjectForm" class="card flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <FloatLabel variant="on">
                    <InputText id="projectName" class="w-full" v-model="projectName" />
                    <label for="projectName">Project Name</label>
                </FloatLabel>
            </div>
            <div class="flex flex-col gap-2">
                <FloatLabel variant="on">
                    <Textarea id="projectDescription" class="w-full" v-model="projectDescription" rows="5" cols="30"
                        style="resize: none" />
                    <label for="projectDescription">Project Description</label>
                </FloatLabel>
            </div>
        </form>
        <template #footer>
            <Button type="button" label="Save Project" icon="pi pi-plus" :loading="saving" @click="save" />
        </template>
    </Dialog>
</template>
