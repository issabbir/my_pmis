<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row >
                <b-col >
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title"> Administrative Designation Setup</h4>
                        </div>
                        <div class="card-content">
                            <b-card-text class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                                    <b-row>
                                        <b-col lg="6">
                                            <b-form-group
                                                label="Designation Name"
                                                label-for="Designation_Name"
                                                class="requiredField">
                                                <b-form-input
                                                    v-model="employeeDesignation.p_designation"
                                                    required
                                                    placeholder="Designation Name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col lg="6">
                                            <div class="form-group">
                                                <label >Designation Name Bangla</label>
                                                <b-form-input v-model="employeeDesignation.p_designation_bng"   type="text" placeholder="Designation Name Bangla"></b-form-input>
                                            </div>
                                        </b-col>

                                    </b-row>

                                    <b-row>

                                        <b-col lg="3">
                                            <b-form-group
                                                label="Short Name"
                                                label-for="short_name"
                                            >
                                                <b-form-input
                                                    v-model="employeeDesignation.p_short_name"
                                                    type="text"
                                                    placeholder="Short name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <!--                                        <b-col lg="3">-->
                                        <!--                                            <b-form-group-->
                                        <!--                                                label="Post Type"-->
                                        <!--                                                label-for="post_type"-->
                                        <!--                                                class="requiredField">-->
                                        <!--                                                <b-form-select-->
                                        <!--                                                    v-model="employeeDesignation.p_post_type_id"-->
                                        <!--                                                    required-->
                                        <!--                                                    :options="post_options"-->
                                        <!--                                                ></b-form-select>-->
                                        <!--                                            </b-form-group>-->
                                        <!--                                        </b-col>-->
                                        <b-col lg="3">
                                            <b-form-group
                                                label="Employee Type"
                                                label-for="emp_type_name"
                                                class="requiredField">
                                                <b-form-select
                                                    v-model="employeeDesignation.p_emp_type_id"
                                                    required
                                                    :options="emp_options"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>

                                        <!--                                        <b-col lg="3">-->
                                        <!--&lt;!&ndash;                                            <div class="form-group">&ndash;&gt;-->
                                        <!--&lt;!&ndash;                                                <label>Min Grade</label>&ndash;&gt;-->
                                        <!--&lt;!&ndash;                                                <b-form-input v-model="employeeDesignation.p_min_grade_id" required  type="text" placeholder="Min Grade"></b-form-input>&ndash;&gt;-->
                                        <!--&lt;!&ndash;                                            </div>&ndash;&gt;-->
                                        <!--                                            <b-form-group label="Min Grade" label-for="grade_id" class="requiredField">-->
                                        <!--                                                <b-form-select-->
                                        <!--                                                    id="grade_id"-->
                                        <!--                                                    v-model="employeeDesignation.p_min_grade_id"-->
                                        <!--                                                    :options="gradeOptions"-->
                                        <!--                                                    required-->
                                        <!--                                                    type="text"-->
                                        <!--                                                    text-field="emp_grade_id"-->
                                        <!--                                                    placeholder="Min Grade"-->
                                        <!--                                                ></b-form-select>-->
                                        <!--                                            </b-form-group>-->
                                        <!--                                        </b-col>-->

                                        <b-col lg="3">

                                            <b-form-group label="Grade ID" label-for="grade_id" class="requiredField">
                                                <b-form-select
                                                    id="grade_id"
                                                    v-model="employeeDesignation.grade_id"
                                                    :options="gradeOptions"
                                                    required
                                                    type="text"
                                                    text-field="emp_grade_id"
                                                    placeholder="Garde ID"
                                                    @change="gradclassByid($this)"
                                                ></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col lg="3">

                                            <b-form-group
                                                label="Class"
                                                label-for="class"
                                                class="requiredField">
                                                <b-form-input
                                                    id="class"
                                                    v-model="employeeDesignation.class"
                                                    required
                                                    type="text"
                                                    text-field="class"
                                                    placeholder="class"
                                                    readonly
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
<!--                                       -->
                                        <!--                                        <b-col lg="3">-->
                                        <!--&lt;!&ndash;                                            <div class="form-group">&ndash;&gt;-->
                                        <!--&lt;!&ndash;               <b-col lg="3">-->

                                        <!--                                            <b-form-group label="Class Name" label-for="class" >-->
                                        <!--                                                <b-form-select-->
                                        <!--                                                    v-model="employeeDesignation.emp_class"-->
                                        <!--                                                    :options="classOptions"-->
                                        <!--                                                    text-field="emp_class"-->
                                        <!--                                                ></b-form-select>-->
                                        <!--                                            </b-form-group>-->
                                        <!--                                        </b-col>                                  <label>Max Grade</label>&ndash;&gt;-->
                                        <!--&lt;!&ndash;                                                <b-form-input v-model="employeeDesignation.p_max_grade_id" required  type="text" placeholder="Max Grade"></b-form-input>&ndash;&gt;-->
                                        <!--&lt;!&ndash;                                            </div>&ndash;&gt;-->
                                        <!--                                            <b-form-group label="Max Grade" label-for="grade_id" class="requiredField">-->
                                        <!--                                                <b-form-select-->
                                        <!--                                                    id="grade_id"-->
                                        <!--                                                    v-model="employeeDesignation.p_max_grade_id"-->
                                        <!--                                                    :options="gradeOptions"-->
                                        <!--                                                    required-->
                                        <!--                                                    type="text"-->
                                        <!--                                                    text-field="emp_grade_id"-->
                                        <!--                                                    placeholder="Max Grade"-->
                                        <!--                                                ></b-form-select>-->
                                        <!--                                            </b-form-group>-->
                                        <!--                                        </b-col>-->
                                        <!--                                        <b-col lg="3">-->
                                        <!--                                            <b-form-group label="Profession Type"-->
                                        <!--                                                          label-for="profession_type"-->
                                        <!--                                                          class="requiredField">-->
                                        <!--                                                <b-form-select-->
                                        <!--                                                    v-model="employeeDesignation.p_profession_type_id"-->
                                        <!--                                                    required-->
                                        <!--                                                    :options="profession_options"-->
                                        <!--                                                ></b-form-select>-->
                                        <!--                                            </b-form-group>-->
                                        <!--                                        </b-col>-->
                                        <b-col lg="3">
                                            <b-form-group>
                                                <label class="d-block">Type</label>
                                                <b-form-radio-group
                                                    id="p_ministerial_yn"
                                                    v-model="employeeDesignation.p_ministerial_yn"
                                                    :options="type_options"
                                                    name="p_ministerial_yn"
                                                ></b-form-radio-group>
                                            </b-form-group>
                                        </b-col>
                                        <b-col lg="3">
                                            <div class="form-group">
                                                <label >Active</label>
                                                <b-form-radio-group
                                                    id="radio-group-1"
                                                    v-model="employeeDesignation.p_enable_yn"
                                                    :options="active_option"
                                                    name="radio-options"
                                                ></b-form-radio-group>
                                            </div>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="mt-2 d-flex justify-content-end">
                                            <b-button lg="6" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                            <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </b-card-text>
                        </div>
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
                                                    @click="editRow(rows.item.designation_id)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                            <!-- <b-link class="text-danger" @click="deleteRow(rows.item.designation_id)">
                                                <i class="bx bx-trash cursor-pointer"></i>
                                            </b-link> -->
                                        </template>
                                    </Datatable>
                                    <div>Total Designation: {{totalList}}</div>
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
            this.$store.commit("setBreadcrumb", { link: "#", label: "Designation" });
            this.allDesignation();
        },
        data() {
            return {
                employeeDesignation: {
                    p_post_type_id:null,
                    p_profession_type_id:null,
                    p_emp_type_id:null,
                    p_min_grade_id:null,
                    p_max_grade_id:null,
                    p_ministerial_yn:'M',
                    p_enable_yn:'Y',
                    grade_id:null,
                    class: null,
                    emp_type_name: null
                },
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                totalList:0,
                perPage:10,
                // totalDesignation: 0,
                index:1,
                tableData: {
                    fields: [
                        {key: 'index', label: 'SL', class: 'text-center'},
                        // {key:'designation_id',label:'ID', sortable:true},
                        {key:'designation',label:'Designation', sortable:true},
                        // {key:'designation_bng', label:'Designation Bangla',sortable:true} ,
                        {key:'grade_id', label:'Grade ID',sortable:true} ,
                        {key:'class', label:'class',sortable:true},
                        {key:'enable_yn', label:'Status', sortable:true},
                        {key:'emp_type_name', label:'Employee Type',  sortable:true},
                        // {key: 'p_profession_type_id', lebel:'Profession', sortable: true},
                        {key: 'action', class: 'text-center'},

                    ],
                    // {key:'profession_type', label:'Profession', sortable:true},
                    //{key:'ministerial_yn', label:'Type', sortable:true}, {key:'short_name', label:'Short Name', sortable:true},
                    // {key:'enable_yn', label:'Status', sortable:true}, {key:'min_grade_id', label:'Min Grade', sortable:true},
                    // {key:'max_grade_id', label:'Max Grade', sortable:true}, 'Action'],
                    items: []
                },
                profession_options: [
                ],
                gradeOptions:[

                ],
                classOptions:[

                ],
                post_options: [
                ],
                type_options: [
                    { text: 'Ministerial', value: 'M' },
                    { text: 'Operational', value: 'O' }
                ],
                active_option: [
                    { text: 'Yes', value: 'Y' },
                    { text: 'No', value: 'N' }
                ],
            }
        },
        methods: {
            allDesignation(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/employee-position/designations').then(result => {
                    this.post_options = result.data.post;
                    this.profession_options = result.data.professionType;
                    this.emp_options = result.data.empType;
                    // this.classOptions = result.data.empClass;
                    this.tableData.items = result.data.table_info;
                    this.totalList = result.data.table_info.length;
                    // this.totalDesignation = result.data.table_info.length;
                    console.log('designation total:', this.totalList);


                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(result => {
                    console.log(result.data);
                    this.gradeOptions= result.data.grades;
                });
            },
            onSubmit(evt) {
                let currObj = this;
                evt.preventDefault();
                if(this.updateIndex > 0){
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND,`/admin/employee-position/designations/${this.updateIndex}`,this.employeeDesignation).then(result => {
                        if(result.data.o_status_code == 1) {
                            this.allDesignation();
                            this.onReset();
                            currObj.$notify({ group: 'admin', text: result.data.o_status_message, type:'success' });
                        }else {
                            currObj.$notify({ group: 'admin', text: result.data.o_status_message, type:'error' });
                        }

                    });
                }else{
                    ApiRepository.callApi(ApiRepository.POST_COMMAND,'/admin/employee-position/designations',this.employeeDesignation).then(result => {

                        // console.log('designation',result.data);
                        if(result.data.o_status_code == 1) {
                            this.allDesignation();
                            this.onReset();
                            currObj.$notify({ group: 'admin', text: result.data.o_status_message, type:'success' });
                        }else {
                            currObj.$notify({ group: 'admin', text: result.data.o_status_message, type:'error' });
                        }
                    });
                }

            },
            onReset(evt) {
                this.employeeDesignation = {
                    department_id:null,
                    prof_type_id:null,
                    // class:null,
                    grade_id:null,
                    status:null,
                },
                    this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });

            },
            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/admin/employee-position/designations/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.employeeDesignation = result.data.designation;
                    this.gradclassByid();
                });

            },

            gradclassByid() {
                let $that = this;
                let id = $that.employeeDesignation.grade_id
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/admin/pay-grades/${id}`).then(result => {
                    $that.employeeDesignation.class = result.data.paygrade.emp_class;
                });

            },
            deleteRow(id) {
                if (id > -1) {
                    if(confirm("Do you really want to delete?")){
                        ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/employee-position/designations/${id}`).then( result => {
                            this.allDesignation();
                        });
                    }
                }
            }


        }
    }
</script>
