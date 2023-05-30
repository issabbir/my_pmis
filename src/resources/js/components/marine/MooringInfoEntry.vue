<template>
    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <div class="content-body">
            <b-card title="Mooring Visit Information">
                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                    <b-row>
                        <b-col>
                            <b-row >
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>SM No.</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-select id="input-3" v-model="marine.incident.category" :options="sm_no" required>  </b-form-select>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1 ">
                                        <b-col sm="3">
                                            <label>SL No.</label>
                                        </b-col>
                                        <b-col sm="9" >
                                            <b-form-input v-model="marine.incident.incidentID7" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row> <!--first row ends-->
                            
                            <b-row >
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>Vessel Used</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-select id="input-3" v-model="marine.incident.category" :options="vessel_used" required>  </b-form-select>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                             <label>SHIP NAME</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID8" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row><!--second row ends-->
                            
                            <b-row class="col-md-">
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>LM Rep.</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID6" type="text" ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>Date</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <date-picker v-model="marine.incident.date"  type="date" width="100%" lang="en" format="YYYY-MM-DD" confirm></date-picker>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row> <!--3rd row-->
                            
                            <b-row>
                                <b-col sm="12" class="d-flex justify-content-end mt-1 ">
                                    <b-button type="SAVE" variant="secondary">SAVE</b-button>
                                </b-col>
                            </b-row>
                            
                        </b-col>
                    </b-row>
                </b-form>
            </b-card>
            <b-card class="card" >
                <b-row >
                    <b-col>
                        <b-card title="">

                            <b-table striped hover show-empty
                                     small
                                     stacked="md"
                                     :items="mooringitems"
                                     :fields="mooringfields"
                                     :current-page="currentPage"
                                     :per-page="perPage"
                                     :filter="filter"
                                     :filterIncludedFields="filterOn"
                                     :sort-by.sync="sortBy"
                                     :sort-desc.sync="sortDesc"
                                     :sort-direction="sortDirection"
                                     @filtered="onFiltered">

                                <template v-slot:cell(status)="row">
                                    <a size="md"  class="text-primary" data-toggle="modal" href="#" data-target="#bordered"><i class="bx bx-edit cursor-pointer"></i> </a>
                                    <a size="md"  class="text-primary" data-toggle="modal" href="#" data-target="#bordered"><i class="bx bx-check cursor-pointer"></i> </a>
                                </template>
                            </b-table>
                        </b-card>
                    </b-col>
                </b-row>
            </b-card>

        </div> <!--content body ends here-->
    </div> <!--content wrapper end here-->

    <!-- END: Content-->

</template>

<script>
    import DatePicker from 'vue2-datepicker'
    // import marine from '../../json/incident.json';

    export default {
        components: { DatePicker },
        data(){
            return {
                datetime: new Date(),
                marine:{'incident':{
                        datetime: new Date(),
                        vessel_used:null,
                        sm_no: null,
                    }},
                vessel_used: [{ text: 'Select One', value: null }, 'Bay Cleaner 01', 'Bay Cleaner 02', 'Bay Cleaner 03'],
                sm_no: [{ text: 'Select One', value: null }, '01', '02', '03'],
                show: true,
                mooringfields: [{key: 'Date', label: 'Date', sortable: false, sortDirection: 'desc', class: 'text-center'},
                    {key: 'SMNo', label: 'SM No', sortable: false, sortDirection: 'desc'},
                    {key: 'SLNo', label: 'SL No', sortable: false, sortDirection: 'desc'},
                    {key: 'ShipName', label: 'Ship Name', sortable: false, sortDirection: 'desc', class: 'text-center'},
                    'status'],
                mooringitems: [
                    {
                        Date: '10/01/2019', SMNo: '1', SLNo: '1', ShipName: 'MV Nova',
                        status: ''
                    },
                    {
                        Date: '15/01/2019', SMNo: '2', SLNo: '2', ShipName: ' MV Queen ',
                        status: ''
                    },
                    {
                        Date: '16/01/2019', SMNo: '3', SLNo: '3', ShipName: 'MV Nova',
                        status: ''
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
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Marine"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Marine Operation"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Mooring Service" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Info Entry" });
            this.totalRows = this.items.length
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if (JSON.parse(localStorage.getItem('marine.incident'))) {
                    this.incidents = JSON.parse(localStorage.getItem('marine.incident'));
                    this.marine.incident.incidentID = parseInt(this.incidents[this.incidents.length - 1].incidentID) + 1;
                }
                this.incidents.push(this.marine.incident);
                localStorage.setItem('marine.incident', JSON.stringify(this.incidents));
                this.items = this.incidents;
                this.totalRows = this.items.length;
                this.marine.incident = {};
            },
            onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.form.incidentID = '';
                this.form.description = '';
                this.form.category = null;
                this.form.location = null;
                this.form.shipname = null;
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
            },
            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`;
                this.infoModal.content = JSON.stringify(item, null, 2);
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            resetInfoModal() {
                this.infoModal.title = '';
                this.infoModal.content = ''
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1
            }
        }

    }
</script>
