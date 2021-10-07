 <template>
    <div class="page-main-area default-block-entry left-alignment margin-t-60">
        <div class="multi-step-form-container">
            <create-category></create-category>
        </div>
    </div>
</template>

<script>

const CreateCategory = () => import(/* webpackChunkName: "forms" */ /* webpackPrefetch: true */ "@/common/components/forms/CreateCategory.vue");
import BreadCrumbs from "@/common/mixins/breadcrumb";

export default {
  name: "categorycreate",
  mixins: [
      BreadCrumbs
  ],
  components: {
      CreateCategory
  },
  created() {
    this.setBreadcrumbs([
      { 
        name: 'dashboard', 
        to:   'dashboardHome'
      },
      { 
        name: 'categories', 
        to:   'categories'
      },
      { 
        name: 'create', 
        to:   'createCategory'
      }
    ]);
  }
};
</script>