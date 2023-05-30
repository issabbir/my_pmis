<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Application for PF Calculation</b-card-header>
                <b-card-body class="border">
                    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                        <!----<b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>-->
                        <!--<fieldset class="border p-2">-->
                        <!--<legend class="w-auto"> Administrative Department Setup</legend>-->

                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="PF ID"
                                    label-for="PF ID"
                                >
                                    <b-form-input
                                        id="result"
                                        v-model="form.pf_id"
                                        type="text"
                                        required
                                        placeholder="PF ID"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Code No"
                                    label-for="Code No"
                                >
                                    <b-form-input
                                        id="result"
                                        v-model="form.code_no"
                                        type="text"
                                        required
                                        placeholder="Code No"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Empoyee ID"
                                    label-for="Empoyee ID"
                                >
                                    <b-form-input
                                        id="result"
                                        v-model="form.empId"
                                        type="text"
                                        required
                                        placeholder="Empoyee ID"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Employee Name"
                                    label-for="Employee Name"
                                >
                                    <b-form-input
                                        id="result"
                                        v-model="form.empName"
                                        type="text"
                                        required
                                        placeholder="Name"
                                        disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Bank"
                                    label-for="Bank"
                                >
                                    <b-form-select v-model="form.bankId"
                                                    :options="bankList"></b-form-select>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Designation"
                                    label-for="Designation"
                                >
                                    <b-form-select v-model="form.designation_id"
                                                    :options="designationList"></b-form-select>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Pay Scale"
                                    label-for="Pay Scale"
                                >
                                    <b-form-select v-model="form.pay_scale_id"
                                                    :options="payscaleList"></b-form-select>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Basic salary"
                                    label-for="Basic salary"
                                >
                                    <b-form-input
                                        id="result"
                                        v-model="form.basic_salary"
                                        type="text"
                                        required
                                        placeholder="Name"
                                        disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Appointment Date"
                                    label-for="date"

                                >
                                    <date-picker v-model="form.appointDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Retirement Leave Date"
                                    label-for="date"

                                >
                                    <date-picker v-model="form.retLeaveDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Retirement Date"
                                    label-for="date"

                                >
                                    <date-picker v-model="form.retireDate" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Service Period"
                                    label-for="Service Period"
                                >
                                    <b-form-input
                                        id="result"
                                        v-model="form.ser_period"
                                        type="text"
                                        required
                                        placeholder="Name"
                                        disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col md="12">
                                <b-form-group
                                    label="Retirement Reasons"
                                    label-for="Retirement Reasons"
                                >
                                        <b-textarea md="6" rows="3">
                                            <b-form-input v-model="form.retire_reason"></b-form-input>
                                        </b-textarea>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="col-md-12 col-12">
                                <fieldset class="border p-2">
                                    <legend class="w-auto">Comments</legend>
                                    <b-row>

                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Own Subscription</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="form.our_subcription"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Amount (Tk.)</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="form.sub_amt"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Authoritative Donation</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="form.auth_donation"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Amount (Tk.)</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="form.donation_amt"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col md="6">
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Total Amount (Tk.)</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="form.tot_amount"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col md="6">
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Deductions</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="form.deduction"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col md="6">
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>Net Amount</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="form.net_amount" disabled></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button md="6" size="md" variant="dark" type="submit">Submit</b-button>&nbsp;
                                <b-button md="6" size="md" class="btn-outline-dark" type="reset">Cancel</b-button>
                            </b-col>
                        </b-row>
                        <!--</fieldset>-->
                    </b-form>
                </b-card-body>
            </b-card>
            <!--<b-card>
                <b-row>
                    <b-col>
                        <b-card title="Withdraw Information List">
                            <template>
                                <div class="content-wrapper">
                                    <div class="content-body">
                                        <Datatable v-bind:fields="fields"
                                                   v-bind:items="items">
                                            <template slot="actions" v-bind:row="row">
                                                <a size="sm" class="text-primary" href=""
                                                   data-toggle="modal"
                                                   data-target="#border-less"><i
                                                    class="bx bx-edit cursor-pointer"></i>
                                                </a>
                                                <a size="sm" class="text-primary" href=""
                                                   data-toggle="modal"
                                                   data-target="#border-details"><i
                                                    class="bx bx-show cursor-pointer"></i></a>
                                            </template>
                                        </Datatable>
                                    </div>
                                </div>
                            </template>
                        </b-card>
                    </b-col>

                </b-row>

            </b-card>-->
        </div>
    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable';

    export default {
        components: {DatePicker, Datatable},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PF Calculation"});
        },
        data() {
            return {
                applyDate: new Date(),
                form: {
                    empId: '',
                    empName: '',
                    bankId: null,
                    branchId: null,
                    accNo: '',
                    districtId: null,
                    applyDate: '',
                    pay_scale_id: null
                },
                bankList: [{text: 'Select One', value: null}, 'Sonali Bank', 'Rupali Bank', 'Pubali Bank', 'NRB Commercial Bank'],
                branchList: [{text: 'Select One', value: null}, 'Mirpur Branch', 'Dhanmondi Branch', 'Agrabad Branch', 'Mohammadpur Branch'],
                districtList: [{text: 'Select One', value: null}, 'Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Sylhet'],
                payscaleList: [{text: 'Select One', value: null}, '1st', '2nd', '3rd', '4th', '5th'],
                designationList: [{
                    text: 'Select One',
                    value: null
                }, 'Chairman', 'General Manager (A & F)', 'General Manager (Admin)', 'Head Of ICT'],
                show: true,
                fields: [{key: 'SL', label: 'Sl', sortable: true, sortDirection: 'desc'},
                    {key: 'empid', label: 'Emp Id', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {
                        key: 'empName',
                        label: 'Employee Name',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-center'
                    },
                    {key: 'bankId', label: 'Bank Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'accNo', label: 'Account No', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {
                        key: 'applyDate',
                        label: 'Apply Date',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-center'
                    },
                    'action'],
                items: [
                    {
                        SL: '1', empid: '31', empName: 'Waker Khan', bankId: 'Sonali Bank', accNo: '1065656598563233',
                        applyDate: '10/01/2019', action: ''
                    },
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                },
            }
        },
        methods: {
            onSubmit(evt) {

                evt.preventDefault()
                console.log(JSON.parse(JSON.stringify(this.academic)));

            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.empId = '',
                    this.form.bankId = null,
                    this.form.branchId = null,
                    this.form.accNo = '',
                    this.form.districtId = null,
                    this.form.applyDate = '',
                    this.form.pay_scale_id = null
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })

            },
            /*editRow(i, code) {

            },*/
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            }

            /*onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }*/

        }
    }
</script>

