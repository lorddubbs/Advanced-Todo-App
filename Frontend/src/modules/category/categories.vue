<template>
    <div class="page-main-area default-block-entry left-alignment margin-t-60">
      <category-table :categories="categoriesData"></category-table>
    </div>
</template>

<script>

const CategoryTable = () => import(/* webpackChunkName: "tables" */ /* webpackPrefetch: true */ "@/common/components/tables/CategoryTable.vue");
import BreadCrumbs from "@/common/mixins/breadcrumb";

export default {
  name: "categories",
  mixins: [
    BreadCrumbs
  ],
  props: {
    categories: {
        type: Array,
        required: true
        /*validator: function(obj) {
        }*/
    }
  },
  components: {
    CategoryTable
  },
  created() {
    this.setBreadcrumbs([
      { 
        name: 'dashboard', 
        to:   'dashboardHome'
      },
      { 
        name: 'categories', 
        to:   'categories'
      }
    ]);
  },
  data() {
    return {
      categoriesData: [],
    }
  },
  computed: {
    items() {
      this.categoriesData = this.categories;
    }
  },
  watch: {
    categories(categories) {
      this.categoriesData = categories;
    }
  }
};
</script>