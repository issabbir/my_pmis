<template>
     <div class="content-wrapper">
        <div class="content-body"><!-- Dashboard Ecommerce Starts -->
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            // this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            console.log('Component mounted.')
        }
    }
</script>
