<template>
  <div class="container height-fix">
    <div class="top-navigation-section default-block-entry left-alignment">
      <header class="top-navigation-header navigation-background">
        <div class="container height-fix-2">
          <nav class="navbar navbar-expand-md navbar-light padding-a-0 height-fix-2">
            <div class="container height-fix-2">
              <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
                @click="menuClass = !menuClass"
              >
              </button>
              <div class="navigation-entry default-flex-entry height-fix-2 padding-l-r-7">
                <div class="navigation-entry-logo center-alignment padding-t-b-3">
                  <router-link
                    :to="{ name: 'Home' }"
                    class="navbar-brand center-alignment logo-dark"
                  >
                  TODO.
                    <!-- logo stays here -->
                  </router-link>
                </div>
                <div
                  class="collapse navbar-collapse"
                  id="navbarSupportedContent"
                >
                  
                  <div class="navbar-collapse-content default-flex-entry height-fix-2">
                    <div class="top-main-links height-fix-2">
                      <div class="container height-fix-2">
                        <ul class="navbar-nav mr-auto default-flex-entry height-fix-2">
                          <li>
                            <router-link to="/about">
                              About us
                            </router-link>
                          </li>
                          <li>
                            <router-link to="/contact">
                              Contact
                            </router-link>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="top-main-user-area width-38">
                        <div class="top-main-user height-fix-2">
                          <div class="user-notification u-n-user">
                                <div class="notification-bell">
                                    <router-link :to="{name: 'tasks' }" v-if="user !== null" class="u-notify-color-user">
                                      <i class="fas fa-tasks"></i>
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
                                        <div class="user-menu">
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
                                            <span class="caret">
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
              </div>
            </div>
          </nav>
        </div>
      </header>
      </div>
    <slot />

  </div>
</template>

<script>

//const Notification = () => import(/* webpackChunkName: "overlays" */ /* webpackPrefetch: true */ "@/common/components/overlays/Notifications.vue");

export default {
  name: "UserLayout",
  data() {
    return {
      menuClass: false,
      notificationStatus: true
    };
  },
  computed: {
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
