<template>
  <component :is="layout">
    <slot />
  </component>
</template>

<script>
const defaultLayout = "UserLayout";
export default {
  name: "MainLayout",
  computed: {
    layout() {
      const layout = this.$route.meta.layout || defaultLayout;
      return () => import(`/${layout}.vue`);
    }
  }
};
</script>
