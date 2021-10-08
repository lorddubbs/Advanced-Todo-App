<template>
<div class="container">
    <slot name="left-sidebar">
    <div class="sidebar-container left-sd-bg height-fix-2 position-f-l width-20">
      <header class="top-navigation-header">
          <nav class="navbar-expand-md flex-column padding-a-0 height-fix-2">
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
              <div class="height-fix-2">
                <div class="navigation-entry-logo padding-t-b-3">
                  <router-link
                    :to="{ name: 'Home' }"
                    class="navbar-brand center-alignment logo-white"
                  >
                  TODO.
                    <!-- logo stays here -->
                  </router-link>
                </div>
                <div
                  class="collapse navbar-collapse"
                  id="navbarSupportedContent"
                >
                  <div class="navbar-collapse-content height-fix-2">
                    <div class="top-side-links height-fix-2">
                      <div class="container height-fix-2">
                        <ul class="flex-column height-fix-2">
                          <li class="height-fix-2">
                            <router-link :to="{ name: 'tasks' }">
                              <span>
                                  <i class="fas fa-tasks"></i>
                              </span>
                              Tasks
                            </router-link>
                          </li>
                          <li>
                            <router-link :to="{ name: 'categories' }">
                              <span>
                                  <i class="fas fa-tags"></i>
                              </span>
                              Categories
                            </router-link>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </nav>
          </header>
        </div>
    </slot>
    
    <slot name="right-sidebar">
      <div class="sidebar-container right-sd-br height-fix-2 position-f-r width-25">
        <div class="box-content">
          <h1>Latest Stats</h1>
        </div>
        <div class="stats-box">
          <ul>
            <li>
              <span>
                My Tasks
              </span>
              <span>
                {{ tasks = 0 ? '0' : tasks }}
              </span>
            </li>
            <li>
              <span>
                Task Categories
              </span>
              <span>
                {{ categories = 0 ? '0' : categories }}
              </span>
            </li>
          </ul>
        </div>
      </div>
    </slot>
    </div>
</template>

<script>

import { mapGetters } from "vuex";
export default {
  name: "Dashboard",
  computed: {
    ...mapGetters({
      tasks: "task/taskCount",
      categories: "category/categoryCount"
    })
  }
};
</script>
