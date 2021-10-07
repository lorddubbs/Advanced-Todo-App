import Vue from "vue";
const cookie = {
    setCookie(name, cookie_value, expiry) {
    const d = new Date();
    d.setTime(d.getTime() + (expiry*24*60*60*1000));
    let expires = "expires=" + d.toGMTString();
    document.cookie = name + "=" + cookie_value + ";" + expires + ";path=/";
  },
   getCookie(name) {
    let cookie_name = name + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(cookie_name) == 0) {
        return c.substring(cookie_name.length, c.length);
      }
    }
    return "";
    },
    deleteCookie(name) {
        let opts = 0;
        this.setCookie(name, '', opts);
    },
    install(Vue) {
      Vue.prototype.$cookie = this;
    }
  }

  export default cookie;