
<template>
    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <div class="content-body">

                    <b-card title="Inspector Approval">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">

                            <b-row class="col-md-">
                                <b-col>

                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>From Date </label>
                                        </b-col>
                                        <b-col sm="9" >
                                            <date-picker v-model="marine.incident.datetime" width="100%"  type="datetime" lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>To Date </label>
                                        </b-col>
                                        <b-col sm="9">
                                            <date-picker v-model="marine.incident.datetime"   width="100%"  type="datetime" lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>Inspector:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID5" readonly type="text"  ></b-form-input>
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


                               <!-- <template slot="selected" slot-scope="row">
                                    <b-form-group>
                                        <input type="checkbox" v-model="row.item.selected" />
                                    </b-form-group>
                                </template>-->

                                <template v-slot:cell(selected)="row">
                                    <input type="checkbox" class=" mr-2" v-model="row.item.selected" />
                                </template>

                                <template v-slot:cell(status)="row">
                                    <a size="md"  class="text-primary" data-toggle="modal" href="#" data-target="#border-less"><i class="bx bx-edit cursor-pointer"></i> </a>
                                    <a size="md"   class="text-primary ml-1" data-toggle="modal" href="#" data-target="#border-less"><i class="bx bx-check cursor-pointer"></i> </a>
                                  <!--  <input class=" ml-1" type="checkbox" v-model="row.item.selected" />-->
                                </template>
                               
                                <template v-slot:cell(date)="row">
                                          <b-form-input type="date"  ></b-form-input>
                                </template>

                            </b-table>

                        </b-card>
                    </b-col>

                </b-row>
                <b-row class="justify-content-end">
                    <div>


                        <b-button variant="dark">Approve</b-button>

                    </div>

                </b-row>

            </b-card>

        </div><!--content body div ends-->

    </div> <!--content wrapper div ends-->


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
                incidents: [],
                marine: {
                    'incident': {
                        incidentID: 1,
                        datetime: new Date(),
                        location: null,
                        shipname: null,
                        category: null,
                    }
                },
                location: [{
                    text: 'Select One',
                    value: null
                }, 'Karnofuli River', 'Outer Anchorage Alfa', 'Outer Anchorage Charli', 'Port Crossing Area'],
                shipname: [{text: 'Select One', value: null}, 'MV Augusta', 'NJ Tribedi', 'MV Titan'],
                category: [{
                    text: 'Select One',
                    value: null
                }, 'Collision with other ship', 'Fire on board', 'Crew Fall from ship'],
                show: true,
                fields: [
                    {key: 'incidentID', sortable: true},
                    {key: 'datetime', sortable: true},
                    {key: 'category', sortable: true},
                    {key: 'location', sortable: true},
                    {key: 'shipname', sortable: true},
                    {key: 'description', sortable: true},
                    'actions'
                ],

                mooringfields: [
                    {key: 'selected', label: '', sortable: false, sortDirection: 'desc', class: 'text-center'},
                    {key: 'SMNo', label: 'SM No', sortable: false, sortDirection: 'desc'},
                    {key: 'FromDate', label: 'From Date', sortable: false, sortDirection: 'desc', class: 'text-center'},
                    {key: 'date', label: 'To Date', sortable: false, sortDirection: 'desc', class: 'text-center'},
                    {key: 'DayCount', label: 'Day Count', sortable: false, sortDirection: 'desc', class: 'text-center'},
                    {key: 'ShipName', label: 'Ship Name', sortable: false, sortDirection: 'desc', class: 'text-center'},
                    'status'
                ],

                mooringitems: [
                    {selected: false, SMNo: '1', FromDate: '10/01/2019', date: '', DayCount: '1', ShipName: 'Sea Queen', status: ''},
                    {selected: false,  SMNo: '2', FromDate: '11/02/2018', date: '', DayCount: '1', ShipName: 'Blue Ribbon', status: ''},
                    {selected: false, SMNo: '3', FromDate: '12/03/2018', date: '', DayCount: '1', ShipName: 'Sea Lion', status: ''},
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


                items: [
                    {
                        'incidentID': '1',
                        'datetime': '1',
                        'category': '1',
                        'location': '1',
                        'location': '1',
                        'shipname': '1',
                        'description': '1'
                    }
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
            };
        },
       mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Marine"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Marine Operation"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Mooring Service" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Inspector Approval" });
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
                this.currentPage = 1;
            }
        }

    }
</script>

