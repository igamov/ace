<template>
  <div>
    <prev></prev>
    <div class="grid">
      <p class="grid-header">Создать проект</p>
      <div class="grid-body">
        <div class="item-wrapper">
          <div class="row mb-3">
            <div class="col-md-8 mx-auto">
              <form v-on:submit.prevent="createProject">
                <div class="form-group row">
                  <div class="col">
                    <label for="title">Название</label>
                    <div class="input-group ">
                      <input type="text" v-model="project.title"
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
                      <select v-model="project.priority_id" id="priority"
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
                      <input type="text" v-model.lazy="project.date_start"
                             :class="'form-control enable-mask phone-mask' + (errors.date_start ? ' is-invalid' : '')"
                             id="date_start" placeholder="DD/MM/YYYY">
                      <div class="invalid-feedback" v-if="errors.date_start">
                        {{errors.date_start[0]}}
                      </div>
                    </div>
                  </div>

                  <div class="col">
                    <label for="date_end">Дата окончания</label>
                    <div class="input-group">
                      <input type="date" v-model="project.date_end"
                             :class="'form-control' + (errors.date_end ? ' is-invalid' : '')" id="date_end">
                      <div class="invalid-feedback" v-if="errors.date_end">
                        {{errors.date_end[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row showcase_row_area">
                  <div class="col">
                    <label for="description">Описание</label>
                    <div class="input-group">
                      <textarea :class="'form-control' + (errors.body ? ' is-invalid' : '')" v-model="project.body"
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
                    <label for="manager">Менеджер проекта</label>
                    <div class="input-group">
                      <select v-model="project.manager_id" id="manager"
                              :class="'custom-select' + (errors.manager_id ? ' is-invalid' : '')">
                        <option selected value="1">Иванов И.И</option>
                        <option value="2">Коломейцев А.О</option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.manager_id">
                        {{errors.manager_id[0]}}
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <label for="customer">Компания</label>
                    <div class="input-group">
                      <select v-model="project.customer_id" id="customer"
                              :class="'custom-select' + (errors.customer_id ? ' is-invalid' : '')">
                        <option v-for="(customer) in customers"
                                :value="customer.id">
                          {{customer.name}}
                        </option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.customer_id">
                        {{errors.customer_id[0]}}
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
        project: {},
        errors: {},
        loading: false,
        priorities: [],
        customers: [],
      }
    },
    mounted() {
      this.getPriorities();
      this.getCustomers();
    },
    methods: {
      getPriorities(){
        this.loading = true;
        var vm = this;
        axios.get(route('priority.index'))
          .then((response) => {
            vm.priorities = response.data.priorities;
            vm.project.priority_id = vm.priorities[0].id;
            vm.loading = false;
          });
      },
      getCustomers(){
        this.loading = true;
        var vm = this;
        axios.get(route('customers.index'))
          .then((responce) => {
            vm.customers = responce.data.customers;
            vm.project.customer_id = vm.customers[0].id;
            this.loading = false;
          })
      },
      createProject() {
        this.loading = true;

        axios.post(route('projects.store'), this.project)
          .then(function (resp) {
            this.$router.push({name: 'projectList'});
            this.loading = false;
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
