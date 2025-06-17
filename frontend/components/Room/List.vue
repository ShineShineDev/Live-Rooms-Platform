<!-- components/EventList.vue -->
<template>
    <div class="container mx-auto px-4 py-2">
        <div v-if="loading" v-for="n in 4" :key="n">
            <RoomLoading class="mt-3"></RoomLoading>
        </div>
        <Toast ref="toast" />
        <div class="flex justify-end">
            <div v-if="subscribeLoading" role="status">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="flex justify-end">
            <div class="p-4">
                <div class="mb-4">
                    <button v-for="option in filterOptions" :key="option.value"
                        :class="['px-4 py-2 rounded mr-2', selectedFilter === option.value ? 'bg-blue-600 text-white' : 'bg-gray-200']"
                        @click="filteredSubscriptions(option.value)">
                        {{ option.label }}
                    </button>
                </div>
            </div>
        </div>

        <div v-for="(datas, category) in events" :key="category" class="bg-gray-100  p-2 rounded-lg">
            <h6> {{ category }} </h6>
            <div class="flex overflow-x-auto space-x-4 pb-4 scrollbar-hide mt-2">
                <!-- Scroll navigation arrows (simplified) -->
                <!-- <button
                    class="flex-shrink-0 p-2 rounded-full bg-gray-200 hover:bg-gray-300 self-center hidden md:block">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button> -->

                <div v-for="event in datas" :key="event.id"
                    class="flex-shrink-0 w-64 bg-white rounded-lg shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                    <div class="relative">
                        <img :src="event.image_url" :alt="event.title" class="w-full h-32 object-cover">
                        <span v-if="event.is_live"
                            class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">LIVE</span>
                        <span v-if="event.is_hot"
                            class="absolute top-2 left-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">HOT</span>
                    </div>
                    <!-- <p class="text-sm text-gray-500 p-1 ">{{ event.category }}</p> -->
                    <div class="px-0  py-0" style="background-color: #f5e185;">
                        <div class="flex items-center justify-center space-x-2 ">
                            <h6 class="text-lg  text-gray-800">{{ event.team_a }}</h6>
                            <span class="text-lg font-bold text-red-600">VS</span>
                            <h6 class="text-lg  text-gray-800">{{ event.team_b }}</h6>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-700">
                            <div class="flex items-center space-x-1">
                                <span>&nbsp; {{ formatDate(event.date) }} {{ event.time }}</span>
                            </div>
                            <button @click="subscribe(event.id)"
                                class="bg-gray-200 cursor-pointer hover:bg-gray-300 text-gray-800 font-medium py-1 px-3 rounded-md flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5m6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5z" />
                                </svg>
                                <span>Subscribe</span>
                            </button>

                        </div>
                    </div>
                </div>

                <!-- <button
                    class="flex-shrink-0 p-2 rounded-full bg-gray-200 hover:bg-gray-300 self-center hidden md:block">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button> -->
            </div>
        </div>

        <div v-if="events.length == 0" class="text-center text-gray-500 py-10">
            <p class="text-lg mb-4">No events available at the moment.</p>
        </div>

    </div>
</template>
<script>
import { httpFetch } from '~/composables/http'
import Toast from '~/components/Toast.vue'
export default {
    name: 'EventList',
    data() {
        return {
            events: [],
            loading: true,
            error: null,
            authUser: null,
            router: null,
            subscribeLoading: false,
            selectedFilter: 'all',
            filterOptions: [
                { label: 'All', value: 'all' },
                { label: 'Live Now', value: 'live_now' },
                { label: 'Today', value: 'today' },
                { label: 'Tomorrow', value: 'tomorrow' }
            ]
        };
    },
    mounted() {
        this.router = useRouter()
        this.fetchEvents();
    },
    async created() {
        const { user, fetchUser } = useAuth()
        fetchUser()
        this.authUser = user.value
    },
    methods: {
        formatDate(date) {
            return date ? date.split('T')[0] : ''
        },
        async fetchEvents() {
            try {
                const response = await httpFetch('/api/gateway/pub/live_room_service/rooms')
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`)
                }
                const data = await response.json();
                this.events = data.data;
            } catch (error) {
                console.error('Failed to load events:', error);
                this.error = 'Unable to fetch events.';
            } finally {
                this.loading = false;
            }
        },
        async filteredSubscriptions(value) {
            this.selectedFilter = value;
            this.subscribeLoading = true;
            try {
                const { user } = useAuth();
                const userId = user.value?.id;

                if (!userId) {
                    throw new Error("User not authenticated");
                }

                const response = await httpFetch(`/api/gateway/pub/live_room_service/rooms/filter/option?filter=${this.selectedFilter}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                this.events = data.data;
            } catch (error) {
                console.error("Filter fetch failed:", error);
                this.$refs.toast?.show({
                    type: 'error',
                    title: 'Error',
                    message: 'Unable to filter subscriptions.',
                    timeout: 3000
                });
            } finally {
                this.subscribeLoading = false;
            }
        },

        async subscribe(id) {
            if (this.authUser != null) {
                this.subscribeLoading = true;
                const user_id = this.authUser.id
                try {
                    const response = await httpFetch('/api/gateway/subscription_service/subscribe', {
                        method: 'POST',
                        body: JSON.stringify({
                            user_id,
                            room_id: id,
                        }),
                    });
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();

                    this.$refs.toast.show({
                        type: 'info',
                        title: 'Message',
                        message: data.message,
                        timeout: 3000
                    })
                } catch (error) {
                    console.error('Failed to load events:', error);
                    this.error = 'Unable to fetch events.';
                } finally {
                    this.subscribeLoading = false;
                }
            } else {
                alert("Please Login First")
                this.router.push('/auth/login')
            }
        }
    }

};
</script>


<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
