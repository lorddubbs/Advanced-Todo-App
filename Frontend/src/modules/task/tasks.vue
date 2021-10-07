<template>
    <div class="page-main-area default-block-entry left-alignment margin-t-60">
      <task-table :tasks="tasksData" :categories="categoriesData"></task-table>
    </div>
</template>
 
<script>

const TaskTable = () => import(/* webpackChunkName: "tables" */ /* webpackPrefetch: true */ "@/common/components/tables/TaskTable.vue");

export default {
  name: "tasks",
  components: {
      TaskTable
  },
  props: {
    tasks: {
        type: Array,
        required: true
        /*validator: function(obj) {
        }*/
    },
    categories: {
        type: Array,
        required: true
        /*validator: function(obj) {
        }*/
    }
  },
  data() {
    return {
      tasksData: [],
      categoriesData: [],
    }
  },
  computed: {
    items() {
      this.tasksData = this.tasks;
      this.categoriesData = this.categories;
    }
  },
  watch: {
    tasks(tasks) {
      this.tasksData = tasks;
    },
    categories(categories) {
      this.categoriesData = categories;
    }
  }
  
};
</script>