<template>
  <div class="row">
    <div class="col-4">
      <div class="grid">
        <div class="grid-body">
          <div class="row">
            <div class="col-12">
              <form v-on:submit.prevent="createNote()">
                          <textarea v-model="form.body" :class="'form-control' + (errors.body ? ' is-invalid' : '')"
                                    placeholder="Добавить заметку" cols="12" rows="3"></textarea>
                <div class="text-right mt-1">
                  <button class="btn btn-primary btn-sm" type="submit">
                    <i class="mdi mdi-send"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4" v-for="(note, index) in notes">
      <div class="grid">
        <div class="grid-body">
          <div class="d-flex justify-content-between">
            <p class="card-title font-weight-light">
              <small>{{note.created_at | dateAgo}}</small>
            </p>
            <div class="btn-group">
              <button type="button" class="btn btn-trasnparent btn-xs component-flat pr-0"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-dots-vertical"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">Edit</a>
                <a class="dropdown-item text-danger" @click="deleteNote(note, index)">Delete</a>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="row">
              <div class="word-break"><p>{{note.body}}</p></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import moment from 'moment';
  export default {
    props: {
      project_id: Number
    },
    data(){
      return {
        loading: false,
        form: {
          id: '',
          body: '',
          index: '',
          user_id: '',
          project_id: ''
        },
        notes: {},
        errors: {},
        date_diff: '',
      }
    },
    created: function () {
      this.getNotes();
    },
    methods: {
      createNote(){
        var vm = this;
        this.form.project_id = this.project_id;
        this.form.user_id = 1;
        axios.post(route('notes.store'), this.form)
          .then(function (response) {
            pnotify.alert({
              title: 'Success',
              text: 'Успешно добавлено',
              type: 'success',
              delay: 1000,
            });
            vm.notes.push(response.data);
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
      getNotes(){
        var vm = this;
        this.loading = true;
        axios.get(route('notes.index'))
          .then((response) => {
            this.notes = response.data.notes;
            this.loading = false;
          });

      },
      deleteNote(note, index){
        var vm = this;
        axios.delete(route('notes.destroy', [note.id]))
          .then(() => {
            pnotify.alert({
              title: 'Success',
              text: 'Успешно удалено',
              type: 'success',
              delay: 1000,
            });
            vm.notes.splice(index, 1);
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

      clearForm(){
        this.form = {};
        this.errors = {};
      },
    },
    filters: {
      dateAgo: function (value) {
        if (!value) return '';
        moment.lang('ru');
        return moment(value, "YYYYMMDDh:mm:ss").fromNow();
      },
      dateTo: function (value) {
        if (!value) return '';
        moment.lang('ru');
        return moment(value, "YYYYMMDDh:mm:ss").format('LL');
      },
    }
  }
</script>