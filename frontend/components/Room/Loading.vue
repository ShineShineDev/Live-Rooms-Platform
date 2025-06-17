<template>
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-extrabold text-gray-900 animate-pulse h-5 w-70 bg-gray-300 rounded"></h2>
    <div class="flex space-x-4 overflow-x-auto mt-1">
      <div v-for="n in 4" :key="n"
        class="flex-shrink-0 w-80 bg-white rounded-lg shadow-md overflow-hidden animate-pulse">
        <div class="w-full h-32 bg-gray-300"></div>
        <div class="p-4 space-y-2">
          <div class="h-4 bg-gray-300 rounded w-3/4"></div>
          <div class="flex justify-center space-x-2">
            <div class="h-5 w-16 bg-gray-300 rounded"></div>
            <div class="h-5 w-6 bg-gray-400 rounded"></div>
            <div class="h-5 w-16 bg-gray-300 rounded"></div>
          </div>
          <div class="h-4 bg-gray-300 rounded w-1/2 mx-auto"></div>
          <div class="flex justify-between items-center mt-4">
            <div class="h-4 w-20 bg-gray-300 rounded"></div>
            <div class="h-6 w-16 bg-gray-300 rounded"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
