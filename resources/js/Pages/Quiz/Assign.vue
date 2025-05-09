<template>
    <RootLayout>
        <form @submit.prevent="onSubmit" class="max-w-lg space-y-3" autocomplete="off">
            <div class="relative">
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter
                </label>
                <input v-model="q" type="text" id="name_or_email" @input="onSearch"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="John" />
                <ul v-if="users.length > 0" class=" bg-white shadow-md absolute w-full z-10 mt-1  rounded-lg">
                    <li class="border-b p-3  border-gray-300" v-for="user in users" :key="user.id"
                        @click="onSelect({ name: user.name, id: user.id })">
                        {{ user.name }}
                    </li>
                </ul>
                <ul v-for="selectedUser in selectedUsers" :key="selectedUser.id"
                    class="space-y-3 border mt-1 border-gray-300 rounded-lg">
                    <li class="flex justify-between items-center p-2 cursor-pointer rounded-lg ">
                        <p>{{ selectedUser.name }}</p>
                        <svg v-if="selectedUser.canDelete" @click="onRemove(selectedUser.id)"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>

                    </li>
                </ul>
            </div>
            <button class="btn-primary" type="submit" :disabled="form.processing || !selectedUsers.length">
                {{ form.processing ? 'Submitting...' : 'Submit' }}
            </button>
        </form>
    </RootLayout>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import RootLayout from '@components/layout/RootLayout.vue'
import { useDebounce } from '../../hooks/useDebounce';
import { router, useForm } from '@inertiajs/vue3';

const form = useForm<{ user_ids: Array<number> }>({ user_ids: [] });

const q = ref('')
const debounce = useDebounce()
const users = ref<Array<{ name: string, id: number }>>([])
const selectedUsers = ref<Array<{ name: string, id: number, canDelete?: true }>>([])
const props = defineProps({ users: Array<{ name: string, id: number }> })
watch(
    () => props.users,
    (newUsers: any) => {
        selectedUsers.value = [...newUsers]
    },
    { immediate: true } 
)

const onSearch = () => {
    if (!q.value) {
        users.value = []
        return
    }
    debounce(async () => {
        try {
            const res = await fetch('/users?q=' + q.value, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include'
            })
            if (res.ok) {
                const data = await res.json()
                users.value = data.users
            }
            throw res
        } catch (error) {

        }
    }, 500)
}

const onSelect = (user: { name: string, id: number }) => {

    const found = selectedUsers.value.find((u) => u.id === user.id)
    if (!found) {
        selectedUsers.value = [...selectedUsers.value, { ...user, canDelete: true }]
    }
    users.value = []
}

const onRemove = (id: number) => {
    selectedUsers.value = selectedUsers.value.filter((u) => u.id !== id)
}

const onSubmit = () => {
    form['user_ids'] = selectedUsers.value.map(u => u.id)
    form.post('', {
        onFinish() {
            router.reload({
                only: ['users']
            })
        }
    })
}

</script>