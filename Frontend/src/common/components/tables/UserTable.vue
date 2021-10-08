<template>
                  <div class="item-entry cursor-style">
                  <div class="item-badge margin-b-10">
                    <div class="badge">
                      <span class="user" v-if="user.thumbnail === null">
                        <i class="far fa-smile"></i>
                      </span>
                      <img :src="user.thumbnail" class="user-thumbnail" v-else />
                    </div>
                  </div>
                  <div class="item-content">
                      <ul>
                          <li class="margin-b-10">
                            <h1>
                              {{ user.name }} 
                            </h1>
                          </li>
                          <li>
                            <span id="tasktag">
                              <b>{{ user.tasks.length }}</b> tasks
                            </span>
                          </li>
                      </ul>
                  </div>
                </div>
</template>

<script>

export default {
  name: "UserTable",
  props: {
    user: {
        type: Array,
        required: true
        /*validator: function(obj) {
        }*/
    }
  }
};
</script>