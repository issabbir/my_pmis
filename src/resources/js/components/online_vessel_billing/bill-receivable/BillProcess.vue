<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Bill Processing</h4>
                        </div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                                    <!--<fieldset class="border p-2">-->
                                    <!--<legend class="w-auto"> Administrative Department Setup</legend>-->
                                    <b-row>
                                        <b-col>
                                            <b-row>
                                                <b-col lg="4">
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Registration/ROT No</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-select v-model="form.reg_no" :options="regNoList"></b-form-select>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Registration Date</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <date-picker v-model="form.datetime" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> </date-picker>
                                                        </b-col>
                                                    </b-row>

                                                </b-col>
                                                <b-col lg="4">
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Bill No</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input
                                                                v-model="form.bill_no"
                                                                required id="input-id"
                                                                type="text"
                                                                placeholder="Bill No">

                                                            </b-form-input>

                                                        </b-col>
                                                    </b-row>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Bill Date</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <date-picker v-model="form.datetime" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                                        </b-col>
                                                    </b-row>
                                                </b-col>

                                                <b-col lg="4">
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Exchange Rate</label>
                                                        </b-col>
                                                        <div class="col-md-8 form-group">
                                                            <b-form-input
                                                                v-model="form.exchange_rate"
                                                                required id="input-id" type="text"
                                                                placeholder="Exchange Rate">
                                                            </b-form-input>
                                                        </div>
                                                    </b-row>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Outer Date</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <date-picker v-model="form.datetime" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                                        </b-col>
                                                    </b-row>

                                                </b-col>

                                            </b-row>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col class="mt-2 d-flex justify-content-end">
                                            <b-button lg="6" size="md" variant="dark" type="submit" >Print</b-button>&nbsp;
                                        </b-col>
                                    </b-row>
                                    <!--</fieldset>-->
                                </b-form>
                            </div>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>

        </div>


    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker';
    export default {
        components: {DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Bill Receivable"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Vessel Billing"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Bill Process"});
        },
        data() {
            return {
                form: {
                    datetime: new Date(),
                },
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                tableData: {
                    fields: [{key: 'employee_id', label: 'ID'}, 'department_name', 'division_name', 'financial_code', 'shift', 'action'],
                    items: [
                        {
                            "employee_id": 1,
                            "department_name": "Traffic",
                            "division_name": "Chairman",
                            "financial_code": 90200,
                            "shift": 1,

                        },
                        {
                            "employee_id": 2,
                            "department_name": "Security",
                            "division_name": "Chairman",
                            "financial_code": 90550,
                            "shift": 2,

                        },
                        {
                            "employee_id": 3,
                            "department_name": "Finance & Accounts",
                            "division_name": "Member(Finace)",
                            "financial_code": 904800,
                            "shift": 1,

                        },
                        {
                            "employee_id": 4,
                            "department_name": "Audit & Inspection",
                            "division_name": "Member(Finace)",
                            "financial_code": 90490,
                            "shift": 1,

                        },
                        {
                            "employee_id": 5,
                            "department_name": "Computer Center",
                            "division_name": "Member(Finance)",
                            "financial_code": 90810,
                            "shift": 1,

                        },
                        {
                            "employee_id": 6,
                            "department_name": "Mechanical",
                            "division_name": "Member(Engineering)",
                            "financial_code": 90730,
                            "shift": 1,

                        },
                        {
                            "employee_id": 7,
                            "department_name": "Estate Affairs",
                            "division_name": "Member(Engineering)",
                            "financial_code": 90631,
                            "shift": 1,

                        },
                        {
                            "employee_id": 8,
                            "department_name": "Electrical",
                            "division_name": "Member(Engineering)",
                            "financial_code": 90720,
                            "shift": 1,

                        },
                        {
                            "employee_id": 9,
                            "department_name": "Civil Engineering",
                            "division_name": "Member(Engineering)",
                            "financial_code": 90720,
                            "shift": 1,

                        },
                        {
                            "employee_id": 10,
                            "department_name": "Store",
                            "division_name": "Member(Engineering)",
                            "financial_code": 90720,
                            "shift": 1,

                        }
                    ]
                },
                regNoList: [
                    {value: null, text: '01012365'},
                ],
                financial_code_options: [
                    {value: null, text: 'Please select'},
                    {value: 97040, text: '97040'},
                    {value: 97041, text: '97041'},
                    {value: 97042, text: '97042'},
                    {value: 97043, text: '97043'},
                    {value: 97044, text: '97044'},
                    {value: 97045, text: '97045'},
                    {value: 97046, text: '97046'},
                    {value: 90720, text: '90720'},
                    {value: 90631, text: '90631'},
                    {value: 90730, text: '90730'},
                    {value: 90810, text: '90810'},
                    {value: 90490, text: '90490'},
                ],
                shift_options: [
                    {value: null, text: 'Please select'},
                    {value: '1', text: '1'},
                    {value: '2', text: '2'},
                    {value: '3', text: '3'},
                    {value: '4', text: '4'},
                    {value: '5', text: '5'},
                    {value: '6', text: '6'},
                    {value: '7', text: '7'},
                ]

            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if (this.updateIndex > -1) { //update
                    this.tableData.items[this.updateIndex].employee_id = this.form.employee_id;
                    this.tableData.items[this.updateIndex].department_name = this.form.department_name;
                    this.tableData.items[this.updateIndex].designation = this.form.designation;
                    this.tableData.items[this.updateIndex].division_name = this.form.division_name;
                    this.tableData.items[this.updateIndex].financial_code = this.form.financial_code;
                    this.tableData.items[this.updateIndex].shift = this.form.shift;

                } else { //new data add
                    this.tableData.items.push({
                        employee_id: this.form.employee_id,
                        department_name: this.form.department_name,
                        designation: this.form.designation,
                        division_name: this.form.division_name,
                        financial_code: this.form.financial_code,
                        shift: this.form.shift,
                    });
                }
                this.onReset(evt);
            },
            onReset(evt) {
                evt.preventDefault();
                this.employee_id = '';
                this.department_name = '';
                this.designation = '';
                this.division_name = null;
                this.financial_code = null;
                this.shift = null;


                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });

            },
            editRow(i, code) {
                this.submitBtn = 'Update';
                this.updateIndex = i;
                let data = this.tableData.items[i];

                console.log(data);

                this.form.employee_id = data.employee_id;
                this.form.department_name = data.department_name;
                this.form.designation = data.designation;
                this.form.division_name = data.division_name;
                this.form.financial_code = data.financial_code;
                this.form.shift = data.shift;

                console.log(this.form);

            },
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            }

        }
    }
</script>

