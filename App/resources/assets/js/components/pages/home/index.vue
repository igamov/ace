<template>
  <div v-if="!loading">
    <div class="row">
      <div class="col-md-6 task-count">
        <div class="row">
          <div class="col-6 equel-grid">
            <div class="grid d-flex flex-column align-items-center justify-content-center">
              <div class="grid-body text-center">
                <div class="profile-img img-rounded bg-inverse-primary no-avatar component-flat mx-auto mb-4"><i
                  class="mdi mdi-new-box mdi-2x"></i></div>
                <h2 class="font-weight-medium"><span class="animated-count">{{tasks_new}}</span></h2>
                <hr class="border-primary">
                <small class="text-gray d-block mt-3">НОВЫЕ</small>
              </div>
            </div>
          </div>
          <div class="col-6 equel-grid">
            <div class="grid d-flex flex-column align-items-center justify-content-center">
              <div class="grid-body text-center">
                <div class="profile-img img-rounded bg-inverse-warning no-avatar component-flat mx-auto mb-4"><i
                  class="mdi mdi-code-tags mdi-2x"></i></div>
                <h2 class="font-weight-medium animated-count">{{tasks_work}}</h2>
                <hr class="border-warning">
                <small class="text-gray d-block mt-3">В РАБОТЕ</small>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6 equel-grid">
            <div class="grid d-flex flex-column align-items-center justify-content-center">
              <div class="grid-body text-center">
                <div class="profile-img img-rounded bg-inverse-info no-avatar component-flat mx-auto mb-4"><i
                  class="mdi mdi-clock mdi-2x"></i></div>
                <h2 class="font-weight-medium animated-count">{{tasks_check}}</h2>
                <hr class="border-info">
                <small class="text-gray d-block mt-3">ПРОВЕРЯЮТСЯ</small>
              </div>
            </div>
          </div>
          <div class="col-6 equel-grid">
            <div class="grid d-flex flex-column align-items-center justify-content-center">
              <div class="grid-body text-center">
                <div class="profile-img img-rounded bg-inverse-success no-avatar component-flat mx-auto mb-4"><i
                  class="mdi mdi-marker-check mdi-2x"></i></div>
                <h2 class="font-weight-medium"><span class="animated-count">{{tasks_complete}}</span></h2>
                <hr class="border-success">
                <small class="text-gray d-block mt-3">ЗАВЕРШЕНЫ</small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 equel-grid">
        <div class="grid d-flex flex-column justify-content-between overflow-hidden">
          <div class="grid-body">
            <p class="card-title">Задачи</p>
            <div class="row">
              <div class="col-md-12 mt-4">
                <LineChart :data="chartData"></LineChart>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-if="auth.role_name === 'admin' || auth.role_name === 'manager'">
      <div class="col-md-10 equel-grid">
        <div class="grid">
          <div class="grid-body py-3">
            <p class="card-title ml-n1">Новый тикеты</p>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Приоритет</th>
                <th>Проект</th>
                <th>Статус</th>
                <th>Создана</th>
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
                <td>{{ticket.created_at | dateTo}}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import LineChart from '../../LineChart'

  export default {
    data() {
      return {
        loading: false,
        tickets: [],
        tasks_new: [],
        tasks_work: [],
        tasks_check: [],
        tasks_complete: [],
        data_tasks: [],
        chartData: {
          labels: ["Новые", "В работе", "Проверяются", "Завершены"],
          datasets: [
            {
              backgroundColor: ["#4d8af0", "#2d92fe", "#05478f", "#00cccc", "#6CA5E0", "#1A76CA"],
              data: [],
            }
          ]
        }
      };
    },
    components: {
      LineChart
    },
    mounted () {
      this.getTasks();
      this.getTickets();
    },
    computed: {
      auth() {
        return this.$store.state.Auth;
      },
        filteredTickets(){
          return this.tickets.filter(ticket => {
            return ticket.status.title.indexOf('Новая') > -1;
          });
        }

    },
    methods: {
      getTickets(){
        this.loading = true;
        var vm = this;
        axios.get(route('tickets.index') + '?user_id=' + this.auth.user_id)
          .then((responce) => {
            this.tickets = responce.data.tickets;
            this.loading = false;
          })
      },
      getTasks(){
        var vm = this;
        this.loading = true;
        axios.get(route('task.index'))
          .then((response) => {
            this.tasks_new = response.data.tasks_new.length;
            this.tasks_work = response.data.tasks_work.length;
            this.tasks_check = response.data.tasks_check.length;
            this.tasks_complete = response.data.tasks_complete.length;
            this.chartData.datasets[0].data = [this.tasks_new, this.tasks_work, this.tasks_check, this.tasks_complete];
            this.loading = false;
          })
      },
    },
    filters: {
      dateAgo: function (value) {
        if (!value) return '';
        moment.lang('ru');
        return moment(value, "YYYYMMDDh:mm:ss").fromNow();
      },
      dateTo: function (value) {
        if (!value) return '';
        moment.lang('ru');
        return moment(value, "YYYYMMDDh:mm:ss").format('LL');
      },
    }
  }
</script>
<style>
  .task-count hr {
    border-top: 4px solid rgba(0, 0, 0, 0.1);
    border-radius: 4px;
  }
</style>
