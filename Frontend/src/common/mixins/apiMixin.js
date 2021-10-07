import Vue from "vue";
import { $apiService } from "../../services/apiService";

Vue.mixin({
  computed: {
    $apiService: () => $apiService
  }
});
