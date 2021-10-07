<template>
  <div class="width-fix default-block-entry left-alignment height-fix-2 dashboard-view">
    <dashboard>
      <template v-slot:left-sidebar></template>
      <template v-slot:right-sidebar></template>
    </dashboard>
    <slot/>
  </div>
</template>

<script>
import Dashboard from "./Dashboard";

export default {
  name: "MainDashboardLayout",
  components: {
    Dashboard
  }
};
</script>
