<template>
    <div class="content-body">
        <!--<b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Nominee Information</b-card-header>
            <b-card-body class="border">
                <Datatable :items="items" :perPage="perPage" :fields="fields" :totalList="totalList"></Datatable>
            </b-card-body>
        </b-card>-->
        <b-tabs>
            <b-tab title="PENSION" active><pension-nominee :id="id"></pension-nominee></b-tab>
            <b-tab title="BNF"><bnf-nominee :id="id"></bnf-nominee></b-tab>
            <b-tab title="GPF"><gpf-nominee :id="id"></gpf-nominee></b-tab>
        </b-tabs>
    </div>
</template>

<script>
    import ApiRepository from "../../../Repository/ApiRepository";
    import Datatable from "../../../layouts/common/datatable"
    import moment from "moment";
    import BNFNominee from "../../components/BNFNominee";
    import GPFNominee from "../../components/GPFNominee";
    import PensionNominee from "../../components/PensionNominee";
    import SideBar from "../../../components/pmis/partials/sidebar";

    export default {
        name: "Nominee",
        components: {'bnf-nominee':BNFNominee,'gpf-nominee':GPFNominee, 'pension-nominee':PensionNominee, SideBar, Datatable},
        data() {
            return {
                fields: [
                    {key: 'index', label: 'Sl.', sortable: true},
                    {key: 'nominee_name', label: 'Name', orderDate: true},
                    {key: 'relation_type_name', label: 'Relation', orderDate: true},
                    {key: 'nominee_email', label: 'Email', sortable: true},
                    {key: 'nominee_contact_no', label: 'Contact No.', sortable: true},
                    {key: 'nominee_for_name', label: 'Nominee For', sortable: true},
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
                /*ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/api/nominee`).then(result => {
                    this.items = result.data.data.nominee
                    this.totalList = this.items.length
                });*/
            }
        },
        computed:{
            id:function () {
                return this.$store.getters.user.emp_id
            }
        }
    }
</script>

<style scoped>

</style>
