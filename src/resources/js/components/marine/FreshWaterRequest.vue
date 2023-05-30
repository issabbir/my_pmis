<template>
    <div class="content-wrapper">
        <div class="content-body">

            <b-card  title="Fresh Water Requisition">
                <b-card-text class="card-content">
                    <div class="card body mb-2">
                        <b-form @reset="onReset" @submit="onSubmit" v-if="show">
                            
                            <b-row>
                                <b-col  md="4">
                                        <b-row>
                                            <b-col md="2">
                                              <label>Vessel Name</label>
                                            </b-col>
                                            <b-col md="10" class="form-group">
                                                <b-form-select v-model="form.vesselName" :options="vesselName"></b-form-select>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col lg="2">
                                              <label>Anchorage Area</label>
                                            </b-col>
                                            <b-col md="10" class="form-group">
                                                <b-form-select v-model="form.anchorageArea" :options="anchorageArea"></b-form-select>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col lg="2">
                                              <label>Remarks</label>
                                            </b-col>
                                            <b-col md="10" class="form-group">
                                                <b-form-textarea
                                                    id="textarea-rows"
                                                    placeholder="Add Note/Comment"
                                                    rows="4"
                                                  ></b-form-textarea>
                                            </b-col>
                                        </b-row>
                                </b-col>
                                
                                <b-col  md="4">
                                        <b-row>
                                                <b-col md="2">
                                                  <label>Date & Time</label>
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
                                        <b-row>
                                                <b-col md="2">
                                                  <label>Time/Date (expected delivery)</label>
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
                                
                                <b-col  md="4">
                                     <b-row>
                                            <b-col md="2">
                                              <label>Quantity Required</label>
                                            </b-col>
                                            <b-col md="10" class="form-group">
                                                <b-form-input
                                                    placeholder="Quantity Required" v-model="form.QuantityRequired">
                                                </b-form-input>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col lg="2">
                                              <label>Agent Name</label>
                                            </b-col>
                                            <b-col md="10" class="form-group">
                                                <b-form-select v-model="form.agentName" :options="agentName"></b-form-select>
                                            </b-col>
                                        </b-row>
                                </b-col>
                            </b-row>
                            
                            <b-row>
                                <b-col class="d-flex justify-content-end">
                                    <b-button md="6" size="md" type="submit" variant="dark">Save</b-button>&nbsp;
                                    <b-button class="btn-outline-dark" md="6" size="md" type="reset">Cancel</b-button>
                                </b-col>
                            </b-row>
                        </b-form>

                    </div>
                </b-card-text>
            </b-card>
            <!--Table for vessel registration-->
            <!--b-card>
                <div class="card-header">
                    <h4 class="card-title">Fresh Water Requisition List</h4>
                </div>
                <b-card-text class="card-content">
                    <b-card-body>
                        <b-card-text>                          
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
                            
                            <b-table
                                striped
                                hover
                                show-empty
                                small
                                :items="billApprovalItems"
                                :current-page="currentPage"
                                :filter="filter"
                                :per-page="perPage"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                :fields="billApprovalFields"
                                @filtered="onFiltered"
                                responsive>
                                                           
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
                            
                        </b-card-text>
                        

                    </b-card-body>
                </b-card-text>
            </b-card-->
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Fresh Water request"});
        },
        data() {
            return {
                form: {
                    datetime: new Date(),                    
                    vesselName: null,
                     anchorageArea: null,
                     agentName: null
                },
                show: true,
                //updateIndex: -1,
               // searchBtn: 'Search',
              //  approvforwardBtn:'Approve & Forward',

               /* billApprovalFields: [
                    {key: 'vesselName', label: 'Vessel Name ', sortable: true, sortDirection: 'desc'},
                    {key: 'quantityRequired', label: 'Quantity Required', sortable: true,sortDirection: 'desc',class: 'text-center'},
                    {key: 'anchorageArea', label: 'Anchorage Area',sortable: true, sortDirection: 'desc',class: 'text-center' },
                    {key: 'timeDate', label: 'Time Date',sortable: true, sortDirection: 'desc',class: 'text-center' },
                    {key: 'agentName', label: 'Agent Name',sortable: true, sortDirection: 'desc',class: 'text-center' },
                    //{key: 'shippingAgent', label: 'Shipping Agent',sortable: true, sortDirection: 'desc',class: 'text-center' },
                    {key: 'remarks', label: 'Remarks',sortable: true, sortDirection: 'desc',class: 'text-center' },
                    //{key: 'forwardTo', label: 'Forward To',sortable: true, sortDirection: 'desc',class: 'text-center' },
                ],
                billApprovalItems: [
                    {vesselName: 'MV Augusta', quantityRequired: '200', anchorageArea: 'O/A', timeDate: '01-Jan-19', agentName: 'Dino', remarks: 'Nothing'},
                ],*/
                
                 vesselName: [
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
                  ],
                  
              /*  totalRows: 1,
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
                },*/
                  

            }
        },
        
    }
</script>

