import Vue from "vue";
import axios from "@/plugins/request";

class BaseApiService {
  baseUrl = process.env.API_URL;
  resource;

  constructor(resource) {
    if (!resource) throw new Error("No resource is provided");
    this.resource = resource;
  }

  getUrl(id = "") {
    return `${this.baseUrl}/${this.resource}/${id}`;
  }

  defaultUrl(id = "") {
    return `${this.baseUrl}/${id}`;
  }

  setEssentials(response) {
    localStorage.setItem("one_id_verified", response.email_verified_at);
    localStorage.setItem("UserBio", response.name);
    localStorage.setItem("UserThumbnail", response.thumbnail);
  }


  handleErrors(error) {
    let errors = error.response.data.errors || error.response.data.data.errors;
    for (let field of Object.keys(errors)) {
      Vue.$toast.error(errors[field][0], "error");
    }
  }
}

class GetterApiService extends BaseApiService {
  constructor(resource) {
    super(resource);
  }
  async fetch(config = {}) {
    try {
      const response = await axios.get(this.getUrl(), config);
      return response.data;
    } catch (error) {
      this.handleErrors(error);
    }
  }
  async get(id) {
    try {
      if (!id) throw Error("No record id is provided");
      const response = await axios.get(this.getUrl(id));
      return response.data;
    } catch (error) {
      this.handleErrors(error);
    }
  }
}

class ModelApiService extends GetterApiService {
  constructor(resource) {
    super(resource);
  }
  async post(data = {}) {
    try {
      const response = await axios.post(this.getUrl(), data);
      return response.data;
    } catch (error) {
      this.handleErrors(error);
      return false;
    }
  }
  async put(id, data = {}) {
    if (!id) throw Error("No record id is provided");
    try {
      const response = await axios.post(this.getUrl(id), data);
      const { id: responseId } = response.data;
      return responseId;
      //return response.data;
    } catch (error) {
      this.handleErrors(error);
    }
  }
  async delete(id) {
    if (!id) throw Error("No record id is provided");
    try {
      await axios.delete(this.getUrl(id));
      return true;
    } catch (error) {
      this.handleErrors(error);
    }
  }

}

class AuthApiService extends ModelApiService {
  constructor() {
    super("auth");
  }

  async registerUser(payload) {
    try {
      await axios.get(this.defaultUrl() + "csrf-cookie");
      const response = await axios.post(
        this.defaultUrl() + "register",
        payload
      );
      this.setEssentials(response.data.data.user);
      return response.data;
    } catch (error) {
      this.handleErrors(error);
    }
  }

  async loginUser(payload) {
    try {
      await axios.get(this.defaultUrl() + "csrf-cookie");
      const response = await axios.post(
        this.defaultUrl() + "login",
        payload
      );
      this.setEssentials(response.data.data.user);
      return response.data;
    } catch (error) {
      this.handleErrors(error);
      return;
    }
  }

  async verifyUser() {
    try {
      await axios.get(this.defaultUrl() + "csrf-cookie");
      const response = await axios.post( 
        this.defaultUrl() + "email/verification/resend"
      );
      return response.data;
    } catch (error) {
      this.handleErrors(error);
      return;
    }
  }
}

class UserApiService extends ModelApiService {
  constructor() {
    super("user");
  }

  async myProfile() {
    try {
      await axios.get(this.defaultUrl() + "csrf-cookie");
      const response = await axios.get(
        this.baseUrl + "/userProfile"
      );
      this.setEssentials(response);
      return response.data;
    } catch (error) {
      return;
    }
  }

  async updateProfile(payload) {
    try {
      await axios.get(this.defaultUrl() + "csrf-cookie");
      const response = await axios.post(
        this.baseUrl + "/updateProfile",
        payload
      );
      this.setEssentials(response.data.data);
      return response.data;
    } catch (error) {
      return;
    }
  }
}

class TaskApiService extends ModelApiService {
  constructor() {
    super("task");
  }
}

class CategoryApiService extends ModelApiService {
  constructor() {
    super("category");
  }
}

class CommentApiService extends ModelApiService {
  constructor() {
    super("comment");
  }

  async getComments(taskId) {
    try {
      await axios.get(this.defaultUrl() + "csrf-cookie");
      const response = await axios.get(this.baseUrl + `/comment/task/${taskId}`);
      return response.data;
    } catch (error) {
      return;
    }
 }
}

export const $apiService = {
  auth: new AuthApiService(),
  user: new UserApiService(),
  task: new TaskApiService(),
  category: new CategoryApiService(),
  comment: new CommentApiService()
};
