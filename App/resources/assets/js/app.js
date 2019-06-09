require("./bootstrap");


window.route = require('./route').default;

import VueRouter from 'vue-router';
import router from './router';
window.router = router;

import App from './components/layout/App';


const app = new Vue({
  el: '#app',
  render: h => h(App),
  store,
  router
});


router.beforeResolve((to, from, next) => {
  // If this isn't an initial page load.
  if (to.name) {
    // Start the route progress bar.
    NProgress.start()
  }
  next()
});

router.afterEach((to, from) => {
  // Complete the animation of the route progress bar.
  NProgress.done()
});

