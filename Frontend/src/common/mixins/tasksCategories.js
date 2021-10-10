import { mapActions, mapGetters } from "vuex";

export default {
    computed: {
        ...mapGetters({
            categories: "category/categories",
            tasks: "task/tasks"
        })
    },
    watch: {
        tasks : {
          immediate:true,
          handler(tasks) {
            this.tasksData = tasks;
            this.taskCountStorage(tasks.length)
          }
        },
        categories : {
          immediate:true,
          handler(categories) {
            this.categoriesData = categories
            this.categoryCountStorage(categories.length)
          }
        }
      },
    methods: {
        ...mapActions({
            getTasks: "task/getAllTasks",
            getCategories: "category/getAllCategories"
        }),
        taskCountStorage(args) {
            localStorage.removeItem('taskCount');
            localStorage.setItem('taskCount', args)
          },
        categoryCountStorage(args) {
            localStorage.removeItem('categoryCount');
            localStorage.setItem('categoryCount', args)
        }
    }
}