<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row >
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Holiday Setup</h4>
                        </div>
                        <div class="card-content">
                             <b-card-text class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset"  v-if="show">
                                    <!--<fieldset class="border p-2">-->
                                        <!--<legend class="w-auto">Holiday Setup</legend>-->
                                        <b-row >
                                            <b-col>
                                                <b-row class="row">
                                                    <b-col lg="6">
                                                        <b-row >
                                                        <b-col lg="3">
                                                            <label>Holiday</label>
                                                        </b-col>
                                                        <b-col lg="9">
                                                            <div class="form-group">
                                                                 <b-form-input v-model="holiday.p_holiday" required  type="text" placeholder="Holiday"></b-form-input>
                                                            </div>
                                                        </b-col>
                                                    </b-row>
                                                    </b-col>
                                                    <b-col lg="6">
                                                        <b-row >
                                                        <b-col lg="3">
                                                            <label>Holiday Bangla</label>
                                                        </b-col>
                                                        <b-col lg="9">
                                                            <div class="form-group">
                                                                 <b-form-input v-model="holiday.p_holiday_bng" required  type="text" placeholder="Holiday Bangla"></b-form-input>
                                                            </div>
                                                        </b-col>
                                                    </b-row>
                                                    </b-col>
                                                    <b-col lg="6">

                                                        <b-row >
                                                            <b-col lg="3">
                                                                <label>From Date </label>
                                                            </b-col>
                                                            <b-col lg="9" class="form-group">
                                                                <b-form-input v-model="holiday.p_date_from" required  type="date" placeholder="MM/DD/YYY"></b-form-input>

                                                            </b-col>
                                                        </b-row>

                                                    </b-col>
                                                    <b-col lg="6" >

                                                        <b-row >
                                                            <b-col lg="3">
                                                                <label>To Date</label>
                                                            </b-col>
                                                            <b-col lg="9" class="form-group">
                                                                <b-form-input v-model="holiday.pa_date_to" required  type="date" placeholder="MM/DD/YYYY"></b-form-input>
                                                            </b-col>
                                                        </b-row>
                                                    </b-col>
                                                     <b-col lg="6">
                                                        <b-row >
                                                        <b-col lg="3">
                                                            <label>Description</label>
                                                        </b-col>
                                                        <b-col lg="9">
                                                            <div class="form-group">
                                                                 <b-form-input v-model="holiday.p_description" required  type="text" placeholder="Description"></b-form-input>
                                                            </div>
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
                                                    @click="editRow(rows.item.holiday_id)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                            <b-link class="text-danger" @click="deleteRow(rows.item.holiday_id)">
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
            this.$store.commit("setBreadcrumb", { link: "#", label: "Holiday" });
            this.allHoliday();
        },
        data() {
            return {
                holiday: {},
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                totalList:0,
                perPage:5,
                tableData: {
                    fields: [{key:'holiday_id', label: 'ID', sortable:true}, {key:'holiday', label: 'Holiday', sortable:true}, {key:'holiday_bng', label: 'Holiday bangla', sortable:true}, {key:'description', sortable:true}, {key:'date_from', label: 'From date', sortable:true}, {key:'date_to', label: 'To date', sortable:true},'Action'],
                    items:[]
                },
                holiday_type_options: [],
                status_options: [],

            }
        },
         methods: {
             allHoliday(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/leave-setup/holidays').then(result => {
                    console.log(result.data.holiday);
                    this.tableData.items = result.data.holiday;
                });
            },
            onSubmit(evt) {
                evt.preventDefault();
                if(this.updateIndex > 0){
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND,`/admin/leave-setup/holidays/${this.updateIndex}`,this.holiday).then(result => {
                         this.allHoliday();
                         this.onReset();
                    });
                }else{
                    ApiRepository.callApi(ApiRepository.POST_COMMAND,'/admin/leave-setup/holidays',this.holiday).then(result => {
                       this.allHoliday();
                       this.onReset();
                    });
                }

            },
            onReset(evt) {
                this.employeeDesignation = {
                    department_id:null,
                    prof_type_id:null,
                    class_id:null,
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
                 ApiRepository.callApi(ApiRepository.GET_COMMAND,`/admin/leave-setup/holidays-fetch/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.employeeDesignation = result.data.designation;
                 });

            },
            deleteRow(id) {
                if (id > -1) {
                     if(confirm("Do you really want to delete?")){
                            ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/leave-setup/holidays/${id}`).then( result => {
                            this.allDesignation();
                        });
                    }
                }
            }

        }
    }
</script>

