<template>
  <div v-if="!loading">
    <prev></prev>
    <div class="grid">
      <p class="grid-header">Создать тикет</p>
      <div class="grid-body">
        <div class="item-wrapper">
          <div class="row mb-3">
            <div class="col-md-8 mx-auto">
              <form v-on:submit.prevent="createTicket">
                <div class="form-group row">
                  <div class="col">
                    <label for="title">Название</label>
                    <div class="input-group ">
                      <input type="text" v-model="ticket.title"
                             :class="'form-control' + (errors.title ? ' is-invalid' : '')" id="title"
                             placeholder="Название">
                      <div class="invalid-feedback" v-if="errors.title">
                        {{errors.title[0]}}
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <label for="priority">Приоритет</label>
                    <div class="input-group">
                      <select v-model="ticket.priority_id" id="priority"
                              :class="'custom-select' + (errors.priority_id ? ' is-invalid' : '')">
                        <option v-for="(priority) in priorities"
                                :value="priority.id">
                          {{priority.title}}
                        </option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.priority_id">
                        {{errors.priority_id[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row showcase_row_area">
                  <div class="col">
                    <label for="description">Описание</label>
                    <div class="input-group">
                      <textarea :class="'form-control' + (errors.body ? ' is-invalid' : '')" v-model="ticket.body"
                                id="description" cols="12" rows="5"
                                placeholder="Описание"></textarea>
                      <div class="invalid-feedback" v-if="errors.body">
                        {{errors.body[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col">
                    <label for="customer">Проект</label>
                    <div class="input-group">
                      <select v-model="ticket.project_id" id="customer"
                              :class="'custom-select' + (errors.project_id ? ' is-invalid' : '')">
                        <option v-for="(project) in projects"
                                :value="project.id">
                          {{project.title}}
                        </option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.project_id">
                        {{errors.project_id[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <button class="btn btn-sm btn-primary" type="submit">Создать тикет</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  export default {

    data() {
      return {
        ticket: {},
        errors: {},
        loading: false,
        priorities: [],
        projects: [],

      }
    },
    mounted() {
      this.getPriorities();
      this.getProjects();
    },
    methods: {
      getPriorities(){
        this.loading = true;
        var vm = this;
        axios.get(route('priority.index'))
          .then((response) => {
            vm.priorities = response.data.priorities;
            vm.ticket.priority_id = vm.priorities[0].id;
            vm.loading = false;
          });
      },
      getProjects(){
        this.loading = true;
        var vm = this;
        axios.get(route('project.all'))
          .then((responce) => {
            vm.projects = responce.data.projects;
            if (vm.projects.length > 0) {
              vm.ticket.project_id = vm.projects[0].id;
            }
            this.loading = false;
          })
      },
      createTicket() {
        var vm = this;
        vm.ticket.spokesman_id = vm.$store.state.Auth.user_id;
        axios.post(route('tickets.store'), this.ticket)
          .then(function (response) {
            vm.$router.push({name: 'ticketList'});
          })
          .catch((error) => {
            if (error.response) {
              if (error.response.data.errors) {
                this.errors = error.response.data.errors;
              }
              pnotify.alert({
                title: 'Ошибка',
                text: error.response.data.message,
                type: 'error',
                delay: 1000,
              });
            }
          });
      }
    }
  }
</script>
