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
      <router-link tag="li" :to="{ name: 'settings' }" exact>
        <a>
          <span class="link-title">Настройки системы</span>
          <i class="mdi mdi-settings link-icon"></i>
        </a>
      </router-link>
    </ul>
  </div>
</template>

<script>

</script>
