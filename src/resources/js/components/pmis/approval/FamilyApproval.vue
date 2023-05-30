<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Family Search </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="loadFamilies">
                        <b-row>
                            <b-col md="6">
                                <b-form-group label="Employee Code" label-for="emp_code" label-cols-md="4" class="requiredField">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchEmpCode"
                                        id="emp_code">
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Search</b-button>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pending Family For Approval</b-card-header>
                <b-card-body class="border">
                    <b-form
                        @submit.prevent="showConfirmBox"
                        class="form form-vertical col-md-12 ">
                        <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :perPage="perPage" :totalList="totalList">
                            <template v-slot:actions="{ rows }">
                                <div class="d-flex justify-content-center">
                                    <a style="margin-top:6%" @click="show_family_details(rows.item)"><i class="text-primary fas fa-eye"></i></a>
                                    <a  @click="changeStatus(rows.item)">
                                        <i v-if="rows.item.hold_yn == 'N'" title="Keep process"  class='text-success bx bxs-checkbox-checked' ></i>
                                        <i class='bx bxs-checkbox text-danger' title="Hold" v-else ></i>
                                    </a>
                                </div>

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
        <b-modal ref="detail_modal" size="xl" hide-footer title="Family Member Details">
            <b-row>
                <b-col md="9">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                              label="Employee"
                              label-for="employee"
                            >
                                <b-form-input id="employee" readonly :value="detailFormData.emp_code+' - '+detailFormData.emp_name"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                              label="Member Name"
                              label-for="emp_member_name"
                            >
                                <b-form-input id="emp_member_name" readonly v-model="detailFormData.emp_member_name"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                              label="Relation"
                              label-for="relation_type"
                            >
                                <b-form-input id="relation_type" readonly v-model="detailFormData.relation_type"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                              label="Marital Status"
                              label-for="maritial_status"
                            >
                                <b-form-input id="maritial_status" readonly v-model="detailFormData.maritial_status"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <!--                <b-col md="6">-->
                        <!--                    <b-form-group-->
                        <!--                        label="Address Line (1)"-->
                        <!--                        label-for="address_line_1"-->
                        <!--                    >-->
                        <!--                        <b-form-input id="address_line_1" readonly v-model="detailFormData.address_line_1"></b-form-input>-->
                        <!--                    </b-form-group>-->
                        <!--                </b-col>-->
                        <!--                <b-col md="6">-->
                        <!--                    <b-form-group-->
                        <!--                        label="Address Line (2)"-->
                        <!--                        label-for="address_line_2"-->
                        <!--                    >-->
                        <!--                        <b-form-input id="address_line_2" readonly v-model="detailFormData.address_line_2"></b-form-input>-->
                        <!--                    </b-form-group>-->
                        <!--                </b-col>-->
                        <b-col md="4">
                            <b-form-group
                              label="Mobile Number"
                              label-for="emp_member_mobile"
                            >
                                <b-form-input id="emp_member_mobile" readonly v-model="detailFormData.emp_member_mobile"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                              label="Identity Document Name"
                              label-for="auth_doc_type_name"
                            >
                                <b-form-input id="auth_doc_type_name" readonly v-model="detailFormData.auth_doc_type_name"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                              label="Identity Document Number"
                              label-for="auth_id"
                            >
                                <b-form-input id="auth_id" readonly v-model="detailFormData.auth_id"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                              label="Education Allowance"
                              label-for="emp_member_allowance"
                            >
                                <b-form-input id="emp_member_allowance" readonly v-model="detailFormData.emp_member_allowance"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                              label="Medical ID"
                              label-for="emp_member_medical_id"
                            >
                                <b-form-input id="emp_member_medical_id" readonly v-model="detailFormData.emp_member_medical_id"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <!--                <b-col md="3">-->
                        <!--                    <b-form-group-->
                        <!--                        label="Member Status"-->
                        <!--                        label-for="family_member_status"-->
                        <!--                    >-->
                        <!--                        <b-form-input id="family_member_status" readonly v-model="detailFormData.family_member_status"></b-form-input>-->
                        <!--                    </b-form-group>-->
                        <!--                </b-col>-->
                        <!--                <b-col md="3">-->
                        <!--                    <b-form-group-->
                        <!--                        label="District"-->
                        <!--                        label-for="geo_district_name"-->
                        <!--                    >-->
                        <!--                        <b-form-input id="geo_district_name" readonly v-model="detailFormData.geo_district_name"></b-form-input>-->
                        <!--                    </b-form-group>-->
                        <!--                </b-col>-->
                        <!--                <b-col md="3">-->
                        <!--                    <b-form-group-->
                        <!--                        label="Thana"-->
                        <!--                        label-for="geo_thana_name"-->
                        <!--                    >-->
                        <!--                        <b-form-input id="geo_thana_name" readonly v-model="detailFormData.geo_thana_name"></b-form-input>-->
                        <!--                    </b-form-group>-->
                        <!--                </b-col>-->
                        <!--                <b-col md="3">-->
                        <!--                    <b-form-group-->
                        <!--                        label="Post Code"-->
                        <!--                        label-for="post_code"-->
                        <!--                    >-->
                        <!--                        <b-form-input id="post_code" readonly v-model="detailFormData.post_code"></b-form-input>-->
                        <!--                    </b-form-group>-->
                        <!--                </b-col>-->
                        <b-col md="4">
                            <b-form-group
                              label="Birth Date"
                              label-for="nominee_dob"
                            >
                                <b-form-input id="nominee_dob" readonly :value="detailFormData.emp_member_dob|dateFormat2"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                              label="Gender"
                              label-for="gender_name"
                            >
                                <b-form-input id="gender_name" readonly :value="detailFormData.gender_name"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <a class="text-primary" v-if="detailFormData.auth_attachment" size="sm" @click="showAttachment(detailFormData.auth_attachment)"><i
                              class="mt-1 bx bx-download cursor-pointer"></i> Download Document </a>
                        </b-col>

                    </b-row>
                </b-col>
                <b-col md="3"  class="text-center profileImage">
                    <b-card class="m-0" style="border: 1px solid #eff1f2;">
                        <b-card-text >
                            <img id="profilepic" :src="detailFormData.photo ? detailFormData.photo : '/images/avatar.png'"  class="img-fluid" alt="...">
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <b-row>
                <b-col class="d-flex justify-content-end">
                    <b-button-group>
                        <b-button type="button" @click="singleApprove(detailFormData)" variant="primary">Approve</b-button>
                    </b-button-group>
                </b-col>
            </b-row>
        </b-modal>
    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Datatable from "../../../layouts/common/datatable"
    import ApiRepository from '../../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    export default {
        name: "FamilyApproval",
        components: {DatePicker, Datatable, vSelect, vcss},
        data(){
            return{
                detailFormData: {
                    address_line_1: "",
                    address_line_2: null,
                    approved_yn: "",
                    auth_attach_file_name: null,
                    auth_attach_file_type: null,
                    auth_attachment: '',
                    auth_doc_type_id: "",
                    auth_doc_type_name: "",
                    auth_id: "",
                    district_id: "",
                    emp_code: "",
                    emp_family_id: "",
                    emp_id: "",
                    emp_member_allowance: null,
                    emp_member_allowance_yn: null,
                    emp_member_dob: "",
                    emp_member_medical_id: "",
                    emp_member_mobile: null,
                    emp_member_name: "",
                    emp_member_name_bng: null,
                    emp_name: "",
                    family_member_status: null,
                    family_member_status_id: null,
                    gender_id: "",
                    gender_name: "",
                    geo_district_name: "",
                    geo_thana_name: "",
                    hold_yn: "",
                    insert_by: null,
                    insert_date: null,
                    is_nominee_yn: "",
                    marital_status_id: "",
                    maritial_status: "",
                    percentage: "",
                    photo: "",
                    photo_file_name: null,
                    photo_file_type: "",
                    post_code: null,
                    relation_type: "",
                    relation_type_id: "",
                    thana_id: "",
                    update_by: "",
                    update_date: ""
                },
                perPage: 15,
                totalList: 1,
                selectedEmployee: {emp_id: ''},
                empIdList: [],
                formData: {
                    emp_id: ""
                },
                tableData: {
                    fields: [
                        {key: 'index', label: 'Sl', sortable: true},
                        {key: 'emp_code', label: 'Employee Code', sortable: true},
                        {key: 'emp_name', label: 'Employee Name', sortable: true},
                        {key: 'emp_member_name', label: 'Member Name', sortable: true},
                        {key: 'relation_type', label: 'Relation Type', sortable: true},
                        {key: 'last_updated_by', label: 'Last Updated By', sortable: true},
                        {key: 'action', class: 'text-center'}],
                    items: []
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Operations"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Operations Process"});
            this.loadFamilies()
        },
        watch:{
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.formData.emp_id = val.emp_id
                }
            }
        },
        methods: {
            show_family_details(item){
                this.detailFormData = {
                    address_line_1: item.address_line_1,
                    address_line_2: item.address_line_2,
                    approved_yn: item.approved_yn,
                    auth_attach_file_name: item.auth_attach_file_name,
                    auth_attach_file_type: item.auth_attach_file_type,
                    auth_attachment: '',
                    auth_doc_type_id: item.auth_doc_type_id,
                    auth_doc_type_name: item.auth_doc_type_name,
                    auth_id: item.auth_id,
                    district_id: item.district_id,
                    emp_code: item.emp_code,
                    emp_family_id: item.emp_family_id,
                    emp_id: item.emp_id,
                    emp_member_allowance: item.emp_member_allowance,
                    emp_member_allowance_yn: item.emp_member_allowance_yn,
                    emp_member_dob: item.emp_member_dob,
                    emp_member_medical_id: item.emp_member_medical_id,
                    emp_member_mobile: item.emp_member_mobile,
                    emp_member_name: item.emp_member_name,
                    emp_member_name_bng: item.emp_member_name_bng,
                    emp_name: item.emp_name,
                    family_member_status: item.family_member_status,
                    family_member_status_id: item.family_member_status_id,
                    gender_id: item.gender_id,
                    gender_name: item.gender_name,
                    geo_district_name: item.geo_district_name,
                    geo_thana_name: item.geo_thana_name,
                    hold_yn: item.hold_yn,
                    insert_by: item.insert_by,
                    insert_date: item.insert_date,
                    is_nominee_yn: item.is_nominee_yn,
                    marital_status_id: item.marital_status_id,
                    maritial_status: item.maritial_status,
                    percentage: item.percentage,
                    photo: "",
                    photo_file_name: item.photo_file_name,
                    photo_file_type: item.photo_file_type,
                    post_code: item.post_code,
                    relation_type: item.relation_type,
                    relation_type_id: item.relation_type_id,
                    thana_id: item.thana_id,
                    update_by: item.update_by,
                    update_date: item.update_date
                }
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/family-files/${item.emp_family_id}`).then(res => {
                    this.detailFormData.photo = res.data.photo
                    this.detailFormData.auth_attachment = res.data.auth_attachment
                })

                this.$refs['detail_modal'].show()
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            changeStatus(item) {
                let status = item.hold_yn=='Y'?'N':'Y'
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/pmis/update-family-temp/'+item.emp_family_id+'/'+status).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.loadFamilies()
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
                });
            },
            onProcess() {
                let obj = {};
                obj.items = this.tableData.items.filter( i => {
                    return i.hold_yn == 'N';
                });
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/approve-family`, obj).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.loadFamilies();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            singleApprove(obj) {
                if (obj.emp_id){
                    this.changeStatus(obj);
                }
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/approve-family-single`, obj).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.loadFamilies();
                        this.$refs['detail_modal'].hide();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset() {
                this.selectedEmployee = {emp_id:''};
                this.$nextTick(() => {
                });
            },
            loadFamilies() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/unapproved-family-list`, this.formData).then(res => {
                    this.tableData.items = res.data
                    this.totalList = res.data.length
                })
            },

            showConfirmBox() {
                this.$bvModal.msgBoxConfirm('Please confirm that you want to approve the families.', {
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
                }).catch(err => {
                })
            },
            showAttachment(data) {
                const win = window.open("","_blank");
                let html = '';
                html += '<html>';
                html += '<body style="margin:0!important">';
                html += '<embed width="100%" height="100%" src="'+data+'"/>';
                html += '</body>';
                html += '</html>';
                setTimeout(() => {
                    win.document.write(html);
                }, 0);
            },
        },
        filters: {
            dateFormat2: function(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY')
                }
            }
        }
    }
</script>

<style scoped>
    .bx{
        font-size: 2.2rem;
    }
</style>
