export default {
    namespaced: true,
    state: {
      task: [],
      tasks: [],
      taskCount: ''
    },
    getters: {
      task: state => state.task,
      tasks: state => state.tasks,
      taskCount: state => state.taskCount
    },
    mutations: {
      SET_TASK(state, task) {
        state.task = task;
      },
      GET_TASKS(state, tasks) {
        state.tasks = tasks.data;
      },
      GET_TASK(state, task) {
        state.task = task.data;
      },
      GET_TASK_COUNT(state, task) {
        state.taskCount = task;
      },
      UPDATE_TASK(state, task) {
        var index = state.tasks.findIndex(function(item, i) {
          return item.id === task.id;
        });
        state.tasks = [
           ...state.tasks.slice(0, index),
           payload,
           ...state.tasks.slice(index + 1)
         ]
      },
      DELETE_TASK(state, task){
        var index = state.tasks.findIndex(function(item, i) {
          return item.id === task;
        });
        state.tasks.splice(index, 1)
      },
    },
    actions: {
      async createTask({ commit }, payload) {
        let task = await this.$apiService.task.post(payload);
        commit("SET_TASK", task);
      },
      
      async updateTask({ commit }, payload) {
        let task = await this.$apiService.task.put(payload.id, payload.data);
        commit("UPDATE_TASK", task.data);
      },

      async deleteTask({ commit }, payload) {
        let task = await this.$apiService.task.delete(payload);
        commit("DELETE_TASK", task.data);
      },

      async getTask({ commit }, payload) {
        let task = await this.$apiService.task.get(payload);
        commit("GET_TASK", task);
      },
      
      async getAllTasks({ commit }) {
        let tasks = await this.$apiService.task.fetch();
        commit("GET_TASKS", tasks);
        commit("GET_TASK_COUNT", tasks.data.length);
      },
    }
  };
  