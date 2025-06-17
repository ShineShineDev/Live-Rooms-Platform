export async function httpFetch(url, options = {}) {
  const host = 'http://localhost:8000';
  const token = localStorage.getItem('jwt_token') || ''

  options.headers = options.headers || {}

  if (token) {
    options.headers['Authorization'] = `Bearer ${token}`
  }

  if (!options.headers['Content-Type']) {
    options.headers['Content-Type'] = 'application/json'
  }

  try {
    const response = await fetch(`${host}${url}`, options)
    if (response.status === 401) {
      console.warn('Unauthorized - maybe token expired')
    }

    return response
  } catch (error) {
    console.error('HTTP fetch error:', error)
    throw error
  }
}
