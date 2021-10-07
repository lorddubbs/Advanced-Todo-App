import cookie from "@/plugins/cookie";

export default {
    namespaced: true,
    state: {
      user: [],
      users: [],
      token: ''
    },
    getters: {
      user: state => state.user,
      users: state => state.users,
      token: state => state.token
    },
    mutations: {
      SET_USER(state, user) {
        state.user = user.user;
        state.token = user.token;
      },
      SET_USERS(state, users) {
        state.users = users;
      },
      GET_USER(state, user) {
        state.user = user;
      }
    },
    actions: {
      async registerUser({ commit }, payload) {
        let user = await this.$apiService.auth.registerUser(payload);
        cookie.setCookie('token', user.data.token)
        commit("SET_USER", user.data);
      },
      async loginUser({ commit }, payload) {
        let user = await this.$apiService.auth.loginUser(payload);
        cookie.setCookie('token', user.data.token)
        commit("SET_USER", user.data);
      },
      async verifyUser({ commit }) {
        let user = await this.$apiService.auth.verifyUser();
        return user;
      },
      async getUser({ commit }) {
        let user = await this.$apiService.user.myProfile();
        commit("GET_USER", user);
      },
      async updateUser({ commit }, payload) {
        let user = await this.$apiService.user.updateProfile(payload);
        commit("UPDATE_USER", user.data);
      },
      async getAllUsers({ commit }) {
        let users = await this.$apiService.user.fetch();
        commit("SET_USERS", users.data);
      },
    }
  };
  