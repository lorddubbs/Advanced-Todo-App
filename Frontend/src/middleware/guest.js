// src/middleware/guest.js

import store from '@/store/index';
import cookie from '@/plugins/cookie';

export default function guest ({ next, router }){
    let user = store.getters['user/token'] || cookie.getCookie('token');
    if(user.length) {
        return next({
            name: 'dashboardHome'
        })
    }
    return next();
   }