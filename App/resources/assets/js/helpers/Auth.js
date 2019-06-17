export default {
  init() {
    store.commit("Login");
    if (store.state.Auth.api_token) {
      axios.defaults.headers.common["Authorization"] =
        "Bearer " + store.state.Auth.api_token;
    }
  },

  login(data) {
    localStorage.setItem("user_id", data.user_id);
    localStorage.setItem("email", data.email);
    localStorage.setItem("api_token", data.api_token);
    localStorage.setItem("last_name", data.last_name);
    localStorage.setItem("first_name", data.first_name);
    localStorage.setItem("patronymic", data.patronymic);
    localStorage.setItem("role_name", data.role_name);
    localStorage.setItem("role_id", data.role_id);
    localStorage.setItem("photo", data.photo);

    this.init();
  },

  logout() {
    localStorage.removeItem("user_id");
    localStorage.removeItem("email");
    localStorage.removeItem("api_token");
    localStorage.removeItem("last_name");
    localStorage.removeItem("first_name");
    localStorage.removeItem("patronymic");
    localStorage.removeItem("role_name");
    localStorage.removeItem("role_id");
    localStorage.removeItem("photo");

    this.init();
  },

  check() {
    if (!store.state.Auth.login) {
      router.push({name: 'login'});
    }
  }
};