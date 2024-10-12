<script setup>
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import Button from 'primevue/button';
import ProgressSpinner from 'primevue/progressspinner';
import Image from 'primevue/image';
import { useToast } from 'primevue/usetoast';
import { help } from "@/Services/helper";
import FloatLabel from 'primevue/floatlabel';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Dialog from 'primevue/dialog';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const token = ref(csrfToken);
const route = useRoute();
const projectId = ref(route.params.id);
const loadingData = ref(true);
const src = ref('/assets/images/Logo.png');
const toast = useToast();
const uploading = ref(false);
const savingEdit = ref('');
const saving = ref(false);
const displayConfirmationDelete = ref(false);
const deleteLoading = ref(false);

const editing = ref(false);

function GoTo() {
    window.location.href = "/";
}

onMounted(() => {
    loadProject();
});

const projectName = ref('Loading....');
const projectDescription = ref('Loading.....');
const createdAt = ref('Loading.....');
const updatedAt = ref('Loading......');
async function loadProject() {
    const response = await fetch(`/api/get/projects/info?id=${projectId.value}`, {
        method: "GET",
        headers: { "Content-Type": "application/json" }
    });

    const result = await response.json();

    if (result.data == null) {
        projectId.value = "";
    } else {
        const data = result.data;
        src.value = data.pi_logo != null ? `/ProjectLogos/${data.pi_logo}` : '/assets/images/Logo.png';
        projectName.value = data.pi_name;
        projectDescription.value = data.pi_description;
        createdAt.value = help.formatDate(data.created_at);
        updatedAt.value = help.formatDate(data.updated_at)

    }

    loadingData.value = false;


}

function fileChange(event) {
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

function cancelEdit() {
    editing.value = false;
    savingEdit.value = "";
}

function editProject() {
    editing.value = true;
}

function saveEdit() {
    document.getElementById('editProjectForm').requestSubmit();
}

async function saveEditProject() {
    savingEdit.value = "Saving.........";
    saving.value = true;

    const response = await fetch('/api/post/projects/update', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: help.dataBuilder(['id', 'name', 'description'], [projectId.value, projectName.value, projectDescription.value])
    });
    const result = await response.json();

    help.parseData(result, toast);
    savingEdit.value = "Saved";
    saving.value = false;
    loadProject();
}

function deleteProject(){
    displayConfirmationDelete.value = true;
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
    projectId.value = false;
}


function next(){
    help.goto(`/automationprocess/uiuxtechnology/${projectId.value}`);
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
                <form @submit.prevent="uploadPhoto" class="flex items-center justify-center flex-col gap-4"
                    enctype="multipart/form-data">
                    <input type="hidden" name="_token" v-model="token">
                    <input type="hidden" name="id" v-model="projectId">
                    <Image v-if="src" :src="src" alt="Image" width="250" height="250" preview />
                    <div>
                        <input @change="fileChange"
                            class="block w-full mb-5 text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            name="file" type="file">
                    </div>
                    <Button :loading="uploading" type="submit" label="Upload" />
                </form>

                <div class="col-span-3 grid grid-cols-2 h-full p-4">
                    <div class="flex justify-between flex-col">

                        <div v-if="!editing">
                            <h1 class="text-2xl">General Information</h1>
                            <div class="pl-4 mt-4 flex flex-col gap-2">
                                <p class="font-bold">Name: <span class="font-normal">{{ projectName }}</span></p>
                                <p class="font-bold">Description: <span class="font-normal">{{ projectDescription
                                        }}</span>
                                </p>
                                <p class="font-bold">Created: <span class="font-normal">{{ createdAt }}</span></p>
                                <p class="font-bold">Updated: <span class="font-normal">{{ updatedAt }}</span></p>

                            </div>
                        </div>

                        <div v-if="editing">
                            <h1 class="text-2xl">Edit Project Information</h1>
                            <form id="editProjectForm" @submit.prevent="saveEditProject"
                                class="card flex flex-col gap-4">
                                <div class="flex flex-col gap-2">
                                    <FloatLabel variant="on">
                                        <InputText id="projectName" required class="w-full" v-model="projectName" />
                                        <label for="projectName">Project Name</label>
                                    </FloatLabel>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <FloatLabel variant="on">
                                        <Textarea id="projectDescription" required class="w-full"
                                            v-model="projectDescription" rows="5" cols="30" style="resize: none" />
                                        <label for="projectDescription">Project Description</label>
                                    </FloatLabel>
                                </div>
                                <div class="flex justify-end">{{ savingEdit }}</div>
                            </form>
                        </div>

                        <div class="flex justify-end w-full gap-2">
                            <Button v-if="editing" @click="cancelEdit" :disabled="saving" icon="pi pi-times"
                                severity="warn" text raised rounded aria-label="Cancel Edit" />
                            <Button v-if="editing" @click="saveEdit" :disabled="saving" icon="pi pi-save"
                                severity="success" text raised rounded aria-label="Save Edit" />
                            <Button v-if="!editing" :disabled="saving" icon="pi pi-pen-to-square" @click="editProject"
                                severity="help" text raised rounded aria-label="Edit" />
                            <Button icon="pi pi-trash" severity="danger" @click="deleteProject" :disabled="saving" text raised rounded
                                aria-label="Delete" />
                        </div>

                        <Dialog header="Delete Project?" v-model:visible="displayConfirmationDelete"
                            :style="{ width: '350px' }" :modal="true">
                            <div class="flex items-center justify-center">
                                <i class="pi pi-exclamation-triangle mr-4" style="font-size: 2rem" />
                                <span>This action is ireversable! Proceed with caution</span>
                            </div>
                            <template #footer>
                                <Button label="No" icon="pi pi-times" @click="closeConfirmDelete" text
                                    severity="secondary" />
                                <Button label="Confirm" icon="pi pi-check" @click="confirmDeleteProject"
                                    severity="danger" :loading="deleteLoading" outlined />
                            </template>
                        </Dialog>

                    </div>

                    <div class="flex justify-between flex-col">
                        <div>
                            <h1 class="text-2xl">Configurations</h1>
                            <div class="pl-4 mt-4 flex flex-col gap-2">

                                <p>Front End Approach</p>
                                <p>UI/UX Tecnology</p>
                                <p>Accounts & Roles</p>
                                <p>Database</p>
                                <p>Login Template</p>
                                <p>Export Times</p>
                                <p>Last Exported</p>
                                <p>Export</p>

                            </div>
                        </div>

                        <div class="flex justify-end w-full">
                            <Button label="Next" @click="next" icon="pi pi-arrow-right" iconPos="right" />
                        </div>
                    </div>
                </div>

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
