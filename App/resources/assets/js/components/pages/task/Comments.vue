<template>
  <div class="grid">
    <p class="grid-header">Комментарии</p>
    <div class="grid-body">
      <div class="row">
        <div class="col-12">
          <form action="">
            <div class="media">
              <img class="profile-img mr-3"
                   :src="auth.photo">
              <div class="media-body">
                <form v-on:submit.prevent="createComment()">
                  <textarea v-model="form.body" :class="'form-control' + (errors.body ? ' is-invalid' : '')" placeholder="Написать комментарий" cols="12" rows="3"></textarea>
                  <div class="text-right mt-1">
                    <button class="btn btn-primary btn-sm" type="submit">
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
            <img class="profile-img mr-3" :src="comment.user.photo">
            <div class="media-body">
              <div class="author">{{comment.user.last_name}} {{comment.user.first_name[0]}}. {{comment.user.patronymic[0]}}.</div>
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
        this.form.user_id = this.auth.user_id;
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
    computed: {
      auth() {
        return this.$store.state.Auth;
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
