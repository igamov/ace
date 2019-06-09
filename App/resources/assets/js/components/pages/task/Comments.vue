<template>
  <div class="grid">
    <p class="grid-header">Комментарии</p>
    <div class="grid-body">
      <div class="row">
        <div class="col-12">
          <form action="">
            <div class="media">
              <img class="mr-3"
                   src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2264%22%20height%3D%2264%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2064%2064%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16b0f723522%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16b0f723522%22%3E%3Crect%20width%3D%2264%22%20height%3D%2264%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2213.84375%22%20y%3D%2236.5%22%3E64x64%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                   alt="Generic placeholder image">
              <div class="media-body">
                <form v-on:submit.prevent="createComment()">
                  <textarea v-model="form.body" :class="'form-control' + (errors.body ? ' is-invalid' : '')" placeholder="Написать комментарий" cols="12" rows="3"></textarea>
                  <div class="text-right mt-1">
                    <button class="btn btn-primary" type="submit">
                      <i class="mdi mdi-send"></i>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </form>
        </div>
        <div class="col-12">
          <div class="media mt-4" v-for="(comment, index) in comments">
            <img class="mr-3"
                 src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2264%22%20height%3D%2264%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2064%2064%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16b0f723522%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16b0f723522%22%3E%3Crect%20width%3D%2264%22%20height%3D%2264%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2213.84375%22%20y%3D%2236.5%22%3E64x64%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                 alt="Generic placeholder image">
            <div class="media-body">
              <div class="author">{{comment.user_id}}</div>
              <div class="metadata">
                <span class="date">{{comment.created_at | dateAgo}}</span>
              </div>
              <div class="media-text text-justify">
                {{comment.body}}
              </div>

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
    data(){
      return {
        loading: false,
        form: {
          id: '',
          body: '',
          index: '',
          user_id: '',
          task_id: ''
        },
        errors: {},
      }
    },
    props: {
      comments: Array,
      task_id: Number
    },
    methods: {
      createComment(){
        var vm = this;
        this.form.task_id = this.task_id;
        this.form.user_id = 1;
        axios.post(route('comment.store'), this.form)
          .then(function (response) {
            pnotify.alert({
              title: 'Success',
              text: 'Успешно добавлено',
              type: 'success',
              delay: 1000,
            });
            vm.comments.unshift(response.data);
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
      date: function (value) {
        if (!value) return '';
        moment.lang('ru');
        return moment(value, "YYYYMMDDh:mm:ss").format('LLL');
      },
    }
  }
</script>
<style>
  ul {
    list-style-type: inherit;
  }

  .media-body .author {
    display: inline-block;
    font-size: 1rem;
    color: #000;
    font-weight: 700;
  }

  .media-body .metadata {
    display: inline-block;
    margin-left: .5rem;
    color: #777;
    font-size: .8125rem;
  }
</style>
