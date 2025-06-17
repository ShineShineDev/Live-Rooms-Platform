<template>
  <div class="p-6">
    <UCard
      class="max-w-md mx-auto shadow-xl rounded-xl"
      :ui="{
        base: 'overflow-hidden',
        ring: 'ring-1 ring-gray-200 dark:ring-gray-800',
        divide: 'divide-y divide-gray-200 dark:divide-gray-800',
        header: { padding: 'px-6 py-4' },
        body: { padding: 'px-0 py-0' },
        footer: { padding: 'px-6 py-4' }
      }"
    >
      <template #header>
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white">Your Notifications</h3>
          <UBadge
            v-if="unreadCount > 0"
            color="primary"
            variant="solid"
            size="sm"
            class="ml-2 px-2 py-1 rounded-full text-xs font-semibold"
          >
            {{ unreadCount }} New
          </UBadge>
        </div>
      </template>

      <div v-if="notifications.length === 0" class="py-10 text-center text-gray-500">
        <UIcon name="i-heroicons-bell-slash" class="w-8 h-8 mb-2" />
        <p class="text-lg">No new notifications for now!</p>
        <p class="text-sm">We'll let you know when something pops up.</p>
      </div>

      <UList v-else class="divide-y divide-gray-200 dark:divide-gray-800">
        <UListItem
          v-for="notification in notifications"
          :key="notification.id"
          class="group transition-all duration-200 ease-in-out cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800"
          :class="{ 'bg-blue-50 dark:bg-blue-950': !notification.read }"
        >
          <div class="flex items-start p-4">
            <div class="mr-3 pt-1">
              <UIcon
                :name="notification.icon"
                class="w-6 h-6"
                :class="notification.read ? 'text-gray-400' : 'text-primary-500 dark:text-primary-400'"
              />
            </div>
            <div class="flex-grow">
              <div class="flex items-center justify-between mb-1">
                <p class="font-semibold" :class="notification.read ? 'text-gray-700 dark:text-gray-300' : 'text-gray-900 dark:text-white'">
                  {{ notification.title }}
                </p>
                <span class="text-xs text-gray-400">{{ notification.time }}</span>
              </div>
              <p
                class="text-sm line-clamp-2"
                :class="notification.read ? 'text-gray-500 dark:text-gray-400' : 'text-gray-600 dark:text-gray-300'"
              >
                {{ notification.message }}
              </p>
            </div>
          </div>
          <template #trailing>
            </template>
        </UListItem>
      </UList>

      <template #footer>
        <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
          <span>Last updated: {{ lastUpdated }}</span>
          <UButton
            v-if="unreadCount > 0"
            variant="link"
            color="primary"
            size="sm"
            @click="markAllAsRead"
          >
            Mark all as read
          </UButton>
        </div>
      </template>
    </UCard>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const notifications = ref([
  { id: 1, title: 'New Message', message: 'You have a new message from John Doe. Check it out now!', time: '2 mins ago', read: false, icon: 'i-heroicons-chat-bubble-left-right' },
  { id: 2, title: 'Event Reminder', message: 'Your meeting with Jane is in 30 minutes. Don\'t forget your presentation!', time: '1 hour ago', read: false, icon: 'i-heroicons-calendar-days' },
  { id: 3, title: 'System Update', message: 'Good news! Our system update completed successfully. Enjoy the new features!', time: 'Yesterday', read: true, icon: 'i-heroicons-wrench-screwdriver' },
  { id: 4, title: 'New Follower', message: 'Sarah joined your network! Say hello and welcome her.', time: '2 days ago', read: false, icon: 'i-heroicons-user-plus' },
  { id: 5, title: 'Payment Confirmed', message: 'Your recent payment of $49.99 for premium subscription has been successfully processed.', time: '3 days ago', read: true, icon: 'i-heroicons-currency-dollar' },
]);

const lastUpdated = ref(new Date().toLocaleString());

const unreadCount = computed(() => {
  return notifications.value.filter(n => !n.read).length;
});

const markAllAsRead = () => {
  notifications.value.forEach(n => {
    n.read = true;
  });
};
</script>

<style scoped>
/* No custom styles needed here thanks to Nuxt UI and Tailwind CSS */
</style>