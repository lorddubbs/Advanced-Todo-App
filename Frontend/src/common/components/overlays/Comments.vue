<template>
    <div class="width-fix">
      <div class="multi-step-comment-form-container">
        <create-comment :task="task"></create-comment>

        <div class="comment-section">
          <div class="multi-step-comment">
        <div class="container">
          <div class="form-group" v-for="comment in comments" :key="comment.id" @mouseover="hover = true" @mouseleave="hover = false">
            <p class="commented">
              {{ comment.comment }}
            </p>
            <div class="edit-button">
              <ul v-show="hover">
                <li>
                  <span @click="deleteComment(comment.id)" class="cursor-style"><i class="fas fa-trash"></i></span>
                </li>
              </ul>
            </div>
          </div>
          </div>
          </div>
        </div>
      </div>
    </div>
        
</template>

<script>
import { mapActions } from "vuex";
const CreateComment = () => import(/* webpackChunkName: "forms" */ /* webpackPrefetch: true */ "@/common/components/forms/CreateComment.vue");

export default {
  name: "Comments",
  props: {
     task: {
      type: Number,
      required: true
        /*validator: function(obj) {
      }*/
    },
    comments: {
        type: Array,
        required: true
        /*validator: function(obj) {
        }*/
    }
  },
  components: {
    CreateComment
  },
  data() {
    return {
      hover: false,
    }
  },
  methods: {
    ...mapActions({
      deleteComment: "comment/deleteComment"
    })
  }
};
</script>
