<template>
  <div class="col-md-6">
    <div class="grid">
      <div class="grid-body">
        <div class="d-flex justify-content-between">
          <p class="card-title">НДС</p>
          <div class="btn-group">
            <button type="button" @click="newModal" class="btn btn-trasnparent btn-xs component-flat pr-0"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="mdi mdi-plus"></i>
            </button>
          </div>
        </div>
      </div>
      <table class="table table-hover">
        <thead>
        <tr>
          <th>#</th>
          <th>Наименование</th>
          <th>Процент</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(item, index) in nds" v-bind:key="item.id">
          <td>{{index + 1}}</td>
          <td>{{item.title}}</td>
          <td>{{item.percent}}</td>
          <td class="actions">
            <button @click="editModal(item, index)" class="btn btn-link btn-xs shadow-none">
              <i class="mdi mdi mdi-pencil"></i>
            </button>
            <button @click="deleteModal(item, index)" class="btn btn-link btn-xs text-danger shadow-none">
              <i class="mdi mdi mdi-delete"></i>
            </button>

          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="modal fade" id="delete_item" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Удалить НДС</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Вы уверены ?
          </div>
          <div class="modal-footer">
            <button @click="unsetDelete()" type="button" class="btn btn-secondary btn-sm">Отмена</button>
            <button @click="setDelete()" type="button" class="btn btn-primary btn-sm">Удалить</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="add_item">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form v-on:submit.prevent="editmode ? updateItem() : createItem()">
            <div class="modal-header">
              <h5 class="modal-title">Создание НДС</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="priority_title">Наименование</label>
                <input type="text" v-model="form.title"
                       :class="'form-control' + (errors.title ? ' is-invalid' : '')" id="priority_title"
                       placeholder="Title">
                <div class="invalid-feedback" v-if="errors.title">
                  {{errors.title[0]}}
                </div>
              </div>
              <div class="form-group">
                <label for="priority_color">Процент</label>
                <input type="text" v-model="form.percent"
                       :class="'form-control' + (errors.percent ? ' is-invalid' : '')" id="priority_color"
                       placeholder="Percent">
                <div class="invalid-feedback" v-if="errors.percent">
                  {{errors.percent[0]}}
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
              <button v-show="editmode" type="submit" class="btn btn-success btn-sm">Обновить</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary btn-sm">Создать</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        nds: [],
        form: {
          id: '',
          title: '',
          color: '',
          index: '',
        },
        errors: {},
        loading: false,
        editmode: false,
      }
    },
    created() {
      this.getItems();
    },
    methods: {
      newModal(){
        this.clearForm();
        this.editmode = false;
        $('#add_item').modal('show');
      },
      editModal(item, index){
        this.editmode = true;
        this.form = item;
        this.form.index = index;
        $('#add_item').modal('show');
      },
      deleteModal(item, index){
        this.form = item;
        this.form.index = index;
        $('#delete_item').modal('show');
      },
      getItems(){
        this.loading = true;
        axios.get(route('nds.index'))
          .then((response) => {
            this.nds = response.data.nds;
            this.loading = false;
          });
      },
      createItem() {
        this.loading = false;
        var vm = this;
        axios.post(route('nds.store'), this.form)
          .then(function (response) {
            pnotify.alert({
              title: 'Success',
              text: 'Успешно добавлено',
              type: 'success',
              delay: 1000,
            });
            vm.nds.push(response.data);
            $('#add_item').modal('hide');
            vm.clearForm();
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
      updateItem(){
        var vm = this;
        axios.put(route('nds.update', [this.form.id]), this.form)
          .then((response) => {
            pnotify.alert({
              title: 'Success',
              text: 'Успешно обновлено',
              type: 'success',
              delay: 1000,
            });
            vm.nds.splice(vm.form.index, 1, response.data);
            $('#add_item').modal('hide');
            vm.clearForm();
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
      setDelete(){
        var vm = this;
        axios.delete(route('priority.destroy', [this.form.id]))
          .then(() => {
            pnotify.alert({
              title: 'Success',
              text: 'Успешно удалено',
              type: 'success',
              delay: 1000,
            });
            vm.nds.splice(vm.form.index, 1);
            $('#delete_item').modal('hide');
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
      unsetDelete(){
        $('#delete_item').modal('hide');
      },
      clearForm(){
        this.form = {};
        this.errors = {};
      },
    },
  }
</script>
