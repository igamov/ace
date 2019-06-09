<template>
  <div class="sidebar">
    <ul class="navigation-menu">
      <li class="nav-category-divider">MAIN</li>
      <router-link tag="li" :to="{ name: 'home' }" exact>
        <a>
          <span class="link-title">Home</span>
          <i class="mdi mdi-gauge link-icon"></i>
        </a>
      </router-link>
      <li>
        <a href="#projects" data-toggle="collapse">
          <span class="link-title">Проекты</span>
          <i class="mdi mdi-briefcase link-icon"></i>
        </a>
        <ul class="collapse navigation-submenu" id="projects">
          <li>
            <router-link :to="{ name: 'projectList' }" exact>Список проектов</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'projectCreate' }" exact>Создать проект</router-link>
          </li>
        </ul>
      </li>
      <li>
        <a href="#tasks" data-toggle="collapse">
          <span class="link-title">Задачи</span>
          <i class="mdi mdi-clipboard-outline link-icon"></i>
        </a>
        <ul class="collapse navigation-submenu" id="tasks">
          <li>
            <router-link :to="{ name: 'taskList' }" exact>Список задач</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'taskCreate' }" exact>Создать задачу</router-link>
          </li>
        </ul>
      </li>
      <li>
        <a href="#customers" data-toggle="collapse">
          <span class="link-title">Компании</span>
          <i class="mdi mdi-domain link-icon"></i>
        </a>
        <ul class="collapse navigation-submenu" id="customers">
          <li>
            <router-link :to="{ name: 'customerList' }" exact>Список компаний</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'customerCreate' }" exact>Создать компанию</router-link>
          </li>
        </ul>
      </li>
      <li class="nav-category-divider">Финансы</li>
      <li>
        <a href="#invoices" data-toggle="collapse">
          <span class="link-title">Счета</span>
          <i class="mdi mdi-file-document-box link-icon"></i>
        </a>
        <ul class="collapse navigation-submenu" id="invoices">
          <li>
            <router-link :to="{ name: 'invoiceList' }" exact>Список счетов</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'invoiceCreate' }" exact>Создать счет</router-link>
          </li>
        </ul>
      </li>
      <li class="nav-category-divider">Настройки системы</li>
      <li>
        <a href="#users" data-toggle="collapse" aria-expanded="false">
          <span class="link-title">Пользователи</span>
          <i class="mdi mdi-account-multiple link-icon"></i>
        </a>
        <ul class="collapse navigation-submenu" id="users">
          <li>
            <router-link :to="{ name: 'userList' }" exact>Список пользователей</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'userCreate' }" exact>Создать пользователя</router-link>
          </li>
        </ul>
      </li>
      <router-link tag="li" :to="{ name: 'settings' }" exact>
        <a>
          <span class="link-title">Настройки системы</span>
          <i class="mdi mdi-settings link-icon"></i>
        </a>
      </router-link>
    </ul>
    <div class="sidebar_footer">
      <div class="user-account">
        <a class="user-profile-item" href="#"><i class="mdi mdi-settings"></i> Профиль</a>
        <button class="btn btn-primary btn-logout" @click="onLogout()">Выйти</button>
      </div>
      <div class="btn-group admin-access-level" @click="onProfileClick()">
        <div class="avatar">
          <img class="profile-img" src="http://www.placehold.it/50x50" alt="">
        </div>
        <div class="user-type-wrapper">
          <p class="user_name">{{auth.email}}</p>
          <div class="d-flex align-items-center">
            <div class="status-indicator small rounded-indicator bg-success"></div>
            <small class="user_access_level">Пользователь</small>
          </div>
        </div>
        <i class="arrow mdi mdi-chevron-right"></i>
      </div>
    </div>
  </div>
</template>

<script>
  import Auth from "../../helpers/Auth";
  export default {
    data() {
      return {
        user: {},
      }
    },
    created() {
      Auth.init();
    },
    methods:{
      onProfileClick(){
        $('.sidebar_footer').toggleClass('opened');
      },
      onLogout(){
        axios.post(route("user.logout"))
          .then(response => {
            if (response.data.success) {
              Auth.logout();
              this.$router.push({name: 'login'});
            }
          })
      }
    },
    computed: {
      auth() {
        return this.$store.state.Auth;
      },
    },
  }
</script>
