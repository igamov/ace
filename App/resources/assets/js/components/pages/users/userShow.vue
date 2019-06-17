<template>
  <div v-if="!loading">
    <prev></prev>
    <div class="grid">
      <div class="grid-body">
        <div class="row">
          <div class="col-12 col-sm-2">
            <img :src="user.photo"
                 class="rounded-circle w-100" alt="">
          </div>
          <div class="col-12 col-sm-10">
            <h4>{{user.last_name}} {{user.first_name}} {{user.patronymic}}</h4>
            <hr>
            <p>E-mail: {{user.email}}</p>
            <p>Роль: <b>{{user.role.name}}</b></p>
          </div>
        </div>
      </div>
    </div>
    <div class="tasks-count" v-if="user.role.name === 'developer'">
      <div class="row">
        <div class="col-12 col-md-2"></div>
        <div class="col-12 col-md-2 text-center">
          <div class="grid">
            <div class="grid-body">
              <p class="h2 font-weight-bol">0</p>
              <hr class="border-primary">
              <p class="h6">Новые</p>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-2 text-center">
          <div class="grid">
            <div class="grid-body">
              <p class="h2 font-weight-bold">0</p>
              <hr class="border-warning">
              <p class="h6">В работе</p>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-2 text-center">
          <div class="grid">
            <div class="grid-body">
              <p class="h2 font-weight-bold">0</p>
              <hr class="border-info">
              <p class="h6">На проверке</p>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-2 text-center">
          <div class="grid">
            <div class="grid-body">
              <p class="h2 font-weight-bold">0</p>
              <hr class="border-success">
              <p class="h6">Завершены</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-2"></div>
      </div>
    </div>
    <div v-if="user.role.name === 'manager'">
    <div class="grid">
      <p class="grid-header">Список проектов</p>
      <div class="item-wrapper">
        <table class="table table-hover">
          <thead>
          <tr>
            <th>#</th>
            <th>Проект</th>
            <th>Приоритет</th>
            <th>Компания</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(project, index) in user.projects">
            <td>{{index+1}}</td>
            <td><router-link :to="{name: 'projectShow', params: { id: project.id }}">{{project.title}}</router-link></td>
            <td><label :class="'badge '+ project.priority.color">{{project.priority.title}}</label></td>
            <td><router-link :to="{name: 'customerShow', params: { id: project.customer.id }}">{{project.customer.name}}</router-link></td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    </div>
    <div v-if="user.role.name === 'manager' || user.role.name === 'customer'">
      <div class="grid">
        <p class="grid-header">Список компаний</p>
        <div class="item-wrapper">
          <table class="table table-hover">
            <thead>
            <tr>
              <th>#</th>
              <th>Название компании</th>
              <th>Телефон</th>
              <th>Email</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(customer, index) in user.customers">
              <td>{{index+1}}</td>
              <td><router-link :to="{name: 'customerShow', params: { id: customer.id }}">{{customer.name}}</router-link></td>
              <td>{{customer.phone}}</td>
              <td>{{customer.email}}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  export default {
    data(){
      return {
        user: [],
        loading: false,
      }
    },
    created: function () {
      this.getUser();
    },
    methods: {
      getUser(){
        this.loading = true;
        var vm = this;
        axios.get(route('user.show', [this.$route.params.id]))
          .then((response) => {
            this.user = response.data;
            this.loading = false;
          })
      },
    },
  }
</script>
<style>
  .tasks-count {
    margin: 0 auto;
  }

  .tasks-count hr {
    border-top: 4px solid rgba(0, 0, 0, 0.1);
    border-radius: 4px;
  }
</style>
