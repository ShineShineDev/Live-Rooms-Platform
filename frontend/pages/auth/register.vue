<template>
  <br>
  <div class="flex  justify-center">
    <div class="w-full max-w-md bg-white rounded-lg shadow p-6">
      <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
      <form @submit.prevent="handleRegister()">
        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">First Name</label>
          <input v-model="firstName" required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400" />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Last Name</label>
          <input v-model="lastName" required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400" />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Email</label>
          <input v-model="email" type="email" required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400" />
        </div>

        <!-- <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Phone</label>
          <input v-model="phone" type="tel"
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400" />
        </div> -->

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Password</label>
          <input v-model="password" type="password" required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400" />
        </div>

        <div class="mb-6">
          <label class="block text-sm font-medium mb-1">Confirm Password</label>
          <input v-model="passwordConfirmation" type="password" required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-400" />
        </div>

        <button type="submit"
          class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
          Register
        </button>

        <p v-if="error" class="text-red-500 text-sm mt-3">{{ error }}</p>
      </form>

      <p class="text-sm mt-4 text-center">
        Already have an account?
        <NuxtLink to="/auth/login" class="text-blue-600 hover:underline">Login</NuxtLink>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuth } from '~/composables/useAuth'

const { register } = useAuth()

const firstName = ref('')
const lastName = ref('')
const email = ref('')
const phone = ref('')
const password = ref('')
const passwordConfirmation = ref('')
const error = ref('')
const router = useRouter()

async function handleRegister() {
  error.value = ''

  if (!firstName.value || !lastName.value || !email.value || !password.value || !passwordConfirmation.value) {
    error.value = 'All fields are required'
    return
  }

  if (password.value !== passwordConfirmation.value) {
    error.value = 'Passwords do not match'
    return
  }

  try {
    console.log({
      first_name: firstName.value,
      last_name: lastName.value,
      email: email.value,
      phone: phone.value || null,
      password: password.value,
      password_confirmation: passwordConfirmation.value
    });
    await register({
      first_name: firstName.value,
      last_name: lastName.value,
      email: email.value,
      phone: phone.value || null,
      password: password.value,
      password_confirmation: passwordConfirmation.value
    })
    window.location.href = '/'
  } catch (err) {
    console.log(err);
    error.value = err?.response?.data?.message || 'Registration failed'
  }
}
</script>
