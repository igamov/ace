<template>
  <div>
    <div v-if="auth.login">
      <HeaderTop/>
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
    </div>
    <div v-if="!auth.login">
      <transition>
        <router-view></router-view>
      </transition>
    </div>
  </div>
</template>

<script>
  import Auth from "../../helpers/Auth";
  import HeaderTop from './header';
  export default {
    components: {
      HeaderTop
    },
    created() {
      Auth.init();
      Auth.check();
    },
    computed: {
      auth() {
        return this.$store.state.Auth;
      },
    },
  }
</script>
