<template>
  <div class="container">
    <div class="container-table"> 
        <table class="custom-table">
            <thead>
               <tr>
                   <th>Name</th>
                   <th>Number of Tasks</th>
                   <th>Date Added</th> 
                   <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <tr v-for="category in categories" :key="category.id">
                   <td>
                     <span class="default-c">
                       {{ category.name }}
                     </span>
                   </td>
                   <td>
                     <span class="default-c">
                       {{ category.tasks.length ? category.tasks.length : '-' }}
                     </span>
                   </td>
                   <td>
                     <span class="default-c">
                       {{ category.created_at }}
                      </span>
                    </td>
                    <td>
                     <button id="delete" @click="deleteCategory(category.id)">
                       <i class="fas fa-trash"></i>
                     </button>
                    </td>
               </tr>
               <tr colspan="4">
                 <td>
                   <div class="user-new-category">
                        <router-link :to="{name: 'createCategory' }">
                          <i class="far fa-plus-square"></i>
                          New Category
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
export default {
  name: "CategoryTable",
  props: {
    categories: {
        type: Array,
        required: true
        /*validator: function(obj) {
        }*/
    }
  },
  methods: {
    ...mapActions({
      deleteCategory: "category/deleteCategory"
    }),
  }
};
</script>
