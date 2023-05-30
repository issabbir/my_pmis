<template>
    <div class="content-body">
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Leave Summary</b-card-header>
            <b-card-body class="border">
                <Datatable :items="items" :perPage="perPage" :fields="fields" :totalList="totalList"></Datatable>
            </b-card-body>
        </b-card>

        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Leave Enjoy</b-card-header>
            <b-card-body class="border">
                <Datatable :items="enjoyItems" :perPage="perPage" :fields="enjoyFields" :totalList="enjoyTotalList"></Datatable>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import Datatable from "../../../layouts/common/datatable"
    import ApiRepository from "../../../Repository/ApiRepository"
    import moment from "moment";
    export default {
        name: "Leave",
        components: {Datatable},
        data() {
            return {
                fields: [
                    {key: 'leave_days', label: 'Leave Days', orderDate: true},
                    {key: 'leave_enjoy', label: 'Leave Enjoy', orderDate: true},
                    {key: 'leave_remaining', label: 'Leave Remaining', sortable: true}
                ],
                enjoyFields: [
                    {key: 'index', label: 'Sl.', sortable: true},
                    {
                        key: 'application_date',
                        label: 'Application Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        orderDate: true},
                    {
                        key: 'approve_date',
                        label: 'Approve Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        orderDate: true
                    },
                    {key: 'leave_type', label: 'Leave Type', sortable: true},
                    {
                        key: 'leave_start_date',
                        label: 'Start Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true
                    },
                    {
                        key: 'leave_end_date',
                        label: 'End Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true
                    },
                    {key: 'leave_days', label: 'Leave Days', sortable: true}
                ],
                items: [],
                enjoyItems: [],
                perPage: 5,
                totalList: 1,
                enjoyTotalList: 1
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty")
            this.$store.commit("setBreadcrumb", {link: "dashboard", label: "Dashboard"})
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account", label: "My Account"})
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account/leave", label: "My Leave"})
            this.loadLeave()
        },
        methods: {
            loadLeave() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/api/leave`).then(result => {
                    this.items = result.data.data.leave
                    this.totalList = this.items.length

                    this.enjoyItems = result.data.data.leave_enjoy
                    this.enjoyTotalList = this.enjoyItems.length
                });
            }
        }
    }
</script>

<style scoped>

</style>
