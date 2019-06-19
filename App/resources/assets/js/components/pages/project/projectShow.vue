<template>
  <div v-if="!loading">
    <prev></prev>
    <h1 class="mb-4">{{project.title}}</h1>
    <div class="item-wrapper">
      <div class="tab-container ">
        <ul class="nav nav-tabs" id="bt-tab_1" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="bt-tab_1_1" data-toggle="tab" href="#bt-content_1_1" role="tab"
               aria-controls="bt-content_1_1" aria-selected="true">Общие</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="bt-tab_1_2" data-toggle="tab" href="#bt-content_1_2" role="tab"
               aria-controls="bt-content_1_2" aria-selected="false">Задачи</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="bt-tab_1_5" data-toggle="tab" href="#bt-content_1_4" role="tab"
               aria-controls="bt-content_1_5" aria-selected="false">Заметки</a>
          </li>
        </ul>
        <div class="tab-content" id="bt-tab_content_1" style="padding: 30px 0 0 0; background: none;">
          <div class="tab-pane show active" id="bt-content_1_1" role="tabpanel" aria-labelledby="bt-tab_1_1">
            <div class="grid widget-revenue-card">
              <div class="grid-body d-flex flex-column h-100">
                <div class="mt-auto">
                  <h3 class="font-weight-medium mt-2">{{date_diff}}</h3>
                  <p class="text-gray">ДО ЗАВЕРШЕНИЯ</p>
                  <div class="d-flex justify-content-between text-muted mt-3">
                    <small>{{project.date_start | dateTo}} - {{project.date_end | dateTo}}</small>
                    <small>{{date_percent}}%</small>
                  </div>
                  <div class="progress progress-slim mt-2">
                    <div class="progress-bar bg-primary" role="progressbar"  v-bind:style="{ width: date_percent + '%' }"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="grid">
              <div class="grid-body">
                <div class="row">
                  <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <p>
                      <small><b>Менеджер проекта</b></small>
                    </p>
                    <p>{{project.manager.last_name}} {{project.manager.first_name[0]}}. {{project.manager.patronymic[0]}}.</p>
                  </div>
                  <div class="col-12 col-md-3 mb-3  mb-md-0">
                    <p>
                      <small><i class="fa-calendar-o"></i> <b>Сроки проекта</b></small>
                    </p>
                    <p>{{project.date_start| dateTo}} - {{project.date_end| dateTo}}</p>
                  </div>
                  <div class="col-12 col-md-3 mb-3  mb-md-0">
                    <p>
                      <small><b>Компания</b></small>
                    </p>
                    <p>
                      <router-link :to="{name: 'customerShow', params: { id: project.customer_id}}">
                        {{project.customer.name}}
                      </router-link>
                    </p>
                  </div>
                  <div class="col-12 col-md-3 mb-3  mb-md-0">
                    <p>
                      <small><b>Приоритет</b></small>
                    </p>
                    <p><span :class="'badge ' + project.priority.color">{{project.priority.title}}</span></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="grid">
              <div class="grid-body">
                <h4 class="card-title mb-4">Описание проекта</h4>
                <p><span>{{project.body}}</span></p>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="bt-content_1_2" role="tabpanel" aria-labelledby="bt-tab_1_2">
            <Tasks v-bind:project_id="project.id"/>
          </div>
          <div class="tab-pane" id="bt-content_1_4" role="tabpanel" aria-labelledby="bt-tab_1_4">
            <Notes v-bind:notes="project.notes" v-bind:project_id="project.id"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment';
  import Notes from './Notes';
  import Tasks from './Tasks';
  export default {
    components:{
      Tasks,
      Notes,
    },
    data(){
      return {
        project: [
          'company_name'
        ],
        loading: false,
        date_diff: '',
        date_percent: '',
      }
    },
    created: function () {
      this.getProject();
    },
    methods: {
      getProject(){
        this.loading = true;
        axios.get(route('projects.show', [this.$route.params.id]))
          .then((response) => {
            this.project = response.data;
            moment.lang('ru');
            var dateB = moment();
            var dateC = moment(this.project.date_end, "YYYYMMDDh:mm:ss");

            var date_diff = dateC.diff(dateB, 'days');

            var dateD = moment(this.project.date_start, "YYYYMMDDh:mm:ss");
            var date_amount = dateC.diff(dateD, 'days');


            var dney = 'дней';
            if (date_diff <= 4 && date_diff > 1 || date_diff < -1 && date_diff >= -4){
              var dney = 'дня';
            }else if (date_diff === 1){
              var dney = 'день';
            }
            this.date_diff = date_diff + ' ' + dney;
            this.date_percent = Math.round(100 * (date_amount - date_diff)/ date_amount);
            this.loading = false;
          })
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
<style>
  .word-break {
    word-break: break-all;
    display: inline-block;
  }
</style>
