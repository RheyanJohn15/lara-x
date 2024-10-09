<script setup>
import { ref } from 'vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';


const email = ref('');
const password = ref('');

async function submitLogin(){
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const response = await fetch('/api/post/auth/login/false', {
        method: 'POST',
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            _token: csrfToken,
            email: email.value,
            password: password.value
        })
    });

    const result = await response.json();
    console.log(result);
}
</script>

<template>
    <div class="w-full h-screen flex justify-center items-center">
        <div class="rounded w-[95vh] md:w-1/4 border shadow p-4 flex justify-center items-center flex-col">
            <img :src="'/assets/images/Logo.png'" class="w-1/2" alt="Logo">

            <form class="w-full flex flex-col gap-4">

                <div class="flex flex-col gap-2">
                    <label for="email">Email</label>
                    <InputText id="email" type="email" placeholder="Enter Email" v-model="email"  />
                </div>

                <div class="flex flex-col gap-2">
                    <label for="email">Password</label>
                    <InputText id="password" placeholder="Enter Password" type="password" v-model="password"  />
                </div>

                <Button label="Login" @click="submitLogin" raised />

            </form>
        </div>
    </div>
</template>
