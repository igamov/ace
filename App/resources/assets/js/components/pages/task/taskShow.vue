<template>
  <div v-if="!loading">
    <prev></prev>
    <h1 class="mb-4">{{task.title}}</h1>
    <div class="row">
      <div class="col-sm-12 col-md-8">
        <div class="grid">
          <div class="grid-body">
            <div class="row">
              <div class="col-12">
                <div class="row">
                  <div class="col-6">
                    <button v-if="btn3.show" @click="updateStatus(task.status_id - 1)" v-bind:class="'btn ' + btn3.btn_class + ' has-icon'" v-bind:disabled="btn3.disabled">
                      <i v-bind:class="btn3.icon"></i>{{btn3.txt}}
                    </button>
                  </div>
                  <div class="col-6 text-right">
                    <button  v-if="!btn2.show" @click="updateStatus(task.status_id + 1)" v-bind:class="'btn ' + btn1.btn_class + ' has-icon'" v-bind:disabled="btn1.disabled">
                      <i v-bind:class="btn1.icon"></i>{{btn1.txt}}
                    </button>
                    <button v-if="btn2.show" @click="updateStatus(task.status_id + 1)" v-bind:class="'btn ' + btn2.btn_class + ' has-icon'" v-bind:disabled="btn2.disabled">
                      <i v-bind:class="btn2.icon"></i>{{btn2.txt}}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="grid">
          <div class="grid-body">
            <div class="row">
              <div class="col-12">
                <div class="row">
                  <div class="col-1"><p class="align-middle display-4 text-center text-secondary"><i
                    class="icon-briefcase"></i></p></div>
                  <div class="col-11"><p> В проекте</p>
                    <p><router-link :to="{name: 'projectShow', params: { id: task.project.id }}">{{task.project.title}}</router-link></p></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="grid">
          <p class="grid-header">Описание задачи</p>
          <div class="grid-body">
            <div class="row">
              <div class="col-12">
                {{task.body}}
              </div>
            </div>
          </div>
        </div>
       <Comments v-bind:comments="task.comments" v-bind:task_id="task.id"/>
      </div>
      <div class="col-12 col-md-4">
        <div class="grid">
          <div class="grid-body">
            <div class="table-responsive">
              <table class="table info-table">
                <tbody>
                <tr>
                  <td>Дата начала</td>
                  <td>{{task.date_start | date}}</td>
                </tr>
                <tr>
                  <td>Крайний срок</td>
                  <td>{{task.date_end | date}}</td>
                </tr>
                <tr>
                  <td>Статус</td>
                  <td>{{task.status.title}}</td>
                </tr>
                <tr>
                  <td>Приоритет</td>
                  <td><label :class="'badge '+ task.priority.color">{{task.priority.title}}</label></td>
                </tr>
                <tr>
                  <td>Постановщик</td>
                  <td><a href="#">Коломейцев А.О.</a></td>
                </tr>
                <tr>
                  <td>Исполнитель</td>
                  <td><a href="#">{{task.developer_id}}</a></td>
                </tr>
                <tr>
                  <td>Проект</td>
                  <td><router-link :to="{name: 'projectShow', params: { id: task.project.id }}">{{task.project.title}}</router-link></td>
                </tr>
                <tr>
                  <td>Компания</td>
                  <td><router-link :to="{name: 'customerShow', params: { id: task.project.customer_id }}">{{task.project.customer.name}}</router-link></td>
                </tr>
                <tr>
                  <td>Создана</td>
                  <td>{{task.created_at | date}}</td>
                </tr>
                <tr>
                  <td>Изменена</td>
                  <td>{{task.updated_at | date}}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <History/>
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment';
  import Comments from './Comments';
  import History from './History';
  export default {
    data(){
      return {
        task: [],
        btn1: {
          icon: 'mdi mdi-play',
          txt: 'Начать',
          btn_class: 'btn-outline-primary',
          disabled: false,
        },
        btn2: {
          show: false,
        },
        btn3: {},
        loading: false,
      }
    },
    components:{
      Comments,
      History
    },
    created: function () {
      this.getTask();
    },
    methods: {
      getTask(){
        this.loading = true;
        var vm = this;
        axios.get(route('task.show', [this.$route.params.id]))
          .then((response) => {
            this.task = response.data;
            this.loading = false;
            var status = vm.task.status_id;
            vm.updateBtn(status);
          })
      },
      updateStatus(new_status_id){
        var vm = this;
        this.task.status_id = new_status_id;
        axios.put(route('task.update', [this.task.id]), this.task)
          .then((response) => {
            pnotify.alert({
              title: 'Success',
              text: 'Успешно обновлено',
              type: 'success',
              delay: 1000,
            });
            this.task = response.data;
            this.updateBtn(new_status_id);
          })
      },
      updateBtn(status_id){
        var vm = this;
        var role = vm.$store.state.Auth.role_name;
        switch (status_id) {
          case 2:
            vm.btn1.txt = 'На проверку';
            vm.btn1.icon = 'mdi mdi-check';
            vm.btn1.btn_class = 'btn-outline-info';
            vm.btn1.disabled = false;
            vm.btn1.show = true;
            vm.btn3.show = false;
            if (role === 'manager'){
              vm.btn1.show = false;
              vm.btn2.txt = 'В работе';
              vm.btn2.icon = 'mdi mdi-timer-sand';
              vm.btn2.btn_class = 'btn-outline-warning';
              vm.btn2.disabled = true;
              vm.btn2.show = true;
            }
            break;
          case 3:
            if (role === 'developer') {
              vm.btn1.show = true;
              vm.btn1.txt = 'Проверяется';
              vm.btn1.icon = 'mdi mdi-timer-sand';
              vm.btn1.btn_class = 'btn-outline-warning';
              vm.btn1.disabled = true;
            }
            if (role === 'manager') {
              vm.btn2.txt = 'Завершить';
              vm.btn2.icon = 'mdi mdi-check';
              vm.btn2.btn_class = 'btn-outline-success';
              vm.btn2.show = true;

              vm.btn3.txt = 'На доработку';
              vm.btn3.icon = 'mdi mdi-code-tags';
              vm.btn3.btn_class = 'btn-outline-warning';
              vm.btn3.show = true;
            }
            break;
          case 4:
            vm.btn1.txt = 'Выполнена';
            vm.btn1.icon = 'mdi mdi-check';
            vm.btn1.btn_class = 'btn-inverse-success';
            vm.btn1.disabled = true;
            vm.btn2.show = false;
            vm.btn3.show = false;
            break;
        }
      }
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
