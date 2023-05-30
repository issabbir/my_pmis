<template>
    <div class="">
        <div class="content-header row">
        </div>
        <div class="content-wrapper">
            <div class="content-body"><!-- Dashboard Ecommerce Starts -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
          this.breadCrumbs = this.$store.state.breadCrumbs
        },
        mounted() {
            this.$store.commit("setBreadcrumb", { link: "/#", label: "Overtime System" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Dashboard" });
        },
        data() {
            return {
                "breadCrumbs":""
            }
        }

    }
</script>

