export default {
  Login(state) {
    state.Auth.user_id = localStorage.getItem("user_id");
    state.Auth.email = localStorage.getItem("email");
    state.Auth.api_token = localStorage.getItem("api_token");
    state.Auth.last_name = localStorage.getItem("last_name");
    state.Auth.first_name = localStorage.getItem("first_name");
    state.Auth.patronymic = localStorage.getItem("patronymic");
    state.Auth.role_name = localStorage.getItem("role_name");
    state.Auth.role_id = localStorage.getItem("role_id");
    state.Auth.photo = localStorage.getItem("photo");
    state.Auth.login =
      state.Auth.user_id !== null &&
      state.Auth.email !== null &&
      state.Auth.api_token !== null &&
      state.Auth.last_name !== null &&
      state.Auth.first_name !== null &&
      state.Auth.role_name !== null &&
      state.Auth.role_id !== null &&
      state.Auth.patronymic !==null;
  }
}