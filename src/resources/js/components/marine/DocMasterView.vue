<template>
    <div class="content-wrapper">
        <div class="content-body">

            <b-card  title="Doc Master View">
                <b-card-text class="card-content">
                    <div class="card body mb-2">
                        <b-form @reset="onReset" @submit="onSubmit" v-if="show">
                            <b-row>
                                <b-col  md="5">
                                        <b-row>
                                                <b-col md="2">
                                                  <label>Form</label>
                                                </b-col>
                                                <b-col md="10" class="form-group">
                                                        <date-picker
                                                            format="YYYY-MM-DD"
                                                            input-class="form-control"
                                                            lang="en"
                                                            type="date"
                                                            v-model="arrivalDate"
                                                            width="100%">
                                                        </date-picker>
                                                </b-col>
                                          </b-row>
                                </b-col>
                                <b-col  md="5">
                                        <b-row>
                                                <b-col md="2">
                                                  <label>To</label>
                                                </b-col>
                                                <b-col md="10" class="form-group">
                                                        <date-picker
                                                            format="YYYY-MM-DD"
                                                            input-class="form-control"
                                                            lang="en"
                                                            type="date"
                                                            v-model="arrivalDate"
                                                            width="100%">
                                                        </date-picker>
                                                </b-col>
                                          </b-row>
                                </b-col>
                                <b-col  md="2">
                                        <b-row>
                                                <b-col class="d-flex justify-content-end">
                                                    <b-button md="6" size="md" type="submit" variant="dark">Search</b-button>&nbsp;
                                                    <b-button class="btn-outline-dark" md="6" size="md" type="reset">Cancel</b-button>
                                                </b-col>
                                          </b-row>
                                </b-col>
                            </b-row>                           
                        </b-form>
                    </div>
                </b-card-text>
            </b-card>
            <!--Table for vessel registration-->
            <b-card class="card">
                <b-row>
                    <b-col>
                        <b-card title="Fresh Water Request List">
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
                                
                                    <template v-slot:cell(assign)="row">
                                               <b-form-select v-model="involvement" :options="assignList"></b-form-select>
                                    </template>

                                <template v-slot:cell(action)="row">
                                    <a size="sm"  class="text-primary"  href="/approval_service/#/leave-details" ><i class="bx bx-check-square cursor-pointer"></i> </a>
                                    <a size="sm"  class="text-primary" data-toggle="modal" href="#" data-target="#border-less"><i class="bx bx-edit cursor-pointer"></i> </a>                                     
                                    <!--a target="_self" href="#" class="text-danger"><i class="bx bx-trash cursor-pointer"></i></a-->                                   
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
</template>

<script>

    import DatePicker from 'vue2-datepicker'

    export default {
        components: {DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Marine"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Marine Operation"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Fresh Water"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Doc Master View"});
        },
        data() {
            return {
                form: {
                    datetime: new Date(),                    
                    //involmentType: null,
                    // anchorageArea: null,
                     //agentName: null
                },
                show: true,
                //updateIndex: -1,
               // searchBtn: 'Search',
              //  approvforwardBtn:'Approve & Forward',  

            fields: [
                {key: 'sLNo', label: 'SL No', sortable: true, sortDirection: 'desc'},
                {key: 'veselName', label: 'Vesel Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                {key: 'shippingCo', label: 'Shipping Co', sortable: true, sortDirection: 'desc', class: 'text-center'},
                {key: 'qty', label: 'Qty.(ton)', sortable: true, sortDirection: 'desc', class: 'text-center'},
                {key: 'anchorage', label: 'Anchorage', sortable: true, sortDirection: 'desc', class: 'text-center'},
                {key: 'expDelivery', label: 'Exp. Delivery', sortable: true, sortDirection: 'desc', class: 'text-center'},
                {key: 'assign', label: 'Assign', sortable: true, sortDirection: 'desc', class: 'text-center'},'action',
                {key: 'delivery', label: 'Delivery', sortable: true, sortDirection: 'desc', class: 'text-center'},
                ],
                items: [
                {sLNo: '1', veselName: 'MV Simon', shippingCo: 'Sikdar Shipping', qty: '200', anchorage: 'Alpha', expDelivery: '05-11-19',  assign: '', action: '', delivery: 'Pending'},
                {sLNo: '2', veselName: 'MV Augusta', shippingCo: 'Monsur Shipping', qty: '300', anchorage: 'Bravo', expDelivery: '07-11-19',  assign: '',  action: '', delivery: 'Pending'},
                {sLNo: '3', veselName: 'MV Sea Queen', shippingCo: 'See Pearl Shipping', qty: '500', anchorage: 'Charlie', expDelivery: '09-11-19',  assign: '',  action: '', delivery: 'Pending'},
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
                
               // selected: [1],
                        assignList: [
                            {value: 1, text: 'Radio Control Room'},
                            {value: 2, text: 'Jalpari 01'},
                        ],
                
                /* vesselName: [
                    { text: "Select", value: null },
                    { text: "MV Augusta", value: "Augusta" },
                    { text: "MV Janifer", value: "Janifer" }
                  ],
                  
                  anchorageArea: [
                    { text: "Select", value: null },
                    { text: "O/A", value: "O/A" },
                    { text: "RM/8", value: "RM/8" }
                  ],
                 agentName: [
                    { text: "Select", value: null },
                    { text: "ABC Shopping Company", value: "ABC" }
                  ],*/
                  
                
            }
        },
        
    }
</script>

