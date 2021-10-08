 <template>
    <div class="page-main-area default-block-entry left-alignment margin-t-30">
        <div class="multi-step-form-container">
            <create-task :categories="categories"></create-task>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

const CreateTask = () => import(/* webpackChunkName: "forms" */ /* webpackPrefetch: true */ "@/common/components/forms/CreateTask.vue");
import BreadCrumbs from "@/common/mixins/breadcrumb";

export default {
  name: "taskcreate",
  mixins: [
      BreadCrumbs
  ],
  components: {
      CreateTask
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
      },
      { 
        name: 'create', 
        to:   'createTask'
      }
    ]);
    this.getCategories();
  },
  computed: {
    ...mapGetters({
      categories: "category/categories"
    })
  },
  methods: {
    ...mapActions({
      getCategories: "category/getAllCategories"
    }),
  }
};
</script>