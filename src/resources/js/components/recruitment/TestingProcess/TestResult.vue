<template>
    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card title="Result">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-row>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col md="3">
                                            <label>Advertisement Ref No</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-select v-model="form.advRefNo" :options="advRefNolist"></b-form-select>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col md="3">
                                            <label>Job Title</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-select v-model="jobTitle" :options="jobTitleList"></b-form-select>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col md="3">
                                            <label>Exam Type</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-select v-model="examType" :options="examTypelist"></b-form-select>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>
                             <b-row class="d-flex justify-content-center mt-3">
                                    <b-button type="submit"  class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
                                    <b-button type="reset" class="btn btn-outline-dark  mb-1">Clear</b-button>
                           </b-row>
                        </b-form>

                        <br>
                        <br>

                        <b-row>
                            <b-col sm="2" md="2" class="my-1">
                                <b-form-group
                                    label="Per page"
                                    label-cols-sm="6"
                                    label-cols-md="6"
                                    label-cols-lg="6"
                                    label-align-sm="left"
                                    label-size="sm"
                                    label-for="perPageSelect"
                                    class="mb-0">
                                    <b-form-select
                                        v-model="perPage"
                                        id="perPageSelect"
                                        size="sm"
                                        :options="pageOptions"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3" md="3" class="my-1 ml-auto">
                                <b-input-group size="sm">
                                    <b-form-input
                                        v-model="filter"
                                        type="search"
                                        label-align-sm="right"
                                        id="filterInput"
                                        placeholder="Type to Search"
                                        ></b-form-input>
                                    <b-input-group-append>
                                        <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-col>
                        </b-row>
                        <b-table striped hover show-empty
                                 small
                                 stacked="md"
                                 :items="items"
                                 :fields="fields"
                                 :current-page="currentPage"
                                 :per-page="perPage"
                                 :filter="filter"
                                 :filterIncludedFields="filterOn"
                                 :sort-by.sync="sortBy"
                                 :sort-desc.sync="sortDesc"
                                 :sort-direction="sortDirection"
                                 @filtered="onFiltered">

                            <template  v-slot:cell(status)="row">
                                       <b-form-select v-model="resultstatus" :options="resultstatuslist"></b-form-select>
                            </template>
                            <template v-slot:cell(position)="row">
                                      <b-form-input v-model="position"></b-form-input>
                            </template>
                            <template v-slot:cell(action)="row">
                                      <b-form-select v-model="boardaction" :options="boardactionlist"></b-form-select>
                            </template>

                        </b-table>
                        <b-col sm="12" md="12" class="my-1">
                            <b-pagination
                                v-model="currentPage"
                                :total-rows="totalRows"
                                :per-page="perPage"
                                align="right"
                                size="sm"
                                class="my-0"></b-pagination>
                        </b-col>
                    </b-card>
                </b-col>
            </b-row>

        </div>
    </div>

    <!-- END: Content-->
</template>



<script>
    import DatePicker from "vue2-datepicker";
    import { FormWizard, TabContent } from "vue-form-wizard";
    import "vue-form-wizard/dist/vue-form-wizard.min.css";
    export default {
        data() {
            return {
                advRefNolist: [{text: '00029/19', value: 1}],
                jobTitleList: [{text: 'Senior Programmer', value: 1},{text: 'Programmer', value: 2}],
                examTypelist: [{text: 'Written', value: 1},{text: 'Viva', value: 2}],
                resultstatuslist: [{text: 'Pass', value: 1}, {text: 'Fail', value: 2}, {text: 'Expelled', value: 3}],
                boardactionlist: [{text: 'Interview', value: 1}, {text: 'Reject', value: 2}],
                fields: [{key: 'sl', label: 'Sl', sortable: true, sortDirection: 'desc'},
                    {key: 'advRefNo', label: 'Advertisement Ref. No', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'examType', label: 'Exam Type', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'jobTitle', label: 'Job Title', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'roll', label: 'Roll', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'name', label: 'Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'availalbility', label: 'Availalbility', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'mark', label: 'Mark', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'status', label: 'Status', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'position', label: 'Position', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'action'],
                items: [
                    {sl: '1', advRefNo: '00029/19', examType: 'Written', jobTitle: 'Senior Programmer', roll: '3', name: 'Himel', availalbility: 'Present', mark: '30', status: '', position: '', action: '', },
                    {sl: '2', advRefNo: '00029/19', examType: 'Written', jobTitle: 'Senior Programmer', roll: '30', name: 'Akik', availalbility: 'Present', mark: '40', status: '', position: '', action: '', },
                    {sl: '3', advRefNo: '00029/19', examType: 'Written', jobTitle: 'Senior Programmer', roll: '32', name: 'Rahim', availalbility: 'Present', mark: '70', status: '', position: '', action: '', },
                    {sl: '4', advRefNo: '00029/19', examType: 'Written', jobTitle: 'Senior Programmer', roll: '39', name: 'Selim', availalbility: 'Present', mark: '50', status: '', position: '', action: '', },
                    {sl: '5', advRefNo: '00029/19', examType: 'Written', jobTitle: 'Senior Programmer', roll: '21', name: 'Dipu', availalbility: 'Present', mark: '60', status: '', position: '', action: '', },
                    {sl: '6', advRefNo: '00029/19', examType: 'Written', jobTitle: 'Senior Programmer', roll: '27', name: 'Ripon', availalbility: 'Present', mark: '20', status: '', position: '', action: '', },
                    {sl: '7', advRefNo: '00029/19', examType: 'Written', jobTitle: 'Senior Programmer', roll: '9', name: 'Faysal', availalbility: 'Present', mark: '46', status: '', position: '', action: '', },
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

                appDeadline: new Date(),
                pubdate: new Date(),
                quota: "not_accepted",
                form: {
                    advRefNo: '',
                    jobTitle: '',
                    examType: '',
                    resultstatus: '',
                    position: '',
                    boardaction: ''
                },
                show: true
            };
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Online Recruitment"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Testing"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Result"});
            this.totalRows = this.items.length
        },
        methods: {
            formSubmitted() {
                alert("Form submitted!");
            },
            onSubmit(evt) {
                evt.preventDefault();
                alert(JSON.stringify(this.form));
            },
            onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.form.email = "";
                this.form.name = "";
                this.form.food = null;
                this.form.checked = [];
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            }
        },
        components: {
            FormWizard,
            DatePicker,
            TabContent
        }
    };
</script>
