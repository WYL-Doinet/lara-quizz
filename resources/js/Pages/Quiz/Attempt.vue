<script setup lang="ts">
import RootLayout from '@components/layout/RootLayout.vue'
import { Link } from '@inertiajs/vue3'
const props = defineProps({ quizzes: Object })
// console.log($route)
</script>

<template>
    <RootLayout>
        <div class="grid grid-cols-3 gap-5">
            <div v-for="quiz in quizzes" :key="quiz.id"
                class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Card Header -->
                <div class="p-4">
                    <h2 class="text-xl font-bold text-gray-900">{{ quiz.title }}</h2>
                    <p class="text-sm text-gray-600">{{ quiz.created_at }}</p>
                </div>

                <!-- Card Body -->
                <div class="p-4">
                    <p class="text-gray-800">{{ quiz.description }}</p>
                </div>

                <!-- Card Footer -->
                <div class="p-4 flex justify-between items-center flex-wrap">
                    <Link as="button" v-if="!quiz.completed_at" :href="route('quiz.show', quiz.id)" class="btn-primary">
                    {{ 'Try Quiz' }}
                    </Link>
                    <Link href="" class="btn-primary" v-else>
                    View Score Report
                    </Link>
                    <div
                        class="flex h-20 w-20 text-xl rounded-full bg-indigo-800 text-white font-extrabold justify-center items-center">
                        {{ quiz.completed_at ? quiz.score : 'Score' }}
                    </div>
                </div>
            </div>
        </div>
    </RootLayout>
</template>
