<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h3 class="card-title">Accounting Calendar Setup</h3>
                        </div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input
                                        v-model="updateIndex"
                                        required
                                        id="input-update-index"
                                        type="text"
                                        :style="{'display':'none'}"
                                        ></b-form-input>
                                    <b-row>
                                        <b-col>
                                            <b-row>
                                                <b-col lg="6">
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Calendar</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input v-model="form.calendar" placeholder="Calendar"></b-form-input>
                                                        </b-col>
                                                    </b-row>
                                                </b-col>

                                                <b-col lg="6">
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Description</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input v-model="form.description" placeholder="Description"></b-form-input>
                                                        </b-col>
                                                    </b-row>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col class="mt-2 d-flex justify-content-left">
                                            <b-button
                                                lg="6"
                                                size="md"
                                                class="btn-outline-dark"
                                                type="reset" 
                                                v-on:click="isHidden = !isHidden"
                                                >
                                                <i class="bx bxs-plus-circle cursor-pointer"></i> Add
                                            </b-button>
                                        </b-col>
                                        <b-col class="mt-2 d-flex justify-content-end">
                                            <b-button lg="6" size="md" class="btn-outline-dark" type="reset"><i class="bx bx-search cursor-pointer"></i>Search</b-button>
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </div>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <b-row  v-if="isHidden">
                <b-col>
                    <b-card class="card">
                        <div class="card-content">
                            <b-card-text class="card-body">
                                <h3 class="card-title">Calendar Setup</h3>
                                <b-table
                                    striped
                                    hover
                                    show-empty
                                    small
                                    :items="calendarItems"
                                    :current-page="currentPage"
                                    er-page="perPage"
                                    :filter="filter"
                                    ort-by.sync="sortBy"
                                    ort-desc.sync="sortDesc"
                                    ort-direction="sortDirection"
                                    :fields="calendarFields"
                                    responsive
                                    bordered
                                    >
                                    <template v-slot:cell(pTypes)="row">
                                          <b-form-select v-model="form.pTypes" :options="pTypesList"></b-form-select>
                                    </template>
                                    <template v-slot:cell(year)="row">
                                              <b-form-input v-model="year"></b-form-input>
                                    </template>
                                    <template v-slot:cell(qurter)="row">
                                              <b-form-input v-model="qurter"></b-form-input>
                                    </template>
                                    <template v-slot:cell(dateFrom)="row">
                                              <date-picker
                                            v-model="form.dateFrom"
                                            input-class="form-control"
                                            type="date"
                                            lang="en"
                                            format="YYYY-MM-DD"></date-picker>
                                    </template>
                                    <template v-slot:cell(dateTo)="row">
                                              <date-picker
                                            v-model="form.dateTo"
                                            input-class="form-control"
                                            type="date"
                                            lang="en"
                                            format="YYYY-MM-DD"></date-picker>
                                    </template>
                                    <template v-slot:cell(name)="row">
                                              <b-form-input v-model="name"></b-form-input>
                                    </template>
                                    <template v-slot:cell(action)="row">
                                              <b-form-checkbox
                                            id="checkbox-1"
                                            v-model="status"
                                            name="checkbox-1"
                                            value="accepted"
                                            unchecked-value="not_accepted"
                                            ></b-form-checkbox>
                                    </template>
                                </b-table>
                            </b-card-text>
                            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                <b-row>
                                    <b-col class="mt-2 d-flex justify-content-end">
                                        <b-button lg="6" size="md" variant="dark" type="submit">Save</b-button>
                                    </b-col>
                                </b-row>
                            </b-form>
                        </div>
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import DatePicker from "vue2-datepicker";
    export default {
        components: {DatePicker, Multiselect},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Financial Calender"});
        },
        data() {
            return {
                form: {},
                show: true,
                updateIndex: -1,
                submitBtn: "Search",
                calendarFields: ["action",
                    {key: "prefix", label: "Month Prefix", sortable: true},
                    {key: "pTypes", label: "P.Types", sortable: true},
                    {key: "year", label: "Year", sortable: true},
                    {key: "qurter", label: "Qurter", sortable: true},
                    {key: "dateFrom", label: "Date From", sortable: true},
                    {key: "dateTo", label: "Date To", sortable: true},
                    {key: "name", label: "Name", sortable: true}],
                calendarItems: [
                    {
                        prefix: "Jul",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                    {
                        prefix: "Aug",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                    {
                        prefix: "Sep",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                    {
                        prefix: "oct",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                    {
                        prefix: "Nov",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                    {
                        prefix: "Dec",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                    {
                        prefix: "Jan",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                    {
                        prefix: "Feb",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                    {
                        prefix: "Mar",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                    {
                        prefix: "Apr",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                    {
                        prefix: "May",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                    {
                        prefix: "Jun",
                        pTypes: "",
                        year: "",
                        qurter: "",
                        dateFrom: "",
                        dateTo: "",
                        name: ""},
                ],
                pTypesList: [{value: 1, text: 'Monthly'}, {value: 1, text: 'Quaterly'}
                ]

            };
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if (this.updateIndex > -1) {
                    //update
                    this.tableData.items[
                            this.updateIndex
                    ].employee_id = this.form.employee_id;
                    this.tableData.items[
                            this.updateIndex
                    ].department_name = this.form.department_name;
                    this.tableData.items[
                            this.updateIndex
                    ].designation = this.form.designation;
                    this.tableData.items[
                            this.updateIndex
                    ].division_name = this.form.division_name;
                    this.tableData.items[
                            this.updateIndex
                    ].financial_code = this.form.financial_code;
                    this.tableData.items[this.updateIndex].shift = this.form.shift;
                } else {
                    //new data add
                    this.tableData.items.push({
                        employee_id: this.form.employee_id,
                        department_name: this.form.department_name,
                        designation: this.form.designation,
                        division_name: this.form.division_name,
                        financial_code: this.form.financial_code,
                        shift: this.form.shift
                    });
                }
                this.onReset(evt);
            },
            onReset(evt) {
                evt.preventDefault();
                this.employee_id = "";
                this.department_name = "";
                this.designation = "";
                this.division_name = null;
                this.financial_code = null;
                this.shift = null;

                this.updateIndex = -1;
                this.submitBtn = "Save";
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(i, code) {
                this.submitBtn = "Update";
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
    };
</script>

