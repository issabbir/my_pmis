<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Approval Details for GPF/CPF Loan</h4>
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
                                                <label>Emp Id</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="empId" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="name" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Designation</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="designation" disabled ></b-form-input>
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
                                                <label>Department</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="department" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Section</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="section" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Reason</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="reason" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="8">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="2">
                                                <label>Description</label>
                                            </b-col>
                                            <b-col md="10">
                                                <b-form-textarea v-model="description" disabled ></b-form-textarea>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>CPF/GPF No</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="cpfGpfNo" disabled ></b-form-input>
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
                                                <label>Account No</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="accountNo" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Applied Amount(TK)</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="appliedAmt" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Approved Amount(TK)</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="approvedAmt"></b-form-input>
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
                                                <label>Bill No</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="billNo" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                 
                                 <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Applied Installment</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="appliedInstlmnt" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Approved Installment</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="approvedInstlmnt"></b-form-input>
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
                                                <label>Age</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="age" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                 <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Date Of Approval</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="dateOfApproval" disabled ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Attachment</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-file
                                                    v-model="attachmnet"
                                                    :state="Boolean(file)"
                                                    drop-placeholder="Drop file here..."
                                                    ></b-form-file>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col class="mt-2 d-flex justify-content-end">
                                    <b-button md="6"  size="md" variant="success" type="submit" >Approved</b-button>&nbsp;
                                    <b-button md="6"  size="md" variant="dark" type="reset" >Reset</b-button>&nbsp;
                                    <b-button md="6" size="md" class="btn-outline-dark" href="/approval_service/#/approve-cpf" type="reset">Cancel</b-button>
                                </b-col>
                            </b-row>
                            <!--</fieldset>-->
                        </b-form>
                    </div>
                </b-card-text>
            </b-card>

        </div>


    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    export default {
        components: {DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Position"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Department"});
        },
        data() {
            return {
                interviwdate: new Date(),

                form: {
                    refno: '',
                    jobTitle: '',
                },
                departmntList: [{text: 'Finance & Account', value: 1}, {text: 'Administration', value: 2}],
                sectionList: [{text: 'Computer Center', value: 1}, {text: 'Billing', value: 2}],
                empList: [{text: 'Waker Khan', value: 1}, {text: 'Jamil', value: 2}],
                show: true,
                resultstatuslist: [{text: 'Pass', value: 1}, {text: 'Fail', value: 2}, {text: 'Expelled', value: 3}],
                boardactionlist: [{text: 'Interview', value: 1}, {text: 'Reject', value: 2}],
                fields: [{key: 'SL', label: 'Sl', sortable: true, sortDirection: 'desc'},
                    {key: 'empid', label: 'Emp Id', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'empname', label: 'Employee Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'appliedamt', label: 'Applied Amount', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'reason', label: 'Reason', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'installment', label: 'Installment', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'action'],
                items: [
                    {SL: '1', empid: '31', empname: 'Waker Khan', appliedamt: '100000', reason: 'House Building',
                        installment: '10', action: ''},
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

