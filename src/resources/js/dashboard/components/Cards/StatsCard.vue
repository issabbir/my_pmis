<template>
  <b-card class="md-card-stats">
    <b-card-header :data-background-color="dataBackgroundColor">
      <slot name="header"></slot>
    </b-card-header>

    <b-card-content>
      <slot name="content"></slot>
    </b-card-content>

    <b-card-footer md-alignment="left">
      <slot name="footer"></slot>
    </b-card-footer>
  </b-card>
</template>
<script>
export default {
  name: "stats-card",
  props: {
    dataBackgroundColor: {
      type: String,
      default: ""
    }
  }
};
</script>
<style>
    .md-card .md-card-header {
        margin: 0px 0px 0 !important;
        padding: 10px!important;
    }
</style>
