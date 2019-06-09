<template>
  <div v-if="!loading">
    <prev></prev>
    <div class="grid">
      <p class="grid-header">Создать счёт</p>
      <div class="grid-body">
        <div class="item-wrapper">
          <div class="row mb-3">
            <div class="col-md-12 mx-auto">
              <form ref="form" v-on:submit.prevent>
                <div class="form-group row">
                  <div class="col">
                    <label for="customer">Плательщик</label>
                    <div class="input-group">
                      <select v-model="invoice.customer_id" id="customer"
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
                  <div class="col">
                    <label for="payment_date">Оплатить до</label>
                    <div class="input-group ">
                      <input type="text" v-model="invoice.payment_date"
                             :class="'form-control' + (errors.payment_date ? ' is-invalid' : '')" id="payment_date"
                             placeholder="Оплатить до">
                      <div class="invalid-feedback" v-if="errors.payment_date">
                        {{errors.payment_date[0]}}
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="mt-4 form-group">
                  <div class="col">
                    <h4><b>Список услуг</b></h4>
                    <div class="table-responsive mt-2">
                      <table class="table table-hover">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Наименование</th>
                          <th>Цена</th>
                          <th>Кол-во</th>
                          <th>НДС</th>
                          <th>Сумма</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(service, index) in invoice.services">
                          <td>{{index + 1}}</td>
                          <td>{{service.title}}</td>
                          <td>{{service.price}}</td>
                          <td>{{service.count}}</td>
                          <td>{{service.nds_title}}</td>
                          <td>{{service.sum}}</td>
                          <td class="actions">
                            <i class="mdi mdi-dots-vertical"></i>
                          </td>
                        </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col">
                    <button class="btn btn-link shadow-none m-0 p-0" @click="newModal()">Добавить</button>
                  </div>
                </div>
                <hr>
                <div class="text-right">
                  <p>НДС 10%: <b>{{nds_10}} <i class="mdi mdi-currency-rub"></i></b></p>
                  <p>НДС 18%: <b>{{nds_18}} <i class="mdi mdi-currency-rub"></i></b></p>
                  <p>НДС 20%: <b>{{nds_20}} <i class="mdi mdi-currency-rub"></i></b></p>
                  <hr>
                  <h4>Итого: {{invoice.sum}} <i class="mdi mdi-currency-rub"></i></h4>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="text-right">
      <button class="btn btn-primary" @click="createInvoice()" type="submit">Создать счет</button>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="add_service">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form v-on:submit.prevent="editmode ? updateItem() : createItem()">
            <div class="modal-header">
              <h3 class="modal-title">Add Service</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <input type="text" v-model="form.title"
                       :class="'form-control' + (errors.title ? ' is-invalid' : '')"
                       placeholder="Наименование">
                <div class="invalid-feedback" v-if="errors.title">
                  {{errors.title[0]}}
                </div>
              </div>
              <div class="form-group">
                <input type="text" v-model="form.price"
                       :class="'form-control' + (errors.price ? ' is-invalid' : '')"
                       placeholder="Цена, руб.">
                <div class="invalid-feedback" v-if="errors.price">
                  {{errors.price[0]}}
                </div>
              </div>
              <div class="form-group">
                <input type="text" v-model="form.count"
                       :class="'form-control' + (errors.count ? ' is-invalid' : '')"
                       placeholder="Количество">
                <div class="invalid-feedback" v-if="errors.count">
                  {{errors.count[0]}}
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <select v-model="form.nds_id"
                          :class="'custom-select' + (errors.nds ? ' is-invalid' : '')">
                    <option v-for="(nds) in ndses"
                            :value="nds.id + ', ' + nds.title + ', ' + nds.percent">
                      {{nds.title}}
                    </option>
                  </select>
                  <div class="invalid-feedback" v-if="errors.nds_id">
                    {{errors.nds_id[0]}}
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-success btn-sm">Update</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary btn-sm">Add</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {

    data() {
      return {
        invoice: {
          sum: 0,
          services: [],
        },
        customers: [],
        ndses: [],
        form: {
          title: '',
          price: '',
          count: '',
          nds_id: '',
          nds_title: '',
          sum: ''
        },
        nds_10: 0,
        nds_18: 0,
        nds_20: 0,
        errors: {},
        editmode: false,
        loading: false,
      }
    },
    created() {
      this.getNds();
      this.getCustomers();
    },
    methods: {
      newModal(){
        this.clearForm();
        this.editmode = false;
        $('#add_service').modal('show');
      },
      createItem() {
        var vm = this;
        if (vm.checkForm()) {

          var sum = vm.form.price * vm.form.count;
          let nds = vm.form.nds_id.split(', ', 3);
          let nds_id = nds[0];
          let nds_title = nds[1];
          let nds_percent = nds[2];
          vm.form.sum = sum;
          vm.invoice.sum = vm.invoice.sum + vm.form.sum;
          vm.form.nds_id = nds_id;
          vm.form.nds_title = nds_title;
          switch (nds_percent) {
            case '10':
              this.nds_10 = this.nds_10 + (sum * 0.1);
              break;
            case '18':
              this.nds_18 = this.nds_18 + (sum * 0.18);
              break;
            case '20':
              this.nds_20 = this.nds_20 + (sum * 0.2);
              break;
          }
          this.invoice.services.push(vm.form);
          $('#add_service').modal('hide');
          vm.clearForm();
        } else {
          console.log(vm.errors);
          pnotify.alert({
            title: 'Ошибка',
            text: 'Исправьте ошибки',
            type: 'error',
            delay: 1000,
          });
        }
      },
      getCustomers(){
        this.loading = true;
        var vm = this;
        axios.get(route('customers.index'))
          .then((response) => {
            vm.customers = response.data.customers;
            vm.invoice.customer_id = vm.customers[0].id;
            vm.loading = false;
          });
      },
      getNds(){
        var vm = this;
        axios.get(route('nds.index'))
          .then((response) => {
            vm.ndses = response.data.nds;
            vm.loading = false;
          });
      },
      createInvoice(){
        var vm = this;
        axios.post(route('invoice.store'), this.invoice)
          .then(function (resp) {
            vm.$router.push({name: 'invoiceList'});
          })
          .catch((error) => {
            if (error.response) {
              this.errors = error.response.data.errors;
              pnotify.alert({
                title: 'Ошибка',
                text: error.response.data.message,
                type: 'error',
                delay: 1000,
              });
            }
          });
      },
      getNDS(){
        this.loading = true;
        var vm = this;
      },
      checkForm() {
        this.errors = [];
        if (this.form.title && this.form.price && this.form.count && this.form.nds_id) {
          return true;
        }

        if (!this.form.title) {
          this.errors = {title: ['Требуется указать наименование']};
        }
        if (!this.form.price) {

          this.errors = {price: ['Требуется указать цену']};
        }
        if (!this.form.count) {
          this.errors = {count: ['Требуется указать количество']};
        }
        if (!this.form.nds_id) {
          this.errors = {nds_id: ['Требуется указать НДС']};
        }
      },
      clearForm(){
        this.form = {};
        this.errors = {};
      },
    }
  }
</script>
