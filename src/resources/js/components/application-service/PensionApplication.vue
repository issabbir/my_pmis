<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Pension Application</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body mb-2">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                            label="Employee ID"
                                            label-for="employee_id"
                                    >
                                        <b-form-input
                                                id="employee_id"
                                                v-model="pensionApplication.employeeId = 1126186"
                                                type="text"
                                                required
                                                placeholder="Employee ID"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="2">
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

                                <b-col md="2">
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

                                <b-col md="2">
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

                                <b-col md="2">
                                    <b-form-group
                                            label="Application to"
                                            label-for="to"
                                    >
                                        <b-form-input
                                                id="fname"
                                                v-model="pensionApplication.to"
                                                type="text"
                                                required
                                                placeholder="Application to"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="2">
                                    <b-form-group
                                            label="PRL DATE"
                                            label-for="prl_date"
                                    >
                                        <date-picker
                                                v-model="pensionApplication.prl_date"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                format="YYYY-MM-DD"></date-picker>
                                    </b-form-group>
                                </b-col>

                                <b-col md="2">
                                    <b-form-group
                                            label="PERMANENT RETIREMENT DATE"
                                            label-for="permanent_retirement_date"
                                    >
                                        <date-picker
                                                v-model="pensionApplication.permanent_retirement_date"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                format="YYYY-MM-DD"></date-picker>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <hr />
                            <b-row>
                                <b-col class="border ml-1 mr-1 p-2">
                                    <b-row>
                                        <b-col>
                                            <b-row>
                                                <b-col md="1">
                                                    <b-form-group label="SL" label-for="sl"></b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                            label="Nominee's Name"
                                                            label-for="nominee_name"
                                                    >

                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                            label="Date of Birth"
                                                            label-for="date-of-birth"
                                                    >
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                            label="Relationship with Nominee"
                                                            label-for="relationship_nominee"
                                                    >
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                            label="Percent(%)"
                                                            label-for="nominee_percentage"
                                                    >
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                            label="Marital status"
                                                            label-for="nominee_marital_status"
                                                    >
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="1">
                                                    Action
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <hr />
                                    <b-row v-for="(nominee, index) in pensionApplication.nominees" :key="index">
                                        <b-col>
                                            <b-row>
                                                <b-col md="1">
                                                    {{ index+1 }}
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                            label=""
                                                            label-for="nominee_name"
                                                    >
                                                        <b-form-input
                                                                id="nominee_name"
                                                                v-model="nominee.nominee_name"
                                                                type="text"
                                                                required
                                                                placeholder="Nominee's Name"
                                                        ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                            label=""
                                                            label-for="date-of-birth"
                                                    >
                                                        <date-picker
                                                                v-model="nominee.nominee_date_of_birth"
                                                                width="100%"
                                                                input-class="form-control"
                                                                type="date"
                                                                lang="en"
                                                                format="YYYY-MM-DD"></date-picker>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                            label=""
                                                            label-for="relationship_nominee"
                                                    >
                                                        <b-form-input
                                                                id="relationship_nominee"
                                                                v-model="nominee.relationship_nominee"
                                                                type="text"
                                                                required
                                                                placeholder="Relationship with Nominee"
                                                        ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                            label=""
                                                            label-for="nominee_percentage"
                                                    >
                                                        <b-form-input
                                                                id="nominee_percentage"
                                                                v-model="nominee.nominee_percentage"
                                                                type="text"
                                                                required
                                                                placeholder="Percent(%)"
                                                        ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group
                                                            label=""
                                                            label-for="nominee_marital_status"
                                                    >
                                                        <b-form-select v-model="nominee.nominee_marital_status" class="select2 form-control" id="nominee_marital_status" name="nominee_marital_status">
                                                            <option value="Married">Married</option>
                                                            <option value="Unmarried">Unmarried</option>
                                                        </b-form-select>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="1">
                                                    <button type="button" @click.prevent="removeNominee(index)" class="btn btn-block btn-danger text-white">
                                                        <i class="bx bx-trash cursor-pointer"></i>
                                                    </button>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <button type="button" @click.prevent="addNominee" class="btn btn-success text-white" :disabled="disabled">
                                                <i class="bx bx-plus cursor-pointer"></i>
                                            </button>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>

                            <hr />

                            <b-row>
                                <b-col md="4">
                                    <b-form-group label="Branch Name of Sonali Bank" label-for="branch_of_sonali_bank">
                                        <b-form-input
                                                id="branch_of_sonali_bank"
                                                v-model="pensionApplication.branch"
                                                type="text"
                                                required
                                                placeholder="Branch Name of Sonali Bank"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group label="Account Type" label-for="account_type">
                                        <b-form-select v-model="pensionApplication.accountType" class="">
                                            <option value="2">Current Account</option>
                                            <option value="1">Savings Account</option>
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group label="Account No" label-for="account_no">
                                        <b-form-input
                                                id="account_no"
                                                v-model="pensionApplication.accountNo"
                                                type="text"
                                                required
                                                placeholder="Account no"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <hr />

                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                            label="Full signature"
                                            label-for="full_signature"
                                    >
                                        <b-form-file id="full_signature" v-model="pensionApplication.full_signature" placeholder="Full Signature"></b-form-file>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                            label="Short signatrure"
                                            label-for="short_signature"
                                    >
                                        <b-form-file id="short_signature" v-model="pensionApplication.short_signature" placeholder="Short Signature"></b-form-file>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3" class="mt-2">
                                    <b-form-file v-model="pensionApplication.lthumb" class="mt-3" id="lthumb" plain hidden></b-form-file>
                                    <label style="width:100%" tabindex="0" for="lthumb" class="btn btn-primary ">L Thumb</label>
                                </b-col>
                                <b-col md="3" class="mt-2">
                                    <b-form-file v-model="pensionApplication.rthumb" class="mt-3" id="rthumb" plain hidden></b-form-file>
                                    <label style="width:100%" tabindex="0" for="rthumb" class="btn btn-primary ">R Thumb</label>
                                </b-col>
                            </b-row>

                            <hr />
                            <b-row>
                                <b-col>
                                    <b-form-group
                                            label="Applicant's present address"
                                            label-for="present_address"
                                    >
                                        <b-form-textarea
                                                id="present_address"
                                                v-model="pensionApplication.present_address"
                                                placeholder="Applicant's present address"
                                                rows="3"
                                                max-rows="6"
                                        ></b-form-textarea>
                                    </b-form-group>
                                </b-col>

                                <b-col>
                                    <b-form-group
                                            label="Applicant's permanent address"
                                            label-for="permanent_address"
                                    >
                                        <b-form-textarea
                                                id="permanent_address"
                                                v-model="pensionApplication.permanent_address"
                                                placeholder="Applicant's permanent address"
                                                rows="3"
                                                max-rows="6"
                                        ></b-form-textarea>
                                    </b-form-group>
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
                                            <b-link class="text-danger" @click="deleteRow(rows.item.holiday_id)">
                                                <i class="bx bx-trash cursor-pointer"></i>
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
                disabled: false,
                nominee: {nominee_name: '', nominee_date_of_birth: '', relationship_nominee: '', nominee_percentage: '', nominee_marital_status: ''},
                pensionApplication: {
                    nominees: [
                        {nominee_name: '', nominee_date_of_birth: '', relationship_nominee: '', nominee_percentage: '', nominee_marital_status: ''},
                    ]
                },
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
                    fields: [{key:'id', label: 'ID', sortable:true}, {key:'name', label: 'Name', sortable:true}, {key:'last_designation', label: 'Last designation', sortable:true}, {key:'last_department', label: 'Last department', sortable:true}, {key:'to', label: 'Application To', sortable:true}, 'Action'],
                    items:[
                        {
                            id: 1,
                            name: 'Mrs. Anita Prova Chowdhury',
                            last_designation: 'Metron',
                            last_department: 'Medical department',
                            to: 'Chief Medical Officer'
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
                this.pensionApplication = i;
            });*/
            console.log(this.pensionApplication);
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Application Service"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PRL Application"});
        },
        methods: {
            addNominee: function () {
                this.pensionApplication.nominees.push(Vue.util.extend({}, this.nominee));
                if(this.pensionApplication.nominees.length > 8) {
                    this.disabled = true;
                } else {
                    this.disabled = false;
                }
            },
            removeNominee: function(index) {
                Vue.delete(this.pensionApplication.nominees, index);
                if(this.pensionApplication.nominees.length < 9) {
                    this.disabled = false;
                } else {
                    this.disabled = true;
                }
            },
            onSubmit(evt) {
                let id = this.$route.params.id;
                let pimaryKey = "";
                let pimaryValue = ""
                if (id) {
                    pimaryKey = "empId";
                    pimaryValue = id;
                }
                evt.preventDefault();
                /*Repo.callApi(Repo.POST_COMMAND, "/pmis/employee/basic-info", this.pensionApplication, pimaryKey, pimaryValue).then(res => {
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

