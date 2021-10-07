// ~/verifyEmail.vue
<template>
  <div class="container">
    <div class="layout-container center-alignment">
      <div class="layout-form-container default-block-entry left-alignment">
        <div class="row-headers">
          <h1>Verify your email</h1>
        </div>
        <div class="layout-form default-block-entry left-alignment padding-t-10">
          <div class="layout-form-item default-block-entry left-alignment margin-t-40">
            <div class="container">
                  <div class="container-message">
                    <p id="message">
                      Please check the email provided and <br/>
                      click the link to verify your account
                    </p>
                  </div>

                  <div class="container-message">
                    <router-link :to="{ name: 'login' }" class="default-block-entry" id="message-link">
                      Login
                    </router-link>
                  </div>
               </div>
          </div>
           <div class="layout-form-footer default-block-entry left-alignment">
                <ul class="layout-form-footer-items">
                  <li class="footer-items">
                    <button @click="initiate" class="items">Resend Email</button>
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
  name: "EmailVerify",
  methods: {
    ...mapActions({
          verifyUser: "user/verifyUser"
      }),
    async initiate() {
      try {
        let response = await this.verifyUser();
        this.$toast.info(response.message);
      } catch (error) {
        let errors = error.response.data.errors;
        if (error.response.status === 404) {
          this.$toast.error(error.response.data.message);
          return;
        }
        for (let field of Object.keys(errors)) {
          this.$toast.error(errors[field][0], "error");
        }
      }
    }
  }
};
</script>
