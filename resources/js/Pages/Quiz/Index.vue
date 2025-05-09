<script setup lang="ts">
import RootLayout from '@components/layout/RootLayout.vue'
import { Link } from '@inertiajs/vue3'
const props = defineProps({ quizzes: Object })
// console.log($route)
</script>

<template>
    <RootLayout>
        <div  class="grid grid-cols-3 gap-5 overflow-y-auto">
            <div v-for="quiz in quizzes" :key="quiz.id" class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
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
                    <div class="p-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">Created by: User {{ quiz.created_by }}</span>
                        <Link :href="route('quiz.assign', quiz.id)"
                            class="btn-primary">
                            Assign Quiz
                        </Link>
                    </div>
                </div>
        </div>
    </RootLayout>
</template>
