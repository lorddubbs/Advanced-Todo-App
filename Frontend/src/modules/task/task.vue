<template>
<div class="width-fix">
<div class="multi-step-form-container">
  <div class="container">
      <div class="form-group">
          <h1>Update {{ page }}</h1>
      </div>

      <div class="form-group">
        <div class="task-image" v-if="items.thumbnail">
        <img :src="items.thumbnail" alt="Task Image" />
        </div>
      </div>

      <div class="form-group margin-t-40 default-flex-entry">
          <input type="text" placeholder="Title" v-model="items.title" /> 
      </div>
       <div class="form-group"> 
          <div class="form-select">
               <select name="category_id" v-model="category_id" required>
                 <option disabled selected value="">Select a Category</option>
                 <option v-for="category in categories" :value="category.id" :key="category.id">
                   {{ category.name }}
                 </option>
               </select>
               <span>
                   <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
           </div>
      </div>
      <div class="form-group margin-t-10">
            <textarea 
            placeholder="Enter a Description" 
            id="description" spellcheck="true" 
            v-model="items.description">
            </textarea>
      </div>
      <div class="form-group"> 
          <div class="form-select">
               <select name="priority" v-model="items.priority" required>
                 <option disabled selected value="">Choose Priority Level</option>
                 <option value="low" :selected="items.priority == 'low'">low</option>
                 <option value="medium" :selected="items.priority == 'medium'">medium</option>
                 <option value="high" :selected="items.priority== 'high'">high</option>
               </select>
               <span>
                   <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
           </div>
      </div>
      <div class="form-group">
      <div class="container-tenor">
          <div class="tenor-range">
            <date-picker :placeholder="taskItems.start_date || 'Start Date'" v-model="items.start_date" valueType="format"></date-picker>
          </div>
          <div class="tenor-range">
            <date-picker :placeholder="taskItems.start_date || 'End Date'" v-model="items.end_date" valueType="format"></date-picker>
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
                  <input type="checkbox" id="access" true-value="1" false-value="0" v-model="items.access">
                  <label for="access" v-if="items.access == 0">Mark as Private</label>
                  <label for="access" v-else-if="items.access == 1">Switch to Public</label>
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
  <div class="comments-container" v-if="items.id">
        <comment :task="items.id" :comments="taskComments"></comment>
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
  mixins: [
      BreadCrumbs,
      FileUpload,
      TaskCrud
  ],
  props: {
    categories: {
        type: Array,
        required: true
        /*validator: function(obj) {
        }*/
    }
  },
  components: {
    Comment,
    DatePicker
  },
   created() {
    this.getTask(this.uniqueId);
    this.getAllComments(this.uniqueId);
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
        name: this.page, 
          to: 'viewTask'
      }
    ]);
  },
   data() {
    return {
      uniqueId: this.$route.params.id,
      page: this.$route.params.task,
      category_id: '',
      items: [],
      thumbnail: '',
      loading: false
    };
  },
  computed: {
    ...mapGetters({
      task: "task/task",
      taskComments: "comment/comments"
    }),
    taskItems() {
        return {...this.task};
    }
  },
  watch: {
    taskItems(itemState) {
      this.items = itemState;
    }
  },
  methods: { 
    ...mapActions({
      getTask: "task/getTask",
      getAllComments: "comment/getAllComments",
      updateTask: "task/updateTask",
      deleteTask: "task/deleteTask"
    })
  }
};
</script>