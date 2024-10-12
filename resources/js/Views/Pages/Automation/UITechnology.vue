<script setup>
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import Button from 'primevue/button';
import ProgressSpinner from 'primevue/progressspinner';
import { help } from "@/Services/helper";
import { useToast } from 'primevue/usetoast';

// State Variables
const route = useRoute();
const projectId = ref(route.params.id);
const selectedApproach = ref('');
const selectedCSSFramework = ref('');
const loading = ref(false);
const approach = ref('');
const framework = ref('');
const toast = useToast();
const devApproach = ref([
    {
        title: "Vanilla Approach",
        value: "approach-vanilla",
        image: "/assets/images/UITech/frontend_tech.png",
        description: "Harness the core power of the web by building with pure HTML, CSS, and JavaScript. Ideal for those who prefer simplicity, control, and a lightweight setup without dependencies."
    },
    {
        title: "Vue JS",
        value: "approach-vuejs",
        image: "/assets/images/UITech/vue.png",
        description: "Leverage the flexibility and ease of Vue.js, a progressive JavaScript framework. Perfect for building dynamic and reactive user interfaces with a component-based architecture."
    },
]);

const cssFrameworks = ref([
    {
        title: "Bootstrap CSS",
        value: "css-bootstrap",
        image: "/assets/images/UITech/bootstrap.png",
        description: "Achieve consistency and responsive design quickly with Bootstrap, the world’s most popular CSS framework. A great choice for delivering professional-looking interfaces with minimal effort."
    },
    {
        title: "Tailwind CSS",
        value: "css-tailwind",
        image: "/assets/images/UITech/tailwind.png",
        description: "Unlock unlimited customization with Tailwind CSS, a utility-first framework. Tailor every detail of your design, while enjoying the simplicity of predefined classes and rapid prototyping."
    }
]);

// Functions
function GoTo() {
    window.location.href = "/";
}

function selectApproach(_approach) {
    selectedApproach.value = _approach;
}

function selectCSSFramework(_framework) {
    selectedCSSFramework.value = _framework;
}

async function saveDevApproach(){
    loading.value = true;

    save(selectedApproach.value, 'approach');

}

async function saveCss(){
    loading.value = true;
    save(selectedCSSFramework.value, 'css-framework');
}

async function save(data, type){
    const response = await fetch('/api/post/uitech/save',{
        method:"POST",
        headers: {"Content-Type": "application/json"},
        body: help.dataBuilder(['id', 'value', 'context'], [projectId.value, data, type])
    });

    const result = await response.json();

    help.parseData(result, toast);
    loading.value = false;
    loadUITech();
}

async function loadUITech(){
    const response = await fetch(`/api/get/uitech/get?id=${projectId.value}`, {
        method:"GET",
        headers: {"Content-Type": "application/json"}
    });

    const result = await response.json();
    const data = result.data;

    data.forEach(d => {
        console.log(d.type);
        if(d.type == 'approach'){
            approach.value = d.value;
            selectedApproach.value = d.value;
        }else{
            framework.value = d.value;
            selectedCSSFramework.value = d.value;
        }
    });
   

    console.log(selectedApproach.value);
}

function next(){
    help.goto(`/automationprocess/loginpagetemplate/${projectId.value}`);
}

function previous(){
    help.goto(`/automationprocess/projectinfo/${projectId.value}`);
}

// OnMount
onMounted(() => {loadUITech()});
</script>

<template>

    <div v-if="loading" class="fixed w-full h-screen bg-black/50 z-[99999999] top-0 left-0 flex justify-center items-center flex-col gap-2">
        <ProgressSpinner />
        <p class="text-xl text-white">Please Wait.........</p>
    </div>

    <div class="card">
        <div class="title mb-6">
            <p class="mb-4 text-4xl font-bold">
                UI/UX Technology
            </p>
            <p class="text-2xl text-gray-400 font-light">
                Select a UI/UX technology that suits your need whether a CSS framework or a JS framework or native frontend
            </p>
        </div>

        <div class="card" v-if="projectId">
            <div class="w-full flex justify-between mb-6 mt-6">
                <h1 class="text-xl font-bold ">Choose Your Development Approach</h1>

                <div v-if="approach != selectedApproach" class="flex gap-1">
                    <Button label="Save" icon="pi pi-save" @click="saveDevApproach" severity="success" rounded />      
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div
                    v-for="tech in devApproach"
                    :key="tech.title"
                    @click="selectApproach(tech.value)"
                    class="overflow-hidden transition-shadow shadow duration-300 bg-white rounded cursor-pointer"
                    :class="{ 'border-4 border-blue-500': selectedApproach === tech.value }"
                >
                    <img :src="tech.image" class="object-contain w-full h-64 rounded" alt="" />
                    <div class="p-5">
                        <p class="text-2xl font-bold leading-5">{{ tech.title }}</p>
                        <p class="mb-4 text-gray-700">{{ tech.description }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full flex justify-between mb-6 mt-6">
                <h1 class="text-xl font-bold ">Choose Your CSS Framework</h1>

                <div v-if="framework != selectedCSSFramework" class="flex gap-1">
                    <Button label="Save" @click="saveCss" icon="pi pi-save" severity="success" rounded />      
                </div>
            </div>
          
            <div class="grid grid-cols-2 gap-4">
                <div
                    v-for="css in cssFrameworks"
                    :key="css.title"
                    @click="selectCSSFramework(css.value)"
                    class="overflow-hidden transition-shadow shadow duration-300 bg-white rounded cursor-pointer"
                    :class="{ 'border-4 border-green-500': selectedCSSFramework === css.value }"
                >
                    <img :src="css.image" class="object-contain w-full h-64 rounded" alt="" />
                    <div class="p-5">
                        <p class="text-2xl font-bold leading-5">{{ css.title }}</p>
                        <p class="mb-4 text-gray-700">{{ css.description }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-between w-full mt-8">
                <Button label="Previous" @click="previous" severity="danger" icon="pi pi-arrow-left" raised />
                <Button label="Next" @click="next" severity="success" icon="pi pi-arrow-right" iconPos="right" raised />
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
