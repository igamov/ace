<template>
  <div class="kanban-board-wrapper">
    <div class="board-category">
      <div class="board-category-head">
        <h6 class="heading-title">Новые</h6>
        <span class="badge badge-inverse-primary">{{tasks_new.length}}</span>

      </div>
        <draggable
          v-model="tasks_new"
          tag="ul"
          class="board-task ui-sortable"
          id="board-category_1"
          @add="onAdd($event, 1)"
          @change="update"
          v-bind="dragOptions()">
        <li class="task-item ui-sortable-handle" v-for="(task, index) in tasks_new" :key="task.id" :data-id="task.id">
          <p class="task-title">{{task.title}}</p>
          <div class="task-time"><i class="mdi mdi-clock-outline"></i>
            <small>{{task.created_at | dateAgo}}</small>
          </div>
          <p class="task-details"><label :class="'badge '+ task.priority.color">{{task.priority.title}}</label></p>
          <p><router-link :to="{name: 'taskShow', params: { id: task.id }}">Подробнее</router-link></p>
        </li>
        </draggable>
      <router-link  class="add-task" :to="{ name: 'taskCreate' }" exact>Создать задачу</router-link>
    </div>
    <div class="board-category">
      <div class="board-category-head">
        <h6 class="heading-title">В работе</h6>
        <span class="badge badge-inverse-warning">{{tasks_work.length}}</span>
      </div>
    <draggable
      v-model="tasks_work"
      tag="ul"
      class="board-task ui-sortable"
      id="board-category_2"
      @add="onAdd($event, 2)"
      @change="update"
      v-bind="dragOptions()">
        <li class="task-item ui-sortable-handle" v-for="(task, index) in tasks_work" :key="task.id" :data-id="task.id">
          <p class="task-title">{{task.title}}</p>
          <div class="task-time"><i class="mdi mdi-clock-outline"></i>
            <small>{{task.created_at | dateAgo}}</small>
          </div>
          <p class="task-details"><label :class="'badge '+ task.priority.color">{{task.priority.title}}</label></p>
          <p><router-link :to="{name: 'taskShow', params: { id: task.id }}">Подробнее</router-link></p>
        </li>
    </draggable>
    </div>
    <div class="board-category">
      <div class="board-category-head">
        <h6 class="heading-title">На проверке</h6>
        <span class="badge badge-inverse-info">{{tasks_check.length}}</span>
      </div>
      <draggable
        v-model="tasks_check"
        tag="ul"
        class="board-task ui-sortable"
        id="board-category_3"
        @add="onAdd($event, 3)"
        @change="update"
        v-bind="dragOptions()">
          <li class="task-item ui-sortable-handle" v-for="(task, index) in tasks_check" :key="task.id" :data-id="task.id">
            <p class="task-title">{{task.title}}</p>
            <div class="task-time"><i class="mdi mdi-clock-outline"></i>
              <small>{{task.created_at | dateAgo}}</small>
            </div>
            <p class="task-details"><label :class="'badge '+ task.priority.color">{{task.priority.title}}</label></p>
            <p><router-link :to="{name: 'taskShow', params: { id: task.id }}">Подробнее</router-link></p>
          </li>
      </draggable>
    </div>
    <div class="board-category">
      <div class="board-category-head">
        <h6 class="heading-title">Завершены</h6>
        <span class="badge badge-inverse-success">{{tasks_complete.length}}</span>
      </div>
      <draggable
        v-model="tasks_complete"
        tag="ul"
        class="board-task ui-sortable"
        id="board-category_4"
        @add="onAdd($event, 4)"
        @change="update"
        v-bind="dragOptionsManager()">
          <li class="task-item ui-sortable-handle" v-for="(task, index) in tasks_complete" :key="task.id" :data-id="task.id">
            <p class="task-title">{{task.title}}</p>
            <div class="task-time"><i class="mdi mdi-clock-outline"></i>
              <small>{{task.created_at | dateAgo}}</small>
            </div>
            <p class="task-details"><label :class="'badge '+ task.priority.color">{{task.priority.title}}</label></p>
            <p><router-link :to="{name: 'taskShow', params: { id: task.id }}">Подробнее</router-link></p>
          </li>
      </draggable>
    </div>

  </div>
</template>
<script>
  import moment from 'moment';
  import draggable from 'vuedraggable'
  export default {
    data(){
      return {
        tasks: [],
        tasks_new: [],
        tasks_work: [],
        tasks_check: [],
        tasks_complete: []
      };
    },
    components: {
      draggable,
    },
    computed: {
      auth() {
        return this.$store.state.Auth;
      },
    },
    mounted() {
      this.getTasks();
    },
    props: {
      project_id: Number
    },
    methods: {
      dragOptions() {
        if (this.$store.state.Auth.role_name === 'customer'){
          var disable = true
        }else{
          var disable = false
        }
        return {
          animation: 150,
          group: "tasks",
          ghostClass: "ui-sortable-helper",
          disabled: disable,
        };
      },
      dragOptionsManager(){
        if (this.$store.state.Auth.role_name === 'customer' || this.$store.state.Auth.role_name === 'developer'){
          var disable = true
        }else{
          var disable = false
        }
        return {
          animation: 150,
          group: "tasks",
          ghostClass: "ui-sortable-helper",
          disabled: disable,
        };
      },
      getTasks(){
        this.loading = true;
        axios.get(route('task.index') + '?project_id=' + this.project_id)
          .then((response) => {
            this.tasks_new = response.data.tasks_new;
            this.tasks_work = response.data.tasks_work;
            this.tasks_check = response.data.tasks_check;
            this.tasks_complete = response.data.tasks_complete;
            this.loading = false;
          })
      },
      update() {
        this.tasks = this.tasks.concat(this.tasks_new, this.tasks_work);
        this.tasks.map((task, index) => {
          task.rank = index + 1;
        });

        axios.put((route('task.updateAll')), {
          tasks: this.tasks,
        }).then((response) => {
          // success message
        })
      },
      onAdd(event, status_id) {
        let id = event.item.getAttribute('data-id');
        axios.patch(route('task.updateStatus',[id]), {
          status_id: status_id,
          user_id: this.$store.state.Auth.user_id
        }).then((response) => {
          // success message
        })
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