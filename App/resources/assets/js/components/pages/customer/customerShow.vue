<template>
  <div v-if="!loading">
    <prev></prev>
    <h1 class="mb-4">{{customer.name}}</h1>
    <div class="item-wrapper">
      <div class="tab-container ">
        <ul class="nav nav-tabs" id="bt-tab_1" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="bt-tab_1_1" data-toggle="tab" href="#bt-content_1_1" role="tab"
               aria-controls="bt-content_1_1" aria-selected="true">Общие</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="bt-tab_1_2" data-toggle="tab" href="#bt-content_1_2" role="tab"
               aria-controls="bt-content_1_2" aria-selected="false">Проекты</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="bt-tab_1_3" data-toggle="tab" href="#bt-content_1_3" role="tab"
               aria-controls="bt-content_1_3" aria-selected="false">Счета</a>
          </li>
        </ul>
        <div class="tab-content" id="bt-tab_content_1" style="padding: 30px 0 0 0; background: none;">
          <div class="tab-pane show active" id="bt-content_1_1" role="tabpanel" aria-labelledby="bt-tab_1_1">
            <div class="grid">
              <p class="grid-header">{{customer.name}}</p>
              <div class="grid-body">
                <div class="row">
                  <div class="col-12 col-md-6">
                    <div class="row">
                      <div class="d-inline p-2"><p><b>Email</b></p></div>
                      <div class="d-inline p-2"><p>{{customer.email}}</p></div>
                      <div class="w-100"></div>
                      <div class="d-inline p-2"><p><b>Телефон</b></p></div>
                      <div class="d-inline p-2"><p>{{customer.phone}}</p></div>
                      <div class="w-100"></div>
                      <div class="d-inline p-2"><p><b>Сайт</b></p></div>
                      <div class="d-inline p-2"><p>{{customer.site}}</p></div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="row">
                      <div class="d-inline p-2"><p><b>Сфера деятельности</b></p></div>
                      <div class="d-inline p-2"><p>{{customer.area_activity.title}}</p></div>
                      <div class="w-100"></div>
                      <div class="d-inline p-2"><p><b>Представитель</b></p></div>
                      <div class="d-inline p-2"><p>{{customer.spokesman.last_name}} {{customer.spokesman.first_name[0]}}. {{customer.spokesman.patronymic[0]}}.</p></div>
                      <div class="w-100"></div>
                      <div class="d-inline p-2"><p><b>Ответственный</b></p></div>
                      <div class="d-inline p-2"><p>{{customer.manager.last_name}} {{customer.manager.first_name[0]}}. {{customer.manager.patronymic[0]}}.</p></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="grid">
              <p class="grid-header">Банковские реквизиты</p>
              <div class="grid-body">
                <div class="row">

                  <div class="col-12 col-md-6">
                    <div class="row">
                      <div class="d-inline p-2"><p><b>ИНН</b></p></div>
                      <div class="d-inline p-2"><p>{{customer.inn}}</p></div>
                      <div class="w-100"></div>
                      <div class="d-inline p-2"><p><b>КПП</b></p></div>
                      <div class="d-inline p-2"><p>{{customer.kpp}}</p></div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="row">
                      <div class="d-inline p-2"><p><b>Полное юридическое название</b></p></div>
                      <div class="d-inline p-2"><p>{{customer.legal_name}}</p></div>
                      <div class="w-100"></div>
                      <div class="w-100"></div>
                      <div class="d-inline p-2"><p><b>Юридический адрес</b></p></div>
                      <div class="d-inline p-2"><p>{{customer.legal_address}}</p></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="bt-content_1_2" role="tabpanel" aria-labelledby="bt-tab_1_2">
            <div class="grid">
              <p class="grid-header">Проекты</p>
              <div class="item-wrapper">
                <table class="table table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Проект</th>
                    <th>Дата начала</th>
                    <th>Дата окончания</th>
                    <th>Компания</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="project in customer.projects">
                    <td>{{project.id}}</td>
                    <td><router-link :to="{name: 'projectShow', params: { id: project.id }}">{{project.title}}</router-link></td>
                    <td>{{project.date_start}}</td>
                    <td>{{project.date_end}}</td>
                    <td>{{customer.name}}</td>
                    <td class="actions">
                      <i class="mdi mdi-dots-vertical"></i>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="bt-content_1_3" role="tabpanel" aria-labelledby="bt-tab_1_3">
            <div class="grid">
              <p class="grid-header">Счета</p>
              <div class="item-wrapper">
                <div class="table-responsive">
                  <table class="data-table table table-hover">
                    <thead>
                    <tr>
                      <th>Номер счета</th>
                      <th>Плательщик</th>
                      <th>Менеджер</th>
                      <th>Оплатить до</th>
                      <th>Сумма</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(invoice, index) in customer.invoices">
                      <td><router-link :to="{name: 'invoiceShow', params: { id: invoice.id }}">{{invoice. number}}</router-link>
                      <td>{{customer.name}}</td>
                      <td>{{invoice.manager_id}}</td>
                      <td>{{invoice.payment_date}}</td>
                      <td>{{invoice.sum}}</td>
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
        </div>
      </div>

    </div>
  </div>
</template>

<script>

  export default {
    data(){
      return {
        customer: [],
        loading: false,
      }
    },
    created: function () {
      this.getCustomer();
    },
    methods: {
      getCustomer(){
        this.loading = true;
        axios.get(route('customers.show', [this.$route.params.id]))
          .then((response) => {
            this.customer = response.data;
            this.loading = false;
          })
      }
    },
  }
</script>
