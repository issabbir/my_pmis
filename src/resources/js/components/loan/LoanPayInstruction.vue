<template>
    <div class="content-wrapper">
        <div class="content-body">
             <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Loan Pay Instruction</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSearch"  @reset.prevent="onReset">
                         <b-row>
                            <b-col md="3">
                                <b-form-group label="Month" label-for="month" class="required">
                                    <b-form-select text-field="show_value"
                                                   value-field="pass_value"
                                                   v-model="searchPayInstruction.month"
                                                   :options="monthList"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Loan Type" label-for="loan_type" class="required">
                                    <b-form-select id="loan_type" @change="loanTypeChange" v-model="searchPayInstruction.loan_type_id" text-field="loan_name" value-field="loan_type_id" :options="loanTypes" required ></b-form-select>
                                </b-form-group>
                            </b-col>
<!--                            <b-col md="3">-->
<!--                                <b-form-group label="Employee Code" label-for="emp_code">-->
<!--                                    <v-select-->
<!--                                        label="option_name"-->
<!--                                        v-model="selectedEmployee"-->
<!--                                        :options="empIdList"-->
<!--                                        @search="searchEmployees"-->
<!--                                        id="emp_code"-->
<!--                                    >-->
<!--                                        <template #selected-option="{ emp_code }">-->
<!--                                            <div style="display: flex; align-items: baseline;">-->
<!--                                                {{ emp_code }}-->
<!--                                            </div>-->
<!--                                        </template>-->
<!--                                    </v-select>-->
<!--                                </b-form-group>-->
<!--                            </b-col>-->
                             <b-col md="3">
                                 <b-form-group label="Loan No" label-for="loan_no">
                                     <v-select
                                         label="loan_no"
                                         value="application_id"
                                         v-model="searchPayInstruction.loan_no"
                                         :options="LoanList"
                                         @search="onChangeLoanNo()"
                                         ref="selectedEl"
                                         id="loan_no"
                                     >
                                         <template #selected-option="{ loan_no }">
                                             <div style="display: flex; align-items: baseline;">
                                                 {{ loan_no }}
                                             </div>
                                         </template>
                                     </v-select>
                                 </b-form-group>
                             </b-col>
                            <b-col md="3" style="margin-top: 15px">
                                <b-button-group>
                                    <b-button md="6" size="md" variant="primary" type="submit">Search</b-button>&nbsp;
                                    <b-button md="6" size="md" variant="secondary" type="reset">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>


                    </b-form>
                    <b-form @submit.prevent="onSubmit('payInstruction')"   @reset.prevent="onReset">
                    <Datatable  v-bind:fields="columns" :totalList="totalItems" :small="small" perPage="10" v-bind:items="listItems">
                        <template v-slot:head1="{ rows }">
                            <b-form-checkbox
                                v-model="allSelected"
                                :indeterminate="indeterminate"
                                aria-describedby="items"
                                aria-controls="items"
                                @change="toggleAll"
                            >
                            </b-form-checkbox>
                        </template>
                        <template v-slot:headCell1="{ rows }">
                            <b-form-checkbox
                                v-model="rows.item.checkbox"
                                value="1"
                                unchecked-value="0"
                                stacked
                            ></b-form-checkbox>

                        </template>
                        <template v-slot:action3="{ rows }">
                            <b-form-input type="number" v-model="rows.item.instr_priencipal_amt" class="text-right"></b-form-input>
                        </template>
                        <template v-slot:action4="{ rows }">
                            <b-form-input type="number" v-model="rows.item.instr_interest_amt" class="text-right"></b-form-input>
                        </template>
                    </Datatable>
                    <b-row align-h="end" class="mt-2">
                        <b-col md="2" class="mb-2 d-flex justify-content-end">
                            <b-button   lg="6" size="md" variant="dark" type="submit" class="mr-2" >{{submitBtn}}</b-button>&nbsp;
                            <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                        </b-col>
                    </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
