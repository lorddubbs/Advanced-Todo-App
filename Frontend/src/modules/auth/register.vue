// ~/register.vue
<template>
  <div class="container">
    <div class="layout-container default-block-entry left-alignment">
      <div class="layout-form-container default-block-entry left-alignment">
        <div class="row-headers">
          <h1>Sign up</h1>
        </div>
        <div class="layout-form default-block-entry left-alignment padding-t-10">
          <div class="layout-form-item default-block-entry left-alignment margin-t-40">
                <div class="container">
                  <div class="form-group">
                    <label for="name" class="default-block-entry">Full Name</label>
                    <input id="name" type="text" placeholder="Full Name" autocomplete="on" v-model="user.name" autofocus/>
                  </div>

                  <div class="form-group">
                    <label for="email_address" class="default-block-entry">Email Address</label>
                    <input id="email_address" type="email" placeholder="Enter Email Address" autocomplete="on" v-model="user.email" autofocus/>
                  </div>
                  
                  <div class="form-group">
                    <router-link :to="{ name: 'findEmail' }">Forgot Password?</router-link>
                    <label for="password" class="default-block-entry">Password</label>
                    <input id="password" :type="[showPassword ? 'text' : 'password']" placeholder="Enter Password" v-model="user.password" />
                    <div @click="showPassword = !showPassword" class="reveal-button">
                      <span class="reveal-password">
                        {{ showPassword ? 'hide' : 'show'}}
                      </span>
                    </div>
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
                      Sign up
                   </button>
                 </div>
               </div>
             </div>
           <div class="layout-form-footer default-block-entry left-alignment">
                <ul class="layout-form-footer-items">
                  <li class="footer-items">
                    <router-link :to="{ name: 'login' }" class="items">
                      Log in
                    </router-link>
                  </li>
                </ul>
            </div>
       </div>
      </div>
    </div>
  </div>
</template>

<script>

import { mapActions } from "vuex";
export default {
  name: "register",
   data() {
    return {
      user: {
        name: null,
        email: null,
        password: null,
      },
      showPassword: false,
      loading: false
    };
  },
  computed: {
    isDisabled: function() {
      return (
        !this.user.email ||
        !this.user.password
      );
    }
  },
  methods: {
    ...mapActions({
        registerUser: "user/registerUser"
    }),
    async initiate() {
        try {
          this.loader(true);
          await this.registerUser(this.user);
          this.loader(false);
          this.$router.push({name: "verifyEmail"});
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