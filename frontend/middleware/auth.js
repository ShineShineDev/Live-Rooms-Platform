// middleware/auth.js
export default defineNuxtRouteMiddleware(() => {
  if (process.client) {
    const token = localStorage.getItem('jwt_token')
    if (!token) {
      return navigateTo('/auth/login')
    }
  }
})
