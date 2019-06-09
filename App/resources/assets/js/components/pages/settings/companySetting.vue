<template>
  <div class="col-md-6">
    <div class="grid">
      <div class="grid-body">
        <div class="d-flex mb-3 justify-content-between">
          <p class="card-title">Реквизиты веб-студии</p>
        </div>
        <form v-on:submit.prevent="updateItem()">
          <div class="form-group">
            <div class="input-group">
              <input type="text" v-model="company_details.legal_name"
                     :class="'form-control' + (errors.legal_name ? ' is-invalid' : '')" id="legal_name"
                     placeholder="Полное юридическое название">
              <div class="invalid-feedback" v-if="errors.legal_name">
                {{errors.legal_name[0]}}
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col">
              <div class="input-group">
                <input type="number" v-model="company_details.inn"
                       :class="'form-control' + (errors.inn ? ' is-invalid' : '')" id="inn" placeholder="ИНН">
                <div class="invalid-feedback" v-if="errors.inn">
                  {{errors.inn[0]}}
                </div>
              </div>
            </div>
            <div class="col">
              <div class="input-group">
                <input type="number" v-model="company_details.kpp"
                       :class="'form-control' + (errors.kpp ? ' is-invalid' : '')" id="kpp" placeholder="КПП">
                <div class="invalid-feedback" v-if="errors.kpp">
                  {{errors.kpp[0]}}
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col">
              <div class="input-group">
                <input type="text" v-model="company_details.bank"
                       :class="'form-control' + (errors.bank ? ' is-invalid' : '')" id="bank" placeholder="Банк">
                <div class="invalid-feedback" v-if="errors.bank">
                  {{errors.bank[0]}}
                </div>
              </div>
            </div>
            <div class="col">
              <div class="input-group">
                <input type="number" v-model="company_details.bik"
                       :class="'form-control' + (errors.bik ? ' is-invalid' : '')" id="bik" placeholder="БИК">
                <div class="invalid-feedback" v-if="errors.bik">
                  {{errors.bik[0]}}
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col">
              <div class="input-group">
                <input type="number" v-model="company_details.rs"
                       :class="'form-control' + (errors.rs ? ' is-invalid' : '')" id="rs" placeholder="Расчетный счет">
                <div class="invalid-feedback" v-if="errors.rs">
                  {{errors.rs[0]}}
                </div>
              </div>
            </div>
            <div class="col">
              <div class="input-group">
                <input type="number" v-model="company_details.ks"
                       :class="'form-control' + (errors.ks ? ' is-invalid' : '')" id="ks" placeholder="Корпаративный счет">
                <div class="invalid-feedback" v-if="errors.ks">
                  {{errors.ks[0]}}
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" v-model="company_details.legal_address"
                     :class="'form-control' + (errors.legal_address ? ' is-invalid' : '')" id="legal_address"
                     placeholder="Юридический адрес">
              <div class="invalid-feedback" v-if="errors.legal_address">
                {{errors.legal_address[0]}}
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" v-model="company_details.director"
                     :class="'form-control' + (errors.director ? ' is-invalid' : '')" id="director"
                     placeholder="Руководитель">
              <div class="invalid-feedback" v-if="errors.director">
                {{errors.director[0]}}
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" v-model="company_details.accountant"
                     :class="'form-control' + (errors.accountant ? ' is-invalid' : '')" id="accountant"
                     placeholder="Бухгалтер">
              <div class="invalid-feedback" v-if="errors.accountant">
                {{errors.accountant[0]}}
              </div>
            </div>
          </div>
          <button class="btn btn-sm btn-primary" type="submit">Сохранить</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        company_details: [],
        errors: {},
        loading: false,
      }
    },
    created() {
      this.getItems();
    },
    methods: {
      getItems(){
        this.loading = true;
        axios.get(route('company_detail.show', 1))
          .then((response) => {
            this.company_details = response.data;
            this.loading = false;
          });
      },
      updateItem(){
        var vm = this;
        axios.put(route('company_detail.update', [1]), this.company_details)
          .then((response) => {
            pnotify.alert({
              title: 'Success',
              text: 'Успешно обновлено',
              type: 'success',
              delay: 1000,
            });
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
    },
  }
</script>
