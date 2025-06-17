<!-- components/AppHeader.vue -->
<template>
    <div class="flex items-center space-x-4">
        <template v-if="authUser">
            <div class="flex items-center space-x-4">
                <span class="text-sm hidden sm:block"> {{ authUser.first_name }} {{ authUser.last_name
                    }}</span>
                <NuxtLink to="/deposit">
                    <div class="bg-black text-yellow-400  rounded-full flex items-center space-x-2 px-2 shadow-inner">

                        <div class="bg-black text-yellow-400 p-1 rounded-full flex items-center space-x-2 shadow-inner">
                            <span class="font-bold">{{ authUser.points ?? 1000 }}</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                        </svg>

                    </div>
                </NuxtLink>
                <div class="relative">
                    <NuxtLink to="/noti">
                        <button class="p-2 rounded-full bg-black hover:bg-gray-800 transition-colors duration-300">
                            <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                        </button>
                        <span
                            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">2</span>
                    </NuxtLink>
                </div>
                <NuxtLink to="/profile">
                    <button class="p-2 rounded-full bg-black hover:bg-gray-800 transition-colors duration-300">
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zM9.5 13a6.5 6.5 0 00-6.5 6h13a6.5 6.5 0 00-6.5-6z">
                            </path>
                        </svg>
                    </button>
                </NuxtLink>
            </div>
            <button @click="logout" class=" hover:underline">Logout</button>
        </template>
        <template v-else>
            <NuxtLink to="/auth/login"
                class="hover:text-gray-900 hover:underline transition-colors duration-300 rounded-md px-3 py-1">
                Login</NuxtLink>
            <NuxtLink to="/auth/register"
                class="hover:text-gray-900 hover:underline transition-colors duration-300 rounded-md px-3 py-1">
                Register</NuxtLink>
        </template>
    </div>
</template>

<script>
import { useAuth } from '~/composables/useAuth'

export default {
    name: 'QuickUserInfo',

    data() {
        return {
            authUser: null,
        }
    },

    async created() {
        const { user, fetchUser } = useAuth()
        fetchUser()
        this.authUser = user.value
    },

    methods: {
        async logout() {
            const { logout } = useAuth()
            await logout()
            this.authUser = null
        }
    }
}
</script>


<style>
body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    background-color: #e0e0e0;
}
</style>
