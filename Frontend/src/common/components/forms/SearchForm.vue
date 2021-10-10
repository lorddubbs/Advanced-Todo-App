<template>
  <div class="container">
    
      <div class="form-group default-flex-entry">
          <input type="text" placeholder="Search tasks" v-model="query" @keyup="initiate($event)" />
      </div>
      
      <div class="search-results" v-if="status">
          <div class="results" ><!--@click="status = false"-->
          <search-results :searchResults="queryResults" @minimize="status = $event"></search-results>
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
        queryResults: [],
        keyTimer: undefined,
        timeoutValue: 1000,
        status: false
    };
  },
  methods: {
       async initiate(e) {
          clearTimeout(this.keyTimer);
          this.keyTimer = setTimeout(() => {
              this.status = true;
                   this.$axios.get(
                      "/search", {
                      params: {
                          query: this.query
                      }
                  }
              ).then(response => {
                  this.queryResults = response.data.data;
              }).catch((error) => {
                  let errors = error.response.data.errors || error.response.data.data.errors;
                  for (let field of Object.keys(errors)) {
                    this.$toast.error(errors[field][0], "error");
                }
            });
              }, this.timeoutValue);
      },
  }

};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only 
<style scoped lang="scss">

</style>
-->
