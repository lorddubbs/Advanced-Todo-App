<template>
    <div class="container">
          <div class="form-group">
          <h1>Task Comments</h1>
         </div>
          <div class="form-group margin-t-40">
            <textarea 
            placeholder="Comment about task" 
            id="comment" spellcheck="true" 
            v-model="comment">
            </textarea>
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
                Post Comment !
          </button>
        </div>
        </div>
</template>


<script>
import { mapActions } from "vuex";

export default {
  name: "CreateComment",
  props: {
     task: {
      type: Number,
      required: true
        /*validator: function(obj) {
      }*/
    }
  },
  data() {
    return {
      comment: '',
      loading: false
    }
  },
  methods: {
    ...mapActions({
      createComment: "comment/createComment"
    }),
    async initiate() {
          try {
              this.loader(true);
              await this.createComment({task_id: this.task, comment:this.comment});
              this.loader(false);
              this.$toast.info("Done");
              this.comment = ''
              } catch (error) {
                  this.loader(false);
          }
      },
      loader(args) {
        this.loading = args;
      }
  }
};
</script>
