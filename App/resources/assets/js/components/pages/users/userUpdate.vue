<template>
  <div>
    <prev></prev>
    <div class="row">
      <div class="col-12 col-sm-3">
        <div class="grid">
          <div class="grid-body">
            <div>
            <img :src="profileImage" class="profile-image w-100 border-0">
            <input type="file" ref="profileimage" @change="onUploadImage" class="profile-image-input">
            </div>
            <div class="w-100 text-center">
            <button class="mt-1 btn btn-primary" @click="onSelectImage">Загрузить фото</button>
            </div>
          </div>
        </div>
      </div>

    <div class="col-12 col-sm-9">
    <div class="grid">
      <p class="grid-header">Обновить профиль</p>
      <div class="grid-body">
        <div class="item-wrapper">
          <div class="row mb-3">
            <div class="col-md-12 mx-auto">
              <div class="form-group row">
                <div class="col">
                  <label for="last_name">Фамилия</label>
                  <div class="input-group ">
                    <input type="text" v-model="form.last_name"
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
                    <input type="text" v-model="form.first_name"
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
                    <input type="text" v-model="form.patronymic"
                           :class="'form-control' + (errors.patronymic ? ' is-invalid' : '')" id="patronymic"
                           placeholder="Отчество">
                    <div class="invalid-feedback" v-if="errors.patronymic">
                      {{errors.patronymic[0]}}
                    </div>
                  </div>
                </div>
              </div>
              <button class="btn btn-sm btn-primary" type="submit" @click="onUpdate('profile')">Обновить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="grid">
      <p class="grid-header">Обновить пароль</p>
      <div class="grid-body">
        <div class="form-group">
          <div class="col">
            <label for="old_password">Старый пароль</label>
            <div class="input-group">
              <input type="password" v-model="form.old_password"
                     :class="'form-control' + (errors.old_password ? ' is-invalid' : '')" id="old_password"
                     placeholder="Пароль">
              <div class="invalid-feedback" v-if="errors.old_password">
                {{errors.old_password[0]}}
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col">
            <label for="password">Новый пароль</label>
            <div class="input-group">
              <input type="password" v-model="form.password"
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
              <input type="password" v-model="form.password_confirmation"
                     :class="'form-control' + (errors.password_confirmation ? ' is-invalid' : '')"
                     id="password_confirmation"
                     placeholder="Подтвердите пароль">
              <div class="invalid-feedback" v-if="errors.password_confirmation">
                {{errors.password_confirmation[0]}}
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-sm btn-primary" type="submit" @click="onUpdate('password')">Обновить</button>
      </div>
    </div>
    </div>
  </div>
  </div>
</template>

<script>
  import Auth from "../../../helpers/Auth";
  export default {
    computed: {
      profileImage() {
        return this.$store.state.Auth.photo;
      }
    },
    data() {
      return {
        form: {
          name: null,
          email: null,
          password: null,
          password_confirmation: null,
          action: null
        },
        errors: {},
      }
    },
    created() {
      this.edit_profile();
    },
    methods: {
      edit_profile() {
        this.loading = true;
        var vm = this;
        axios.post(route('user.editProfile'))
          .then((response) => {
            if (response.data.success) {
              this.form = response.data.user;
            }
          })
          .catch(error => {
            if (error.response.status === 401) {
              Auth.logout();
              this.$router.push({name: 'login'});
            }
          });
      },
      onUpdate(action) {
        this.errors = {};
        this.form.action = action;
        axios
          .post(route('user.updateProfile'), this.form)
          .then(response => {
            if (response.data.success) {
              Auth.login(response.data.user);
              pnotify.alert({
                title: 'Success',
                text: 'Профиль успешно обновлен',
                type: 'success',
                delay: 1000,
              });
            }
          })
          .catch(error => {
            this.errors = error.response.data.errors;
            pnotify.alert({
              title: 'Ошибка',
              text: error.response.data.message,
              type: 'error',
              delay: 1000,
            });
          });
      },
      onSelectImage() {
        this.$refs.profileimage.click();
      },
      onUploadImage(e) {
        if (e.target.files && e.target.files.length) {
          let file = e.target.files[0];
          let data = new FormData();
          this.form.action = "photo";
          for (let i in this.form) {
            data.append(i, this.form[i]);
          }
          data.append("profilephoto", file);
          axios.post(route('user.updateProfile'), data).then(response => {
            if (response.data.success) {
              Auth.login(response.data.user);
              pnotify.alert({
                title: 'Success',
                text: 'Профиль успешно обновлен',
                type: 'success',
                delay: 1000,
              });
            }
          });
        }
      }
    }
  }
</script>
<style>
  .profile-image {
    width: 200px;
    border-radius: 5px;
    border: 1px solid rgba(0, 0, 0, 0.5);
  }
  .profile-image-input {
    display: none;
  }
</style>
