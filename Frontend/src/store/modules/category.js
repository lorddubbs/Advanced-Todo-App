export default {
    namespaced: true,
    state: {
      category: [],
      categories: []
    },
    getters: {
      category: state => state.category,
      categories: state => state.categories
    },
    mutations: {
      SET_CATEGORY(state, category) {
        state.category = category;
      },
      GET_CATEGORIES(state, categories) {
        state.categories = categories.data;
      },
      GET_CATEGORY(state, category) {
        state.category = category;
      },
      DELETE_CATEGORY(state, category){
        var index = state.categories.findIndex(function(item, i) {
          return item.id === category;
        });
        state.categories.splice(index, 1)
      }
    },
    actions: {
      async createCategory({ commit }, payload) {
        let category = await this.$apiService.category.post(payload);
        commit("SET_CATEGORY", category);
      },

      async getCategory({ commit }) {
        let category = await this.$apiService.category.get(id);
        commit("GET_CATEGORY", category);
      },

      async getAllCategories({ commit }) {
        let categories = await this.$apiService.category.fetch();
        commit("GET_CATEGORIES", categories);
      },

      async deleteCategory({ commit }, payload) {
        let category = await this.$apiService.category.delete(payload);
        commit("DELETE_CATEGORY", category.data);
      },
    }
  };
  