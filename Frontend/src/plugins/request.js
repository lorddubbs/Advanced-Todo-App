import axios from "axios";
import store from '@/store/index';
import cookie from '@/plugins/cookie';

const devInstance = createInstance(process.env.API_URL);
    
function createInstance(baseURL) {
  let token = cookie.getCookie('token') || store.getters['user/token'];
    return axios.create({
    baseURL,
    withCredentials: true,
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

export default devInstance;
