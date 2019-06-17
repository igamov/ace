import VueRouter from 'vue-router';

//home
import home from './components/pages/home/index';

//Project
import projectList from './components/pages/project/projectList';
import projectCreate from './components/pages/project/projectCreate';
import projectShow from './components/pages/project/projectShow';
//Customer
import customerList from './components/pages/customer/customerList';
import customerCreate from './components/pages/customer/customerCreate';
import customerShow from './components/pages/customer/customerShow';

//Settings
import Settings from './components/pages/settings/Setting';

//Invoices
import invoiceList from './components/pages/invoice/invoiceList';
import invoiceCreate from './components/pages/invoice/invoiceCreate';
import invoiceShow from './components/pages/invoice/invoiceShow'
//Tasks
import taskList from './components/pages/task/taskList';
import taskCreate from './components/pages/task/taskCreate';
import taskShow from './components/pages/task/taskShow'
// Errors
import PageNotFound from './components/pages/errors/PageNotFound';
import forbidden from './components/pages/errors/403';
//Login
import Login from './components/pages/auth/login';
//Users
import userList from './components/pages/users/userList';
import userCreate from './components/pages/users/userCreate';
import userShow from './components/pages/users/userShow';
import userUpdate from './components/pages/users/userUpdate';


const routes = [
  {
    path: '/',
    name: 'home',
    component: home,
    meta: {requires: true}
  },
  {
    path: '/projects',
    name: 'projectList',
    component: projectList,
    meta: {requires: true}
  },
  {
    path: '/projects/create',
    name: 'projectCreate',
    component: projectCreate,
    meta: {requires: true, roles: ['admin', 'manager']}
  },
  {
    path: '/projects/:id',
    name: 'projectShow',
    component: projectShow,
    meta: {requires: true}
  },

  {
    path: '/customers',
    name: 'customerList',
    component: customerList,
    meta: {requires: true, roles: ['admin', 'manager', 'customer']}
  },
  {
    path: '/customers/create',
    name: 'customerCreate',
    component: customerCreate,
    meta: {requires: true, roles: ['admin', 'manager']}
  },
  {
    path: '/customers/:id',
    name: 'customerShow',
    component: customerShow,
    meta: {requires: true, roles: ['admin', 'manager', 'customer']}
  },
  {
    path: '/invoices',
    name: 'invoiceList',
    component: invoiceList,
    meta: {requires: true, roles: ['admin', 'manager', 'customer']}
  },
  {
    path: '/invoices/create',
    name: 'invoiceCreate',
    component: invoiceCreate,
    meta: {requires: true, roles: ['admin', 'manager']}
  },
  {
    path: '/invoices/:id',
    name: 'invoiceShow',
    component: invoiceShow,
    meta: {requires: true, roles: ['admin', 'manager', 'customer']}
  },
  {
    path: '/tasks',
    name: 'taskList',
    component: taskList,
    meta: {requires: true, roles: ['admin', 'manager']}
  },
  {
    path: '/tasks/create',
    name: 'taskCreate',
    component: taskCreate,
    meta: {requires: true, roles: ['admin', 'manager']}
  },
  {
    path: '/tasks/:id',
    name: 'taskShow',
    component: taskShow,
    meta: {requires: true, roles: ['admin', 'manager', 'developer']}
  },
  {
    path: '/settings',
    name: 'settings',
    component: Settings,
    meta: {requires: true, roles: ['admin']}
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/users',
    name: 'userList',
    component: userList,
    meta: {requires: true, roles: ['admin', 'manager']}
  },
  {
    path: '/users/:id',
    name: 'userShow',
    component: userShow,
    meta: {requires: true, roles: ['admin', 'manager']}
  },
  {
    path: '/users/update',
    name: 'userUpdate',
    component: userUpdate,
    meta: {requires: true}
  },
  {
    path: '/users/create',
    name: 'userCreate',
    component: userCreate,
    meta: {requires: true, roles: ['admin']}
  },
  {
    path: '/403',
    name: 'forbidden',
    component: forbidden
  },
  {path: "*", component: PageNotFound}
];
const router = new VueRouter({
  routes,
  mode: 'history',
  linkActiveClass: "active",
  linkExactActiveClass: "active"
});
router.beforeEach((to, from, next) => {
  if(to.meta.requires) {
    const authUser_token =  localStorage.getItem("api_token");
    const authUser_role =  localStorage.getItem("role_name");
    if(!authUser_token) {
      next({name:'login'})
    }
    if (!to.meta.roles){
      return next();
    }
    if (to.meta.roles.includes(authUser_role)){
      return next();
    }
    next({name: 'forbidden'})
  }
  next();
});
export default router;