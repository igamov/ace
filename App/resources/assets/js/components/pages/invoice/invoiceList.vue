<template>
  <div v-if="!loading">
    <div class="email-header">
      <router-link :to="{name: 'invoiceCreate'}" tag="button" class="btn btn-primary has-icon email-composer"><i
        class="mdi mdi-plus"></i> Создать счёт
      </router-link>
    </div>
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
            <tr v-for="(invoice, index) in invoices">
              <td><router-link :to="{name: 'invoiceShow', params: { id: invoice.id }}">{{invoice. number}}</router-link>
              <td>{{invoice.customer.name}}</td>
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
</template>
<script>
  export default {
    data(){
      return {
        invoices: [],
        loading: false,
      }
    },
    methods: {
      getInvoices(){
        this.loading = true;
        axios.get(route('invoice.index'))
          .then((responce) => {
            this.invoices = responce.data.invoices;
            this.loading = false;
          })
      }
    },
    mounted() {
      this.getInvoices();
    }
  }
</script>
