import axios from "axios";
import store from '@/store/index';
import cookie from '@/plugins/cookie';

const token = store.getters['user/token'] || cookie.getCookie('token');
const devInstance = createInstance(process.env.API_URL);

function createInstance(baseURL) {
    return axios.create({
    baseURL,
    withCredentials: true,
    headers: {
      Authorization: `Bearer ${token}`
    }
  });
}

devInstance.interceptors.request.use((config) => {
  let token = store.getters['user/token'] || cookie.getCookie('token');
  config.headers.Authorization = `Bearer ${token}`;
  return config;
});
devInstance.interceptors.response.use(function(response) {
  return response;
}, function (error) {
 if (error.response.status === 401 || error.response.status === 419) {
     router.push('/login');
 }
 return Promise.reject(error);
});

export default devInstance;
