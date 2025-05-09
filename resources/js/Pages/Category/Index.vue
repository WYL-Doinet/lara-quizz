<template>
    <div class="h-screen bg-gary-100 flex text-white">
        <div class="w-[18%] bg-indigo-950 flex flex-col">
            <div class="h-16 flex justify-center items-center">
                <h1 class="leading-0 font-extrabold text-4xl text-center">Lara Quizz</h1>
            </div>
            <div class="flex-1"></div>
            <div class="p-5 justify-center items-center flex gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                <span>Profile</span>
            </div>
        </div>
        <div class="overflow-hidden">
            <div class="grid grid-cols-6 gap-5 p-5 overflow-y-auto">
                <div class="p-10 bg-yellow-500 rounded-lg text-4xl font-extrabold text-center">
                    JS
                </div>
                <div class="p-10 bg-lime-500 rounded-lg text-4xl font-extrabold text-center">
                    Node
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts"></script>