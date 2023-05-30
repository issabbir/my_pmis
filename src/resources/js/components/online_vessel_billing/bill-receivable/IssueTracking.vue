<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Issue Tracking & Checking</h4>
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
                                                <label>Issue No</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="issueTracker.issueNo" disabled></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Bill No</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="issueTracker.billNo"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Bill Date</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="issueTracker.billDate"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Issue Status</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="issueTracker.issueStatus":options="issueStatusList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Issue Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="issueTracker.issueName"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Registration/ROT No</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="issueTracker.registrationNo":options="registrationNoList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Agent Code</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="issueTracker.agentCode":options="agentCodeList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Assign Employee</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="issueTracker.assignEmp":options="assignEmpList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Issue Description</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="issueTracker.issueDescription"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Issue Date</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="issueTracker.issueDate"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Deck Cargo</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="issueTracker.deckCargo"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Closing Status</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="issueTracker.closingStatus"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row class="mt-3">
                                <b-col class="d-flex justify-content-end">
                                    <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Save</b-button> &nbsp;
                                    <b-button type="submit" class="btn btn-dark shadow mb-1">Approved & Forward</b-button> &nbsp;
                                </b-col>
                            </b-row>
                        </b-form>
                    </div>
                    <div class="mt-2 d-flex justify-content-end">
                  <p style="color:red;">Reverse Journal button enable according to backend.</p>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Bill Receivable"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Vessel Service"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Issue Tracking"});
        },
        data() {
            return {
                voucherDate: new Date(),
                accountingDate: new Date(),
                issueTracker: {

                },
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                issueStatusList: [
                    {value: 1, text: 'Incomplete'},
                    {value: '2', text: 'Complete'},
                    {value: '3', text: 'Approved'},
                    {value: '4', text: 'In Process'},
                    {value: '5', text: 'Reject'}]
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

