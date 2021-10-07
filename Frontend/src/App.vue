<template>
  <div id="stdapp">
    <Layout>
      <router-view :key="$route.fullPath" />
    </Layout> 
  </div>
</template>  

<script>
import { mapGetters } from "vuex";
import Layout from "./layouts/MainLayout";

export default {
  components: {
    Layout
  },
  computed: {
    ...mapGetters({
      users: "user/users",
      user: "user/user"
    })
  },
  watch: {
    $route: {
      immediate: true,
      handler(to) {
      document.title = to.meta.title || "TODO";
      }
    }
  }
};
</script>
