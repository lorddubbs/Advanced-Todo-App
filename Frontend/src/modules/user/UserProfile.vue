<template>
  <div class="container">
    <div class="layout-container center-alignment">
      <div class="user-layout-form-item default-block-entry left-alignment">
        <div class="user-layout-form default-block-entry left-alignment padding-t-10">
          <div class="layout-form-item default-block-entry left-alignment margin-t-40">
                <div class="container">
                  <div class="image-group">
                  <div id="profiler"> 
                    <div class="image-upload">
                        <label for="my-file"><i class="fas fa-camera"></i></label>
                        <input type="file" accept="image/*" @change="previewImage" id="my-file">
                    </div>
                    <div class="border-image">
                        <div class="image" v-if="imagePreview">
                        <img :src="imagePreview" />
                        </div>
                        <div class="image" v-else-if="userData.thumbnail != null">
                        <img :src="userData.thumbnail" alt="Image" />
                        </div>
                        <div id="default" v-else>
                        <span><i class="fas fa-user-circle"></i></span>
                        </div>
                    </div>
                  </div>
                  </div>

                  <div class="form-group margin-t-40">
                    <label for="name" class="default-block-entry">Name</label>
                    <input id="name" type="text" placeholder="Full Name" autocomplete="on" v-model="userData.name" />
                  </div>

                  <div class="form-group">
                    <label for="email_address" class="default-block-entry">Email Address</label>
                    <p v-once>{{userData.email ? userData.email : 'Email Address'}}</p>
                  </div>
                  
                  <div class="form-group">
                    <button class="btn" @click="initiate">
                      <div class="form-group-loader" v-if="loading">
                        <div class="loader">
                          <span>
                            <i class="fas fa-spinner fa-spin"></i>
                          </span>
                        </div>
                      </div>
                      Update Profile
                   </button>
                 </div>
               </div>
             </div>
       </div>
      </div>
    </div>
  </div>
</template>

<script>

import { mapGetters, mapActions } from "vuex";
import BreadCrumbs from "@/common/mixins/breadcrumb";

export default {
  name: "UserProfile",
  mixins: [
      BreadCrumbs
  ],
  data() {
    return {
      userData: [],
      imagePreview: null,
      thumbnail: '',
      loading: false
    };
  },
  created() {
    this.setBreadcrumbs([
      { 
        name: 'dashboard', 
        to:   'dashboardHome'
      },
      { 
        name: 'my profile', 
        to:   'userProfile'
      }
    ]);
    this.getProfile();
  },
  computed: {
    ...mapGetters({
      user: "user/user"
    }),
   loggedUser() {
     return {...this.user}
   }
  },
  watch: {
    loggedUser(user) {
      this.userData = user;
    }
  },
  methods: {
    ...mapActions({
      getProfile: "user/getUser",
      updateUser: "user/updateUser" 
    }),
    previewImage(e) {
      this.thumbnail = e.target.files[0] || e.dataTransfer.files;
      if (e.target.files) {
        let imageReader = new FileReader();
        imageReader.onload = (e) => {
          this.imagePreview = e.target.result;
        }
        imageReader.readAsDataURL(e.target.files[0]);
      }
    },
    async initiate() {
          try { 
              this.loader(true);
              let payload = this.getPayload();
              await this.updateUser(payload);
              this.$toast.info("Done")
              this.loader(false);
              } catch (error) {
                  this.loader(false);
              }
      },
      getPayload() {
          let payload = new FormData();
          payload.append('name', this.userData.name);
          payload.append('thumbnail', this.thumbnail);
          return payload;
      },
    loader(args) {
      this.loading = args;
    }
  }
};
</script>
