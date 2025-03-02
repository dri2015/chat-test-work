import axios from 'axios'

function getUsernameFromCookies(): string | null {
  const match = document.cookie.match(/(?:^|;\s*)username=([^;]*)/)
  return match ? decodeURIComponent(match[1]) : null
}

const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8080/api',
})

axiosInstance.interceptors.request.use(
  (config) => {
    const username = getUsernameFromCookies()
    if (username) {
      config.headers['Username'] = username
    }
    return config
  },
  (error) => Promise.reject(error),
)

export default axiosInstance
