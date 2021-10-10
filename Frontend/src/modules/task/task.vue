<template>
<div class="width-fix">
<div class="multi-step-form-container">
  <div class="container">
      <div class="form-group">
          <h1>Update {{ slug }}</h1>
      </div>

      <div class="form-group">
        <div class="task-image" v-if="taskItems.thumbnail">
        <img :src="taskItems.thumbnail" alt="Task Image" />
        </div>
      </div>

      <div class="form-group margin-t-40 default-flex-entry">
          <input type="text" placeholder="Title" v-model="taskItems.title" /> 
      </div>

       <div class="form-group"> 
          <div class="form-select">
               <select name="category_id" v-model="category_id" required>
                 <option disabled selected value="">Select a Category</option>
                 <option v-for="category in categoryItems" :value="category.id" :key="category.id">
                   {{ category.name }}
                 </option>
               </select>
               <span>
                   <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
                <div class="cc-category">
                  <p v-for="category in taskItems.categories" :key="category.id">
                  {{ category.name }}
                  </p>
                </div>
           </div>
      </div>

      <div class="form-group margin-t-10">
            <textarea 
            placeholder="Enter a Description" 
            id="description" spellcheck="true" 
            @change="describe"
            :value="description || taskItems.description">
            </textarea>
      </div>

      <div class="form-group"> 
          <div class="form-select">
               <select name="priority" v-model="taskItems.priority" required>
                 <option disabled selected value="">Choose Priority Level</option>
                 <option value="low" :selected="taskItems.priority == 'low'">low</option>
                 <option value="medium" :selected="taskItems.priority == 'medium'">medium</option>
                 <option value="high" :selected="taskItems.priority== 'high'">high</option>
               </select>
               <span>
                   <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
           </div>
      </div>

      <div class="form-group">
      <div class="container-tenor">
          <div class="tenor-range">
            <date-picker :placeholder="taskItems.start_date || 'Start Date'" v-model="start_date" valueType="format"></date-picker>
          </div>
          <div class="tenor-range">
            <date-picker :placeholder="taskItems.end_date || 'End Date'" v-model="end_date" valueType="format"></date-picker>
          </div>
      </div>
      </div>

      <div class="form-group margin-t-10 default-flex-entry">
          <div class="upload-box">
              <label class ="upload-button" for="upload_file"> Select Image
              <input id="upload_file" type="file" ref="thumbnail" @change="getFile($event)" /> 
              </label>
          </div>
      </div>

      <div class="form-group margin-t-10 default-flex-entry">
              <div class="width-fix margin-t-10 checkbox">
                  <input type="checkbox" id="access" true-value="1" false-value="0" v-model="taskItems.access">
                  <label for="access" v-if="taskItems.access == 0">Mark as Private</label>
                  <label for="access" v-else-if="taskItems.access == 1">Switch to Public</label>
              </div>
      </div>
      

      <div class="form-group margin-t-20 default-flex-entry">
          <button class="btn" @click="initiate">
              <div class="form-group-loader" v-if="loading">
              <div class="loader">
                    <span>
                    <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </div>
                </div>
                Go Again !
          </button>
        </div>
      </div>
      
  </div>
  <div class="comments-container" v-if="taskItems.id">
        <comment :task="taskItems.id" :comments="taskComments"></comment>
  </div>
  
  </div>
</template>

<script>

import { mapGetters, mapActions } from "vuex";
const Comment = () => import(/* webpackChunkName: "overlays" */ /* webpackPrefetch: true */ "@/common/components/overlays/Comments.vue");
import DatePicker from 'vue2-datepicker';

import BreadCrumbs from "@/common/mixins/breadcrumb";
import TaskCrud from "@/common/mixins/taskCrud";
import FileUpload from "@/common/mixins/fileUpload";


export default {
  name: "task",
   props: {
    slug: {
      type: String
    },
    task: {
      type: Object
    },
    categories: {
      type: Array
    }
  },
  mixins: [
      BreadCrumbs,
      FileUpload,
      TaskCrud
  ],
  components: {
    Comment,
    DatePicker
  },
   created() {
     this.setBreadcrumbs([
      { 
        name: 'dashboard', 
        to:   'dashboardHome'
      },
      { 
        name: 'tasks', 
        to:   'tasks'
      },
      { 
        name: this.slug, 
          to: 'viewTask'
      }
    ]);
     if(this.task === undefined) {
       this.getTask(this.uniqueId);
       this.getAllCategories();
     }
     this.getAllComments(this.uniqueId);
  },
   data() {
    return {
      uniqueId: this.$route.params.id,
      description: '',
      start_date: '',
      end_date: '',
      category_id: '',
      thumbnail: '',
      loading: false
    };
  },
  computed: {
    ...mapGetters({
      currentTask: "task/task",
      categoryList: "category/categories",
      taskComments: "comment/comments"
    }),
    taskItems() {
      if(this.task !== undefined) {
        return {...this.task}
      }
        return {...this.currentTask};
    },
    categoryItems() {
      if(this.categories !== undefined) {
        return {...this.categories}
      }
        return {...this.categoryList};
    }
  },
  methods: { 
    describe(e) {
      this.description = e.target.value
    },
    ...mapActions({
      getTask: "task/getTask",
      getAllCategories: "category/getAllCategories",
      getAllComments: "comment/getAllComments",
      updateTask: "task/updateTask",
      deleteTask: "task/deleteTask"
    })
  }
};
</script>