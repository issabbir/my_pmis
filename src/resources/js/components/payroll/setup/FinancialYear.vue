<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Financial Year Setup</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="3">
                                <b-form-group>
                                    <b-form-group
                                        class="requiredField"
                                        id="fy_name"
                                        label="Financial Year"
                                        label-for="fy_name">
                                        <b-form-input  v-model="fy.fy_name" required  v-validate="'required'"></b-form-input>
                                    </b-form-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    id="fy_name_bng"
                                    label="Financial Year (Bangla)"
                                    label-for="fy_name_bng">
                                    <b-form-input v-model="fy.fy_name_bng"  ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    class="requiredField"
                                    label="Start Date"
                                    label-for="start_date">
                                    <date-picker width="100%" input-class="form-control" v-model="fy.start_date"
                                                 id="start_date"
                                                 name="start_date"
                                                 type="date" :editable="false" lang="en" format="DD-MM-YYYY" required  v-validate="'required'" :value-type="dateValueType"></date-picker>
                                    <span :style="errorMessage">{{ errors.first('start_date') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    class="requiredField"
                                    label="End Date"
                                    label-for="end_date">
                                    <date-picker width="100%" input-class="form-control" v-model="fy.end_date"
                                                 id="end_date"
                                                 name="end_date"
                                                 type="date" :editable="false" lang="en" format="DD-MM-YYYY"
                                                 required  v-validate="'required'" :value-type="dateValueType"></date-picker>
                                    <span :style="errorMessage">{{ errors.first('end_date') }}</span>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="Active"
                                    class="requiredField"
                                    label-for="current_yn">
                                    <b-form-radio-group
                                        v-model="fy.current_yn"
                                        :options="active_options"
                                        id="current_yn"
                                        name="current_yn">
                                    </b-form-radio-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button md="6"  size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                <b-button md="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                            </b-col>
                        </b-row>
                        <!--</fieldset>-->
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Financial Year List</b-card-header>
                <b-card-body class="border">
                    <Datatable  v-bind:fields="fields" v-bind:items="items">
                        <template  v-slot:action4="{ rows }" >
                        </template>
                        <template v-slot:actions="{ rows }">
                            <b-link   ml="4" class="text-primary"
                                    @click="editRow(rows.item.fy_id)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import moment from 'moment';
    import  vcss from 'vue-select/dist/vue-select.css';
    import Datatable from '../../../layouts/common/datatable';
    import DatePicker from "vue2-datepicker";
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {DatePicker,Vue,vSelect,vcss,Datatable},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payroll"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Financial Year"});
            this.loadData();
            this.fy.current_yn = 'N';
        },
        data() {
            return {
                errorMessage: {color: 'red'},
                dateValueType: this.dateFormatter(),
                fy:{
                    fy_name: '',
                    fy_name_bng: '',
                    start_date: moment().month('July').startOf('month').format('YYYY-MM-DD'),
                    end_date: moment().add('year', 1).month('June').endOf('month').format('YYYY-MM-DD'),
                    current_yn: '',
                },
                active_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                submitBtn: 'Save',
                items: [],
                fields: [
                    {key:'fy_name', label:'Financial Year', sortable:true},
                    {key:'fy_name_bng', label:'Financial Year(Bangla)', sortable:true},
                    {key:'start_date',
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label:'Start Date', sortable:true},
                    {key:'end_date',
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label:'End Date', sortable:true},
                    'action'],
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
            onSubmit(evt) {
                evt.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/financial-year", this.fy).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                        this.onReset();
                    } else{
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                    }
                });
            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/financial-years").then(res => {
                    this.items=res.data.data;
                    console.log('fincncial month',moment().month('July').startOf('month'))
                });
            },
            onReset() {
                this.fy={
                    fy_name: '',
                    fy_name_bng: '',
                    start_date: moment().month('July').startOf('month').format('YYYY-MM-DD'),
                    end_date: moment().add('year', 1).month('June').endOf('month').format('YYYY-MM-DD'),
                    current_yn: '',
                };
                this.submitBtn = 'Save';
                this.loadData();
            },
            editRow(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/financial-year/${id}`).then(res => {
                    this.fy = res.data;
                    this.submitBtn = 'Update';
                });
            },

        },

    }
</script>
<style scoped>
</style>
