<template>
    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card title="Final Selection Process">

                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-row>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col md="3">
                                            <label>Ref No</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-select v-model="advNo" :options="refnoData"></b-form-select>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col md="3">
                                            <label>Job Title</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-select v-model="jobTitle" :options="jobTitleData"></b-form-select>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col md="3">
                                            <label>No Of Post</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-input id="no_of_post" disabled></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>
                            <b-row class="d-flex justify-content-center mt-3">
                                <b-button type="submit"  class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
                                <b-button type="reset" class="btn btn-outline-dark  mb-1">Clear</b-button>
                            </b-row>
                        </b-form>
                    </b-card>
                    <b-row>
                        <b-col>
                            <b-card title="Final Selection ">



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

                                    <template v-slot:cell(remark)="row">
                                              <b-form-input id="remark"></b-form-input>
                                    </template>
                                    <template v-slot:cell(document_verification)="row">
                                              <b-form-select v-model="document_verification" :options="documentverifiStatus"></b-form-select>
                                    </template>
                                    <template v-slot:cell(pmis_transfer)="row">
                                              <b-form-select v-model="pmis_transfer" :options="transferStatus"></b-form-select>
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
                </b-col>
            </b-row>

        </div>

    </div>

</template>

<script>
    import DatePicker from 'vue2-datepicker'
    import { FormWizard, TabContent } from "vue-form-wizard";
    import "vue-form-wizard/dist/vue-form-wizard.min.css";
    export default {
        components: {DatePicker},

        data() {
            return {
                interviwdate: new Date(),
                form: {
                    refno: '',
                    jobTitle: '',
                },
                refnoData: [{text: '00029/19', value: 1}],
                jobTitleData: [{text: 'Senior Programmer', value: 1}, {text: 'Programmer', value: 2}],
                documentverifiStatus: [{text: 'Verified', value: 1}, {text: 'NotVerified', value: 2}],
                transferStatus: [{text: 'Transfer', value: 1}, {text: 'NotTransfer', value: 2}],
                show: true,
                resultstatuslist: [{text: 'Pass', value: 1}, {text: 'Fail', value: 2}, {text: 'Expelled', value: 3}],
                boardactionlist: [{text: 'Interview', value: 1}, {text: 'Reject', value: 2}],
                fields: [{key: 'SL', label: 'Sl', sortable: true, sortDirection: 'desc'},
                    {key: 'roll', label: 'Roll', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'reg', label: 'Registration No', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'candidateNameNfatherName', label: 'Candidate Name & Father Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'age', label: 'Age', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'eduQulification', label: 'Educational Qualification', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'district', label: 'District', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'quota', label: 'Quota', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'writnMark', label: 'Written Mark', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'vivaMark', label: 'Viva Mark', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'totalMark', label: 'Total Mark', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'remark',
                    'document_verification', 'pmis_transfer'],
                items: [
                    {SL: '1', roll: '31', reg: 'ASA-003', candidateNameNfatherName: 'Hridoy Khan Ripon Khan', age: '27',
                        eduQulification: 'B.Sc(Hons)CSE-3.83 HSC-5.00,SSC-5.00', district: 'Dhaka', quota: 'General', writnMark: '55.00', vivaMark: '74.00', totalMark: '129.00', remark: '', document_verification: '', pmis_transfer: ''},
                    {SL: '1', roll: '31', reg: 'ASA-003', candidateNameNfatherName: 'Hridoy Khan Ripon Khan', age: '27',
                        eduQulification: 'B.Sc(Hons)CSE-3.83 HSC-5.00,SSC-5.00', district: 'Dhaka', quota: 'General', writnMark: '55.00', vivaMark: '74.00', totalMark: '129.00', remark: '', document_verification: '', pmis_transfer: ''},
                    {SL: '1', roll: '31', reg: 'ASA-003', candidateNameNfatherName: 'Hridoy Khan Ripon Khan', age: '27',
                        eduQulification: 'B.Sc(Hons)CSE-3.83 HSC-5.00,SSC-5.00', district: 'Dhaka', quota: 'General', writnMark: '55.00', vivaMark: '74.00', totalMark: '129.00', remark: '', document_verification: '', pmis_transfer: ''},
                    {SL: '1', roll: '31', reg: 'ASA-003', candidateNameNfatherName: 'Hridoy Khan Ripon Khan', age: '27',
                        eduQulification: 'B.Sc(Hons)CSE-3.83 HSC-5.00,SSC-5.00', district: 'Dhaka', quota: 'General', writnMark: '55.00', vivaMark: '74.00', totalMark: '129.00', remark: '', document_verification: '', pmis_transfer: ''},
                    {SL: '1', roll: '31', reg: 'ASA-003', candidateNameNfatherName: 'Hridoy Khan Ripon Khan', age: '27',
                        eduQulification: 'B.Sc(Hons)CSE-3.83 HSC-5.00,SSC-5.00', district: 'Dhaka', quota: 'General', writnMark: '55.00', vivaMark: '74.00', totalMark: '129.00', remark: '', document_verification: '', pmis_transfer: ''},
                    {SL: '1', roll: '31', reg: 'ASA-003', candidateNameNfatherName: 'Hridoy Khan Ripon Khan', age: '27',
                        eduQulification: 'B.Sc(Hons)CSE-3.83 HSC-5.00,SSC-5.00', district: 'Dhaka', quota: 'General', writnMark: '55.00', vivaMark: '74.00', totalMark: '129.00', remark: '', document_verification: '', pmis_transfer: ''},
                    {SL: '1', roll: '31', reg: 'ASA-003', candidateNameNfatherName: 'Hridoy Khan Ripon Khan', age: '27',
                        eduQulification: 'B.Sc(Hons)CSE-3.83 HSC-5.00,SSC-5.00', district: 'Dhaka', quota: 'General', writnMark: '55.00', vivaMark: '74.00', totalMark: '129.00', remark: '', document_verification: '', pmis_transfer: ''}
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
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Online Recruitment"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Acceptance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Final Selection"});
            this.totalRows = this.items.length
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault()
                console.log(JSON.stringify(this.form))
            },

            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`
                this.infoModal.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            resetInfoModal() {
                this.infoModal.title = ''
                this.infoModal.content = ''
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        }

    }
</script>