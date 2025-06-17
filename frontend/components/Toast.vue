<template>
  <transition name="fade">
    <div
      v-if="visible"
      :class="[
        'fixed top-6 right-6 z-50 flex items-start gap-3 p-4 rounded-lg shadow-lg max-w-xs w-full text-sm text-white',
        toastType.bg
      ]"
      role="alert"
    >
      <i :class="[toastType.icon, 'w-5 h-5 mt-0.5 flex-shrink-0']"></i>

      <div class="flex-1">
        <strong class="block mb-0.5">{{ title }}</strong>
        <p class="text-sm opacity-90">{{ message }}</p>
      </div>

      <button @click="hide" class="ml-3 text-white opacity-70 hover:opacity-100">
        <i class="i-heroicons-x-mark w-4 h-4"></i>
      </button>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'Toast',
  data() {
    return {
      visible: false,
      title: '',
      message: '',
      timeout: 3000,
      type: 'info',
      toastType: {
        icon: 'i-heroicons-information-circle',
        bg: 'bg-blue-600'
      }
    }
  },
  methods: {
    show({ title = 'Notification', message = '', type = 'info', timeout = 3000 }) {
      this.title = title
      this.message = message
      this.type = type
      this.timeout = timeout

      switch (type) {
        case 'success':
          this.toastType.icon = 'i-heroicons-check-circle'
          this.toastType.bg = 'bg-green-600'
          break
        case 'error':
          this.toastType.icon = 'i-heroicons-x-circle'
          this.toastType.bg = 'bg-red-600'
          break
        case 'warning':
          this.toastType.icon = 'i-heroicons-exclamation-triangle'
          this.toastType.bg = 'bg-yellow-500'
          break
        default:
          this.toastType.icon = 'i-heroicons-information-circle'
          this.toastType.bg = 'bg-blue-600'
          break
      }

      this.visible = true

      setTimeout(() => {
        this.visible = false
      }, this.timeout)
    },
    hide() {
      this.visible = false
    }
  }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
  transform: translateY(4px);
}
</style>
