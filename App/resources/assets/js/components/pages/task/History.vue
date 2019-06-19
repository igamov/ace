<template>
  <div class="grid">
    <div class="grid-body">
      <div class="d-flex justify-content-between">
        <p class="card-title">История</p>
      </div>
      <div class="vertical-timeline-wrapper">
        <div class="timeline-vertical dashboard-timeline">
          <div class="activity-log" v-for="history in histories">
            <p class="log-name">{{history.user.last_name}} {{history.user.first_name}}</p>
            <div class="log-details">{{history.body}}
              <div class="grouped-images mt-1">
                <img class="img-sm" :src="history.user.photo" alt="Profile Image">
              </div>
            </div>
            <small class="log-time">{{history.created_at | dateAgo}}</small>
          </div>
        </div>
      </div>
    </div>
    <button class="btn btn-link shadow-none  px-3 py-2 d-block text-gray view" @click="viewAll()">
      <small class="font-weight-medium"><i class="mdi mdi-chevron-down mr-2"></i>{{view}}</small>
    </button>
  </div>
</template>
<script>
  import moment from 'moment';
  export default {
    data(){
      return {
        isOpen: false,
        view: 'Развернуть',
      }
    },
    props: {
      histories: Array
    },
    methods: {
      viewAll(){
        if(this.isOpen){
          $('.timeline-vertical').addClass('dashboard-timeline');
          this.isOpen = false;
          this.view = 'Развернуть';
        }else{
          $('.timeline-vertical').removeClass('dashboard-timeline');
          this.isOpen = true;
          this.view = 'Свернуть';
        }
        $('.view .mdi').toggleClass('mdi-chevron-up');
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