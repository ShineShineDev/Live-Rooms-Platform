<template>
    <br>
  <div class=" flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 py-3 rounded-lg shadow-xl">
      <div class="text-center">
        <h1 class="text-3xl font-extrabold text-gray-900">My Profile</h1>
        <p class="mt-2 text-sm text-gray-600">
          View and manage your personal information.
        </p>
      </div>

      <div v-if="user" class="mt-8 space-y-6">
        <div class="bg-gray-50 p-4 rounded-md shadow-sm">
          <div class="flex items-center mb-3">
            <span class="text-gray-500 mr-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
              </svg>
            </span>
            <strong class="text-gray-700">Personal Information</strong>
          </div>
          <div class="grid grid-cols-1 gap-y-3">
            <div>
              <label class="block text-sm font-medium text-gray-500">First Name:</label>
              <p class="mt-1 text-gray-900">{{ user.first_name }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Last Name:</label>
              <p class="mt-1 text-gray-900">{{ user.last_name }}</p>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-md shadow-sm">
          <div class="flex items-center mb-3">
            <span class="text-gray-500 mr-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M2.93 2.5a.5.5 0 00-.39.18L.28 4.41c-.2.2-.2.51 0 .71l2.26 2.26a.5.5 0 00.71 0l2.26-2.26a.5.5 0 000-.71L3.32 2.68a.5.5 0 00-.39-.18zM17.07 2.5a.5.5 0 00-.39.18L14.68 4.41a.5.5 0 00-.39.18.5.5 0 00-.39-.18l-2.26-2.26a.5.5 0 00-.71 0L1.73 6.09a.5.5 0 00-.71 0L.28 7.41a.5.5 0 000 .71l2.26 2.26a.5.5 0 00.71 0l2.26-2.26a.5.5 0 000-.71L3.32 6.68a.5.5 0 00-.39-.18zM17.07 10.5a.5.5 0 00-.39.18L14.68 12.41a.5.5 0 00-.39.18.5.5 0 00-.39-.18l-2.26-2.26a.5.5 0 00-.71 0L1.73 14.09a.5.5 0 00-.71 0L.28 15.41a.5.5 0 000 .71l2.26 2.26a.5.5 0 00.71 0l2.26-2.26a.5.5 0 000-.71L3.32 14.68a.5.5 0 00-.39-.18z" clip-rule="evenodd" />
              </svg>
            </span>
            <strong class="text-gray-700">Contact Information</strong>
          </div>
          <div class="grid grid-cols-1 gap-y-3">
            <div>
              <label class="block text-sm font-medium text-gray-500">Email:</label>
              <p class="mt-1 text-gray-900">{{ user.email }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Phone:</label>
              <p class="mt-1 text-gray-900">{{ user.phone || 'Not provided' }}</p>
            </div>
          </div>
        </div>

        <button
          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out"
          @click="handleLogout"
        >
          Logout
        </button>
      </div>

      <div v-else class="mt-8 text-center">
        <p class="text-gray-600">You are not logged in.</p>
        <NuxtLink to="/auth/login" class="mt-4 inline-flex items-center px-4 py-2 border t text-sm font-medium rounded-md shadow-sm bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
          Go to Login
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useAuth } from '~/composables/useAuth'
import { useRouter } from 'vue-router'

const { user, fetchUser, logout } = useAuth()
const router = useRouter()

onMounted(() => {
  fetchUser()
})

const handleLogout = () => {
  logout()
  router.push('/auth/login')
}
</script>