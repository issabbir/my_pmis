<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <b-card-header class="card-header">
                            <h4 class="card-title">Employee Wise Salary Allocation Setup</h4>
                        </b-card-header>
                        <div class="card-content">
                            <b-card-text class="mb-2 card-body">

                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>

                                    <b-row>
                                        <b-col lg="6"c>

                                            <b-row >
                                                <b-col lg="6">
                                                    <b-form-group>
                                                        <label>Emp ID</label>
                                                        <b-form-input v-model="employeeSalary.empID"   value="123" required type="text" placeholder="ID"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col lg="6">
                                                    <b-form-group>
                                                        <label>Department</label>
                                                        <b-form-input  v-model="employeeSalary.department" value="Computer Center" required type="text" placeholder="Department"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                <b-col>
                                                    <b-form-group>
                                                        <label>Section</label>
                                                        <b-form-input v-model="employeeSalary.section"   value="28511" required type="text" placeholder="section"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row>

                                                <b-col>
                                                    <b-form-group>
                                                        <label>Net Pay Amount</label>
                                                        <b-form-input v-model="employeeSalary.netPayAmount" value="28511" required type="text" placeholder="petpayamount"></b-form-input>
                                                    </b-form-group>
                                                </b-col>

                                            </b-row>
                                            <fieldset class="border p-2">
                                                <legend class="w-auto ">Allowances</legend>
                                                <!-- Zero configuration table -->
                                                <section >
                                                    <b-row>
                                                        <b-col>
                                                            <b-card class="card">
                                                                <div class="card-content">
                                                                    <b-card-text class="card-body">

                                                                        <Datatable v-bind:fields="tableDataAllowancs.fields" v-bind:items="tableDataAllowancs.items"  v-bind:pageColSize="4" v-bind:searchColSize="5">
                                                                            <template v-slot:action2="{ rows }">
                                                                                <b-form-checkbox></b-form-checkbox>
                                                                            </template>
                                                                            <template v-slot:actions="{ rows }">
                                                                                <b-link ml="4" class="text-primary"
                                                                                        @click="editRow(rows.item.id, rows.item.id)">
                                                                                    <i class="bx bx-edit cursor-pointer"></i>
                                                                                </b-link>
                                                                                <b-link class="text-danger" @click="deleteRow(rows.item.id, rows.item.id)">
                                                                                    <i class="bx bx-trash cursor-pointer"></i>
                                                                                </b-link>
                                                                            </template>
                                                                        </Datatable>

                                                                        <b-row class="mt-2">
                                                                            <b-col lg='4'>
                                                                                <label>Total Allowance Amount</label>
                                                                            </b-col>
                                                                            <b-col lg="3" class="form-group ">
                                                                                <b-form-input v-model="employeeSalary.allownceAmount" required type="text" placeholder="5468"></b-form-input>
                                                                            </b-col>
                                                                        </b-row>

                                                                    </b-card-text>
                                                                </div>
                                                            </b-card>
                                                        </b-col>
                                                    </b-row>
                                                </section>
                                                <!--/ Zero configuration table -->
                                            </fieldset>
                                        </b-col>

                                        <b-col lg="6">
                                            <b-col>
                                                <b-form-group>
                                                    <label>Name</label>
                                                    <b-form-input  v-model="employeeSalary.name" value="Mohammad Waker Khan"  required type="text" placeholder="Name"></b-form-input>
                                                </b-form-group>
                                            </b-col>

                                            <b-col>
                                                <b-form-group>
                                                    <label>Designation</label>
                                                    <b-form-input  v-model="employeeSalary.designation" required type="text" value="Sr. Computer Operator" placeholder="Designation"></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col>
                                                <b-form-group>
                                                    <label>Type</label>
                                                    <b-form-input  v-model="employeeSalary.type" value="Officer" required type="text" placeholder="Officer"></b-form-input>
                                                </b-form-group>
                                            </b-col>

                                            <fieldset class="border p-2">
                                                <legend class="w-auto ">Deduction</legend>
                                                <!-- Zero configuration table -->
                                                <section >
                                                    <b-row>
                                                        <b-col >
                                                            <b-card class="card">
                                                                <div class="card-content">
                                                                    <b-card-text>
                                                                        <b-row >
                                                                            <b-col >
                                                                                <Datatable v-bind:fields="tableDataAllowancs.fields" v-bind:items="tableDataAllowancs.items"  v-bind:pageColSize="4" v-bind:searchColSize="5">
                                                                                    <template v-slot:action2="{ rows }">
                                                                                        <b-form-checkbox></b-form-checkbox>
                                                                                    </template>

                                                                                    <template v-slot:actions="{ rows }">
                                                                                        <b-link ml="4" class="text-primary"
                                                                                                @click="editRow(rows.item.id, rows.item.id)">
                                                                                            <i class="bx bx-edit cursor-pointer"></i>
                                                                                        </b-link>
                                                                                        <b-link class="text-danger" @click="deleteRow(rows.item.id, rows.item.id)">
                                                                                            <i class="bx bx-trash cursor-pointer"></i>
                                                                                        </b-link>
                                                                                    </template>
                                                                                </Datatable>
                                                                            </b-col>
                                                                        </b-row>
                                                                        <b-row class="mt-2">
                                                                            <b-col lg='4'>
                                                                                <label>Total Deduction Ammount</label>
                                                                            </b-col>
                                                                            <b-col lg="3" class="form-group ">
                                                                                <b-form-input v-model="employeeSalary.deductionAmount"  required type="text" placeholder="5468"></b-form-input>
                                                                            </b-col>
                                                                        </b-row>
                                                                    </b-card-text>
                                                                </div>
                                                            </b-card>
                                                        </b-col>
                                                    </b-row>
                                                </section>
                                                <!--/ Zero configuration table -->
                                            </fieldset>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="mt-2 d-flex justify-content-end">
                                            <b-button lg="6" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                            <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                    <!-- </fieldset>-->
                                </b-form>

                            </b-card-text>
                        </div>
                    </b-card>
                </b-col>
            </b-row>


        </div>


    </div>
