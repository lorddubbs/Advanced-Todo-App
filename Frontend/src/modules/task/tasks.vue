<template>
    <div class="page-main-area default-block-entry left-alignment margin-t-60">
      <div class="container">
      <div class="width-fix">
        <category-filter :categories="categoriesData" @category="processCategory"></category-filter>
      </div>
    <div class="container-table"> 
        <table class="custom-table">
            <thead>
               <tr>
                   <th>Title</th>
                   <th>Access</th>
                   <th>Priority</th>
                   <th>Start Date</th>
                   <th>Action</th>
               </tr>
            </thead>
      <task-table :tasks="tasksData"></task-table>
      </table>
    </div>
  </div>
    </div>
</template>
 

<script>

import { mapGetters, mapActions } from "vuex";
const CategoryFilter = () => import(/* webpackChunkName: "filters" */ /* webpackPrefetch: true */ "@/common/components/filters/CategoryFilter.vue");
const TaskTable = () => import(/* webpackChunkName: "tables" */ /* webpackPrefetch: true */ "@/common/components/tables/TaskTable.vue");

export default {
  name: "tasks",
  components: {
      TaskTable,
      CategoryFilter
  },
  created() {
    this.getTasks();
    this.getCategories();
  },
  data() {
    return {
      tasksData: [],
      categoriesData: []
    }
  },
  computed: {
    ...mapGetters({
      tasks: "task/tasks",
      categories: "category/categories"
    })
  },
  watch: {
    tasks : {
      immediate:true,
      handler(tasks) {
        this.tasksData = tasks;
      }
    },
    categories : {
      immediate:true,
      handler(categories) {
        this.categoriesData = categories
      }
    }
  },
  methods: {
    ...mapActions({
      getTasks: "task/getAllTasks",
      getCategories: "category/getAllCategories"
    }),
    processCategory(category) {
      if(category) {
      this.tasksData = this.tasks.filter(({categories}) => (categories.some(({ id }) => id == category)));
      return;
      }
      this.tasksData = this.tasks;
    }
  }
};
</script>