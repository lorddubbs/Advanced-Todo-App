 <template>
    <div class="page-main-area default-block-entry left-alignment margin-t-30">
        <div class="multi-step-form-container">
            <create-task :categories="categoriesData"></create-task>
        </div>
    </div>
</template>

<script>

const CreateTask = () => import(/* webpackChunkName: "forms" */ /* webpackPrefetch: true */ "@/common/components/forms/CreateTask.vue");
import BreadCrumbs from "@/common/mixins/breadcrumb";

export default {
  name: "taskcreate",
  props: {
    categories: {
        type: Array,
        required: true
        /*validator: function(obj) {
        }*/
    }
  },
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
  },
  data() {
    return {
      categoriesData: [],
    }
  },
  computed: {
    items() {
      this.categoriesData = this.categories;
    }
  },
  watch: {
    categories(categories) {
      this.categoriesData = categories;
    }
  }
};
</script>