<template>
  <div v-if="!loading">
    <div class="email-header">
      <!--<router-link :to="{name: 'projectCreate'}" tag="button" class="btn btn-primary has-icon email-composer"><i class="mdi mdi-plus"></i> Создать проект</router-link>-->
    </div>
    <div class="row">
      <div class="col-12 col-sm-9">
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
              <tr v-for="task in filteredTasks">
                <td>{{task.id}}</td>
                <td>
                  <router-link :to="{name: 'taskShow', params: { id: task.id }}">{{task.title}}</router-link>
                </td>
                <td><label :class="'badge '+ task.priority.color">{{task.priority.title}}</label></td>
                <td>
                  <router-link :to="{name: 'projectShow', params: { id: task.project.id }}">{{task.project.title}}
                  </router-link>
                </td>
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
      <div class="col-12 col-sm-3">
        <div class="grid">
          <p class="grid-header">Фильтрация</p>
          <div class="grid-body">
            <div class="form-group">
              <p class="font-weight-bold mb-3">Статус задачи:</p>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="Новая" v-model="status_id">Новая <i
                  class="input-frame"></i>
                </label>
              </div>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="В работе" v-model="status_id">В работе <i
                  class="input-frame"></i>
                </label>
              </div>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="Проверка" v-model="status_id">Проверка <i
                  class="input-frame"></i>
                </label>
              </div>
              <div class="radio mb-3">
                <label class="radio-label mr-4">
                  <input name="sample" type="radio" checked="" value="Выполнена" v-model="status_id">Выполнена <i
                  class="input-frame"></i>
                </label>
              </div>
            </div>
            <div class="w-100 text-right">
              <button class="btn btn-sm btn-outline-secondary" @click="resetFilter()">Сбросить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

  export default {
    data(){
      return {
        tasks: [],
        loading: false,
        status_id: '',
      }
    },

    methods: {
      resetFilter(){
        this.status_id = '';
      },
      getTasks(){
        this.loading = true;
        var vm = this;
        axios.get(route('tasks.all') + '?user_id=' + vm.$store.state.Auth.user_id)
          .then((response) => {
            this.tasks = response.data.tasks;
            this.loading = false;
          })
      }
    },
    mounted() {
      this.getTasks();
    },
    computed: {
      filteredTasks(){
        return this.tasks.filter(task => {
            return task.status.title.indexOf(this.status_id) > -1;
        });
      }
    },
  }
</script>
