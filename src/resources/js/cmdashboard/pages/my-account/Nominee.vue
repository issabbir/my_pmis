<template>
    <div class="content-body">
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Nominee Information</b-card-header>
            <b-card-body class="border">
                <Datatable :items="items" :perPage="perPage" :fields="fields" :totalList="totalList"></Datatable>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import ApiRepository from "../../../Repository/ApiRepository";
    import Datatable from "../../../layouts/common/datatable"
    import moment from "moment";

    export default {
        name: "Nominee",
        components: {Datatable},
        data() {
            return {
                fields: [
                    {key: 'index', label: 'Sl.', sortable: true},
                    {key: 'nominee_name', label: 'Name', orderDate: true},
                    {key: 'relation_type_name', label: 'Relation', orderDate: true},
                    {key: 'nominee_email', label: 'Email', sortable: true},
                    {key: 'nominee_contact_no', label: 'Contact No.', sortable: true},
                    {key: 'percentage', sortable: true}
                ],
                items: [],
                perPage: 5,
                totalList: 1
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "dashboard", label: "Dashboard"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account", label: "My Account"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account/nominee", label: "Nominee Information"});
            this.loadNominee()
        },
        methods: {
            loadNominee() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/api/nominee`).then(result => {
                    this.items = result.data.data.nominee
                    this.totalList = this.items.length
                });
            }
        }
    }
</script>

<style scoped>

</style>
