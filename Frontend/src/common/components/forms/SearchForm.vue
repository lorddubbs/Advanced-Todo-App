<template>
  <div class="container">
    
      <div class="form-group default-flex-entry">
          <input type="text" placeholder="Search tasks" v-model="query" @input="initiate($event)" />
      </div>
      
      <div class="search-results" v-if="status">
          <div class="results" @click="status = false">
          <search-results></search-results>
          </div>
      </div>
  </div>
</template>

<script>


const SearchResults = () => import(/* webpackChunkName: "overlays" */ /* webpackPrefetch: true */ "@/common/components/overlays/SearchResults.vue");

export default {
  name: "SearchForm",
  components: {
      SearchResults
  },
  data() {
    return {
        query: '',
        status: false
    };
  },
  methods: {
      async initiate(text) {
          this.status = true;
          try {
             let response = await this.$axios.get(
                  "/reset-password-request", {
                      query: this.query
                  }
              );
              } catch (error) {
                 return;
              }
      },
  }

};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only 
<style scoped lang="scss">

</style>
-->
