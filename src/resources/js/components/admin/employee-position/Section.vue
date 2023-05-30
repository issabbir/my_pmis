<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Administrative Section Setup</h4>
                        </div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                                    <!--<fieldset class="border p-2">-->
                                        <!--<legend class="w-auto"> Administrative Section Setup</legend>-->
                                        <b-row >
                                            <b-col >
                                                <b-row>
                                                    <b-col md="4">
                                                        <b-form-group id="section"  label="Section Name" label-for="input-name" class="requiredField">
                                                            <b-form-input
                                                                v-model="employeeSection.dpt_section"
                                                                required
                                                                type="text"
                                                                placeholder="Section Name"
                                                            ></b-form-input>
                                                        </b-form-group>

                                                    </b-col>
                                                    <b-col lg="4">
                                                        <b-form-group
                                                            id="Sectuo_bngla" label="Section Name Bangla" label-for="input-name">
                                                            <b-form-input
                                                                v-model="employeeSection.dpt_section_bng"
                                                                type="text"
                                                                placeholder="Section Name Bangla"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col lg="4">
                                                        <b-form-group id="Department_Name" label="Department Name" label-for="input-name" class="requiredField">
                                                            <b-form-select
                                                                v-model="employeeSection.department_id"
                                                                required
                                                                :options="department_options"
                                                            ></b-form-select>
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
                            <b-row>
                                <b-col sm="4">
                                    <b-form-group label="Department Name" label-cols-md="4" label-for="toDeptName">
                                        <v-select v-model="searchParam" :options="department_options" value="department_id"
                                                  label="department_name" required>
                                            <template #search="{attributes, events}">
                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                            </template>
                                        </v-select>

                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <div class="pr-0 d-flex justify-content-start">
                                        <b-button-group>
                                            <b-button type="button" @click="searchByDepartment()" variant="primary"><i
                                                class='bx bx-search'></i>Search
                                            </b-button>
                                            <b-button type="button" @click="clear()" variant="secondary">Reset</b-button>
                                        </b-button-group>
                                    </div>
                                </b-col>

                            </b-row>
                            <div class="card-content">
                                <b-card-text class="card-body">

                                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">
                                        <template v-slot:actions="{ rows }">
                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
<!--                                            <b-link class="text-danger" @click="deleteRow(rows.item.section_id)">-->
<!--                                                <i class="bx bx-trash cursor-pointer"></i>-->
<!--                                            </b-link>-->
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
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    export default {
        components: {
            Datatable,vSelect,vcss
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Employee Position"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Section" });
            this.allSections();
        },
        data() {
            return {
                searchParam: '',
                department_options: [ ],
                employeeSection: {
                    department_id:null,

                },
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                totalList:0,
                perPage:5,
                tableData: {
                    fields: [
                        //{key: 'section_id'},
                        {key: 'index', label: 'SL', class: 'text-center'},
                        {key: 'dpt_section', 'label': 'Section Name', sortable:true},
                        {key:'dpt_section_bng', label:'Section Name Bangla',sortable:true} ,
                        {key:'department_name', label: 'Department Name', sortable:true},
                        'action'
                    ],
                    items: []
                },

            }
        },
        methods: {
             allSections(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/employee-position/sections').then(result => {
                    //console.log(result);
                    this.tableData.items = result.data.sections;
                    this.totalList = result.data.sections.length;
                });

                 ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/search-employees").then(res => {
                         // this.sections = res.data.sections;
                         this.department_options = res.data.departments;
                     });

            },

            onSubmit(evt) {
                evt.preventDefault();
                    ApiRepository.callApi(ApiRepository.POST_COMMAND,'/admin/employee-position/sections',this.employeeSection).then(res => {


                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.allSections();
                            this.onReset();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    })

            },
            onReset(evt) {
                this.employeeSection = {
                    department_id:null
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
                this.employeeSection = item;
                this.submitBtn = 'Update';
            },

            searchByDepartment() {
                let department_id = this.searchParam.department_id;
                //console.log(this.searchParam);
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/employee-position/search-by-deptId/${department_id} `).then(result => {
                    console.log(result.data);
                    this.tableData.items = result.data;
                    //console.log(result.data);
                }).catch(err => {
                    console.log('error');
                });
            },
            clear() {
                this.searchParam = null,
                    this.fetchData();
            },
            deleteRow($id) {
                if($id > 0){
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/employee-position/sections/${$id}`).then(
                        result =>{
                            this.allSections();
                        }
                    ).catch(function (error) {
                        console.log(error);
                    })
                }
            }

        }
    }
</script>

