<template>
  <div class="container">
    
      <div class="form-group default-flex-entry">
          <input type="text" placeholder="Search tasks" v-model="query" @keyup="initiate($event)" />
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
        keyTimer: undefined,
        timeoutValue: 1000,
        status: false
    };
  },
  methods: {
       initiate(e) {
          clearTimeout(this.keyTimer);
          this.keyTimer = setTimeout(() => {
              this.status = true;
              try {
                  let response = this.$axios.get(
                      "/search", {
                      params: {
                          query: this.query
                      }
                  }
              );
              } catch (error) {
                 return;
              }
            }, this.timeoutValue);
      },
  }

};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only 
<style scoped lang="scss">

</style>
-->
