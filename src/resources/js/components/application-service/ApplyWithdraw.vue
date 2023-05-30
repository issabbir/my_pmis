<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Application for Withdraw</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body mb-2">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                            <!--<fieldset class="border p-2">-->
                            <!--<legend class="w-auto"> Administrative Department Setup</legend>-->

                            <b-row>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Empoyee ID</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.empId" ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Employee</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.empName" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>

                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Bank</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="form.bankId" :options="bankList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Branch</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.branchId" ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>


                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Account No.</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.accNo"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>District</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="form.districtId" ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Apply Date</label>
                                            </b-col>
                                            <b-col md="8">
                                                <date-picker
                                                    v-model="applyDate"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    format="YYYY-MM-DD"
                                                    ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col class="mt-2 d-flex justify-content-end">
                                    <b-button md="6"  size="md" variant="dark" type="submit" >Submit</b-button>&nbsp;
                                    <b-button md="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                </b-col>
                            </b-row>
                            <!--</fieldset>-->
                        </b-form>
                    </div>
                </b-card-text>
            </b-card>
            <b-card>
                <b-row>
                    <b-col>
                        <b-card title="Academic Information List">
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

            </b-card>
        </div>


    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../layouts/common/datatable';
    export default {
        components: {DatePicker, Datatable},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Position"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Department"});
        },
        data() {
            return {
                effectDate: new Date(),
                form: {
                    empId: '',
                    empName: '',
                    bankId: null,
                    branchId: '',
                    accNo: '',
                    districtId: '',
                    applyDate: ''
                },
                bankList: [{text: 'Select One', value: null}, 'Sonali Bank', 'Rupali Bank'],
                //bankList: [{text: 'Select One', value: null}, {text: 'Sonali Bank', value: 1}, {text: 'Rupali Bank', value: 2}],
                show: true,
                fields: [{key: 'SL', label: 'Sl', sortable: true, sortDirection: 'desc'},
                    {key: 'empid', label: 'Emp Id', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'empName', label: 'Employee Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'bankId', label: 'Bank Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'accNo', label: 'Account No', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'applyDate', label: 'Apply Date', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'action'],
                items: [
                    {SL: '1', empid: '31', empName: 'Waker Khan', bankId: 'Sonali Bank', accNo: '1065656598563233',
                        applyDate: '10/01/2019', action: ''},
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
                this.submitBtn = 'Process';
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

