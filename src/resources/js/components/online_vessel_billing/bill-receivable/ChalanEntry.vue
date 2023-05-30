<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Chalan Entry</h4>
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
                                                <label>Chalan No</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="chalanEntry.chalanNo"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Chalan Amount</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="chalanEntry.chalanAmt"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Chalan Date</label>
                                            </b-col>
                                            <b-col md="8">
                                                <date-picker
                                                    v-model="chalanEntry.chalanDate"
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
                                <b-col md="4">

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>PO No</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="chalanEntry.poNO"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Party Code</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="chalanEntry.partyCode"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Party Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-input v-model="chalanEntry.partyName"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>PO Date</label>
                                            </b-col>
                                            <b-col md="8">
                                                <date-picker
                                                    v-model="chalanEntry.poDate"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    format="YYYY-MM-DD"
                                                    ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>

                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Bank Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select multiselect v-model="chalanEntry.bank":options="bankList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                    <b-form-group>
                                        <b-row>
                                            <b-col md="4">
                                                <label>Branch Name</label>
                                            </b-col>
                                            <b-col md="8">
                                                <b-form-select v-model="chalanEntry.branch":options="branchList"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>


                            <b-row class="mt-3">
                                <b-col class="d-flex justify-content-end ">
                                    <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Save & Print</b-button> &nbsp;
                                </b-col>
                            </b-row>
                        </b-form>
                    </div>
                </b-card-text>
                <b-card-text class="card-content">
                        <b-table
                            striped
                            hover
                            show-empty
                            small
                            :items="chalanItems"
                            :current-page="currentPage"
                            :per-page="perPage"
                            :filter="filter"
                            :sort-by.sync="sortBy"
                            :sort-desc.sync="sortDesc"
                            :sort-direction="sortDirection"
                            :fields="chalanFields"
                            responsive>
                            <template v-slot:cell(billNo)="row">
                                  <b-form-input v-model="chalanEntry.billNo"></b-form-input>
                            </template>
                            <template v-slot:cell(billDate)="row">
                                      <date-picker
                                    v-model="chalanEntry.billDate"
                                    input-class="form-control"
                                    type="date"
                                    lang="en"
                                    format="YYYY-MM-DD"></date-picker>
                            </template>
                            <template v-slot:cell(nameOfVessel)="row">
                                  <b-form-input v-model="chalanEntry.nameOfVessel"></b-form-input>
                            </template>
                            <template v-slot:cell(natureOfAccounts)="row">
                                  <b-form-input v-model="chalanEntry.natureOfAccounts"></b-form-input>
                            </template>
                            <template v-slot:cell(billAmt)="row">
                                  <b-form-input v-model="chalanEntry.billAmt"></b-form-input>
                            </template>
                            <template v-slot:cell(remarks)="row">
                                  <b-form-input v-model="chalanEntry.remarks"></b-form-input>
                            </template>
                        </b-table>
                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-start">
                                <b-button md="6"  size="md" variant="success" type="submit" >Add</b-button>&nbsp;
                            </b-col>
                        </b-row>
                </b-card-text>
                <br/>
                <br/>
                <br/>
                <br/>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Vessel Billing"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Chalan Entry"});
        },
        data() {
            return {
                voucherDate: new Date(),
                accountingDate: new Date(),
                chalanEntry: {

                },
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                issueStatusList: [
                    {value: 1, text: 'Accepted'},
                    {value: '2', text: 'Not Accepted'},
                    {value: '2', text: 'In Process'}],
                chalanFields: [{key: 'num', label: 'Sl', sortable: true, sortDirection: 'desc'},
                    {key: 'billNo', label: 'Bill No', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'billDate', label: 'Bill Date', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'nameOfVessel', label: 'Name Of Vessel', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'natureOfAccounts', label: 'Nature Of Accounts'},
                    {key: 'billAmt', label: 'Bill Amount', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'remarks', label: 'Remarks', sortable: true, sortDirection: 'desc', class: 'text-center'}],
                chalanItems: [
                    {num: '', billNo: '', billDate: '', nameOfVessel: '', natureOfAccounts: '',
                        billAmt: '', remarks: ''},
                ],

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

