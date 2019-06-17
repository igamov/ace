<template>
  <div v-if="!loading">
    <div class="email-header">
      <router-link :to="{name: 'userCreate'}" tag="button" class="btn btn-primary has-icon email-composer"><i class="mdi mdi-plus"></i> Создать Пользователя</router-link>
    </div>
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
          <tr v-for="user in users">
            <td>{{user.id}}</td>
            <td><img :src="user.photo" alt="" class="profile-img border-0"></td>
            <td><router-link :to="{name: 'userShow', params: { id: user.id }}">{{user.email}}</router-link></td>
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
</template>

<script>

  export default {
    data(){
      return {
        users: [],
        loading: false
      }
    },
    methods: {
      getUsers(){
        this.loading = true;
        axios.get(route('user.index'))
          .then((responce) => {
            this.users = responce.data.users;
            this.loading = false;
          })
      }
    },
    mounted() {

      this.getUsers();
    }
  }
</script>
