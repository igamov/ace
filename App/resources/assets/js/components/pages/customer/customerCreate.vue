<template>
  <div v-if="!loading">
    <prev></prev>
    <div class="grid">
      <p class="grid-header">Создать компанию</p>
      <div class="grid-body">
        <div class="item-wrapper">
          <div class="row mb-3">
            <div class="col-md-8 mx-auto">
              <form v-on:submit.prevent="createCustomer">
                <div class="form-group row">
                  <div class="col">
                    <label for="name">Название</label>
                    <div class="input-group ">
                      <input type="text" v-model="customer.name"
                             :class="'form-control' + (errors.name ? ' is-invalid' : '')" id="name"
                             placeholder="Название">
                      <div class="invalid-feedback" v-if="errors.name">
                        {{errors.name[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col">
                    <label for="spokesman_id">Представитель</label>
                    <div class="input-group ">
                      <select v-model="customer.spokesman_id" id="spokesman_id"
                              :class="'custom-select' + (errors.spokesman_id ? ' is-invalid' : '')">
                        <option v-for="(user) in spokesmans"
                                :value="user.id">
                          {{user.last_name}} {{user.first_name[0]}}. {{user.patronymic[0]}}.
                        </option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.spokesman_id">
                        {{errors.spokesman_id[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col">
                    <label for="area_activity_id">Сфера деятельности</label>
                    <div class="input-group">
                      <select v-model="customer.area_activity_id" id="area_activity_id"
                              :class="'custom-select' + (errors.area_activity_id ? ' is-invalid' : '')">
                        <option v-for="(area_activity) in area_activities"
                                :value="area_activity.id">
                          {{area_activity.title}}
                        </option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.area_activity_id">
                        {{errors.area_activity_id[0]}}
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <label for="manager_id">Ответственный</label>
                    <div class="input-group">
                      <select v-model="customer.manager_id" id="manager_id"
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
                </div>
                <div class="form-group row">
                  <div class="col">
                    <label for="email">E-mail</label>
                    <div class="input-group ">
                      <input type="text" v-model="customer.email"
                             :class="'form-control' + (errors.email ? ' is-invalid' : '')" id="email"
                             placeholder="E-mail">
                      <div class="invalid-feedback" v-if="errors.email">
                        {{errors.email[0]}}
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <label for="phone">Телефон</label>
                    <div class="input-group ">
                      <input type="text" v-model="customer.phone"
                             :class="'form-control' + (errors.phone ? ' is-invalid' : '')" id="phone"
                             placeholder="Телефон">
                      <div class="invalid-feedback" v-if="errors.phone">
                        {{errors.phone[0]}}
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <label for="site">Сайт</label>
                    <div class="input-group ">
                      <input type="text" v-model="customer.site"
                             :class="'form-control' + (errors.site ? ' is-invalid' : '')" id="site" placeholder="Сайт">
                      <div class="invalid-feedback" v-if="errors.site">
                        {{errors.site[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="legal_name">Полное юридическое название</label>
                  <div class="input-group">
                    <input type="text" v-model="customer.legal_name"
                           :class="'form-control' + (errors.legal_name ? ' is-invalid' : '')" id="legal_name"
                           placeholder="Полное юридическое название">
                    <div class="invalid-feedback" v-if="errors.legal_name">
                      {{errors.legal_name[0]}}
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col">
                    <label for="inn">ИНН</label>
                    <div class="input-group">
                      <input type="text" v-model="customer.inn"
                             :class="'form-control' + (errors.inn ? ' is-invalid' : '')" id="inn" placeholder="ИНН">
                      <div class="invalid-feedback" v-if="errors.inn">
                        {{errors.inn[0]}}
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <label for="kpp">КПП</label>
                    <div class="input-group">
                      <input type="text" v-model="customer.kpp"
                             :class="'form-control' + (errors.kpp ? ' is-invalid' : '')" id="kpp" placeholder="КПП">
                      <div class="invalid-feedback" v-if="errors.kpp">
                        {{errors.kpp[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="legal_address">Юридический адрес</label>
                  <div class="input-group">
                    <input type="text" v-model="customer.legal_address"
                           :class="'form-control' + (errors.legal_address ? ' is-invalid' : '')" id="legal_address"
                           placeholder="Юридический адрес">
                    <div class="invalid-feedback" v-if="errors.legal_address">
                      {{errors.legal_address[0]}}
                    </div>
                  </div>
                </div>
                <button class="btn btn-sm btn-primary" type="submit">Создать компанию</button>
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
        customer: {},
        area_activities: [],
        managers: [],
        spokesmans: [],
        errors: {},
        loading: false,
      }
    },
    mounted() {
      this.getAreaActivities();
      this.getUsers();
    },
    methods: {
      getAreaActivities(){
        this.loading = true;
        var vm = this;
        axios.get(route('area_activity.index'))
          .then((response) => {
            vm.area_activities = response.data.area_activities;
            vm.customer.area_activity_id = vm.area_activities[0].id;
            vm.loading = false;
          });
      },
      getUsers(){
        this.loading = true;
        var vm = this;
        axios.get(route('user.index'))
          .then((response) => {
            vm.managers = response.data.managers;
            if (vm.managers.length > 0) {
              vm.customer.manager_id = vm.managers[0].id;
            }
            vm.spokesmans = response.data.customers;
            if (vm.spokesmans.length > 0) {
              vm.customer.spokesman_id = vm.spokesmans[0].id;
            }

            vm.loading = false;
          });
      },
      createCustomer() {
        this.loading = false;
        var vm = this;
        axios.post(route('customers.store'), this.customer)
          .then(function (resp) {
            vm.$router.push({name: 'customerList'});
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
