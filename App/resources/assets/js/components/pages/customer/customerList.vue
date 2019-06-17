<template>
  <div v-if="!loading">
    <div class="email-header">
      <router-link :to="{name: 'customerCreate'}" tag="button" class="btn btn-primary has-icon email-composer"><i
        class="mdi mdi-plus"></i> Создать компанию
      </router-link>
    </div>
    <div class="grid">
      <p class="grid-header">Компании</p>
      <div class="item-wrapper">
        <div class="table-responsive">
          <table class="data-table table table-hover" id="sample-data-table">
            <thead>
            <tr>
              <th>#</th>
              <th>Название компании</th>
              <th>Телефон</th>
              <th>Email</th>
              <th>Ответственный</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="customer in customers">
              <td>{{customer.id}}</td>
              <td>
                <router-link :to="{name: 'customerShow', params: { id: customer.id }}">{{customer.name}}
                </router-link>
              </td>
              <td>{{customer.phone}}</td>
              <td>{{customer.email}}</td>
              <td>{{customer.manager.last_name}} {{customer.manager.first_name[0]}}. {{customer.manager.patronymic[0]}}.</td>
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
        customers: [],
        loading: false,
      }
    },
    methods: {
      getcustomers(){
        this.loading = true;
        axios.get(route('customers.index'))
          .then((responce) => {
            this.customers = responce.data.customers;
            this.loading = false;
          })
      }
    },
    mounted() {
      this.getcustomers();
      $(".data-table").DataTable({});
    }
  }
</script>
