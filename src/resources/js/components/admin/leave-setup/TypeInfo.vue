<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row >
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Leave Type Info</h4>
                        </div>
                        <div class="card-content">
                            <b-card-text class="card-body mb-2">
                                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                                    <!--<fieldset class="border p-2">-->
                                        <!--<legend class="w-auto">Thana Setup</legend>-->
                                        <b-row >
                                            <b-col>
                                                <b-row class="row">
                                                    <b-col lg="6">
                                                        <b-row >
                                                            <b-col lg="4">
                                                                <label>Leave Code</label>
                                                            </b-col>
                                                            <b-col lg="8" class="form-group">
                                                                <b-form-input  v-model="leaveTypeInfo.leavecode"   type="text" placeholder="Leave Code" value="123"></b-form-input>
                                                            </b-col>
                                                        </b-row>

                                                        <b-row>
                                                            <b-col lg="4">
                                                                <label>Leave Description</label>
                                                            </b-col>
                                                            <b-col lg="8" class="form-group">
                                                                <b-form-input  v-model="leaveTypeInfo.description"   type="text" placeholder="Leave Description"></b-form-input>

                                                            </b-col>
                                                        </b-row>
                                                    </b-col>
                                                    <b-col lg="6" >
                                                        <b-row >
                                                            <b-col lg="4">
                                                                <label>Leave Type</label>
                                                            </b-col>
                                                            <b-col lg="8" class="form-group">
                                                                <b-form-input  v-model="leaveTypeInfo.leavetype"  type="text" placeholder="Leave Type"></b-form-input>
                                                            </b-col>
                                                        </b-row>

                                                        <b-row >
                                                            <b-col lg="4">
                                                                <label>Leave Day</label>
                                                            </b-col>
                                                            <b-col lg="8" class="form-group">
                                                                <b-form-input   v-model="leaveTypeInfo.leaveday"  type="text" placeholder="Leave Day"></b-form-input>

                                                            </b-col>
                                                        </b-row>
                                                    </b-col>
                                                </b-row>

                                                <b-row class="row">
                                                    <b-col lg="6">
                                                        <b-row>
                                                            <b-col lg="4"><label class="d-block">Applicable Employee Type</label></b-col>
                                                            <b-col lg="8">
                                                                <b-form-group>
                                                                    <b-form-radio-group v-model="leaveTypeInfo.emp_type_id"
                                                                            :options="emptype_options"
                                                                            name="emptype_options"
                                                                    ></b-form-radio-group>
                                                                </b-form-group>
                                                            </b-col>
                                                        </b-row>
                                                    </b-col>
                                                    <b-col lg="6">
                                                        <b-row>
                                                            <b-col lg="4"><label class="d-block">Applicable Gender</label></b-col>
                                                            <b-col lg="8">
                                                                <b-form-group>
                                                                    <b-form-radio-group v-model="leaveTypeInfo.gender_id"
                                                                            :options="gender_options"
                                                                            name="gender_options"
                                                                    ></b-form-radio-group>
                                                                </b-form-group>
                                                            </b-col>
                                                        </b-row>
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
                                    <!-- </fieldset>-->
                                </b-form>
                            </b-card-text>
                        </div>
                    </b-card>
                </b-col>
            </b-row>



            <!-- Zero configuration table -->
            <section id="basic-datatable">
                <b-row >
                    <b-col >
                        <b-card class="card">
                            <div class="card-content">
                                <b-card-text class="card-body">
                                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" >
                                        <template v-slot:actions="{ rows }">
                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item.leavecode)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                            <b-link class="text-danger" @click="deleteRow(rows.item.leavecode)">
                                                <i class="bx bx-trash cursor-pointer"></i>
                                            </b-link>
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
            this.$store.commit("setBreadcrumb", { link: "#", label: "Leave Setup"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Leave Type" });
            this.allEmployeeTypes();
            this.allGenders();
            this.allLeaveTypes();
        },
        data() {
            return {
                gender:'Male',
                emp_type_id: 'All',
                leaveTypeInfo: { },
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                tableData: {
                    fields: [{key:'leavecode', label: 'Code', sortable:true},
                        {key:'leavetype', label: 'Leave Type', sortable:true},
                        {key:'description', label: 'Leave Description', sortable:true},
                        {key: 'leaveday', label: 'Leave Days', sortable:true},
                        {key: 'emptype.type', label: 'Employee Type', sortable:true},
                        {key: 'gender.name', label: 'Applicable Gender', sortable:true}, 'Action'],
                    items:[]
                },
                gender_options: [],
                emptype_options: [],


            }
        },
        methods: {
            allEmployeeTypes() {
                let that = this;

                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/leave-setup/applicable-employee-types-dropdown')
                    .then(function(result){
                        that.emptype_options = result.data.hrEmpTypes;
                    })
                    .catch(function(error) {
                        // handle errors.
                    });
            },
            allGenders() {
                let that = this;

                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/leave-setup/applicable-genders-dropdown')
                    .then(function(result){
                        that.gender_options = result.data.hrGenders;
                    })
                    .catch(function(error) {
                        // handle errors.
                    });
            },
            allLeaveTypes() {
                let that = this;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/leave-setup/type-infos')
                    .then(function(result){
                        console.log(result.data);
                        that.tableData.items = result.data;
                    })
                    .catch(function(error) {
                        // handle errors.
                    });
            },
            onSubmit(evt) {
                let that = this;

                if(this.updateIndex > 0) {
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/leave-setup/type-infos/${this.updateIndex}`, this.leaveTypeInfo)
                        .then(function(result) {
                            that.allLeaveTypes();
                        })
                        .catch(function(error) {
                            // handle errors.
                        });
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/leave-setup/type-infos', this.leaveTypeInfo)
                        .then(function(result){
                            that.allLeaveTypes();
                        })
                        .catch(function(error) {
                            // handle errors.
                        });
                }

                that.onReset();
            },
            onReset(evt) {
                this.leaveTypeInfo = {}
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(id) {
                let that = this;
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/leave-setup/type-infos-fetch/${id}`)
                    .then(function(result) {
                        that.submitBtn = 'Update';
                        that.leaveTypeInfo = result.data.hrLeaveTypeInfo;
                    })
                    .catch(function(error){
                        // handle errors.
                    });

            },
            deleteRow(id) {
                let that = this;
                if (id > -1) {
                    let confirmation = confirm('Are you sure you want to delete this item?');
                    if(confirmation) {
                        ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/admin/leave-setup/type-infos/${id}`)
                            .then(function(result) {
                                that.allLeaveTypes();
                                that.onReset();
                            })
                            .catch(function(error){
                                // handle errors.
                            });

                        return true;
                    }

                    return false;
                }
            }

        }
    }
</script>

