<template>
  <div class="container">
      <div class="width-fix">
        <category-filter :categories="categoryData" @category="processCategory"></category-filter>
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
            <tbody>
               <tr v-for="task in taskData" :key="task.id" class="cursor-style hover-style">
                   <td @click="pushToPage(task.id, task.slug)">
                     <span class="default-c">
                       {{ task.title }}
                     </span>
                   </td>
                   <td @click="pushToPage(task.id, task.slug)">
                     <span class="access default-c" :class="task.access == '0' ? 'public-access' : (task.access == '1' ? 'private-access' : '')">
                     {{ task.access == 0 ? 'public' : 'private'}}
                     </span>
                   </td>
                   <td @click="pushToPage(task.id, task.slug)">
                     <span class="priority" :class="task.priority == 'low' ? 'low-priority' : (task.priority == 'medium' ? 'medium-priority' : 'high-priority')">
                     {{ task.priority }}
                     </span>
                   </td>
                   <td @click="pushToPage(task.id, task.slug)">
                     <span class="default-c">
                       {{ task.start_date !== null ? task.start_date: '-' }}
                      </span>
                   </td>
                   <td>
                      <button id="delete" @click="deleteTask(task.id)">
                       <i class="fas fa-trash"></i>
                     </button>
                   </td>
               </tr>
               <tr colspan="4">
                 <td>
                   <div class="user-new-category">
                        <router-link :to="{name: 'createTask' }">
                          <i class="far fa-plus-square"></i>
                          New Task
                        </router-link>
                    </div>
                 </td>
               </tr>
            </tbody>
        </table>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";

const CategoryFilter = () => import(/* webpackChunkName: "filters" */ /* webpackPrefetch: true */ "@/common/components/filters/CategoryFilter.vue");
export default {
  name: "TaskTable",
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
,        }*/
    }
  },
  components: {
    CategoryFilter
  },
  data() {
    return {
      taskData: [],
      categoryData: []
    }
  },
   computed: {
    items() {
      this.taskData = this.tasks;
      this.categoryData = this.categories;
    }
  },
  watch: {
    tasks(tasks) {
      this.taskData = tasks;
    },
    categories(categories) {
      this.categoryData = categories;
    }
  },
  methods: {
    processCategory(category) {
      this.taskData = this.tasks.filter(({categories}) => (categories.some(({ id }) => id == category)));
    },
     ...mapActions({
      deleteTask: "task/deleteTask"
    }),
    pushToPage(id, slug) {
       this.$router.push({
              name: 'viewTask',
              params: { id: id, task: slug }
        });
    }
  }
};
</script>
