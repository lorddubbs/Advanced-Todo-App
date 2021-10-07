// ~/emailAccount.vue
<template>
  <div class="container">
    <div class="layout-container center-alignment">
      <div class="layout-form-container default-block-entry left-alignment">
        <div class="row-headers">
          <h1>Reset Password</h1>
          <p>
            Enter your email address and we'll send you a link
            <br/>
            to reset your password
          </p>
        </div>
        <div class="layout-form default-block-entry left-alignment padding-t-10">
          <div class="layout-form-item default-block-entry left-alignment margin-t-40">
          <div class="container">
                  <div class="form-group">
                    <label for="email_address" class="default-block-entry">Email Address</label>
                    <input id="email_address" type="email" placeholder="Enter Email Address" autocomplete="on" v-model="user.email" autofocus/>
                  </div>
                  
                  <div class="form-group">
                    <button :disabled="isDisabled" class="btndouble" @click="initiate">
                      <div class="form-group-loader" v-if="loading">
                        <div class="loader">
                          <span>
                            <i class="fas fa-spinner fa-spin"></i>
                          </span>
                        </div>
                      </div>
                      Send recovery email
                   </button>
                 </div>
               </div>
               </div>
             
           <div class="layout-form-footer default-block-entry left-alignment">
                <ul class="layout-form-footer-items">
                  <li class="footer-items">
                    <router-link :to="{ name: 'login' }" class="items">Log in</router-link>
                  </li>
                </ul>
            </div>
       </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "Email",
  data() {
    return {
      user: {
        email: null,
      },
      loading: false
    };
  },
  computed: {
    isDisabled: function() {
      return !this.user.email;
    }
  },
  methods: {
    async initiate() {
      try {
        this.loader(true);
        let response = await this.$axios.post(
          "/reset-password-request",
          this.user
        );
        this.loader(false);
        this.$toast.info(response.data.message);
      } catch (error) {
        this.loader(false);
        let errors = error.response.data.errors;
        if (error.response.status === 404) {
          this.$toast.error(error.response.data.message);
          return;
        }
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
