import Vue from "vue";
import Vuex from "vuex";
import modules from "./modules";
import apiPlugin from "../plugins/api";

Vue.use(Vuex);

export default new Vuex.Store({
  strict: true,
  modules,
  plugins: [apiPlugin]
});
