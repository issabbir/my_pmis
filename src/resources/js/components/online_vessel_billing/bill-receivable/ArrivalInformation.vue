<template>
    <div class="content-wrapper">
        <div class="content-body">

            <div class="row">
                <div class="col-md-12 col-12">
                    <b-card title="Arrival Information">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-row>
                                <b-col>
                                    <b-row>
                                        <b-col lg="4">
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Registration/ROT No</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <multiselect
                                                        v-model="form.RegistrationNo"
                                                        :options="registrationNoList"
                                                        :custom-label="nameWithLang"
                                                        placeholder="Select one"
                                                        label="text"
                                                        track-by="name"></multiselect>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Registration Date</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-input
                                                        v-model="form.registrationDate"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        disabled
                                                        placeholder="Registration Date"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Shipping Agent</label>
                                                </b-col>
                                                <div class="col-md-8 form-group">
                                                    <b-form-select v-model="form.shippingAgent":options="shippingAgentList"></b-form-select>
                                                </div>
                                            </b-row>
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Vessel Name</label>
                                                </b-col>
                                                <div class="col-md-8 form-group">
                                                    <b-form-input
                                                        v-model="form.VesselName"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="Vessel Name"
                                                        ></b-form-input>
                                                </div>
                                            </b-row>

                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Vessel Flag</label>
                                                </b-col>
                                                <div class="col-md-8 form-group">
                                                    <b-form-select v-model="form.vesselFlag":options="vesselFlagList"></b-form-select>
                                                </div>
                                            </b-row>

                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Vessel Types</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-select v-model="form.vesseltype":options="vesselTypes"></b-form-select>
                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Status</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-select v-model="form.status":options="statusList"></b-form-select>
                                                </b-col>
                                            </b-row>

                                        </b-col>
                                        <b-col lg="4">
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Master Name</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-input
                                                        v-model="form.MasterName"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="Master Name"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Arrival Date</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <date-picker
                                                        v-model="form.ArrivalDate"
                                                        width="100%"
                                                        input-class="form-control"
                                                        type="date"
                                                        lang="en"
                                                        format="YYYY-MM-DD"
                                                        ></date-picker>
                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Port Limit</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-input
                                                        v-model="form.portLimit"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="Port Limit"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Ancorage Area</label>
                                                </b-col>
                                                <div class="col-md-8 form-group">
                                                    <b-form-select v-model="form.ancorageArea":options="ancorageAreaList"></b-form-select>
                                                </div>
                                            </b-row>
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>GRT</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-input
                                                        v-model="form.GRT"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="GRT"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>NRT</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-input
                                                        v-model="form.NRT"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="NRT"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col lg="4">
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Deck Cargo</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-input
                                                        v-model="form.DeckCargo"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="Deck Cargo"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Last Port</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-input
                                                        v-model="form.LastPort"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="Last Port"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Next Port</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-input
                                                        v-model="form.NextPort"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="Next Port"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Port limit crossing time</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <date-picker
                                                        v-model="form.portLimitCrossingTime"
                                                        width="100%"
                                                        input-class="form-control"
                                                        type="time"
                                                        lang="en"
                                                        format="hh-mm-ss"
                                                        ></date-picker>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Draft</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-select v-model="form.draft":options="draftList"></b-form-select>
                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Remarks</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-input
                                                        v-model="form.remarks"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="Remarks"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>
                        </b-form>
                        <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                            <b-button type="button" id="basic_sub_btn" class="btn btn-dark shadow  mb-1">Save</b-button>
                        </div>

                    </b-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import DatePicker from 'vue2-datepicker'
            export default {
                components: {Multiselect, DatePicker},
                mounted() {
                    this.$store.commit("setBreadcrumbEmpty");
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Bill Receivable"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Vessel Service"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Arrival Information"});
                },
                data() {
                    return {
                    form: {
                    datetime: new Date(),
                    },
                            show: true,
                            updateIndex: - 1,
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
                            draftList:[{value: 'Y', text: 'Yes'}, {value: 'N', text: 'No'}],
                            vesselFlagList: [
                            {value: 'BD', text: 'BD'},
                            {value: 'IND', text: 'IND'}
                            ],
                            vesselTypes: [
                            {value: '1', text: "Motor Vessel"},
                            {value: "2", text: "Light Vessel"}
                            ],
                            ancorageAreaList: [
                            {value: 1, text: 'Deep Sea'},
                            {value: 2, text: 'Jetty'},
                            {value: 3, text: 'Patenga'}
                            ],
                            registrationNoList: [
                            {value: 2019 / 23789, text: '2019/23789'},
                            {value: '2019/23790', text: '2019/23790'},
                            {value: '2019/23791', text: '2019/23791'},
                            ],
                            statusList: [
                            {value: 1, text: 'Incomplete'},
                            {value: '2', text: 'Complete'},
                            {value: '4', text: 'In Process'}
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
                        let data = this.tableDatdbA
                        a.items[i];

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

