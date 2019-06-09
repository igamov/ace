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
// PNF
import PageNotFound from './components/PageNotFound'


export default new VueRouter({
  routes : [
    {
      path: '/',
      name: 'home',
      component: home
    },
    {
      path: '/projects',
      name: 'projectList',
      component: projectList
    },
    {
      path: '/projects/create',
      name: 'projectCreate',
      component: projectCreate
    },
    {
      path: '/projects/:id',
      name: 'projectShow',
      component: projectShow
    },

    {
      path: '/customers',
      name: 'customerList',
      component: customerList
    },
    {
      path: '/customers/create',
      name: 'customerCreate',
      component: customerCreate
    },
    {
      path: '/customers/:id',
      name: 'customerShow',
      component: customerShow
    },
    {
      path: '/invoices',
      name: 'invoiceList',
      component: invoiceList
    },
    {
      path: '/invoices/create',
      name: 'invoiceCreate',
      component: invoiceCreate
    },
    {
      path: '/invoices/:id',
      name: 'invoiceShow',
      component: invoiceShow
    },
    {
      path: '/tasks',
      name: 'taskList',
      component: taskList
    },
    {
      path: '/tasks/create',
      name: 'taskCreate',
      component: taskCreate
    },
    {
      path: '/tasks/:id',
      name: 'taskShow',
      component: taskShow
    },
    {
      path: '/settings',
      name: 'settings',
      component: Settings
    },
    { path: "*", component: PageNotFound }
  ],
  mode: 'history',
  linkActiveClass: "active",
  linkExactActiveClass: "active"
})