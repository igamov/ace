<template>
  <router-link :to="{ name: 'projectList' }">projects</router-link>
</template>

<script>
  export default {
    mounted() {
      console.log('App mounted')
    }
  }
</script>
