<template>
  <div class="content-wrapper">
    <div class="content-body">
        Request form
    </div>
  </div>
</template>

<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
export default {
  data() {
    return {
      name: ""
    };
  },
  mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", { link: "#", label: "Leave-management" });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Request" });
  },
  components: {
    FormWizard,
    TabContent
  }
};
</script>
