<template>
  <div class="container-home default-block-entry left-alignment">
    <div class="page-message-area" v-if="status">
      <message @minimize="minimizeWindow"></message>
    </div>

    <div class="page-main-area">
      <user-table :users="users"></user-table>
    </div>
  </div>
</template>

<script>

import { mapActions, mapGetters } from "vuex";
const Message = () => import(/* webpackChunkName: "overlays" */ /* webpackPrefetch: true */ "@/common/components/overlays/Message.vue");
const UserTable = () => import(/* webpackChunkName: "tables" */ /* webpackPrefetch: true */ "@/common/components/tables/UserTable.vue");

export default {
  name: "Home",
  components: {
      Message,
      UserTable
  },
  created() {
    this.getUsers()
  },
  data() {
    return {
      status: true
    }
  },
  computed: {
    ...mapGetters({
      users: "user/users"
    })
  },
  methods: {
  ...mapActions({
    getUsers: "user/getAllUsers"
  }),
  minimizeWindow(minimize) {
      if(minimize) {
        this.status = false;
      }
    }
  }
};
</script>
