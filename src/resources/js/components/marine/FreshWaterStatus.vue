<template>
    <div class="content-wrapper">
        <div class="content-body">

            <!--Table for vessel registration-->
            <b-row>
            <b-col md="8">
                <b-card title="Fresh Water Request Status">
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

                             <!--template v-slot:cell(involvement)="row">
                                        <b-form-select v-model="involvement" :options="involvementList"></b-form-select>
                              </template-->

                        <!--template v-slot:cell(action)="row">
                            <a size="sm"  class="text-primary"  href="/approval_service/#/leave-details" ><i class="bx bx-check-square cursor-pointer"></i> </a>
                            <a size="sm"  class="text-primary" data-toggle="modal" href="#" data-target="#border-less"><i class="bx bx-edit cursor-pointer"></i> </a>                                     
                            <!--a target="_self" href="#" class="text-danger"><i class="bx bx-trash cursor-pointer"></i></a-->                                   
                        <!--/template-->
                        
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
                
             <b-col md="4">
                    <b-card  title="FW Status">
                        <b-card-text class="card-content"> 
                            
                                    <ul class="widget-timeline mb-0">
                                         <li class="timeline-items timeline-icon-danger active">
                                           <div class="timeline-time">September, 16</div>
                                           <h6 class="timeline-title">Request Submitted</h6>
                                           <p class="timeline-text">2 hours ago</p>
                                           <!--div class="timeline-content">
                                             <img src="" alt="document" height="23" width="19"
                                               class="mr-50">New Order.pdf
                                           </div-->
                                         </li>
                                         <li class="timeline-items timeline-icon-warning active">
                                           <div class="timeline-time">September, 17</div>
                                           <h6 class="timeline-title">Request Approved</h6>
                                           <p class="timeline-text">25 minutes ago</p>
                                           <!--div class="timeline-content">
                                             <img src="" alt="document" height="23" width="19"
                                               class="mr-50">Invoices.pdf
                                           </div-->
                                         </li>
                                         <li class="timeline-items timeline-icon-primary active">
                                           <div class="timeline-time">September, 18</div>
                                           <h6 class="timeline-title">FW Delivery To Vesel</h6>
                                           <p class="timeline-text">4 minutes ago</p>
                                         </li>
                                         <li class="timeline-items timeline-icon-success active pb-0">
                                           <div class="timeline-time">September, 18</div>
                                           <h6 class="timeline-title">Delivery Confirmation</h6>
                                           <p class="timeline-text">4 minutes ago</p>
                                         </li>
                                     </ul>
                            
                            
                            </b-card-text>
                        </b-card>
                </b-col>
            </b-row>

            
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Fresh Water Status"});
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
                {key: 'veselAssgined', label: 'Vesel Assgined', sortable: true, sortDirection: 'desc', class: 'text-center'},
                 {key: 'requestStatus', label: 'Request Status', sortable: true, sortDirection: 'desc', class: 'text-center'}
                ],
                items: [
                {sLNo: '1', veselName: 'MV Simon', shippingCo: 'Sikdar Shipping', qty: '200', anchorage: 'Alpha', expDelivery: '05-11-19',  veselAssgined: 'Jalpari 01',  requestStatus: 'Approved'},
                {sLNo: '2', veselName: 'MV Augusta', shippingCo: 'Monsur Shipping', qty: '300', anchorage: 'Bravo', expDelivery: '07-11-19',  veselAssgined: 'Jalpari 02',  requestStatus: 'Submitted'},
                {sLNo: '3', veselName: 'MV Sea Queen', shippingCo: 'See Pearl Shipping', qty: '500', anchorage: 'Charlie', expDelivery: '09-11-19',  veselAssgined: 'Jalpari 03',  requestStatus: 'Confirmation'},
                {sLNo: '4', veselName: 'MV Augusta', shippingCo: 'Monsur Shipping', qty: '800', anchorage: 'Bravo', expDelivery: '25-11-19',  veselAssgined: 'Jalpari 02',  requestStatus: 'Delivery To Vesel'},
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
                       /* involvementList: [
                            {value: 1, text: 'Radio Control Room'},
                            {value: 2, text: 'Jalpari 01'},
                        ],*/
                
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












<!--template>
  <div class="content-wrapper">
    <div class="content-body">
      <div class="row">
        <div class="col-md-12 col-12">
          <div class="card">
            <div class="card-content">
                <div class="card-header">
                      <h4 class="card-title">FW Request Status</h4>
                </div>
              <div class="card-body mb-2">
                <form class="form form-horizontal">
                  <div class="card mb-2">
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-3">
                              <label>Select FW Order</label>
                            </div>
                            <div class="col-md-5 form-group">
                              <select class="form-control" name="fworder" id="fworder">
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                              </select>
                            </div>
                            <div class="col-md-4">
                              <button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-content">
          <div class="card-body mb-2">
            <form-wizard title subtitle color="green">
              <tab-content title="Request Submited"></tab-content>
              <tab-content title="Request Approved"></tab-content>
              <tab-content title="FW Delivery To Vessel"></tab-content>
              <tab-content title="Delivery Confirmation"></tab-content>
            </form-wizard>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
export default {
  components: { DatePicker, FormWizard, TabContent },
  data() {
    return {
      name: "",
      time1: new Date()
    };
  },
  mounted() { 
     //console.log(this.$store.commit.length);
    // if(0 >= this.$store.commit.length){
    //     this.$store.commit("setBreadcrumbEmpty");
    // } 
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", { link: "#", label: "Marine" });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Marine Operation"});
    this.$store.commit("setBreadcrumb", { link: "#", label: "Fresh Water"});
    this.$store.commit("setBreadcrumb", { link: "#", label: "Fresh Water Status" });
  }
};
</script-->
