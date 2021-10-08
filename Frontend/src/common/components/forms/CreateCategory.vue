<template>
  <div class="container">
      <div class="form-group">
          <h1>Create</h1>
      </div>

      <div class="form-group margin-t-40 default-flex-entry">
          <input type="text" placeholder="Title" v-model="name" />
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
                Create !
          </button>
        </div>
  </div>
</template>

<script>

import { mapActions } from "vuex";

export default {
  name: "CreateCategory",
  data() {
    return {
        name: '',
        loading:false
    };
  },
  methods: {
      ...mapActions({
          createCategory: "category/createCategory"
        }),
      async initiate() {
          try {
              this.loader(true);
              let payload = {
                  name: this.name
              };
              await this.createCategory(payload);
              this.loader(false);
              this.$toast.info("Category Created");
              this.$router.push({name: 'categories'})
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

<!-- Add "scoped" attribute to limit CSS to this component only 
<style scoped lang="scss">

</style>
-->
