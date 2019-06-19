<template>
  <div v-if="!loading">
    <prev></prev>
    <h1 class="mb-4">{{ticket.title}}</h1>
    <div class="row">
      <div class="col-sm-12 col-md-8">
        <div class="grid">
          <p class="grid-header">Описание тикета</p>
          <div class="grid-body">
            <div class="row">
              <div class="col-12">
                {{ticket.body}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="grid">
          <div class="grid-body">
            <div class="table-responsive">
              <table class="table info-table">
                <tbody>
                <tr>
                  <td>Статус</td>
                  <td v-if="auth.role_name === 'admin' || auth.role_name === 'manager'" @dblclick="editTitleMode()">
                    <div v-show="!edit_mode">{{ticket.status.title}}</div>
                    <div v-show="edit_mode">
                      <select title="Статус" @change="onChange($event)" v-model="form.status_id" id="status_id"
                              :class="'custom-select custom-select-sm' + (errors.status_id ? ' is-invalid' : '')">
                        <option v-for="status in statuses" :value="status.id">{{status.title}}</option>
                      </select>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Приоритет</td>
                  <td><label :class="'badge '+ ticket.priority.color">{{ticket.priority.title}}</label></td>
                </tr>
                <tr>
                  <td>Постановщик</td>
                  <td>{{ticket.spokesman.last_name}} {{ticket.spokesman.first_name[0]}}. {{ticket.spokesman.patronymic[0]}}.</td>
                </tr>
                <tr>
                  <td>Проект</td>
                  <td><router-link :to="{name: 'projectShow', params: { id: ticket.project.id }}">{{ticket.project.title}}</router-link></td>
                </tr>
                <tr>
                  <td>Создана</td>
                  <td>{{ticket.created_at | date}}</td>
                </tr>
                <tr>
                  <td>Изменена</td>
                  <td>{{ticket.updated_at | date}}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment';
  import Auth from "../../../helpers/Auth";
  export default {
    data(){
      return {
        form: {},
        edit_mode: false,
        ticket: [],
        loading: false,
        statuses: [],
        errors: {},
      }
    },
    created: function () {
      Auth.init();
      this.getTicket();
      this.getStatuses();
    },
    methods: {
      editTitleMode() {
        this.edit_mode = true;
      },
      onChange(event) {
        var vm = this;
        this.form.status_id = event.target.value;
        this.form.action = 'updateStatus';
        axios
          .put(route('tickets.update', [this.ticket.id]), this.form)
          .then(response => {
            if (response.data.success) {
              vm.edit_mode = false;
              this.ticket = response.data.ticket;
              pnotify.alert({
                title: 'Success',
                text: 'Статус успешно обновлен',
                type: 'success',
                delay: 1000,
              });
            }
          })
          .catch(error => {
            pnotify.alert({
              title: 'Ошибка',
              text: error.response.data.message,
              type: 'error',
              delay: 1000,
            });
          });
      },
      getStatuses(){
        var vm = this;
        axios.get(route('status.index'))
          .then((response) => {
            this.statuses = response.data.statuses;
            this.form.status_id = this.ticket.status_id;
          })
      },
      getTicket(){
        this.loading = true;
        var vm = this;
        axios.get(route('tickets.show', [this.$route.params.id]))
          .then((response) => {
            this.ticket = response.data;
            this.loading = false;
          })
      },
    },
    computed: {
      auth() {
        return this.$store.state.Auth;
      },
    },
    filters: {
      dateAgo: function (value) {
        if (!value) return '';
        moment.lang('ru');
        return moment(value, "YYYYMMDDh:mm:ss").fromNow();
      },
      date: function (value) {
        if (!value) return '';
        moment.lang('ru');
        return moment(value, "YYYYMMDDh:mm:ss").format('LLL');
      },
    }
  }
</script>
