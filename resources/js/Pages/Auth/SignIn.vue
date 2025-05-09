<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import logo from '@images/logo.svg'

const form = useForm({
    email: '',
    password: ''
})

const handleSubmit = () => {
    form.post(route('auth.signIn'))
}

</script>

<template>
    <div class="h-screen  flex justify-center items-center bg-indigo-950">
        <div class="flex py-5 px-4 max-w-3xl bg-white rounded-lg w-full flex-wrap space-y-5">
            <div class="flex justify-center items-center flex-1">
                <img :src="logo" alt="logo" class="w-full" />
            </div>
            <form @submit.prevent="handleSubmit" class="flex-1  space-y-3 flex flex-col">
                <h1 class="w-full font-bold text-4xl text-center text-indigo-950">LARA QUIZZ</h1>
                <div>
                    <label for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input v-model="form.email" type="text" id="email" name="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="John@gamil.com" required />
                    <div v-if="form.errors.email" class="text-red-500 flex items-center mt-1 gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 text-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        <span class="font-semibold">{{ form.errors.email }}</span>
                    </div>
                </div>
                <div>
                    <label for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input v-model="form.password" type="password" id="password" name="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required />
                </div>
                <button class="btn-primary w-full">
                    Sign in
                </button>
                <div class="flex items-center w-full mt-5">
                    <div class="flex-grow h-px bg-gray-300"></div>
                    <span class="mx-4 text-gray-500 text-sm font-bold">or</span>
                    <div class="flex-grow h-px bg-gray-300"></div>
                </div>
                <div class="h-full flex items-center justify-center gap-2">
                    <span>You don't have an Account? </span><a href="" class="text-indigo-900 font-bold">Register</a>
                </div>
            </form>
        </div>
    </div>
</template>
