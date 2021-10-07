<template>
    <div class="layout-container-filter">
        <div class="breadcrumb-container">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                    <li v-for="breadcrumb in breadcrumbs" :key="breadcrumb.name" class="breadcrumb-item">
                        <router-link :to="{name: breadcrumb.to}">
                           {{ breadcrumb.name}}
                        </router-link>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="nav-bar-placeholder">
            <div class="top-main-user-area width-fix">
                        <div class="top-main-user height-fix-2">
                            <div class="user-new-task">
                                <router-link :to="{name: 'createTask' }">
                                      <i class="far fa-plus-square"></i>
                                      New Task
                                </router-link>
                            </div>
                            <div class="user-notification u-n-dashboard">
                                <div class="notification-bell">
                                    <router-link :to="{name: 'tasks' }" v-if="userName !== null" class="u-notify-color-dashboard">
                                      <i class="fas fa-bell"></i>
                                    </router-link>
                                </div>
                                <!--<div class="notification-counter" v-if="notificationStatus">
                                    <span>
                                        3
                                    </span>
                                </div>-->
                            </div>
                            <div class="user-menu-container">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown width-fix" v-if="userName !== null">
                                        <div class="user-menu u-mc-dashboard">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" 
                                            aria-haspopup="true" aria-expanded="false">
                                            <div class="user-menu-image">
                                                <div class="user-thumbnail">
                                                    <div class="thumbnail">
                                                      <span v-if=" userImage === 'undefined' || userImage === 'null'"><i class="fas fa-smile"></i></span>
                                                      <img :src="userImage" alt="image" v-else />
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="caret caret-dashboard">
                                                <i class="fas fa-angle-down"></i>
                                            </span> 
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <ul class="navigation-bar-dropdown">
                                                    <li>
                                                        <router-link :to="{ name: 'userProfile' }">
                                                            <i class="far fa-smile"></i>
                                                            {{ userName }}
                                                        </router-link>
                                                    </li>
                                                    <li>
                                                        <span @click="initiate">
                                                            Logout
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                      </div>
                                    </li>
                                    <li class="nav-item" v-else>
                                      <router-link :to="{ name: 'login' }" class="auth-button"> 
                                        Log in
                                      </router-link>
                                    </li>
                                </ul>
                           </div>
                        </div>
                    </div>
        </div>
    </div>
</template>


<script>

import { mapState } from "vuex";

export default {
  name: "BreadCrumb",
  data() {
      return {
          name: this.$route.params.name,
          path: this.$route.path
      };
  },
  computed: {
      ...mapState("breadcrumb", ["breadcrumbs"]),
      userName(){
      return localStorage.getItem('UserBio');
      },
      userImage() {
          return localStorage.getItem("UserThumbnail");
      }
  },
  methods: {
      async initiate() {
      try {
        await this.$axios.post(
          "/logout"
        );
        localStorage.clear();
        this.$cookies.deleteCookie('token');
        this.$router.push({ name: 'Home' });
      } catch (error) {
        return;
      }
    }
  }
};
</script>

