<template>
    <div>
        <!-- BEGIN: Content-->
         <div class="content-wrapper">
                 <div class="content-body">
                     <b-card class="card">
                         <b-row>
                             <b-col>
                                 <b-card title="Hydrography Customer Request List">
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

                                         <template v-slot:cell(action)="row">
                                             <a size="sm"  class="text-primary" data-toggle="modal" href="#" data-target="#border-less"><i class="bx bx-edit cursor-pointer"></i> </a>
                                             <a target="_self" href="/hydrography/#/invoice-admin-Req-Details" class="text-primary"><i class="bx bx-show  cursor-pointer"></i></a>

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
                     </b-card>
                </div>
            </div>
        <!-- END: Content-->
    </div>
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
                hydrography:{'assignAdminRequestList':{
                        vhf_id: '',
                        datetime: new Date(),
                        issue : null,
                        to : null,
                        from : null,
                        comment:null,
                    }},
                location: [{ text: 'Select One', value: null }, 'Karnofuli River', 'Outer Anchorage Alfa', 'Outer Anchorage Charli','Port Crossing Area'],
                shipname: [{ text: 'Select One', value: null }, 'MV Augusta', 'NJ Tribedi', 'MV Titan'],
                category: [{ text: 'Select One', value: null }, 'Collision with other ship', 'Fire on board', 'Crew Fall from ship'],
                show: true,

                fields: [{key: 'RequestId', label: 'Request Id', sortable: true, sortDirection: 'desc'},
                    {key: 'CustomerName', label: 'Customer Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'Email', label: 'Email', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'Phone', label: 'Phone', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'ProductName', label: 'Product Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'Qty', label: 'Qty', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'RequestDate', label: 'Request Date', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'Status', label: 'Status', sortable: true, sortDirection: 'desc', class: 'text-center'},

                    'action'],
                items: [
                    {RequestId: '00012', CustomerName: 'Mr Waker Khan', Email: 'hossaincse2@gmail.com', Phone: '01776427516', ProductName: 'Chart',
                        Qty: '1', RequestDate: '10/01/2019', Status: 'Pending',  action: ''},
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
            this.$store.commit("setBreadcrumb", { link: "#", label: "Hydrography"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Assign Admin Req. List"});

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
