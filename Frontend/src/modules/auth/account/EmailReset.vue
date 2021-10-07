// ~/passwordReset.vue
<template>
  <div class="container">
    <div class="layout-container center-alignment">
      <div class="layout-form-container default-block-entry left-alignment">
        <div class="row-headers">
          <h2>Enter new password</h2>
        </div>
        <div class="layout-form default-block-entry left-alignment padding-t-10">
          <div class="layout-form-item default-block-entry left-alignment margin-t-40">
          <div class="container">
                  
                  <div class="form-group">
                    <label for="password" class="default-block-entry">Your new password</label>
                    <input id="password" :type="[showPassword ? 'text' : 'password']" placeholder="Enter Password" v-model="user.password" />
                    <div @click="showPassword = !showPassword" class="reveal-button">
                      <span class="reveal-password">
                        {{showPassword ? 'hide' : 'show'}}
                      </span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="confirm_password" class="default-block-entry">Confirm your new password</label>
                    <input id="confirm_password" type="password" placeholder="Enter Password" v-model="user.confirm_password" />
                  </div>
                  
                  <div class="form-group">
                    <button :disabled="isDisabled" class="btn" @click="initiate">
                      <div class="form-group-loader" v-if="loading">
                        <div class="loader">
                          <span>
                            <i class="fas fa-spinner fa-spin"></i>
                          </span>
                        </div>
                      </div>
                      Reset password
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
export default {
  name: "EmailReset",
  created() {
    localStorage.removeItem('UserBio');
  },
  data() {
    return {
      password: null,
      user: {
      confirm_password: null,
      passwordToken: this.$route.query.token || null,
      },
      showPassword: false,
      loading: false
    };
  },
  computed: {
    isDisabled: function() {
      return (
        !this.user.password ||
        !this.user.confirm_password
      );
    }
  },
  methods: {
    async initiate() {
      try {
        this.loader(true);
        let response = await this.$axios.post(
          "/update-password",
          this.user
        );
        this.loader(false);
        this.$toast.info(response.data.message);
        this.$router.push({ name: 'login' });
      } catch (error) {
        this.loader(false);
        let errors = error.response.data.data;
        for (let field of Object.keys(errors)) {
          this.$toast.error(errors[field][0], "error");
        }
      }
    },
    loader(args) {
      this.loading = args;
    }
  }
};
</script>
