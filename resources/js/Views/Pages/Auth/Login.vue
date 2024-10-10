<script setup>
import { ref } from 'vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { help } from '@/Services/helper';

import Message from 'primevue/message';
const email = ref('');
const password = ref('');
const visible = ref(false);

const message = ref('');
const notif = ref('');

const isLoading = ref(false);
async function submitLogin() {
    const data = help.dataBuilder(["email", "password"], [email.value, password.value]);
    isLoading.value = true;
    try {
        const response = await fetch('/api/post/auth/login/false', {
            method: 'POST',
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if(!response.ok){
            notif.value = 'error';
        }else{
            notif.value = 'success'
        }

        visible.value = true;
        message.value = result.message;

        isLoading.value = false;
        setTimeout(()=> {
            visible.value = false;
        }, 3000);

        if(result.success){
            sessionStorage.setItem('api_token', result.data);
            window.location.href = "/";
        }

    } catch (error) {
        console.error('Login failed:', error);
    }
}
</script>

<template>

    <div class="w-full h-screen flex justify-center items-center">
        <div class="rounded w-[95vh] md:w-1/4 border shadow p-4 flex justify-center items-center flex-col">
            <img :src="'/assets/images/Logo.png'" class="w-1/2" alt="Logo">

            <form @submit.prevent="submitLogin" class="w-full flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <label for="email">Email</label>
                    <InputText id="email" required type="email" placeholder="Enter Email" v-model="email" />
                </div>

                <div class="flex flex-col gap-2">
                    <label for="password">Password</label>
                    <InputText id="password" required placeholder="Enter Password" type="password" v-model="password" />
                </div>

                <Button icon="pi pi-unlock" :loading="isLoading" type="submit" label="Login" raised />
                <Message v-if="visible" :life="3000" :severity="notif">{{ message }}</Message>
            </form>
        </div>
    </div>
</template>
