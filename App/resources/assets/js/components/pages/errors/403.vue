<template>
  <div class="error_page error_1" style="background: none">
    <div class="container inner-wrapper">
      <h1 class="display-1 error-heading">403</h1>
      <h2 class="error-code">Доступ запрещен</h2>
      <p class="error-message">Вы запросили страницу, доступ к которой ограничен специальными правами.</p>
      <router-link :to="{ name: 'home' }" class="btn btn-primary">На главную страницу</router-link>
    </div>
  </div>
</template>