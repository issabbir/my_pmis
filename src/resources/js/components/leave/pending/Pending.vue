<template>
<b-container fluid>
    <Form @clicked="onClickChild"></Form>
    <Listing></Listing>
</b-container>
</template>

<script>
    import Form from "./Form"
    import Listing from "./Listing";
export default {
  data() {
    return {
      name: ""
    };
  },
  mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", { link: "#", label: "Approval Service" });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Leave pending" });
   },
  methods: {
    onClickChild (value) {
      console.log(value) // someValue
    }
  },
  components: {
    Form,
    Listing
  }
};
</script>
