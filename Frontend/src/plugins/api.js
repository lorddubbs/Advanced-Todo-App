import { $apiService } from "@/services/apiService";

export default function(store) {
  try {
    store.$apiService = $apiService;
  } catch (e) {
    console.error(e);
  }
}
