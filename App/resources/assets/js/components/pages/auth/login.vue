<template>
  <div class="authentication-theme auth-style_2">
    <div class="row inner-wrapper">
      <div class="col-md-7 banner-section">
      </div>
      <div class="col-md-5 form-section">
        <div class="logo-section">
          <a href="#" class="logo">
            <img src="/images/dt.svg" alt="logo" />
          </a>
        </div>
        <form v-on:submit.prevent="onLogin">
          <div class="form-group input-rounded">
            <input type="email" v-model="user.email"
                   :class="'form-control' + (errors.email ? ' is-invalid' : '')" id="email"
                   placeholder="Email">
            <div class="invalid-feedback" v-if="errors.email">
              {{errors.email[0]}}
            </div>
          </div>
          <div class="form-group input-rounded">
            <input type="password" v-model="user.password"
                   :class="'form-control' + (errors.password ? ' is-invalid' : '')" id="password"
                   placeholder="Пароль">
            <div class="invalid-feedback" v-if="errors.password">
              {{errors.password[0]}}
            </div>
          </div>
          <button type="submit"  class="btn btn-primary btn-block"> Войти </button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
  import Auth from "../../../helpers/Auth";
  export default {
    data() {
      return {
        user: {},
        errors: {},
        loading: false,
      }
    },
    methods: {
      onLogin() {
        axios.post(route('user.login'), this.user)
          .then(response => {
            Auth.login(response.data.user);
            pnotify.alert({
              title: 'Добро пожаловать!',
              text: 'Вы успешно вошли в систему',
              type: 'success',
              delay: 1000,
            });
            this.$router.push('/');
          })
          .catch((error) => {
            if (error.response) {
              if (error.response.data.errors) {
                this.errors = error.response.data.errors;
              }
              pnotify.alert({
                title: 'Ошибка',
                text: error.response.data.message,
                type: 'error',
                delay: 1000,
              });
            }
          });
      },
      onKeyup(e) {
        if (e.code === "Enter") {
          this.onLogin();
        }
      }
    }
  }
</script>