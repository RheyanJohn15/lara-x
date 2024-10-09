<script setup>
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import FileUpload from 'primevue/fileupload';

import { ref } from 'vue';
const display = ref(false);
const fileupload = ref();

function open() {
    display.value = true;
}
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
            <div class="m-auto overflow-hidden rounded-lg shadow-lg cursor-pointer h-90 w-60 md:w-80">
                <a href="#" class="block w-full h-full">
                    <img alt="blog photo" :src="'/assets/images/Logo.png'" class="object-cover w-full max-h-40" />
                    <div class="w-full p-4 ">
                        <p class="font-medium  text-md">
                        </p>
                        <p class="mb-2 text-xl font-medium t">
                            New Mac is here !
                        </p>
                        <p class="font-light  text-md">
                            The new supermac is here, 543 cv and 140 000$. This is best racing computer about 7 years
                            on...
                        </p>
                    </div>
                </a>
            </div>
            <div class="m-auto overflow-hidden rounded-lg shadow-lg cursor-pointer h-90 w-60 md:w-80">
                <a href="#" class="block w-full h-full">
                    <img alt="blog photo" :src="'/assets/images/Logo.png'" class="object-cover w-full max-h-40" />
                    <div class="w-full p-4 ">
                        <p class="font-medium  text-md">
                        </p>
                        <p class="mb-2 text-xl font-medium t">
                            New Mac is here !
                        </p>
                        <p class="font-light  text-md">
                            The new supermac is here, 543 cv and 140 000$. This is best racing computer about 7 years
                            on...
                        </p>
                    </div>
                </a>
            </div>
            <div class="m-auto overflow-hidden rounded-lg shadow-lg cursor-pointer h-90 w-60 md:w-80">
                <a href="#" class="block w-full h-full">
                    <img alt="blog photo" :src="'/assets/images/Logo.png'" class="object-cover w-full max-h-40" />
                    <div class="w-full p-4 ">
                        <p class="font-medium  text-md">
                        </p>
                        <p class="mb-2 text-xl font-medium t">
                            New Mac is here !
                        </p>
                        <p class="font-light  text-md">
                            The new supermac is here, 543 cv and 140 000$. This is best racing computer about 7 years
                            on...
                        </p>
                    </div>
                </a>
            </div>
        </div>

    </div>

    <!--Add Project Modal -->
    <Dialog header="Add Project " v-model:visible="display" :breakpoints="{ '960px': '75vw' }" :style="{ width: '30vw' }"
        :modal="true">
        <div class="card flex flex-col gap-4">
                    <div class="font-semibold text-xl">Vertical</div>
                    <div class="flex flex-col gap-2">
                        <label for="name1">Project Name</label>
                        <InputText id="name1" placeholder="Project Name" type="text" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="email1">Project Description</label>
                        <InputText id="email1" placeholder="Project Description" type="text" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="age1">Project Logo</label>
                        <FileUpload name="demo[]" @uploader="onUpload" :multiple="true" accept="image/*" :maxFileSize="1000000" customUpload />
                    </div>
                </div>

        <template #footer>
            <Button label="Save" @click="close" />
        </template>
    </Dialog>
</template>
