<!-- components/EventList.vue -->
<template>
    <div class="container mx-auto px-4 py-2">
        <div v-if="loading" v-for="n in 4" :key="n">
            <RoomLoading class="mt-3"></RoomLoading>
        </div>
        <div v-for="(datas, category) in events" :key="category" class="bg-gray-100  p-2 rounded-lg mt-4">
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
                                <span> &nbsp; {{ event.commentator }}</span>
                            </div>
                            <button @click="subscribe(event.id)" style="cursor: focus;"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-1 px-3 rounded-md flex items-center space-x-1">
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
 
export default {
    name: 'EventList',
    data() {
        return {
            events: [],
            loading: true,
            error: null,
            authUser: null,
            router: null,
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
        async subscribe(id) {
            if (this.authUser != null) {
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
                    alert(data.message);
                } catch (error) {
                    console.error('Failed to load events:', error);
                    this.error = 'Unable to fetch events.';
                } finally {
                    this.loading = false;
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
/* Custom scrollbar hide for aesthetic purposes on this specific component */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
    /* For Chrome, Safari, and Opera */
}

.scrollbar-hide {
    -ms-overflow-style: none;
    /* For Internet Explorer and Edge */
    scrollbar-width: none;
    /* For Firefox */
}
</style>
