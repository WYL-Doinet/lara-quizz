<template>
    <div class="h-screen bg-indigo-950 flex">
        <div class="w-[16%] flex">
            <div class="flex flex-col items-center w-full">
                <img :src="logo" />
                <!-- <div class="flex items-center gap-5">
                    <button type="button"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Start
                    </button>
                    <div class="text-white font-bold text-3xl leading-0">00:00</div>
                </div> -->
            </div>
        </div>
        <div class="flex-1 bg-gray-100 p-5 overflow-hidden">
            <form @submit.prevent="handleSubmit" class="space-y-3 rounded-lg p-5 bg-white h-full overflow-y-auto">
                <div v-for="(question, i) in questions" :key="question.id"
                    class="space-y-3 border-b pb-8  border-b-gray-300">
                    <h4 class="font-semibold text-xl">{{ i + 1 }}. {{ question['question_text'] }}</h4>
                    <div class="grid grid-cols-4 gap-3 ">
                        <div v-for="choice in question.choices" :key="choice.id"
                            class="bg-gray-100 flex items-center p-5 rounded-lg">
                            <input :id="`choice-${choice.id}`" type="radio" :value="choice.id"
                                :name="`question-${question.id}`"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label :for="`choice-${choice.id}`" class="ms-2 text-sm font-medium dark:text-gray-300">{{
                                choice['choice_text'] }}</label>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-5">
                    <button class="btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
</template>

<script setup lang="ts">
import logo from '@images/logo.svg'
import { router } from '@inertiajs/vue3'

const props = defineProps({ quiz: Object, questions: Object })

const handleSubmit = (e: Event) => {
    const data = new FormData(e.target as HTMLFormElement)
    const choices = Array.from(data.entries()).map(([key, value]) => value);

    router.post(route('quiz.answer', props.quiz!.id), {
        "choice_ids": choices as any
    })
}



</script>