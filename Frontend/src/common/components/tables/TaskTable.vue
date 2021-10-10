<template>
            <tbody>
               <tr v-for="task in tasks" :key="task.id" class="cursor-style hover-style">
                   <td @click="pushToPage(task)">
                     <span class="default-c">
                       {{ task.title }}
                     </span>
                   </td>
                   <td @click="pushToPage(task)">
                     <span class="access default-c" :class="task.access == '0' ? 'public-access' : (task.access == '1' ? 'private-access' : '')">
                     {{ task.access == 0 ? 'public' : 'private'}}
                     </span>
                   </td>
                   <td @click="pushToPage(task)">
                     <span class="priority" :class="task.priority == 'low' ? 'low-priority' : (task.priority == 'medium' ? 'medium-priority' : 'high-priority')">
                     {{ task.priority }}
                     </span>
                   </td>
                   <td @click="pushToPage(task)">
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
</template>

<script>
import { mapActions } from "vuex";

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
        }*/
    }
  },
  methods: {
     ...mapActions({
      deleteTask: "task/deleteTask"
    }),
    pushToPage(task) {
       this.$router.push({
              name: 'viewTask',
              params: { 
                id: task.id,
                slug: task.slug, 
                task: task, 
                categories: this.categories
              }
        });
    }
  }
};
</script>
