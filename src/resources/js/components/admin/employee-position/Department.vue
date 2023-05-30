<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Administrative Department Setup</h4>
                        </div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                                    <!--<fieldset class="border p-2">-->
                                        <!--<legend class="w-auto"> Administrative Department Setup</legend>-->
                                        <b-row>
                                            <b-col>
                                                <b-row>
                                                    <b-col md="3">
                                                        <b-form-group label="Department Name" label-for="Department_Name" class="requiredField">
                                                            <b-form-input
                                                                v-model="employeeDepartment.department_name"
                                                                required
                                                                id="departmentName"
                                                                type="text"
                                                                placeholder="Department Name"
                                                            ></b-form-input>
                                                        </b-form-group>

                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="Department Name Bangla" label-for="Department_Name_Bangla" class="">
                                                            <b-form-input
                                                                v-model="employeeDepartment.department_name_bng"
                                                                id="departmentName"
                                                                type="text"
                                                                placeholder="Department Name Bangla"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
<!--                                                    <b-col lg="6">-->
<!--                                                        <b-row>-->
<!--                                                            <b-col lg="4">-->
<!--                                                                <label>Financial Code</label>-->
<!--                                                            </b-col>-->
<!--                                                            <b-col lg="8" class="form-group">-->
<!--                                                                <b-form-input  v-model="employeeDepartment.fin_code" required id="fin_code" type="text" placeholder="Financial Code"></b-form-input>-->
<!--                                                            </b-col>-->
<!--                                                        </b-row>-->
<!--                                                    </b-col>-->
                                                    <b-col md="3">
                                                        <b-form-group label="Division" label-for="division" class="requiredField">
                                                            <b-form-select
                                                                v-model="employeeDepartment.dpt_division_id"
                                                                required
                                                                :options="division_options"
                                                            ></b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                    <b-form-group label="Shift" label-for="shift" class="requiredField">
                                                        <b-form-radio-group
                                                            id="radio-group-1"
                                                            v-model="employeeDepartment.shift_yn"
                                                            :options="shift_yn_options"
                                                            name="radio-options"
                                                        ></b-form-radio-group>
                                                    </b-form-group>

                                                </b-col>
                                                </b-row>
                                            </b-col>
                                        </b-row>

                                        <b-row>
                                            <b-col class="mt-2 d-flex justify-content-end">
                                                <b-button lg="6" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                                <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                            </b-col>
                                        </b-row>
                                    <!--</fieldset>-->
                                </b-form>
                            </div>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <!-- Zero configuration table -->
            <section id="basic-datatable">
                <b-row>
                    <b-col>
                        <b-card class="card">
                            <div class="card-content">
                                <b-card-text class="card-body">
                                        <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">
                                            <template v-slot:actions="{ rows }">
                                                <b-link ml="4" class="text-primary"
                                                        @click="editRow(rows.item)">
                                                    <i class="bx bx-edit cursor-pointer"></i>
                                                </b-link>
<!--                                                <b-link class="text-danger" @click="deleteRow(rows.item.department_id)">-->
<!--                                                    <i class="bx bx-trash cursor-pointer"></i>-->
<!--                                                </b-link>-->
                                            </template>
                                        </Datatable>
                                </b-card-text>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>
            </section>
            <!--/ Zero configuration table -->
        </div>


    </div>
</template>

<script>
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        components: {
            Datatable
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Employee Position"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Department" });
            this.allDepartments();
        },
        data() {
            return {
                employeeDepartment: {
                    fin_code:null,
                    shift_yn:'Y',
                    dpt_division_id:null,
                },
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                totalList:0,
                perPage:5,
                tableData: {
                    fields: [
                        {key: 'index', label: 'SL', class: 'text-center'},
                        // {key:'dpt_division_id', label:'Division ID', sortable:true},
                        {key:'dpt_division_name', label:'DivisionnvName', sortable:true},
                        {key:'department_name',  label:'Department Name', sortable:true},
                        {key:'department_name_bng', label:'Department Name Bangla', sortable:true},
                        {/*key:'fin_code',label:'Financial Code',  sortable:true*/}, 'action'
                    ],
                    items:[]
                },
                financial_code_options: [],
                shift_yn_options: [
                    { value: 'Y', text: 'Yes' },
                    { value: 'N', text: 'No' },
                ],
                division_options:[
                     // { value: '1', text: 'Chairman' },
                     // { value: '2', text: 'Member (Finance)' },
                ]

            }
        },
        methods: {
             allDepartments(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/employee-position/departments').then(result => {
                    //console.log(result.data);
                    //this.division_options = result.data.division;
                    this.tableData.items = result.data;
                    this.totalList = result.data.length;
                });
                 ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/basic-infos').then(result => {

                     this.division_options= result.data.dptDivision;
                 })
            },

            onSubmit(evt) {
                evt.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND,'/admin/employee-position/departments',this.employeeDepartment).then(res => {
                    if (res.data.o_status_code == 1) {
                        //alert({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});

                        this.allDepartments();
                        this.onReset();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                })

            },
            onReset(evt) {
                this.employeeDepartment = {
                    fin_code:null,
                    shift_no:null,
                    division_id:null,
                };
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(i) {
                // console.log(id);
                let item = Object.assign({}, i);
                this.employeeDepartment = item;
                this.submitBtn = 'Update';
            },
            deleteRow(id) {
                 if(confirm("Do you really want to delete?")){
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/employee-position/departments/${id}`).then(result=>{
                        this.allDepartments();
                   });
                 }

            }

        }
    }
</script>

<style>
    .message label:after{
        content:" (File should not exceed 2MB)";
        color:red
    }
</style>
