<template>
  <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
    <b-card>
      <b-card-header header-bg-variant="dark" header-text-variant="white">Others Information Entry</b-card-header>
      <b-card-body class="border">
          <b-row>
              <b-col md="12" sm="12" class="pr-md-0">
                      <div  v-if="can_update">
                          <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                              <b-row>
                                  <b-col md="4">
                                      <b-form-group
                                          label="Salary Heads"
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
                                          label="Salary Heads (Bengali)"
                                          label-for="attribute_name_bn">
                                          <b-form-input
                                              id="attribute_name_bn"
                                              name="attribute_name_bn"
                                              v-model="other.attribute_name_bn"
                                              disabled
                                          ></b-form-input>
                                      </b-form-group>
                                  </b-col>
                                  <b-col md="4" style="pointer-events: none">
                                      <b-form-group
                                          label="Deductible"
                                          label-for="deduction_yn"
                                          class="uppercase">
                                          <b-form-input
                                              :value="deduction_status"
                                              disabled
                                              id="deduction_yn">

                                          </b-form-input>
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
                                  <b-col md="4">
                                      <b-form-group
                                          label="Active"
                                          label-for="active_yn"
                                          class="requiredField">
                                          <b-form-select class="form-control" id="active_yn" name="active_yn" v-model="other.active_yn" :options="deductionType" v-validate="'required'"></b-form-select>
                                          <span :style="errorMessage">{{ errors.first('active_yn') }}</span>
                                      </b-form-group>
                                  </b-col>
                                  <b-col md="12">
                                      <b-form-group
                                          label="description"
                                          label-for="description">
                                          <b-form-textarea
                                              id="description"
                                              v-model="other.description"
                                              placeholder="Type Description"
                                              name="description"
                                              rows="1"
                                          ></b-form-textarea>
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
                      </div>
                      <div class=" mt-2">
                          <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage">
                              <template v-slot:actions="{ rows }">
                                  <b-link ml="4" class="text-primary" @click="editRow(rows.item)"><i class="bx bx-edit cursor-pointer"></i></b-link>
                              </template>
                          </Datatable>
                      </div>
              </b-col>
          </b-row>
      </b-card-body>
    </b-card>
  </b-form>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker'
    import vSelect from 'vue-select';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    import SideBar from "./partials/sidebar";
    const {required, requiredIf, maxLength, minLength, email, maxValue, decimal} = require("vuelidate/lib/validators");
    const marriedRelations = [1, 2, 3, 4, 9, 10, 17, 18]
    export default {
        name: 'OthersCollection',
        components: {DatePicker, Datatable, vSelect},
        props: ['id'],
        computed: {
            deduction_status: function () {
                if(this.other.deduction_yn=='N'){
                    return 'NO'
                }
                else if(this.other.deduction_yn=='Y') {
                    return  'YES'
                } else {
                    return ''
                }
            }
        },
        watch: {
            can_update: function(val, oldVal){
                if(val){
                    this.fields.push({key: 'action', class: 'text-center'})
                }
            },
            clubs:function(val,oldVal) {
                if(val !== null);
                this.other.salary_head_id = val.value.salary_head_id;
                this.other.amount = val.value.default_value;
                this.other.attribute_name = val.value.salary_head;
                this.other.attribute_name_bn = val.value.salary_head_bng;
                this.other.deduction_yn = val.value.deduction_yn;
            }
        },
        data() {
            return {
                can_update: false,
                hidenseek: true,
                errorMessage: {color: 'red'},
                clubs: {text:'',value:''},
                items:[],
                req:'required',
                keepDisable: false,
                totalList: '',
                perPage: 5,
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'attribute_name', label: 'Salary Heads', sortable: true},
                    {key: 'attribute_name_bn', label: 'Salary Heads (Bengali)', sortable: true},
                    {
                        key: 'deduction_yn',
                        label: 'Deductible',
                        formatter: value => {
                            if (value == 'Y') {
                                return 'Yes';
                            } else if(value == 'N'){
                                return 'No'
                            } else {
                                return ''
                            }
                        },
                        sortable: true
                    },
                    {
                        key: 'active_yn',
                        label: 'Active',
                        formatter: value => {
                            if (value == 'Y') {
                                return 'Yes'
                            } else if(value == 'N'){
                                return 'No'
                            } else {
                                return ''
                            }
                        },
                        sortable: true
                    },
                    {
                        key: 'amount',
                        formatter: value => {
                            if(value != null)
                                return value
                        },
                        sortable: true,
                        class:'text-right'
                    },
                    {
                        key: 'percentage',
                        formatter: value => {
                            if(value != null)
                                return value+' %'
                        },
                        sortable: true
                    }
                ],
                other: {
                    amount: '',
                    percentage: '',
                    deduction_yn: '',
                    active_yn:'Y',
                    attribute_type_id: '',
                    salary_head_id: ''
                },
                submitBtn:'Save',
                clubList:[],
                deductionType: [
                    {value: 'Y', text: 'Yes'},
                    {value: 'N', text: 'No'}
                ],
            }
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "other"});
            this.load()
            this.canUpdate()
        },

        methods: {
            canUpdate(){
                this.can_update = this.$store.getters.permissions.includes('CAN_UPDATE')
            },
            hasEmpId: function() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            load(){
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/others/${this.id}`).then(res => {
                        //this.clubList = res.data.salaryHeads;
                        this.other.emp_code = res.data.employee.emp_code;
                        this.other.emp_name = res.data.employee.emp_name;
                        this.other.emp_id = res.data.employee.emp_id;
                        this.other.emp_type_name = res.data.employee.emp_type.emp_type_name;
                        this.other.emp_type_id = res.data.employee.emp_type.emp_type_id;
                        this.items = res.data.data
                        this.totalList = res.data.data.length
                    });
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/salary-heads/visible_scope`).then(res => {
                        this.clubList = res.data.salaryHeads;
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
                this.clubs = {
                    text: '',
                    value: ''
                };
                this.other = {
                    amount: '',
                    percentage: '',
                    deduction_yn: '',
                    active_yn:'Y',
                    attribute_type_id: '',
                    salary_head_id: ''
                };
                this.submitBtn = "Save";
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
<style>
  .uppercase {
    text-transform: uppercase;
  }
</style>
