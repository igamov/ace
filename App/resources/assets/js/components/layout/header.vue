<template>
  <nav class="t-header">
    <div class="t-header-brand-wrapper">
      <a href="#">
        <img class="logo" src="/images/dt.svg" alt="Logo">
        <img class="logo-mini" src="/images/logo-chb.svg" alt="Logo">
      </a>
      <button class="t-header-toggler t-header-desk-toggler d-none d-lg-block"  @click="toggleBtn()">
        <svg class="logo" viewBox="0 0 200 200">
          <path class="top" d="
                M 40, 80
                C 40, 80 120, 80 140, 80
                C180, 80 180, 20  90, 80
                C 60,100  30,120  30,120
              "></path>
          <path class="middle" d="
                M 40,100
                L140,100
              "></path>
          <path class="bottom" d="
                M 40,120
                C 40,120 120,120 140,120
                C180,120 180,180  90,120
                C 60,100  30, 80  30, 80
              "></path>
        </svg>
      </button>
    </div>
  </nav>
</template>
<script>
  export default {
    methods:{
      toggleBtn(){
        $('.t-header-toggler').toggleClass('arrow');
        $('body').toggleClass('sidebar-minimized');
      }
    }
  }
</script>