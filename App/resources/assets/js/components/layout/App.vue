<template>
  <div class="page-body">
    <sidebar></sidebar>
    <div class="page-content-wrapper">
      <div class="page-content-wrapper-inner">
        <div class="content-viewport">
          <div class="row">
            <div class="col-lg-12">
              <transition>
                <router-view></router-view>
              </transition>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  import Auth from "../../helpers/Auth";
  export default {
    created() {
      Auth.init();
    },
    omputed: {
      auth() {
        return this.$store.state.Auth;
      },
    },
  }
</script>
