<template>
  <div class="container">
      <div class="message-box">
          <div class="message-box-icon">
              <div class="icon">
                  <span class="default-block-entry center-alignment">
                      <i class="fas fa-bullhorn"></i>
                  </span>
              </div>
          </div>
          <div class="message-box-content">
              <div class="box-content">
                  <h2>Get busy with this free todo app</h2>
              </div>
              <div class="box-content">
                  <p>Hey, Welcome to TODO. This is  where you get to do stuff. Schedule your tasks and get reminders. It is free forever. 
                      <br/>
                      Terms and Conditions apply.</p>
              </div>
          </div>
          <div class="message-box-control">
              <div class="icon">
                  <span @click="initiate">
                      <i class="fas fa-times"></i>
                  </span>
              </div>
          </div>
      </div>
  </div>
</template>

<script>

export default {
  name: "Message",
  data() {
      return {
          value: true
      }
  },
  methods: {
      initiate() {
          this.$emit('minimize', this.value)
      }
  }
};
</script>
