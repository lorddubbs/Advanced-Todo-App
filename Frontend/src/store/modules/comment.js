export default {
    namespaced: true,
    state: {
      comment: [],
      comments: []
    },
    getters: {
      comment: state => state.comment,
      comments: state => state.comments
    },
    mutations: {
      SET_COMMENT(state, comment) {
        state.comment = comment;
      },
      GET_COMMENTS(state, comments) {
        state.comments = comments.data;
      },
      DELETE_COMMENT(state, comment){
        var index = state.comments.findIndex(function(item, i) {
          return item.id === comment;
        });
        state.comments.splice(index, 1)
      }
    },
    actions: {
      async createComment({ commit }, payload) {
        let comment = await this.$apiService.comment.post(payload);
        commit("GET_COMMENTS", comment);
      },

      async updateComment({ commit }, payload) {
        let task = await this.$apiService.comment.put(payload.id, payload.data);
        commit("UPDATE_COMMENT", comment.data);
      },

      async deleteComment({ commit }, payload) {
        let comment = await this.$apiService.comment.delete(payload);
        commit("DELETE_COMMENT", comment.data);
      },

      async getAllComments({ commit }, payload) {
        let comment = await this.$apiService.comment.getComments(payload);
        commit("GET_COMMENTS", comment);
      },
    }
  };
  