<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Holiday Setup</b-card-header>
                <b-card-body class="border">
                    <b-form @submit="onSubmit" @reset="onReset"  v-if="show">
                        <!--<fieldset class="border p-2">-->
                            <!--<legend class="w-auto">Holiday Setup</legend>-->
                            
                                    <b-row class="row">
                                        <b-col lg="6">
                                            <b-row >
                                            <b-col lg="3">
                                                <label>Holiday</label>
                                            </b-col>
                                            <b-col lg="9">
                                                <div class="form-group">
                                                        <b-form-input v-model="holiday.holiday" required  type="text" placeholder="Holiday"></b-form-input>
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
                                                        <b-form-input v-model="holiday.holiday_bng"   type="text" placeholder="Holiday Bangla"></b-form-input>
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
                                                    <date-picker
                                                        v-model="holiday.date_from"
                                                        width="100%"
                                                        input-class="form-control"
                                                        type="date"
                                                        lang="en"
                                                        required  v-validate="'required'"
                                                        format="DD-MM-YYYY" :value-type="dateValueType"
                                                        name="date_from"
                                                    ></date-picker>
                                                    <span :style="errorMessage">{{ errors.first('date_from') }}</span>
                                                </b-col>
                                            </b-row>

                                        </b-col>
                                        <b-col lg="6" >

                                            <b-row >
                                                <b-col lg="3">
                                                    <label>To Date</label>
                                                </b-col>
                                                <b-col lg="9" class="form-group">
                                                    <date-picker
                                                        v-model="holiday.date_to"
                                                        width="100%"
                                                        input-class="form-control"
                                                        type="date"
                                                        lang="en"
                                                        required  v-validate="'required'"
                                                        format="DD-MM-YYYY" :value-type="dateValueType"
                                                        name="date_to"
                                                    ></date-picker>
                                                    <span :style="errorMessage">{{ errors.first('date_to') }}</span>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col lg="6" >

                                            <b-row >
                                                <b-col lg="3">
                                                    <label>Description</label>
                                                </b-col>
                                                <b-col lg="9" class="form-group">
                                                    <b-form-input v-model="holiday.description" placeholder="Description" required></b-form-input>
                                                    <b-form-input v-model="holiday.holiday_id" hidden ></b-form-input>
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
                    </b-form>
                </b-card-body>
            </b-card>
            <!-- Zero configuration table -->
            <section id="basic-datatable">
                <b-card>
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Holiday List</b-card-header>
                    <b-card-body class="border">
                        <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage" >
                            <template v-slot:actions="{ rows }">
                                <b-link ml="4" class="text-primary"
                                        @click="editRow(rows.item.holiday_id)">
                                    <i class="bx bx-edit cursor-pointer"></i>
                                </b-link>
                            </template>
                        </Datatable>
                    </b-card-body>
                </b-card>
            </section>
        </div>
    </div>
</template>


<script>
    import DatePicker from "vue2-datepicker";
    import moment from 'moment';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    export default {
        components: {DatePicker,Datatable},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Leave"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Holiday Entry" });
            this.loadData();
        },
        data() {
            return {
                unique_code_message: '',
                errorMessage: {color: 'red'},
                dateValueType: this.dateFormatter(),
                holiday: {},
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                perPage:5,
                totalList:0,
                fields: [{key:'holiday', label: 'Holiday', sortable:true}, {key:'holiday_bng', label: 'Holiday bangla', sortable:true},
                    {key:'date_from',  formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label: 'From date', sortable:true},
                    {key:'date_to',  formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label: 'To date', sortable:true},{key:'description', label: 'Description', sortable:true},'Action'],
                items:[],
                holiday_type_options: [],
                status_options: [],

            }
        },
         methods: {
             dateFormatter: function() {
                 return {
                     value2date: value => {
                         return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                     },
                     date2value: date => {
                         return date ? moment(date).format("YYYY-MM-DD") : null;
                     }
                 }
             },
             loadData: function () {
                 ApiRepository.callApi(ApiRepository.GET_COMMAND, "/leave/holiday-entry", this.holiday).then(res => {
                    this.items = res.data.holiday;
                    this.totalList = res.data.holiday.length;

                });
            },
             validateGeneral: async function() {
                 const general = Promise.all([
                     //this.$validator.validate('emp_photo', this.basicInfo.emp_photo),
                     this.$validator.validate('date_from', this.holiday.date_from),
                     this.$validator.validate('date_to', this.holiday.date_to)
                 ]);

                 const areValid = (await general).every(isValid => isValid);
                 const uniqueCode = (this.unique_code_message=='');

                 return areValid && uniqueCode;
             },
           onSubmit(evt) {
               evt.preventDefault();
               let id = this.holiday.holiday_id;
               let currObj = this;
               this.$validator.validateAll().then(() => {
                   if (!this.errors.any()) {
                       if (id > 0) {
                           ApiRepository.callApi(ApiRepository.POST_COMMAND, `/leave/holiday-entry/update/${id}`, this.holiday).then(res => {
                               this.loadData();
                               this.onReset();
                               if (res.data.o_status_code == 1)
                                   currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                               else
                                   currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                           });
                       } else {
                           ApiRepository.callApi(ApiRepository.POST_COMMAND, '/leave/holiday-entry', this.holiday).then(res => {
                               if (res.data.o_status_code == 1) {
                                   currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                   this.loadData();
                                   this.onReset();
                               } else {
                                   currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                               }


                           });
                       }
                   }
               });
            },
            onReset(evt) {
                this.$nextTick(() => {
                    this.holiday.holiday_id='';
                    this.holiday.holiday='';
                    this.holiday.holiday_bng='';
                    this.holiday.date_from='';
                    this.holiday.date_to='';
                    this.holiday.description='';
                    this.updateIndex = -1;
                    this.submitBtn = 'Save';
                    this.show = false;
                    this.show = true;
                });

            },
            editRow(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/leave/holiday-entry/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.holiday = result.data;
                 });

            },

        }
    }
</script>


