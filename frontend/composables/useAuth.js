import { ref } from 'vue'
import { useRuntimeConfig } from '#app'

const user = ref(null)

export function useAuth() {
  const config = useRuntimeConfig()

  const login = async ({ email, password }) => {
    const res = await fetch(`${config.public.apiBase}/api/user/auth/login`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ identifier : email, password })
    })

    const data = await res.json()
    if (!res.ok) {
      throw new Error(data.message || 'Login failed')
    }

    user.value = data.data.customer

    if (process.client) {
      localStorage.setItem('authUser', JSON.stringify(data.data.customer))
      localStorage.setItem('jwt_token', data.data.token)
    }

    return data.data.customer
  }

  const register = async ({ first_name, last_name, email, phone,password, password_confirmation }) => {
    const res = await fetch(`${config.public.apiBase}/api/user/auth/register`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ first_name,last_name,email, phone : '',password,password_confirmation })
    })
    const data = await res.json()
    if (!res.ok) {
      throw new Error(data.message || 'register failed')
    }
    user.value = data.data.customer

    if (process.client) {
      localStorage.setItem('authUser', JSON.stringify(data.data.customer))
      localStorage.setItem('jwt_token', data.data.token)
    }

    return data.data.customer
  }

  const logout = () => {
    user.value = null
    if (process.client) {
      localStorage.removeItem('authUser')
      localStorage.removeItem('jwt_token')
    }
  }

  const fetchUser = () => {
    if (process.client) {
      const authUser = localStorage.getItem('authUser')
      if (authUser) {
        user.value = JSON.parse(authUser)
      }
    }
  }

  return { user, login, logout, fetchUser,register }
}
