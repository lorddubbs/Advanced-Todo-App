import { mapActions, mapGetters } from "vuex";

export default {
    computed: {
        ...mapGetters({
            categories: "category/categories",
            tasks: "task/tasks"
        })
    },
    methods: {
        ...mapActions({
            getTasks: "task/getAllTasks",
            getCategories: "category/getAllCategories"
          })
    }
}