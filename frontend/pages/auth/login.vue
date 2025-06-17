<template>
  <br>
  <div class="flex items-center justify-center ">
    <div class="w-full max-w-md bg-white rounded-lg shadow p-6">
      <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Email</label>
          <input v-model="email" type="email" required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400" />
        </div>
        <div class="mb-6">
          <label class="block text-sm font-medium mb-1">Password</label>
          <input v-model="password" type="text" required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400" />
        </div>
        <button type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Login</button>
        <p v-if="error" class="text-red-500 text-sm mt-3">{{ error }}</p>
      </form>
      <p class="text-sm mt-4 text-center">
        Don’t have an account?
        <NuxtLink to="/auth/register" class="text-blue-600 hover:underline">Register</NuxtLink>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuth } from '~/composables/useAuth'

const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)

const router = useRouter()
const { login } = useAuth()

async function handleLogin() {
  loading.value = true
  error.value = ''
  try {
    await login({ email: email.value, password: password.value })
    // router.push('/')
    window.location.href = '/'
  } catch (err) {
    if (err?.data?.message) {
      error.value = err.data.message
    } else {
      error.value = 'Login failed. Please check your credentials.'
    }
  } finally {
    loading.value = false
  }
}
</script>

