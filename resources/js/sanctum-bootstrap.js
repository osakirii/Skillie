import axios from 'axios';

// configure axios for cookie-based auth
axios.defaults.baseURL = process.env.MIX_APP_URL || 'http://localhost:8000';
axios.defaults.withCredentials = true;

export async function initSanctum() {
  // call CSRF endpoint first
  await axios.get('/sanctum/csrf-cookie');
}

export default axios;
