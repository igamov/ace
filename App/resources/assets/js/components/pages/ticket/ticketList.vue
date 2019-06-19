<template>
  <div v-if="!loading">
    <div class="email-header">
      <!--<router-link :to="{name: 'projectCreate'}" tag="button" class="btn btn-primary has-icon email-composer"><i class="mdi mdi-plus"></i> Создать проект</router-link>-->
    </div>
    <div class="row">
      <div class="col-12 col-sm-9">
        <div class="grid">
          <p class="grid-header">Тикеты</p>
          <div class="item-wrapper">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Приоритет</th>
                <th>Проект</th>
                <th>Статус</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="ticket in filteredTickets">
                <td>{{ticket.id}}</td>
                <td>
                  <router-link :to="{name: 'ticketShow', params: { id: ticket.id }}">{{ticket.title}}</router-link>
                </td>
                <td><label :class="'badge '+ ticket.priority.color">{{ticket.priority.title}}</label></td>
                <td>
                  <router-link :to="{name: 'projectShow', params: { id: ticket.project.id }}">{{ticket.project.title}}
                  </router-link>
                </td>
                <td>{{ticket.status.title}}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-3">
        <div class="grid">
          <p class="grid-header">Фильтрация</p>
          <div class="grid-body">
            <div class="form-group">
              <p class="font-weight-bold mb-3">Статус:</p>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="Новая" v-model="status">Новая <i
                  class="input-frame"></i>
                </label>
              </div>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="В работе" v-model="status">В работе <i
                  class="input-frame"></i>
                </label>
              </div>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="Проверка" v-model="status">Проверка <i
                  class="input-frame"></i>
                </label>
              </div>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="Выполнена" v-model="status">Выполнена <i
                  class="input-frame"></i>
                </label>
              </div>
            </div>
            <div class="form-group">
              <p class="font-weight-bold mb-3">Проект:</p>
              <div class="input-group">
                <select title="Проект" v-model="project" id="project" class="custom-select">
                  <option v-for="(project) in projects"
                          :value="project.title">
                    {{project.title}}
                  </option>
                </select>
              </div>
            </div>
            <div class="w-100 text-right">
              <button class="btn btn-sm btn-outline-secondary" @click="resetFilter()">Сбросить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

  export default {
    data(){
      return {
        tickets: [],
        projects: [],
        loading: false,
        status: '',
        project: '',
      }
    },
    methods: {
      resetFilter(){
        this.status = '';
        this.project = '';
      },
      getTickets(){
        this.loading = true;
        var vm = this;
        axios.get(route('tickets.index') + '?user_id=' + vm.$store.state.Auth.user_id)
          .then((responce) => {
            this.tickets = responce.data.tickets;
            this.loading = false;
          })
      },
      getProjects(){
        this.loading = true;
        axios.get(route('projects.index') + '?user_id=' + this.$store.state.Auth.user_id)
          .then((responce) => {
            this.projects = responce.data.projects;
            this.loading = false;
          })
      }
    },
    computed: {
      filteredTickets(){
        return this.tickets.filter(ticket => {
          return ticket.status.title.indexOf(this.status) > -1 &&
            ticket.project.title.indexOf(this.project) > -1;
        });
      }
    },
    mounted() {
      this.getTickets();
      this.getProjects();
    }
  }
</script>
