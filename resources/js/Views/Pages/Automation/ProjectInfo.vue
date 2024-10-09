<script setup>
import Button from 'primevue/button';
</script>
<template>
    <div className="card">

            <div class="title mb-6">
            <p class="mb-4 text-4xl font-bold ">
                Project Information/Settings
            </p>
            <p class="text-2xl text-gray-400 font-light ">
               Select a Project in edit its project information
            </p>

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
                        The new supermac is here, 543 cv and 140 000$. This is best racing computer about 7 years on...
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
                        The new supermac is here, 543 cv and 140 000$. This is best racing computer about 7 years on...
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
                        The new supermac is here, 543 cv and 140 000$. This is best racing computer about 7 years on...
                    </p>
                </div>
            </a>
        </div>
        </div>

    </div>
</template>
