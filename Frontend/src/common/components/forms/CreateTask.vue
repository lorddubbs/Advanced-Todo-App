<template>
  <div class="container">
      <div class="form-group">
          <h1>Create</h1>
      </div>

      <div class="form-group margin-t-20 default-flex-entry">
          <input type="text" placeholder="Title" v-model="title" />
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
            v-model="description">
            </textarea>
      </div>
      <div class="form-group"> 
          <div class="form-select">
               <select name="priority" v-model="priority" required>
                 <option disabled selected value="">Choose Priority Level</option>
                 <option value="low">low</option>
                 <option value="medium">medium</option>
                 <option value="high">high</option>
               </select>
               <span>
                   <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
           </div>
      </div>
      <div class="form-group">
      <div class="container-tenor">
          <div class="tenor-range">
            <date-picker placeholder="Task starts" v-model="start_date" valueType="format"></date-picker>
          </div>
          <div class="tenor-range">
            <date-picker placeholder="Task ends" v-model="end_date" valueType="format"></date-picker>
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
                  <input type="checkbox" id="access" true-value="1" false-value="0" v-model="access">
                  <label for="access">Mark as Private</label>
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
                Begin !
          </button>
        </div>
  </div>
</template>

<script>

import { mapActions } from "vuex";
import DatePicker from 'vue2-datepicker';
import FileUpload from "@/common/mixins/fileUpload";


export default {
  name: "CreateTask",
  props: {
    categories: {
        type: Array,
        required: true
        /*validator: function(obj) {
        }*/
    }
  },
  mixins: [
    FileUpload
  ],
  components: {
      DatePicker
  },
  data() {
    return {
        title: '',
        description: '',
        priority: '',
        category_id: '',
        start_date:'',
        end_date:'',
        access: '0',
        thumbnail: '',
        loading: false
    };
  },
  methods: {
      ...mapActions({
          createTask: "task/createTask"
        }),
      async initiate() {
          try {
              this.loader(true);
              let payload = this.getPayload();
              await this.createTask(payload);
              this.loader(false);
              this.$toast.info("Task Created");
              this.$router.push({
                name: 'tasks'
              });
              } catch (error) {
                  this.loader(false);
              }
      },
      getPayload() {
          let payload = new FormData();
          payload.append('title', this.title);
          payload.append('description', this.description);
          payload.append('priority', this.priority);
          payload.append('category_id', this.category_id);
          payload.append('start_date', this.start_date);
          payload.append('end_date', this.end_date);
          payload.append('access', this.access);
          payload.append('thumbnail', this.thumbnail);
          return payload;
      },
      loader(args) {
        this.loading = args;
      }
  }

};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only 
<style scoped lang="scss">

</style>
-->
