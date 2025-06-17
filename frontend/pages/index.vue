<template>
  <div class="p-4">
    <RoomList />
    <Toast ref="toast" />
  </div>
</template>

<script>
import io from 'socket.io-client'
import Toast from '~/components/Toast.vue'
import { useAuth } from '~/composables/useAuth'

export default {
  data() {
    return {
      authUser: null,
      socket: null
    }
  },
  components: {
    Toast
  },
  async created() {
    const { user, fetchUser } = useAuth()
    await fetchUser()
    this.authUser = user.value

    this.socket = io('http://localhost:4000')

    if (this.authUser && this.authUser.id) {
      this.socket.emit('join', this.authUser.id)
    }

    this.socket.on('room_subscribed', (data) => {
      this.$refs.toast.show({
        type: 'info',
        title: 'Message From Websocket',
        message: JSON.stringify(data),
        timeout: 3000
      })
    })
  },
  beforeDestroy() {
    if (this.socket) {
      this.socket.disconnect()
    }
  },
  methods: {
  notifySuccess() {
    this.$refs.toast.show({
      type: 'success',
      title: 'Success!',
      message: 'Your action was completed.',
      timeout: 3000
    })
  }
  }
}
</script>
