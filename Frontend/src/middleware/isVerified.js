// src/middleware/isVerified.js

export default function guest ({ next }){
        let isVerified = localStorage.getItem("one_id_verified")
        if (isVerified) {
            return next({
                name: 'dashboardHome'
            })
        }
    
    return next()
   }