</template>


<script>
    import Datatable from '../../../layouts/common/datatable';
    export default {
        components: {
            Datatable
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Salary Setup"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Salary Head" });
        },
        data() {
            return {
                employeeSalary: { },
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                tableDataAllowancs: {
                    fields: [{key:'action2', label:'Select'},{key:'id', sortable:true}, {key:'salary_head', sortable:true}, {key:'amount', sortable:true}, {key:'payment', sortable:true},'action'],
                    items: [
                        {
                            "action2": "",
                            "id": 1,
                            "salary_head": 'Port Allowance',
                            "amount": "5600",
                            "payment": "Full",
                            "action": ""
                        },
                    ]
                },
                holiday_type_options: [
                    {value: null, text: 'Please select'},
                    {value: 'Fixed', text: 'Fixed'},
                    {value: 'Changeable', text: 'Changeable'},
                ],
                status_options: [
                    {value: null, text: 'Please select'},
                    {value: 'Full Day', text: 'Full Day'},
                    {value: 'Half Day', text: 'Half Day'},
                ],
                emp_type_options: [
                    {value: 'All', text: 'All'},
                    {value: 'Officer', text: 'Officer'},
                    {value: 'Staff', text: 'Staff'},
                ],
                coa_code_options: [
                    {value: null, text: 'Please select'},
                    {value: '8000-Salary Allowance', text: '8000-Salary Allowance'},
                    {value: '8000-Salary Allowance', text: '8000-Salary Allowance'},
                    {value: '9000-Salary Allowance', text: '9000-Salary Allowance'},
                    {value: '10000-Salary Allowance', text: '10000-Salary Allowance'},
                    {value: '11000-Salary Allowance', text: '11000-Salary Allowance'},
                    {value: '12000-Salary Allowance', text: '12000-Salary Allowance'},
                ],
                department_options: [
                    {value: null, text: 'Please select'},
                    {value: 'Finance & Accounting', text: 'Finance & Accounting'},
                    {value: 'Administration', text: 'Administration'},
                    {value: 'Hydrography', text: 'Hydrography'},
                ],
                religion_options: [
                    {value: 'Islam', text: 'Islam'},
                    {value: 'Christan', text: 'Christan'},
                    {value: 'Buddhu', text: 'Buddhu'},
                    {value: 'Hindu', text: 'Hindu'},
                    {value: 'Tribal Only', text: 'Tribal Only'},
                ],
                checkopt: [
                    {value: '', text: ''},
                ]

            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                console.log(this.employeeSalary);
                // if (this.updateIndex > -1) { //update
                //     this.tableData.items[this.updateIndex].id = this.form.id;
                //
                // } else { //new data add
                //     this.tableData.items.push({
                //         id: this.form.id,
                //     });
                // }
                // this.onReset(evt);
            },
            onReset(evt) {
                evt.preventDefault();
                this.id = '';

                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });

            },
            editRow(i) {
                this.submitBtn = 'Update';
                this.updateIndex = i;
                let data = this.tableData.items[i];
                console.log(data);

            },
            deleteRow(i) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            }

        }
    }
</script>

