
<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked" style="padding-top:0px">
                <b-card-title>
                    <b-form-checkbox vertical v-model="hidenseek" name="check-button" switch size="lg"></b-form-checkbox>
                </b-card-title>
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0" :class="{'d-none':!hidenseek}">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0" :class="{'col-md-12':!hidenseek}">
                        <b-card title="Promotion">
                            <b-card-body class="border">
                                <Datatable v-bind:fields="fields"  v-bind:items="items" :totalList="totalList" :perPage="perPage"></Datatable>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker';
    import SideBar from "../partials/sidebar";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        components: { DatePicker, SideBar,Datatable},
        props: ['id'],
        data() {
            return {
                hidenseek: true,
                fields: [
                    {key: 'index', label:'Sl', sortable: true},
                    {key: 'order_no',label:'Order No', sortable: true},
                    {key: 'order_date',label:'Order Date', sortable: true},
                    {key: 'promoted_to',label:'Promoted To', sortable: true},
                    {key: 'last_designation',label:'Last Designation', sortable: true}
                ],
                items: [],
                totalList: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Promotion"});
            this.loadData();
        },
        methods: {
            hasEmpId: function() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            loadData: function() {
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/promotions/specific/${this.id}`).then(res => {
                        this.items = res.data;
                        this.totalList = res.data.data.length;
                    });
                }
            },
        }
    }
</script>

