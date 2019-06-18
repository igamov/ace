<template>
  <div v-if="!loading">
    <div class="email-header">
      <!--<router-link :to="{name: 'projectCreate'}" tag="button" class="btn btn-primary has-icon email-composer"><i class="mdi mdi-plus"></i> Создать проект</router-link>-->
    </div>
    <div class="grid">
      <p class="grid-header">Задачи</p>
      <div class="item-wrapper">
        <table class="table table-hover">
          <thead>
          <tr>
            <th>#</th>
            <th>Наименование</th>
            <th>Приоритет</th>
            <th>Проект</th>
            <th>Дата начала</th>
            <th>Дата окончания</th>
            <th>Статус</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="task in tasks">
            <td>{{task.id}}</td>
            <td><router-link :to="{name: 'taskShow', params: { id: task.id }}">{{task.title}}</router-link></td>
            <td><label :class="'badge '+ task.priority.color">{{task.priority.title}}</label></td>
            <td><router-link :to="{name: 'projectShow', params: { id: task.project.id }}">{{task.project.title}}</router-link></td>
            <td>{{task.date_start}}</td>
            <td>{{task.date_end}}</td>
            <td>{{task.status.title}}</td>
            <td class="actions">
              <i class="mdi mdi-dots-vertical"></i>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script>

  export default {
    data(){
      return {
        tasks: [],
        loading: false
      }
    },
    methods: {
      getTasks(){
        this.loading = true;
        var vm = this;
        axios.get(route('tasks.all') + '?user_id=' + vm.$store.state.Auth.user_id)
          .then((responce) => {
            this.tasks = responce.data.tasks;
            this.loading = false;
          })
      }
    },
    mounted() {
      this.getTasks();
    }
  }
</script>
