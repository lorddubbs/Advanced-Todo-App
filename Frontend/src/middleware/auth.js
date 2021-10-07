// src/middleware/auth.js

import store from '../store/index';
import cookie from '@/plugins/cookie';

export default function auth({ next, router }) {
  let user = store.getters['user/token'] || cookie.getCookie('token');
  if(!user.length) {
      return next({
        name: 'login'
     })
  }
  return next();
}

