<script setup>
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import { ref } from 'vue';

import Textarea from 'primevue/textarea';
import FloatLabel from 'primevue/floatlabel';
import Toast from 'primevue/toast';

const projectName = ref('');
const projectDescription = ref('');
const saving = ref(false);
const display = ref(false);
import { help } from '@/Services/helper';
import { useToast } from 'primevue/usetoast';

const toast = useToast();
function open() {
    display.value = true;
}

async function save(){
    saving.value = true;
    const response = await fetch(`/api/post/projects/add`,
    {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(help.dataBuilder(['name', 'description'], [projectName.value, projectDescription.value]))
    }
    );

    const result = await response.json();

    help.parseData(result, toast);
}

</script>
<template>
    <div className="card">
        <Toast position="bottom-right" group="br" />
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
    <Dialog header="Add Project " v-model:visible="display" :breakpoints="{ '960px': '75vw' }"
        :style="{ width: '30vw' }" :modal="true">
        <form class="card flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <FloatLabel variant="on">
                    <InputText id="projectName" class="w-full"v-model="projectName" />
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
