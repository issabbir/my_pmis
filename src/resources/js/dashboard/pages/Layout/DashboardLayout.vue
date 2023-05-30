<template>
  <div class="content-wrapper">
      <!--<dashboard-content> </dashboard-content>-->
      <router-view></router-view>
  </div>
</template>

<script>
    import DashboardContent from "./Content.vue";
    export default {
      components: {
        DashboardContent
      }
    };
</script>
<style lang="scss">

</style>
