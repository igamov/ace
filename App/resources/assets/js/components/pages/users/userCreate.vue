<template>
  <div v-if="!loading">
    <prev></prev>
    <div class="grid">
      <p class="grid-header">Создать пользователя</p>
      <div class="grid-body">
        <div class="item-wrapper">
          <div class="row mb-3">
            <div class="col-md-8 mx-auto">
              <form v-on:submit.prevent="createUser">
                <div class="form-group">
                  <div class="col">
                    <label for="email">Email</label>
                    <div class="input-group ">
                      <input type="text" v-model="user.email"
                             :class="'form-control' + (errors.email ? ' is-invalid' : '')" id="email"
                             placeholder="Email">
                      <div class="invalid-feedback" v-if="errors.email">
                        {{errors.email[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col">
                    <label for="last_name">Фамилия</label>
                    <div class="input-group ">
                      <input type="text" v-model="user.last_name"
                             :class="'form-control' + (errors.last_name ? ' is-invalid' : '')" id="last_name"
                             placeholder="Фамилия">
                      <div class="invalid-feedback" v-if="errors.last_name">
                        {{errors.last_name[0]}}
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <label for="first_name">Имя</label>
                    <div class="input-group">
                      <input type="text" v-model="user.first_name"
                             :class="'form-control' + (errors.first_name ? ' is-invalid' : '')" id="first_name"
                             placeholder="Имя">
                      <div class="invalid-feedback" v-if="errors.first_name">
                        {{errors.first_name[0]}}
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <label for="patronymic">Отчество</label>
                    <div class="input-group">
                      <input type="text" v-model="user.patronymic"
                             :class="'form-control' + (errors.patronymic ? ' is-invalid' : '')" id="patronymic"
                             placeholder="Отчество">
                      <div class="invalid-feedback" v-if="errors.patronymic">
                        {{errors.patronymic[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col">
                    <label for="password">Пароль</label>
                    <div class="input-group">
                      <input type="password" v-model="user.password"
                             :class="'form-control' + (errors.password ? ' is-invalid' : '')" id="password"
                             placeholder="Пароль">
                      <div class="invalid-feedback" v-if="errors.password">
                        {{errors.password[0]}}
                      </div>
                    </div>
                    </div>
                  </div>
                <div class="form-group">
                  <div class="col">
                    <label for="password_confirmation">Подтвердите пароль</label>
                    <div class="input-group">
                      <input type="password" v-model="user.password_confirmation"
                             :class="'form-control' + (errors.password_confirmation ? ' is-invalid' : '')" id="password_confirmation"
                             placeholder="Подтвердите пароль">
                      <div class="invalid-feedback" v-if="errors.password_confirmation">
                        {{errors.password_confirmation[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <button class="btn btn-sm btn-primary" type="submit">Создать пользователя</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  export default {

    data() {
      return {
        user: {},
        errors: {},
        loading: false,
      }
    },
    methods: {
      createUser() {
        var vm = this;
        axios.post(route('user.register'), this.user)
          .then(function (response) {
            pnotify.alert({
              title: 'Успешно!',
              text: 'Пользователь успешно создан!',
              type: 'success',
              delay: 1000,
            });
            vm.user = '';
            this.$router.push({name: 'userList'});
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
      }
    }
  }
</script>
