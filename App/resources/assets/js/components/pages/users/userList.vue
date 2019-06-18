<template>
  <div v-if="!loading">
    <div class="email-header">
      <router-link :to="{name: 'userCreate'}" tag="button" class="btn btn-primary has-icon email-composer"><i
        class="mdi mdi-plus"></i> Создать Пользователя
      </router-link>
    </div>
    <div class="row">
      <div class="col-12 col-sm-9">
        <div class="grid">
          <p class="grid-header">Пользователи</p>
          <div class="item-wrapper">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th></th>
                <th>Email</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="user in filteredUsers">
                <td>{{user.id}}</td>
                <td><img :src="user.photo" alt="" class="profile-img border-0"></td>
                <td>
                  <router-link :to="{name: 'userShow', params: { id: user.id }}">{{user.email}}</router-link>
                </td>
                <td>{{user.last_name}}</td>
                <td>{{user.first_name}}</td>
                <td>{{user.patronymic}}</td>
                <td class="actions">
                  <i class="mdi mdi-dots-vertical"></i>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-3">
        <div class="grid">
          <p class="grid-header">Фильтрация</p>
          <div class="grid-body">

            <div class="form-group">
              <input type="text" class="form-control mb-3" placeholder="Ф.И.О." v-model="search">
              <p class="font-weight-bold mb-3">Роль пользователя:</p>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="customer" v-model="role">Заказчик <i
                  class="input-frame"></i>
                </label>
              </div>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="developer" v-model="role">Исполнитель <i
                  class="input-frame"></i>
                </label>
              </div>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="manager" v-model="role">Менеджер <i
                  class="input-frame"></i>
                </label>
              </div>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="admin" v-model="role">Администратор <i
                  class="input-frame"></i>
                </label>
              </div>
            </div>
            <div class="w-100 text-right">
              <button class="btn btn-sm btn-outline-secondary" @click="resetFilter()">Сбросить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  export default {
    data(){
      return {
        users: [],
        loading: false,
        role: '',
        search: '',
      }
    },
    methods: {
      resetFilter(){
        this.role = '';
        this.search= '';
      },
      getUsers(){
        this.loading = true;
        axios.get(route('user.index'))
          .then((responce) => {
            this.users = responce.data.users;
            this.loading = false;
          })
      }
    },
    computed: {
      filteredUsers(){
        return this.users.filter(user => {
          return (user.last_name.indexOf(this.search) > -1 ||
            user.first_name.indexOf(this.search) > -1 ||
            user.patronymic.indexOf(this.search) > -1) &&
          user.role.name.indexOf(this.role) > -1;

        });
      }
    },
    mounted()
    {

      this.getUsers();
    }
  }
</script>
