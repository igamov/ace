<template>
  <div v-if="!loading">
    <prev></prev>
    <h1 class="mb-4">Счёт №{{invoice.number}}</h1>
    <div class="grid">
      <p class="grid-header">Счёт №{{invoice.number}}</p>
      <div class="grid-body">
        <div class="row">
          <div class="col-12 col-md-6">
            <div class="row">
              <div class="d-inline p-2"><p><b>Плательщик</b></p></div>
              <div class="d-inline p-2">
                <p>
                  <router-link
                    :to="{name: 'customerShow', params: { id: invoice.customer_id }}">
                    {{invoice.customer.name}}
                  </router-link>
                </p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="row">
              <div class="d-inline p-2"><p><b>Оплатить до</b></p></div>
              <div class="d-inline p-2"><p>{{invoice.payment_date}}</p></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="grid">
      <p class="grid-header">Список услуг</p>
      <div class="grid-body">
        <div class="row">
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
              </tr>
              </thead>
              <tbody>
              <tr v-for="(service, index) in invoice.services">
                <td>{{index + 1}}</td>
                <td>{{service.title}}</td>
                <td>{{service.price}}</td>
                <td>{{service.count}}</td>
                <td>{{service.percent}} %</td>
                <td>{{service.sum}}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="text-right">
      <button @click="openPdf()" class="btn has-icon btn-primary btn-rounded"><i class="mdi mdi-file-pdf-box"></i>
        Просмотреть PDF
      </button>
    </div>
  </div>
</template>

<script>
  import jsPDF from 'jspdf';
  export default {
    data(){
      return {
        invoice: [],
        loading: false,
      }
    },
    created: function () {
      this.getInvoice();
    },
    methods: {
      openPdf(){
        window.open(this.invoice.pdf_path, "_blank");
      },
      getInvoice(){
        this.loading = true;
        axios.get(route('invoice.show', [this.$route.params.id]))
          .then((response) => {
            this.invoice = response.data;
            this.loading = false;
          })
      }
    },
  }
</script>
