<template>
    <b-row class="content-wrapper">

        <b-col class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
<!--                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">-->
                            <h4 class="card-title">Administrative Division Setup</h4>

                        </div>
                        <div class="card-header"></div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                                        <b-row>
                                            <b-col lg="4">
                                                <b-form-group
                                                        id="p_dpt_division_name"
                                                        label="Division Name"
                                                        label-for="input-name"
                                                        class="requiredField"
                                                >
                                                    <b-form-input
                                                        v-model="employeeDivision.dpt_division_name"
                                                        required id="input-name"
                                                        type="text"
                                                        placeholder="Division Name"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col lg="4">
                                                <b-form-group
                                                        id="fieldset-2"
                                                        label="Division Name Bangla"
                                                        label-for="input-name"
                                                >
                                                    <b-form-input
                                                        v-model="employeeDivision.dpt_division_name_bng"
                                                        id="input-name"
                                                        type="text"
                                                        placeholder="Division Name Bangla"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col lg="4">
                                                <b-row>
                                                <b-col class="mt-2 d-flex">
                                                    <b-button md="6" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button> &nbsp;
                                                    <b-button md="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                                </b-col>
                                            </b-row>
                                            </b-col>
                                        </b-row>

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
<!--                                            <b-link class="text-danger" @click="deleteRow(rows.item.admin_division_id)">-->
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

        </b-col>


    </b-row>
</template>

<script>
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    import Swal from 'sweetalert2/dist/sweetalert2.js';

    export default {
        components: {
            Datatable
        },
         mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Employee Position"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Division" });
            this.allDivisions();
         },
        data() {
            return {
                employeeDivision: {},
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                totalList:0,
                perPage:5,
                tableData: {
                    fields: [
                        {key: 'index', label: 'SL', class: 'text-center'},
                       // {key:'dpt_division_id', 'label':'ID', sortable:true},
                        {key:'dpt_division_name', label:'Division Name', sortable:true},
                        {key:'dpt_division_name_bng', label:'Division Name Bangla', sortable:true},
                        'action'
                    ],
                    items: []
                }
            }
        },

        methods: {
            allDivisions(){
                let that = this;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/employee-position/divisions').then(result => {
                    console.log(result.data);
                    that.tableData.items = result.data;
                    that.totalList = result.data.length;
                }).catch(function(error) {
                    // handle errors.
                });
            },

            onSubmit(evt) {
                evt.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND,'/admin/employee-position/divisions',this.employeeDivision).then(res => {

                    if (res.data.o_status_code == 1) {
                       this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success',duration: 100000});

                        this.allDivisions();
                        this.onReset();
                    }

                    else {
                        //alert (res.data.o_status_message);
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error',duration: 100000});

                    }
                })

            },
            onReset(evt) {
                this.employeeDivision = {};
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
                this.employeeDivision = item;
                this.submitBtn = 'Update';
            },
            deleteRow(id) {
                let that = this;
                if(confirm("Do you really want to delete?")) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/admin/employee-position/divisions/${id}`).then(result => {
                        that.allDivisions();
                     }).catch(function(error){
                        console.log(error);
                    });
                }
            }

        }
    }
</script>