<!--            <b-card>-->
<!--                <b-card-header header-bg-variant="dark" header-text-variant="white">Pay Instruction List</b-card-header>-->
<!--                <b-card-body class="border">-->
<!--                    <Datatable v-bind:fields="tableData.columns" :totalList="totalDataItems" :small="small" perPage="10"-->
<!--                               v-bind:items="tableData.items">-->
<!--                        <template v-slot:action2="{ rows }">-->
<!--                            <b-link @click="selectLoan(rows.item)" class="ot-btn btn btn-primary">-->
<!--                                <i class="bx bx-edit cursor-pointer"></i>-->
<!--                            </b-link>-->
<!--                        </template>-->
<!--                    </Datatable>-->
<!--                </b-card-body>-->
<!--            </b-card>-->
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import Datatable from '../../layouts/common/datatable_store';
    import ApiRepository from "../../Repository/ApiRepository";
    import vcss from 'vue-select/dist/vue-select.css';
    import DatePicker from "vue2-datepicker";



    export default {
        components: { Datatable, Vue, vSelect, vcss, DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan Approval"});
            this.loadData();

            ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/search-loan/null/null`).then(res => {
                this.LoanList = res.data;
            })
        },
        data() {
            return {
                searchPayInstruction:{
                    month:null,
                    loan_no:null,
                    loan_type_id:null
                },
                payInstruction: {
                    payment_instr_id:null,
                    month:null,
                    instr_priencipal_amt:null,
                    instr_interest_amt:null,
                    remaining_principal:null,
                    remaining_interest:null
                },
                max_value:null,
                submitBtn:'Submit',
                amountReadonly:true,
                ex_hidden:false,
                acc_hidden:false,
                formattedData:null,
                visible: true,
                temp: null,
                small:true,
                empIdList: [],
                listItems:[],
                loanTypes:[],
                LoanList: [],
                totalItems:0,
                totalDataItems:0,
                selectedLoan: {},
                updateIndex: -1,
                selectCheckbox:[],
                allSelected: false,
                indeterminate: false,
                checkBoxDisabled:true,
                monthList:[],
                approval:[{text:'Approved', value:1},{text:'Not Approved', value: -1}, {text: 'Pending', value: 0}],
                appInstlmntList: [{text: '12', value: 12}, {text: '24', value: 24},{text: '36', value: 36}, {text: '48', value: 48}],
                show: true,
                columns: [
                    {key:'head1', label: '', sortable:true,variant:""},
                    {label: 'SL', key: 'index', sortable:true},
                    {label: 'Employee', key: 'emp_name', sortable:true},
                    {label: 'Designation', key:'designation', sortable:true},
                    {label: 'Loan Type', key:'loan_type_name', sortable:true},
                    {label: 'Loan No.', key: 'loan_no'},
                    {label: 'Amount', key: 'loan_amount', sortable: true, class:'text-right'},
                    {label: 'Remaining Principal', key: 'remaining_principal', sortable: true, class:'text-right'},
                    {label: 'Remaining Interest', key: 'remaining_interest', sortable: true, class:'text-right'},
                    {key: 'action3', label: 'Principle Amount', class:"text-right"},
                    {key: 'action4', label: 'Interest Amount', class:"text-right"},
                    {label: 'Status', key: 'approval_status', sortable: true, class:'text-right'},
                ],

            }
        },
        watch: {
            selectCheckbox(newVal, oldVal) {
                // console.log(newVal);
                if (newVal.length === 0) {
                    this.indeterminate = false
                    this.allSelected = false
                } else if (newVal.length === this.items.length) {
                    this.indeterminate = false
                    this.allSelected = true
                } else {
                    this.indeterminate = true
                    this.allSelected = false
                }
            },
            selectedLoan: function (val, oldVal) {
                if (val !== null) {
                    //this.searchPayInstruction.loan_no = val.loan_no;
                }
            }

        },
        methods: {
            toggleAll(checked) {
                console.log(checked);
                for (let i in this.listItems) {
                    this.listItems[i].checkbox =  checked ? '1' : '0';
                 }

                if(this.allSelected == false){
                    this.allSelected = false;
                    this.indeterminate = false;
                    for (let i in this.items) {
                        this.selectCheckbox.push(this.listItems[i].emp_id);
                    }
                }else{
                    this.allSelected = true;
                    this.indeterminate = true;
                    this.selectCheckbox = [];
                }
            },
            onSubmit() {
                //let empId = this.selectCheckbox;
                //console.log(empId);
                let data={};
                data.listItems = this.listItems.filter(function(item,index) {
                    return item.checkbox == "1";
                 });
                console.log(data.listItems);
                data.month = this.searchPayInstruction.month;
                data.priciple_amount = this.payInstruction.priciple_amount;
                data.interest_amount = this.payInstruction.interest_amount;
                let currObj = this;
                this.$validator.validateAll('payInstruction').then(() => {
                    if (!currObj.errors.any()) {
                        if (data.listItems.length > 0) {
                            //console.log(data);
                            ApiRepository.callApi(ApiRepository.POST_COMMAND, '/loan/pay-instruction-store', data).then(res => {
                                if (res.data.o_status_code == 1) {
                                    currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                    this.loadData();
                                    this.show = false;
                                    // this.viewRow(data);
                                } else {
                                    currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                                }
                            });
                        } else {
                            currObj.$notify({group: 'pmis', text: 'Please select a Employee', type: 'error'});
                        }
                    } else {
                        console.log('here', currObj.errors);
                    }
                });
            },
            reset: function() {
                this.searchPayInstruction = {};
            },
            onReset() {
                this.selectedEmployee={emp_id:null};
                this.searchPayInstruction={};
                this.searchPayInstruction.month=null;
                this.searchPayInstruction.loan_type_id=null;
                this.searchPayInstruction.emp_code=null;
                this.selectedLoan=null;
                //    this.listItems=null;
                this.empIdList=[];
            },
            editRow(i, code) {

            },
            deleteRow(i, code) {

            },
            handleOnSelectChange() {
                this.searchPayInstruction.loan_no = null;
            },
            onChangeLoanNo(id) {
                this.searchPayInstruction.loan_no = null;
                let loan_type_id = this.searchPayInstruction.loan_type_id;
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/search-loan/${loan_type_id}/${id}`, this.loanApplication).then(res => {
                        this.LoanList = res.data;
                    })
                }
            },
            loanTypeChange(id){
                let search = null;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/search-loan/${id}/${search}`).then(res => {
                    this.LoanList = res.data;
                })
            },
            loadData() {
                //this.loanApplication.loan_type_id = 1;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/pay-instruction`).then(res => {
                    this.loanTypes=res.data.loanTypes;
                    //this.listItems = res.data.loans;
                    // this.totalItems = res.data.length;
                    this.monthList = res.data.monthYear;
                });
                this.onSearch(this.searchPayInstruction);
            },
            onSearch(data) {
                data = this.searchPayInstruction;
                if(this.searchPayInstruction.loan_no){
                    data.loan_no = this.searchPayInstruction.loan_no.loan_no;
                }
                console.log(data);
               // this.searchPayInstruction.loan_no = val.loan_no;
               // console.log(data);
                if (data.loan_type_id != null || data.month != null){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/loan/pay-instruction-data`,data).then(res => {
                        this.listItems = res.data;
                        this.totalItems = res.data.length;
                        for (let i in this.listItems) {
                            if (this.listItems[i].payment_instr_id != null)
                                this.indeterminate = true;
                            //this.listItems[i].payment_instr_id = this.listItems[i].payment_instr_id;
                            this.listItems[i].checkbox =  this.listItems[i].payment_instr_id != null ? '1' : '0';
                        }
                    });
                }
            },
            onFocusText() {
                this.visible = true;
                this.formattedData = this.temp;
            },
            thousandSeprator(amount) {
                if (amount !== '' || amount !== undefined || amount !== 0 || amount !== '0' || amount !== null) {
                    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                } else {
                    return amount;
                }
            },
            handleChange(input) {
                if (this.loanApplication.loan_type_id==2 && input > this.max_value)
                {
                    this.$bvModal.show('bv-modal-example');
                    this.loanApplication.application_amt=this.max_value;
                }
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
        }
    }
</script>

<style>
    .required label:after {
        content:"*";
        color: red;
    }
</style>
