<template>
    <header class="bg-gradient-to-r from-yellow-200 to-yellow-400 text-white shadow-lg rounded-b-lg">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="text-4 font-bold text-gray-900 rounded-lg p-1 bg-white shadow-inner">LOGO</div>
                <nav class="hidden md:flex space-x-6">
                    <NuxtLink to="/" class="text-gray-900 transition-colors duration-300 rounded-md px-3 py-1">
                        Live Schedule</NuxtLink>
                    <NuxtLink to="/subscribed-list"
                        class="text-gray-900 transition-colors duration-300 rounded-md px-3 py-1">Subscribed List

                    </NuxtLink>
                    <NuxtLink to="/ty-le-keo"
                        class="text-gray-900 transition-colors duration-300 rounded-md px-3 py-1">Odds

                    </NuxtLink>
                    <NuxtLink to="/ket-qua"
                        class="text-gray-900 transition-colors duration-300 rounded-md px-3 py-1">Results

                    </NuxtLink>
                    <NuxtLink to="/phong-chat"
                        class="text-gray-900 transition-colors duration-300 rounded-md px-3 py-1">Chat Rooms
                    </NuxtLink>
                    <NuxtLink to="/tin-tuc"
                        class="text-gray-900 transition-colors duration-300 rounded-md px-3 py-1">News
                    </NuxtLink>
                </nav>
            </div>
            <QuickUserInfo></QuickUserInfo>
        </div>
        <SecondaryNav></SecondaryNav>
    </header>
</template>

<script>
import { useAuth } from '~/composables/useAuth'

export default {
    name: 'AppHeader',
}
</script>


<style>
body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    background-color: #e0e0e0;
}
</style>
