<template>
  <div class="container-home-dashboard default-block-entry left-alignment" @click="status = false">
    <div class="home-header-area"> 
        <div class="header-area">
            <bread-crumb></bread-crumb>
        </div>
        <div class="header-area">
            <notifications></notifications>
        </div>
    </div>
    <div class="search-area">
      <search-form></search-form>
    </div>
    <router-view :key="$route.fullPath"></router-view>
  </div>
</template>

<script>

const BreadCrumb = () => import(/* webpackChunkName: "filters" */ /* webpackPrefetch: true */ "@/common/components/filters/BreadCrumb.vue");
const Notifications = () => import(/* webpackChunkName: "overlays" */ /* webpackPrefetch: true */ "@/common/components/overlays/Notifications.vue");
const SearchForm = () => import(/* webpackChunkName: "forms" */ /* webpackPrefetch: true */ "@/common/components/forms/SearchForm.vue");

import BreadCrumbs from "@/common/mixins/breadcrumb";


export default {
  name: "Dashboard",
  mixins: [
      BreadCrumbs
  ],
  components: {
      BreadCrumb,
      Notifications,
      SearchForm
  },
  created() {
    this.setBreadcrumbs([
      { 
        name: 'dashboard', 
        to:   'dashboardHome'
      },
      { 
        name: 'tasks', 
        to:   'tasks'
      }
    ]);
  }
};
</script>
