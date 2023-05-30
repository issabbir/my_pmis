<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pension Application List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="columns" :totalList="totalItems" perPage="5" v-bind:items="listItems"
                               v-bind:pageColSize="4" v-bind:searchColSize="5" :primaryKeyColumnName="'emp_code'">
                        <template v-slot:action4="{ rows }">
                            <b-button size="sm" variant="primary" v-b-modal.modal-center @click="renderModal(rows.item)">
                                <i class="bx bx-link cursor-pointer"></i>
                            </b-button>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <div>
                <b-modal
                    id="modal-center"
                    scrollable
                    size="xl"
                    body-bg="light"
                    :title="'Pension Clearance Status '+this.clearanceEmp"
                    ok-only
                    hide-footer
                >
                    <b-table
                        :items="pensionItems"
                        :fields="pensionfields"
                        sort-icon-left
                        responsive="md"
                        :small="small"
                        hover
                        head-variant="dark"
                    >
                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                    </b-table>

                    
                </b-modal>
            </div>

        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../Repository/ApiRepository";
    import moment from "moment";
    import DatePicker from "vue2-datepicker";
    import Datatable from "../../layouts/common/datatable";
    import vSelect from "vue-select";
    import vcss from "vue-select/dist/vue-select.css";
    import BFormDatepicker from "bootstrap-vue";

    export default {
        name: "AllPensionApplication",
        components: {DatePicker, Datatable, vSelect, vcss, BFormDatepicker},
        data() {
            return {
                small: true,
                columns: [
                    {label: 'SL', key: 'index', sortable: false},
                    {label: 'Employee Code', key: 'emp_code', sortable: true},
                    {label: 'Name', key: 'emp_name', sortable: true},
                    {label: 'Designation', key: 'designation', sortable: true},
                    {label: 'Department', key: 'department_name', sortable: true},
                    {label: 'Application Date', key: 'apps_date', sortable: true},
                    {label: 'Pension Status', key: 'pension_status', sortable: true},
                    {key: 'action4', label: 'Action'}
                ],
                nomineeFields: [
                    {key:'index', label:'SL', sortable:true},
                    {key:'nominee_name', label: 'Nominee Name', sortable:true},
                    {key:'relationship', label: 'Relationship', sortable:true},
                    {key:'percentage', label: 'Percentage', sortable:true},
                ],
                modalData:{
                    comment: null,
                    last_basic: null
                },
                totalItems: 0,
                totalNominee:0,
                nomineeItems:[],
                formData: {
                    department_id: ''
                },
                listItems: [],
                pensionItems: [],
                totalPension: 0,
                clearanceEmp: '',
                pensionfields: [
                    {label: 'SL', key: 'index', sortable: false},
                    {label: 'Clearance Department', key: 'department_name', sortable: true, },
                    {label: 'Clearance Section', key: 'dpt_section', sortable: true, },
                    {key: 'clearance_date', label: 'Date',formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }, sortable: true, sortDirection: 'desc', class: 'text-center',variant: 'danger' },
                    {label: 'Personal Debt Amount', key: 'personal_debt', sortable: true, class: 'text-right',variant: 'success'},
                    {label: 'Personal Debt Remarks', key: 'personal_debt_remarks', sortable: true, variant: 'warning'},
                    {label: 'Institutional Debt Amount', key: 'institutional_debt', sortable: true, class: 'text-right',variant: 'success'},
                    {label: 'Institutional Debt Remarks', key: 'institutional_debt_remarks', sortable: true, variant: 'warning'},
                    {label: 'Status', key: 'status', sortable: true, class: 'text-center' ,variant: 'default'},
                    {label: 'Clearance By', key: 'clearance_by_name', class: 'text-center', sortable: true,variant: 'primary'}


                ]
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension Application Status"});
            this.loadTable();
            this.preLoadData();
            this.onSearch();
        },
        methods: {
            loadTable() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/applications').then(res => {
                    this.listItems = res.data;
                    this.totalItems = res.data.length;
                });
            },
            preLoadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    this.departmentOptions = res.data.departments;
                });
            },
            onSearch() {
                let data=this.formData;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/search-pension-calculated-data`, data).then(res => {
                    this.tableData.items = res.data;
                    this.totalList=res.data.length;
                });
            },
            renderModal(item) {
                let id = item.emp_id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/get-pension-clearance-status/${id}`).then(res => {
                    this.pensionItems = res.data;
                    console.log(this.pensionItems)
                    this.clearanceEmp=res.data[0].emp_name;
                    this.totalPension = res.data.length;

                });
            },
            editRow(item) {
                this.message='Pension Calculation Information For';
                this.modalData = item;
                this.readonly=false;
                this.disabledRadio=false;
                this.UpdateBtnHidden=false;
                this.ProcessBtnHidden=true;
                this.loadNominee(this.modalData.emp_id);
            },
            loadNominee: function(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/applications/nominee/${id}`).then(res => {
                    this.nomineeItems = res.data;
                    this.totalNominee=res.data.length;
                    console.log(res.data);
                });
            },
        }
    }
</script>

<style scoped>

</style>
