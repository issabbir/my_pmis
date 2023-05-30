<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">In Tour Search </b-card-header>
                <b-card-body class="border">
                    <b-form>
                        <b-row>
                            <b-col md="6">
                                <b-form-group label="Employee Code" label-for="emp_code" label-cols-md="4" class="requiredField">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchEmpCode"

                                        id="emp_code">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-button type="submit" id="basic_sub_btn" @click="searchTour" class="btn btn-dark shadow mr-1 mb-1">Search</b-button>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pending In Tour For Approval</b-card-header>
                <b-card-body class="border">
                    <b-form
                        @submit.prevent="showConfirmBox"
                        class="form form-vertical col-md-12 ">
                        <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :perPage="perPage" :totalList="totalList">
                            <template v-slot:actions="{ rows }">
                                <a  @click="rows.item.approved_yn=(rows.item.approved_yn == 'Y')?'N':'Y'">
                                    <i v-if="rows.item.approved_yn == 'Y'" title="Keep process"  class='text-success bx bxs-checkbox-checked' ></i>
                                    <i class='bx bxs-checkbox text-danger' title="Hold" v-else ></i>
                                </a>
                            </template>
                        </Datatable>
                        <b-row class="mt-4">
                            <b-col class="d-flex justify-content-end">
                                <b-button-group>
                                    <b-button type="submit" variant="primary">Approve</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Datatable from "../../layouts/common/datatable"
    import ApiRepository from '../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';

    export default {
        name: "nominee-approval",
        components: {DatePicker, Datatable, vSelect, vcss},
        data(){
            return{
                tourSearch: { emp_id:null},
                perPage: 15,
                totalList: 1,
                selectedEmployee: [],
                empIdList: [],
                departmentList: [],
                disabled: false,
                datetime: new Date(),
                departmentOptions: [],
                searchParam: '',
                submitBtn: 'Save',
                formData: {
                    emp_id: "",
                    emp_code: "",
                    emp_name: "",
                    department_id: null,
                    charge_type: ""
                },
                show: true,
                tableData: {
                    fields: [
                        {key: 'index', label: 'Sl', sortable: true},
                        // {key: 'nominee_name', label: 'Nominee Name', sortable: true},
                        // {
                        //     key: 'nominee_for_id',
                        //     label: 'Nominee For',
                        //     sortable: true,
                        //     formatter: value => {
                        //         if(value == 1) {
                        //             return 'GPF'
                        //         } else if(value == 2){
                        //             return 'Pension'
                        //         } else {
                        //             return 'BNF'
                        //         }
                        //     },
                        // },
                        {key: 'emp_code', label: 'Employee Code', sortable: true},
                        {key: 'emp_name', label: 'Employee Name', sortable: true},
                        {key: 'tour_type', label: 'Tour Type', sortable: true},
                        {key: 'country', label: 'Country Name', sortable: true},
                        {key: 'tour_name', label: 'Tour Name', sortable: true},
                        {key: 'tour_purpose', label: 'Tour Purpouse', sortable: true},
                        {key:'insert_date', formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable:true, class:'text-right'},
                        {key:'return_date',formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, label:'Return Date', sortable:true, class:'text-right'},
                        {key: 'tour_duration', label: 'Tour Duration', sortable: true},

                        // {key:'charge_end_date',formatter: value => {
                        //         if(value) {
                        //             return moment(value).format('DD-MM-YYYY');
                        //         }
                        //     }, label:'End Date', sortable:true, class:'text-right'},
                        {key: 'last_updated_by', label: 'Last Updated By', sortable: true, class:'text-center'},
                        // {key: 'nominee_contact_no', label: 'Nominee Contact NO', sortable: true},
                        // {
                        //     key: 'autistic_yn',
                        //     label: 'Autistic',
                        //     formatter: value => {
                        //         if(value == 'Y') {
                        //             return 'Yes'
                        //         } else if(value == 'N'){
                        //             return 'No'
                        //         } else {
                        //             return ''
                        //         }
                        //     },
                        //     class: 'text-center',
                        //     sortable: true
                        // },
                        {key: 'action', class: 'text-center'}
                    ],
                    items: []
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Approval"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Approval Nominees"});
            this.loadData()
        },
        computed:{

        },
        watch:{
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.tourSearch.emp_id = val.emp_id;
                    this.tourSearch.emp_code = val.emp_code;
                    this.tourSearch.emp_name = val.emp_name;
                    this.tourSearch.department_id = val.dpt_department_id;
                }
            }
        },
        methods: {
            searchTour() {
                let empId = this.tourSearch.emp_id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/unapproved-tour-list?emp_id=`+empId).then(res => {
                    this.tableData.items = res.data
                    this.totalList = res.data.length
                })
            },

            changeStatus(item) {

                let status = item.hold_yn=='Y' ? 'N' : 'Y'
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/nominees/update-nominee-hold-yn/'+item.nominee_id+'/'+status, items).then(res => {
                    if (res.data.status) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                        this.loadNominee();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
                });
            },
            setEmployee: function (item) {
                this.selectedEmployee = {
                    emp_id: item.emp_id,
                    option_name: item.emp_code + ' ' + item.emp_name,
                    designation: item.designation,
                    department_name: item.department_name,
                    basic_amt: item.basic_from,
                    emp_code: item.emp_code,
                    emp_name: item.emp_name,
                    department_id: item.department_id,
                    dpt_department_id:item.dpt_department_id,
                    designation_id: item.designation_id,
                }
            },
            renderModal(item) {
                this.setEmployee(item)
                this.tour.tour_id = item.tour_id;
                this.tour.approve_note = item.approve_note;
            },
            onProcess() {
                let obj = {};
                obj.items = this.tableData.items.filter( i => {
                    return i.approved_yn == 'Y';
                });
                console.log('asd')
                let empId = this.tourSearch.emp_id;
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/pmis/approve-tour?emp_id=`+empId, obj).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.loadData();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                        // console.log(res.data);
                    })
                }
            },
            onReset() {
                this.selectedEmployee = {emp_id:null};
                this.tour={};
                this.submitBtn = 'Save';
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`;
                this.infoModal.content = JSON.stringify(item, null, 2);
                this.$root.$emit("bv::show::modal", this.infoModal.id, button);
            },
            resetInfoModal() {
                this.infoModal.title = "";
                this.infoModal.content = "";
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            },
            loadData() {
                let empId = '';
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/unapproved-tour-list?emp_id=`+empId).then(res => {
                    this.tableData.items = res.data
                    this.totalList = res.data.length
                })
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            showConfirmBox() {

                this.$bvModal.msgBoxConfirm('Please confirm that you want to approve the Charges.', {
                    title: 'Please Confirm',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                }).then(value => {
                    if(value == true){
                        this.onProcess()
                    }
                })
                    .catch(err => {
                    })
            }
        }
    }
</script>

<style scoped>
    .bx{
        font-size: 2.2rem;
    }
</style>
