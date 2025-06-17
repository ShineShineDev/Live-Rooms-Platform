<template>
  <br>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Deposit Funds</h1>

    <form @submit.prevent="submitDeposit">
      <div class="mb-4">
        <label for="amount" class="block mb-1 font-medium">Amount</label>
        <input
          type="number"
          id="amount"
          v-model="amount"
          class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:border-blue-500"
          min="1"
          required
        />
      </div>

      <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
      >
        Deposit
      </button>
    </form>

    <div v-if="message" class="mt-4 text-green-600">
      {{ message }}
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const amount = ref('')
const message = ref('')

const submitDeposit = async () => {
  try {
    // Replace with actual API endpoint
    const response = await $fetch('/api/deposit', {
      method: 'POST',
      body: { amount: parseFloat(amount.value) },
    })

    message.value = `Successfully deposited ${amount.value} units.`
    amount.value = ''
  } catch (error) {
    console.error(error)
    message.value = 'An error occurred while processing your deposit.'
  }
}
</script>
