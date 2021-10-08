import Vue from "vue";
import axios from "@/plugins/request";
Vue.prototype.$axios = axios;
import App from "@/App.vue";
import "@/common/mixins/apiMixin";
import router from "@/router";
import store from "@/store/index";
import cookies from "@/plugins/cookie";
Vue.prototype.$cookies = cookies;

import "bootstrap/dist/css/bootstrap.min.css";
import 'vue2-datepicker/index.css';
import "jquery/src/jquery.js";
import "bootstrap/dist/js/bootstrap.min.js";
import "@/assets/sass/std.scss";
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-default.css';

Vue.use(VueToast, {
  position: 'top-right',
  queue: true,
  duration: 5000
});


Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#stdapp"); 
