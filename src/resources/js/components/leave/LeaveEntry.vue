<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-tabs>
                <b-tab title="General Leave Application" active>
                    <general-leave></general-leave>
                </b-tab>
                <b-tab title="PRL Application">
                    <PRLLeave></PRLLeave>
                </b-tab>
            </b-tabs>
        </div>
    </div>
</template>

<script>
    import GeneralLeave from "./GeneralLeave";
    import PRLLeave from "./PRLLeave";
    export default {
        components: {GeneralLeave, PRLLeave},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Leave"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Leave Entry"});
        }
    }
</script>

<style>

</style>
