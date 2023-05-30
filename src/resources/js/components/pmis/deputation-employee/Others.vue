<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked  pt-0">
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0">
                        <b-card title="Others Information Entry">
                            <b-card-body class="border">
                                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                                    <b-row>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Club"
                                                label-for="lookup_code"
                                                class="requiredField">
                                                <v-select v-model="clubs" :options="clubList"
                                                          name="lookup_code" id="lookup_code" label="text"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('lookup_code') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Deductible"
                                                label-for="deduction_yn"
                                                class="requiredField uppercase">
                                                <b-form-select class="form-control" id="deduction_yn" name="deduction_yn" v-model="other.deduction_yn" :options="deductionType" v-validate="'required'"></b-form-select>
                                                <span :style="errorMessage">{{ errors.first('deduction_yn') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Attribute name"
                                                label-for="attribute_name">
                                                <b-form-input id="attribute_name"
                                                              name="attribute_name"
                                                              v-model="other.attribute_name"
                                                              disabled
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Attribute Name (Bengali)"
                                                label-for="attribute_name_bn">
                                                <b-form-input id="attribute_name_bn"
                                                              name="attribute_name_bn"
                                                              v-model="other.attribute_name_bn"
                                                              disabled
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="amount"
                                                label-for="amount">
                                                <b-form-input id="amount"
                                                              name="amount"
                                                              v-model="other.amount"
                                                              :disabled="other.percentage != null && other.percentage.length > 0"
                                                              v-validate="`${req}|decimal:2|min_value:0`"
                                                              :maxlength="20"
                                                ></b-form-input>
                                                <span :style="errorMessage">{{ errors.first('amount') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="percentage"
                                                label-for="percentage">
                                                <b-form-input id="percentage"
                                                              name="percentage"
                                                              v-model="other.percentage"
                                                              :disabled="other.amount != null && other.amount.length > 0"
                                                              v-validate="`${req}|decimal:2|min_value:0|max_value:100`"
                                                              :maxlength="3"
                                                ></b-form-input>
                                                <span :style="errorMessage">{{ errors.first('percentage') }}</span>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="8">
                                            <b-form-group
                                                label="description"
                                                label-for="description">
                                                <b-form-textarea
                                                    id="description"
                                                    v-model="other.description"
                                                    placeholder="Type Description"
                                                    name="description"
                                                    rows="1"
                                                    max-rows="5"
                                                ></b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Active"
                                                label-for="active_yn"
                                                class="requiredField">
                                                <b-form-select class="form-control" id="active_yn" name="active_yn" v-model="other.active_yn" :options="deductionType" v-validate="'required'"></b-form-select>
                                                <span :style="errorMessage">{{ errors.first('active_yn') }}</span>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1" :disabled="keepDisable">{{submitBtn}}</b-button>
                                            <b-button type="reset" class="btn btn-outline-dark" :disabled="keepDisable">Cancel</b-button>
                                        </b-col>
                                    </b-row>

                                </b-form>
                            </b-card-body>
                        </b-card>
                        <b-card title="Others Information List">
                            <b-card-body class="border">
                                <Datatable v-bind:fields="fields" v-bind:items="items">
                                    <template v-slot:actions="{ rows }">
                                        <b-link ml="4" class="text-primary" @click="editRow(rows.item)"><i class="bx bx-edit cursor-pointer"></i></b-link>
                                    </template>
                                </Datatable>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker'
    import SideBar from "../partials/sidebar";
    import vSelect from 'vue-select';
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        props: ['id'],
        components: {DatePicker, SideBar, Datatable,vSelect},
        watch: {
            clubs:function(val,oldVal) {
                if(val !== null);
                     this.other.attribute_type_id=val.value.attribute_type_id;
                     this.other.amount=val.value.default_amount;
                     this.other.attribute_name=val.value.attribute_name;
                     this.other.attribute_name_bn=val.value.attribute_name_bn;
                }
            },
        data() {
            return {
                errorMessage: {color: 'red'},
                clubs: {text:'',value:''},
                items:[],
                req:'required',
                keepDisable: false,
                fields:[
                    {key: 'index', label: 'SL'},
                    {key: 'attribute_name', sortable: true},
                    {key: 'attribute_name_bn', sortable: true},
                    {key: 'deduction_yn',
                        formatter: value => {
                            if (value == 'Y') {
                                return 'Yes';
                            }else{
                                return 'No';
                            }
                        }, sortable: true},+
                    {key: 'active_yn',
                        formatter: value => {
                            if (value == 'Y') {
                                return 'Yes';
                            }else{
                                return 'No';
                            }
                        }, sortable: true},
                    {key: 'amount',
                        formatter: value => {
                            if(value != null)
                                return value
                        }, sortable: true, class:'text-right'},
                    {key: 'percentage',
                        formatter: value => {
                        if(value != null)
                            return value+' %'
                    }, sortable: true},
                    'action'],


                other: {
                        amount:'',
                        percentage:'',
                        deduction_yn:'Y',
                        active_yn:'Y',
                        attribute_type_id:''
                        },
                submitBtn:'Save',
                clubList:[],
                deductionType:[{value: 'Y', text: 'Yes'},{value: 'N', text: 'No'}],
                show: true
            }
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "other"});
            this.load();
        },

        methods: {
            hasEmpId: function() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            load(){
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/others/${this.id}`).then(res => {
                        this.clubList = res.data.clubs;
                        this.other.emp_code = res.data.employee.emp_code;
                        this.other.emp_name = res.data.employee.emp_name;
                        this.other.emp_id = res.data.employee.emp_id;
                        this.other.emp_type_name = res.data.employee.emp_type.emp_type_name;
                        this.other.emp_type_id = res.data.employee.emp_type.emp_type_id;
                        this.items=res.data.data;
                    });
                }
            },
            onSubmit(){
                let amount = this.other.amount;
                let percentage = this.other.percentage;
                this.$validator.validateAll().then((result) => {
                    if((amount != null && amount.length > 0) || (percentage != null && percentage.length > 0)){
                        this.req = '';
                    }else{
                        this.req = 'required';
                        return false;
                    }
                    if (!this.errors.any()) {
                        this.keepDisable = true;
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/employee/others`,this.other).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.onReset();
                                this.load();
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                            } else{
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                            }
                            this.keepDisable = false;
                        });
                    }
                });
            },
            onReset(){
                this.clubs = {};
                this.other = {};
                this.show = false;
                this.$nextTick(() => {
                    this.submitBtn = "Save";
                    this.show = true;
                })
            },
            editRow(data){
                this.submitBtn = "Update";
                    this.other = data;
                    this.clubs.text=data.attribute_name;
                    this.clubs.value=data.attribute_type_id;

            }
        }
    }
</script>
