<template>
     <!-- Secondary Navigation -->
        <div class="bg-black py-2 shadow-inner rounded-b-lg">
            <div class="container mx-auto px-4 flex justify-between items-center text-sm">
                <nav class="flex space-x-6">
                    <NuxtLink to="/bang-tin"
                        class="flex items-center space-x-1 hover:text-yellow-400 transition-colors duration-300 rounded-md px-3 py-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-2 2a1 1 0 00-1 1v3a1 1 0 001 1h2a1 1 0 001-1v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Message Board</span>
                    </NuxtLink>
                    <NuxtLink to="/reels"
                        class="flex items-center space-x-1 hover:text-yellow-400 transition-colors duration-300 rounded-md px-3 py-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm10 4a1 1 0 10-2 0v4a1 1 0 102 0V8z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Reels</span>
                    </NuxtLink>
                    <NuxtLink to="/highlight"
                        class="flex items-center space-x-1 hover:text-yellow-400 transition-colors duration-300 rounded-md px-3 py-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Highlight</span>
                    </NuxtLink>
                    <NuxtLink to="/tip-keo"
                        class="flex items-center space-x-1 hover:text-yellow-400 transition-colors duration-300 rounded-md px-3 py-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                            </path>
                            <path fill-rule="evenodd"
                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Betting Tips</span>
                    </NuxtLink>
                    <NuxtLink to="/phim-anh"
                        class="flex items-center space-x-1 hover:text-yellow-400 transition-colors duration-300 rounded-md px-3 py-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-4 4 4 4-4V5h-2v5L8 7l-4 4v4h12z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Film</span>
                    </NuxtLink>
                    <NuxtLink to="/truyen-tranh"
                        class="flex items-center space-x-1 hover:text-yellow-400 transition-colors duration-300 rounded-md px-3 py-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm12 12h-4v-4h4v4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Comic</span>
                    </NuxtLink>
                </nav>
                <div class="flex items-center space-x-4">
                    <button
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-4 rounded-full flex items-center space-x-2 transition-colors duration-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>TIẾNG VIỆT</span>
                    </button>
                    <button class="p-2 rounded-full bg-yellow-400 hover:bg-yellow-500 transition-colors duration-300">
                        <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
</template>