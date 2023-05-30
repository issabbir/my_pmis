<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">

                <b-card-text class="card-content">
                    <div class="card-body mb-2">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <!----<b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>-->
                            <!--<fieldset class="border p-2">-->
                            <!--<legend class="w-auto"> Administrative Department Setup</legend>-->

                            <b-row>
                                <b-col md="12">
                                     <h4 class="card-title">Application for PF Statement</h4>
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
                                        label="Educational Qualification"
                                        label-for="Designation"
                                    >
                                        <b-form-select v-model="form.edu_qualific_id"
                                                       :options="qualificationList"></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Race"
                                        label-for="Race"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.race"
                                            type="text"
                                            required
                                            placeholder="Race"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Residence"
                                        label-for="Residence"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.residence_id"
                                            type="text"
                                            required
                                            placeholder="Residence"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Father's Name"
                                        label-for="Father's Name"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.father_name"
                                            type="text"
                                            required
                                            placeholder="Father's Name"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="12">
                                    <b-form-group
                                        label="Address"
                                        label-for="Address"
                                    >
                                        <b-textarea md="6" rows="3">
                                            <b-form-input v-model="form.address"></b-form-input>
                                        </b-textarea>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Date of Birth"
                                        label-for="Date of Birth"

                                    >
                                        <date-picker v-model="form.date_of_birth" width="100%" input-class="form-control"  type="date" lang="en" format="YYYY-MM-DD"> aa</date-picker>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Height"
                                        label-for="Height"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.height"
                                            type="text"
                                            required
                                            placeholder="Height"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Personal Marks"
                                        label-for="Personal Marks"
                                    >
                                        <b-form-input
                                            id="result"
                                            v-model="form.personal_marks"
                                            type="text"
                                            required
                                            placeholder="Personal Marks"
                                        ></b-form-input>
                                    </b-form-group>
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
                    </div>
                </b-card-text>
            </b-card>
            <!--<b-card>
                <b-row>
                    <b-col>
                        <b-card title="PF Information List">
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
    //import Datatable from '../../layouts/common/datatable';
    import Datatable from '../../../layouts/common/datatable';

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
                applyDate: new Date(),
                form: {
                    empId: '',
                    empName: '',
                    edu_qualific_id: null,
                    department_id: null,
                    pf_id: ''
                },
                balance_date: new Date(),
                qualificationList: [{
                    text: 'Select One',
                    value: null
                }, 'Masters', 'Honours', 'HSC', 'SSC'],
                departmentList: [{
                    text: 'Select One',
                    value: null
                }, 'Administration', 'Planning', 'Security', 'Finance & Accounts'],
                show: true,
                fields: [{key: 'months', label: 'Months', sortable: true, sortDirection: 'desc'},
                    {key: 'subcription', label: 'Subcription', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'extpf', label: 'Ext. PF/Apr. PF', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'loandrawn', label: 'Loan Deawn', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'loanrepay', label: 'Loan Repay', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'settlement', label: 'Settlement', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'monincome', label: 'Monthly Income', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'action'],
                items: [
                    {
                        months: 'JUL', subcription: '4,848.00', extpf: '0.00', loandrawn: '0.00', loanrepay: '10,000.00',
                        settlement: '0.00', monincome: '1,700.00',action: ''

                    },
                    {
                        months: 'AUG', subcription: '5,090.00', extpf: '0.00', loandrawn: '0.00', loanrepay: '10,000.00',
                        settlement: '0.00', monincome: '1,800.00',action: ''

                    },
                    {
                        months: 'SEP', subcription: '5,900.00', extpf: '0.00', loandrawn: '0.00', loanrepay: '10,000.00',
                        settlement: '0.00', monincome: '2,027.00',action: ''

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
                    this.form.empName = ''
                this.form.designation_id = null,
                    this.form.department_id = null,
                    this.form.pf_id = '',

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

