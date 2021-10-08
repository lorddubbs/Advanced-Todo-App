<template>
<div class="filter-box">
    <div class="filter-box-container">
        <div class="filter-box-header">
            <h1 v-if="!header">All Tasks</h1>
            <h1 v-else-if="header">{{type}}</h1>
        </div>
        <div class="filter-box-options" v-if="route === null">
            <div class="filter-menu-container">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown width-fix">
                        <div class="filter-menu">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="false">
                            <div class="filter-menu-options">
                                <div class="filter">
                                    <div class="filter-option">
                                        <span>{{ type }}</span>
                                    </div>
                                </div>
                            </div>
                            <span class="caret">
                                <i class="fas fa-angle-down"></i>
                            </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <ul class="filter-buttons">
                                    <li>
                                      <button @click="initiate()">
                                            All
                                      </button>
                                    </li>
                                    <li v-for="category in categories" :key="category.id">
                                        <button @click="initiate(category.name, category.id)">
                                            {{category.name}}
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</template>

<script>

export default {
  name: "CategoryFilter",
  props: {
    categories: {
        type: Array,
        required: true
        /*validator: function(obj) {
        }*/
    }
  },
  data() {
    return {
      header: false,
      type: 'choose category',
      route: this.$route.params.task || null
    };
  },
   methods: {
    initiate(name = null, id = null) {
      this.header = true;
      this.type = name || 'All Tasks';
      this.$emit('category', id);
    }
  }
};
</script>
