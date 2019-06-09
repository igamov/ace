<template>
  <div class="col-md-6">
    <div class="grid">
      <div class="grid-body">
        <div class="d-flex justify-content-between">
          <p class="card-title">Сферы деятельности</p>
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
          <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(item, index) in area_activities" v-bind:key="item.id">
          <td>{{index + 1}}</td>
          <td>{{item.title}}</td>
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
    <div class="modal fade" id="delete_area_activity" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delete Priority</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure ?
          </div>
          <div class="modal-footer">
            <button @click="unsetDelete()" type="button" class="btn btn-secondary btn-sm">Cancel</button>
            <button @click="setDelete()" type="button" class="btn btn-primary btn-sm">Delete</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="add_area_activity">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form v-on:submit.prevent="editmode ? updateItem() : createItem()">
            <div class="modal-header">
              <h3 class="modal-title">Create Area Activity</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <h6 class="text-primary mb-4">Add Area Activity</h6>
              <hr>
              <div class="form-group">
                <label for="area_activity_title">Title</label>
                <input type="text" v-model="form.title"
                       :class="'form-control' + (errors.title ? ' is-invalid' : '')" id="area_activity_title"
                       placeholder="Title">
                <div class="invalid-feedback" v-if="errors.title">
                  {{errors.title[0]}}
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-success btn-sm">Update</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary btn-sm">Create</button>
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
        area_activities: [],
        form: {
          id: '',
          title: '',
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
        $('#add_area_activity').modal('show');
      },
      editModal(item, index){
        this.editmode = true;
        this.form = item;
        this.form.index = index;
        $('#add_area_activity').modal('show');
      },
      deleteModal(item, index){
        this.form = item;
        this.form.index = index;
        $('#delete_area_activity').modal('show');
      },
      getItems(){
        this.loading = true;
        axios.get(route('area_activity.index'))
          .then((response) => {
            this.area_activities = response.data.area_activities;
            this.loading = false;
          });
      },
      createItem() {

        this.loading = false;
        var vm = this;
        axios.post(route('area_activity.store'), this.form)
          .then(function (response) {
            pnotify.alert({
              title: 'Success',
              text: 'Успешно добавлено',
              type: 'success',
              delay: 1000,
            });
            vm.area_activities.push(response.data);
            $('#add_area_activity').modal('hide');
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
        axios.put(route('area_activity.update', [this.form.id]), this.form)
          .then((response) => {
            pnotify.alert({
              title: 'Success',
              text: 'Успешно обновлено',
              type: 'success',
              delay: 1000,
            });
            vm.area_activities.splice(vm.form.index, 1, response.data);
            $('#add_area_activity').modal('hide');
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
        axios.delete(route('area_activity.destroy', [this.form.id]))
          .then(() => {
            pnotify.alert({
              title: 'Success',
              text: 'Успешно удалено',
              type: 'success',
              delay: 1000,
            });
            vm.area_activities.splice(vm.form.index, 1);
            $('#delete_area_activity').modal('hide');
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
        $('#delete_area_activity').modal('hide');
      },
      clearForm(){
        this.form = {};
        this.errors = {};
      },
    },
  }
</script>
