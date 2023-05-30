<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Department Approval</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body mb-2">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                            label="Employee ID"
                                            label-for="employee_id"
                                    >
                                        <b-form-input
                                                id="employee_id"
                                                v-model="departmentalApproval.employeeId = 1126186"
                                                type="text"
                                                required
                                                placeholder="Employee ID"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                            label="Name"
                                            label-for="name"
                                    >
                                        <b-form-input
                                                id="name"
                                                type="text"
                                                required
                                                placeholder=""
                                                value="Mrs. Anita Prova Chowdhury"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                            label="LAST DESIGNATION"
                                            label-for="last_designation"
                                    >
                                        <b-form-input
                                                id="name"
                                                type="text"
                                                required
                                                placeholder=""
                                                value="Metron"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                            label="LAST DEPARTMENT"
                                            label-for="last_department"
                                    >
                                        <b-form-input
                                                id="name"
                                                type="text"
                                                required
                                                placeholder=""
                                                value="Medical department"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            label="Retirement allowance decreases (BDT)"
                                            label-for="retirement_allowance_decreases"
                                    >

                                        <b-form-input
                                                id="retirement_allowance_decreases"
                                                v-model="departmentalApproval.retirement_allowance_decreases"
                                                placeholder="Retirement allowance decreases"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                            label="Amount of gratuity reduction (BDT)"
                                            label-for="amount_of_gratuity_reduction"
                                    >

                                        <b-form-input
                                                id="amount_of_gratuity_reduction"
                                                v-model="departmentalApproval.amount_of_gratuity_reduction"
                                                placeholder="Amount of gratuity reduction"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            label="The retirement allowance is payable after this reduction (BDT)"
                                            label-for="retirement_allowance_decreases"
                                    >
                                        <b-form-input
                                                id="retirement_allowance_decreases"
                                                v-model="departmentalApproval.retirement_allowance_after_decreases"
                                                placeholder="The retirement allowance is payable after this reduction"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                            label="This appearance is gratifying after the reduction (BDT)"
                                            label-for="amount_of_gratuity_reduction"
                                    >
                                        <b-form-input
                                                id="amount_of_gratuity_reduction"
                                                v-model="departmentalApproval.amount_of_gratuity_after_reduction"
                                                placeholder="This appearance is gratifying after the reduction"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                            label="Applicable date of Retirement allowance"
                                            label-for="applicable_date"
                                    >
                                        <date-picker
                                                v-model="departmentalApproval.applicable_date"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                format="YYYY-MM-DD"></date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                            label="Signed by"
                                            label-for="signed_by"
                                    >

                                        <b-form-input
                                                id="signed_by"
                                                v-model="departmentalApproval.signed_by"
                                                placeholder="Signed by"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col class="mt-2">
                                    <b-form-checkbox
                                            id="approved"
                                            v-model="departmentalApproval.status"
                                            name="approved"
                                            value="1"
                                            unchecked-value="0">
                                        Approved
                                    </b-form-checkbox>
                                </b-col>
                            </b-row>

                            <b-row>
                                <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                    <b-button type="submit" id="basic_sub_btn"
                                              class="btn btn-dark shadow mr-1 mb-1">Submit
                                    </b-button>
                                    <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">
                                        Cancel
                                    </b-button>
                                </div>
                            </b-row>
                        </b-form>
                    </div>
                </b-card-text>
            </b-card>
            <!-- Zero configuration table -->
            <section id="basic-datatable">
                <b-row >
                    <b-col >
                        <b-card class="card">
                            <div class="card-content">
                                <b-card-text class="card-body">
                                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" >
                                        <template v-slot:actions="{ rows }">
                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item.holiday_id)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                        </template>
                                    </Datatable>
                                </b-card-text>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>
            </section>
            <!--/ Zero configuration table -->
        </div>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../layouts/common/datatable';
    import Repo from '../../Repository/ApiRepository';

    export default {
        components: {DatePicker, Datatable},
        props: ['id'],
        data() {
            return {
                departmentalApproval: {},
                employeeTitleList: [
                    {text: 'MR.', value: 'MR.'},
                    {text: 'MRS.', value: 'MRS.'}
                ],
                options: [
                    {text: 'Male', value: ''},
                    {text: 'Female', value: 'second'},
                    {text: 'Other', value: 'third'}
                ],

                tableData: {
                    fields: [{key:'id', label: 'ID', sortable:true}, {key:'name', label: 'Name', sortable:true}, {key:'last_designation', label: 'Last designation', sortable:true}, {key:'last_department', label: 'Last department', sortable:true}, {key:'status', label: 'Status', sortable:true}, 'Action'],
                    items:[
                        {
                            id: 1,
                            name: 'Mrs. Anita Prova Chowdhury',
                            last_designation: 'Metron',
                            last_department: 'Medical department',
                            status: 'Approved'
                        }
                    ]
                },
                show: true
            }
        },
        mounted() {
            /*Repo.callApi(Repo.GET_COMMAND, "/pmis/employee/basic-info").then(res => {
                let i = {};
                let id = this.$route.params.id;
                res.forEach(function(item) {
                    if (item.empId == id)
                        i = item;
                });
                this.prlApplication = i;
            });*/
            console.log(this.departmentalApproval);
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Approval Service"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Departmental Approval"});
        },
        methods: {
            onSubmit(evt) {
                let id = this.$route.params.id;
                let pimaryKey = "";
                let pimaryValue = ""
                if (id) {
                    pimaryKey = "empId";
                    pimaryValue = id;
                }
                evt.preventDefault();
                /*Repo.callApi(Repo.POST_COMMAND, "/pmis/employee/basic-info", this.prlApplication, pimaryKey, pimaryValue).then(res => {
                    console.log(res.data);
                });*/
            },
            onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.form.email = '';
                this.form.name = '';
                this.form.food = null;
                this.form.checked = [];
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
            }
        }
    }
</script>