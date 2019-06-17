<template>
  <div v-if="!loading">
    <prev></prev>
    <div class="grid">
      <p class="grid-header">Создать задачу</p>
      <div class="grid-body">
        <div class="item-wrapper">
          <div class="row mb-3">
            <div class="col-md-8 mx-auto">
              <form v-on:submit.prevent="createTask">
                <div class="form-group row">
                  <div class="col">
                    <label for="title">Название</label>
                    <div class="input-group ">
                      <input type="text" v-model="task.title"
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
                      <select v-model="task.priority_id" id="priority"
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
                <div class="form-group row">
                  <div class="col">
                    <label for="date_start">Дата начала</label>
                    <div class="input-group">
                      <input type="text" v-model.lazy="task.date_start"
                             :class="'form-control enable-mask phone-mask' + (errors.date_start ? ' is-invalid' : '')"
                             id="date_start" placeholder="DD/MM/YYYY">
                      <div class="invalid-feedback" v-if="errors.date_start">
                        {{errors.date_start[0]}}
                      </div>
                    </div>
                  </div>

                  <div class="col">
                    <label for="date_end">Крайний срок</label>
                    <div id="datepicker-popup"  class="input-group date datepicker">
                      <input type="text" v-model="task.date_end"
                             :class="'form-control' + (errors.date_end ? ' is-invalid' : '')" id="date_end" placeholder="DD/MM/YYYY">
                      <div class="invalid-feedback" v-if="errors.date_end" >
                        {{errors.date_end[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row showcase_row_area">
                  <div class="col">
                    <label for="description">Описание</label>
                    <div class="input-group">
                      <textarea :class="'form-control' + (errors.body ? ' is-invalid' : '')" v-model="task.body"
                                id="description" cols="12" rows="5"
                                placeholder="Описание"></textarea>
                      <div class="invalid-feedback" v-if="errors.body">
                        {{errors.body[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col">
                    <label for="manager">Менеджер задачи</label>
                    <div class="input-group">
                      <select v-model="task.manager_id" id="manager"
                              :class="'custom-select' + (errors.manager_id ? ' is-invalid' : '')">
                        <option v-for="(user) in managers"
                                :value="user.id">
                          {{user.last_name}} {{user.first_name[0]}}. {{user.patronymic[0]}}.
                        </option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.manager_id">
                        {{errors.manager_id[0]}}
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <label for="developer">Исполнитель</label>
                    <div class="input-group">
                      <select v-model="task.developer_id" id="developer"
                              :class="'custom-select' + (errors.developer_id ? ' is-invalid' : '')">
                        <option v-for="(user) in developers"
                                :value="user.id">
                          {{user.last_name}} {{user.first_name[0]}}. {{user.patronymic[0]}}.
                        </option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.developer_id">
                        {{errors.developer_id[0]}}
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <label for="customer">Проект</label>
                    <div class="input-group">
                      <select v-model="task.project_id" id="customer"
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
                <button class="btn btn-sm btn-primary" type="submit">Создать проект</button>
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
        task: {},
        errors: {},
        loading: false,
        priorities: [],
        projects: [],
        managers: [],
        developers: [],

      }
    },
    mounted() {
      this.getPriorities();
      this.getProjects();
      this.getUsers();
      if ($("#datepicker-popup").length) {
        $('#datepicker-popup').datepicker({
          enableOnReadonly: true,
          todayHighlight: true,
          templates: {
            leftArrow: '<i class="mdi mdi-chevron-left"></i>',
            rightArrow: '<i class="mdi mdi-chevron-right"></i>'
          }

        });
      }
    },
    methods: {
      getPriorities(){
        this.loading = true;
        var vm = this;
        axios.get(route('priority.index'))
          .then((response) => {
            vm.priorities = response.data.priorities;
            vm.task.priority_id = vm.priorities[0].id;
            vm.loading = false;
          });
      },
      getProjects(){
        this.loading = true;
        var vm = this;
        axios.get(route('projects.index'))
          .then((responce) => {
            vm.projects = responce.data.projects;
            if (vm.projects.length > 0) {
              vm.task.project_id = vm.projects[0].id;
            }
            this.loading = false;
          })
      },
      getUsers(){
        this.loading = true;
        var vm = this;
        axios.get(route('user.index'))
          .then((response) => {
            vm.managers = response.data.managers;
            if (vm.managers.length > 0) {
              vm.task.manager_id = vm.managers[0].id;
            }

            vm.developers = response.data.developers;
            if (vm.developers.length > 0) {
              vm.task.developer_id = vm.developers[0].id;
            }

            vm.loading = false;
          });
      },
      createTask() {
        var vm = this;
        axios.post(route('task.store'), this.task)
          .then(function (resp) {
            vm.$router.push({name: 'taskList'});
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
