<template>
    <div class="page">
      <div class="cancel"><span @click="minimize"><i class="fas fa-times"></i></span></div>
      <div class="page-results" v-for="result in results" :key="result.id">
        <ul class="page-results-list" @click="pushToPage(result.id, result.slug)">
          <li>
            <div class="page-result-list-header">
               <div class="thumbnail">
                  <span v-if="result.thumbnail === null"><i class="fas fa-tasks"></i></span>
                  <img :src="result.thumbnail" alt="image" v-else />
                </div>
                <div class="list-header">
                  <h1>{{ result.title }}</h1>
                </div>
            </div>
          </li>
          <li>
            <span class="access default-c" :class="result.access == '0' ? 'public-access' : (result.access == '1' ? 'private-access' : '')">
              {{ result.access == 0 ? 'public' : 'private'}}
            </span>
          </li>
          <li>
            <span class="priority" :class="result.priority == 'low' ? 'low-priority' : (result.priority == 'medium' ? 'medium-priority' : 'high-priority')">
              {{ result.priority }} priority
            </span>
          </li>
          <li>
            <i><b>Status</b></i>
            <p v-if="checkIfDateExceeded(result.end_date)">
              This task seems to have expired {{result.end_date}}, we hope you followed through.
            </p>
            <p v-else>
              You still have time to finish this task. It ends {{result.end_date}}
            </p>
          </li>
        </ul>
      </div>
    </div>
</template>

<script>

export default {
  name: "SearchResults",
  props: {
    searchResults: {
        type: Array,
        required: true
        /*validator: function(obj) {
        }*/
    }
  },
  data() {
    return {
      results: [],
      status: false
    }
  },
  watch: {
    searchResults(results) {
      this.results = results
    }
  },
  methods: {
    checkIfDateExceeded(endDate) {
      let today = new Date();
      endDate.toISOString;
      if(endDate <= today.setHours(0,0,0,0)) {
        return true;
      }
      return false;
    },
    pushToPage(id, slug) {
       this.$router.push({
              name: 'viewTask',
              params: { id: id, task: slug }
        });
    },
    minimize() {
      this.$emit('minimize', false);
    }
  }
};
</script>