<template>
  <div v-if="!loading">
    <div class="email-header">
      <router-link :to="{name: 'projectCreate'}" tag="button" class="btn btn-primary has-icon email-composer"><i
        class="mdi mdi-plus"></i> Создать проект
      </router-link>
    </div>
    <div class="grid">
      <div class="grid-body py-3">
        <div class="row dataTables_wrapper">
          <div class="col-sm-12 col-md-6">
            <p class="card-title ml-n1">Проекты</p>
          </div>
          <div class="col-sm-12 col-md-6 dataTables_filter">
            <input type="search" class="form-control form-control-sm" v-model="search" placeholder="Название проекта...">
          </div>
        </div>
      </div>
      <div class="item-wrapper">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
            <tr class="solid-header">
              <th>#</th>
              <th>Проект</th>
              <th>Приоритет</th>
              <th>Менеджер проекта</th>
              <th>Дата начала</th>
              <th>Дата окончания</th>
              <th>Компания</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="project in filteredProjects">
              <td>{{project.id}}</td>
              <td>
                <router-link :to="{name: 'projectShow', params: { id: project.id }}">{{project.title}}</router-link>
              </td>
              <td><label :class="'badge '+ project.priority.color">{{project.priority.title}}</label></td>
              <td>{{project.manager.last_name}} {{project.manager.first_name[0]}}. {{project.manager.patronymic[0]}}.
              </td>
              <td>{{project.date_start}}</td>
              <td>{{project.date_end}}</td>
              <td>
                <router-link :to="{name: 'customerShow', params: { id: project.customer.id }}">{{project.customer.name}}
                </router-link>
              </td>
              <td class="actions">
                <i class="mdi mdi-dots-vertical"></i>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

  export default {
    data(){
      return {
        projects: [],
        loading: false,
        search: '',
      }
    },
    methods: {
      getProjects(){
        this.loading = true;
        var vm = this;
        axios.get(route('projects.index') + '?user_id=' + vm.$store.state.Auth.user_id)
          .then((responce) => {
            this.projects = responce.data.projects;
            this.loading = false;
          })
      }
    },
    computed: {
      filteredProjects(){
        return this.projects.filter(project => {
          return project.title.indexOf(this.search) > -1;

        });
      }
    },
    mounted() {
      this.getProjects();
    }
  }
</script>
