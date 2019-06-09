<template>
  <p>{{ date }}</p>
</template>

<script>
  import moment from 'moment';
  export default {
    props: {
      date: String
    },
    created() {
        moment.lang('ru');
        this.date = moment(this.date, "YYYYMMDDh:mm:ss").fromNow();
    },
  }
</script>
