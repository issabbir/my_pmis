<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Department And Designation Setup</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col sm="3">
                                <b-form-group label="DEPARTMENT" label-for="department" class="requiredField">
                                    <b-form-select
                                        id="department"
                                        v-model="formData.department_id"
                                        :options="departmentOptions"
                                        text-field="department_name"
                                        value-field="department_id"
                                        required
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="DESIGNATION" label-for="designation" class="requiredField">
                                    <b-form-select
                                        id="designation"
                                        v-model="formData.designation_id"
                                        :options="designationOptions"
                                        text-field="designation"
                                        value-field="designation_id"
                                        required
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="SANCTIONED POST" label-for="sanctioned_post" class="requiredField">
                                    <b-form-input id="sanctioned_post" v-model="formData.sanctioned_post" required placeholder="Sanctioned Post"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="Execution Type" label-for="execution_type" class="requiredField">
                                    <b-form-radio-group
                                        id="execution_type"
                                        v-model="formData.execution_mode"
                                        :options="executionTypeOptions"
                                        name="radio-options"
                                    ></b-form-radio-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button-group>
                                    <b-button-group>
                                        <b-button type="submit" variant="primary">{{submitBtn}}</b-button>
                                        <b-button type="reset" variant="secondary">Reset</b-button>
                                    </b-button-group>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Department And Designation Setup List </b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary" @click="editRow(rows.item)"><i class="bx bx-edit cursor-pointer"></i></b-link>
                        </template>
                    </Datatable>
                    <b>SANCTIONED POST : {{totalSanction}}</b>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    import vcss from 'vue-select/dist/vue-select.css';
    import vSelect from 'vue-select';

    export default {
        components: {Datatable, ApiRepository, vSelect, vcss},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Employee Position"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Department And Designation" });
            this.preLoadData();
            this.tableDataList();
        },
        data() {
            return {
                formData:{
                    /*department_id: '',
                    designation_id: '',
                    execution_mode: '',*/
                },

                departmentOptions:[],
                designationOptions:[],
                executionTypeOptions:[
                    { text: 'New', value: 'N' },
                    { text: 'Modification', value: 'M' }
                    ],
                submitBtn: 'Save',
                totalSanction:0,
                totalList:0,
                perPage:5,
                tableData: {
                    fields: [
                        {key:'index', label:'SL'},
                        {key:'department_name', label:'Department', sortable:true},
                        {key:'designation', label:'Designation', sortable:true},
                        {key:'sanctioned_post', label:'Sanctioned Post', sortable:true},
                        {key:'class', label:'class',  sortable:true},
                        {key:'emp_type', label:'Employee Type',  sortable:true},
                        {key:'grade', label:'Grade ID',  sortable:true},
                        'action'
                    ],
                    items:[]
                },
            }
        },
        methods: {

            onSubmit: function () {
                let data = this.formData;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/admin/employee-position/dpt-designation-mapping`, data).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.tableDataList();
                        this.onReset();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset(evt) {
                this.formData = {};
                this.submitBtn = 'Save';
                this.$nextTick(() => {
                    this.show = true;
                });
            },

            editRow(item) {
                this.submitBtn = 'Update';
                this.formData=item;
            },

            preLoadData(){

                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    this.departmentOptions = res.data.departments;
                    this.designationOptions= res.data.designations;
                });
            },

            tableDataList(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/employee-position/dpt-designation-mapping-data`).then(res => {
                    this.tableData.items = res.data.deptDesingations;
                    this.totalList=res.data.deptDesingations.length;
                    // this.totalSanction = res.data.deptDesingations.reduce((partialSum, a) => parseInt(partialSum) + parseInt(a.sanctioned_post), 0)
                    this.totalSanction = parseInt(res.data.sanctionedPost);
                    console.log(this.tableData.items );
                });
            }
        }
    }
</script>

