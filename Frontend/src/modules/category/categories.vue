<template>
    <div class="page-main-area default-block-entry left-alignment margin-t-60">
      <div class="container">
    <div class="container-table"> 
        <table class="custom-table">
            <thead>
               <tr>
                   <th>Name</th>
                   <th>Number of Tasks</th>
                   <th>Date Added</th> 
                   <th>Action</th>
               </tr>
            </thead>
      <category-table :categories="categories"></category-table>
      </table>
    </div>
  </div>
    </div>
</template>

<script>

const CategoryTable = () => import(/* webpackChunkName: "tables" */ /* webpackPrefetch: true */ "@/common/components/tables/CategoryTable.vue");
import BreadCrumbs from "@/common/mixins/breadcrumb";
import TasksCategories from "@/common/mixins/tasksCategories";

export default {
  name: "categories",
  mixins: [ 
    BreadCrumbs,
    TasksCategories
  ],
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
    this.getCategories();
    this.getTasks();
  }
};
</script>