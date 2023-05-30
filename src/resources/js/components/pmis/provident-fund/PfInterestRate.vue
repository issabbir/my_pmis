<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Interest Rate
                </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="Active Date Form"
                                    label-for="active_date_from"
                                    class="requiredField">
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="interestRate.active_date_from"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        required  v-validate="'required'"
                                        format="DD-MM-YYYY" :value-type="dateValueType">
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Active Date To"
                                    label-for="active_date_end">
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="interestRate.active_date_end"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        format="DD-MM-YYYY" :value-type="dateValueType">
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Interest Rate"
                                    label-for="interest_rate"
                                    class="requiredField">
                                    <b-form-input
                                        id="interest_rate"
                                        v-model="interestRate.interest_rate"
                                        type="number"
                                        required
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Active"
                                    class="requiredField"
                                    label-for="active_yn">
                                    <b-form-radio-group
                                        v-model="interestRate.active_yn"
                                        :options="active_options"
                                        id="active_yn"
                                        name="active_yn">
                                    </b-form-radio-group>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end mt-1">
                                <b-button md="6" size="md" variant="dark" type="submit">{{submitBtn}}</b-button>&nbsp;
                                <b-button md="6" size="md" class="btn-outline-dark" type="reset">Cancel</b-button>
                            </b-col>
                        </b-row>
                        <!--</fieldset>-->
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Interest Rate List
                </b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items"
                               :totalList="totalList" :perPage="perPage" v-bind:pageColSize="4" v-bind:searchColSize="5">
                        <template v-slot:actions="{ rows }"  >
                            <a size="sm"   @click="editRow(rows.item)"> <i class="bx bx-edit cursor-pointer"></i> </a>
                            <!-- <a size="sm"   class="text-danger"  @click="deleteRow(rows.item.settlement_id, rows.index)"> <i class="bx bx-trash cursor-pointer"></i> </a>-->
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import ApiRepository from '../../../Repository/ApiRepository';

    export default {
        components: {DatePicker, Datatable, vSelect, vcss},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "GPF Subscription Rate"});
            this.loadData();
        },
        data() {
            return {
                submitBtn: 'Save',
                dateValueType: this.dateFormatter(),
                active_date_from: new Date(),
                active_date_end: new Date(),
                interestRate: {
                    active_date_from: moment().format("YYYY-MM-DD"),
                    active_date_end: moment().format("YYYY-MM-DD"),
                    interest_rate: null,
                    active_yn: '',

                },
                active_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                show: true,
                perPage: 5,
                totalList: 0,
                tableData: {
                    fields:[
                        {key: 'index', label:'#sl', sortable: true},
                        {key: 'active_date_from',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, label: 'Active Date From', sortable: true},
                        {key: 'active_date_end',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, label: 'Active Date To', sortable: true},

                        {key: 'interest_rate',
                            label:'Interest Rate', sortable: true},
                        {key: 'active_yn',
                            formatter: value => {
                                if(value=='Y') {
                                    return 'Active';
                                }else{
                                    return  'Inactive'
                                }
                            },
                            label:'Active', sortable: true},
                        'action'],
                    items: []
                }
            }
        },
        watch: {

        },
        methods: {
            onSubmit() {
                if(this.interestRate.gpf_interest_rate_id != null){
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/providentFund/pf/interest-update`, this.interestRate).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.loadData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }else{
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/providentFund/pf/interest-store`, this.interestRate).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.loadData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }

            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/pf/interest-list`).then(res => {
                    this.tableData.items= res.data;
                    this.totalList = res.data.length;
                });
            },
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
            onReset() {
                this.show = false;
                this.submitBtn = 'Save';
                this.interestRate={},
                this.$nextTick(() => {
                    this.show = true
                })
            },
            editRow(item) {
                this.interestRate=item;
                this.submitBtn='Update';
            },
        }
    }
</script>

