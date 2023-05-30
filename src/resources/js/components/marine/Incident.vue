<template>
        <!-- BEGIN: Content-->
       <div class="content-wrapper">
                <div class="content-body">
                    <b-row>
                        <b-col>
                             <b-card title="Incident Info Entry Form">
                                 <b-form @submit="onSubmit" @reset="onReset" v-if="show">

                                     <b-row>
                                         <b-col md="6">
                                             <b-row class="my-1">
                                                <b-col sm="2">
                                                    <label>DATE & TIME:</label>
                                                </b-col>
                                                <b-col sm="10">
                                                    <date-picker v-model="marine.incident.datetime"  width="100%"  type="datetime" lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                                                </b-col>
                                            </b-row>
                                         </b-col>
                                         <b-col md="6">
                                             <b-row class="my-1">
                                                <b-col sm="2">
                                                    <label>DATE & TIME:</label>
                                                </b-col>
                                                <b-col sm="10">
                                                    <date-picker v-model="marine.incident.datetime" width="100%"   type="datetime" lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                                                </b-col>
                                            </b-row>
                                         </b-col>                                         
                                     </b-row>
                                     
                                        <b-row class="d-flex justify-content-end">
                                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Submit</b-button> &nbsp;
                                                <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">Reset</b-button>
                                        </b-row>
                                        </b-form>

                             </b-card>
                        </b-col>
                    </b-row>
                    
                    <!--b-row>
                        <b-col>
                            <b-card  title="Action Taken">  
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                 <b-row>
                                     <b-col md="2">
                                         <b-input-group size="sm">
                                             <b-form-input
                                                 v-model="filter"
                                                 type="search"
                                                 label-align-sm="right"
                                                 id="filterInput"
                                                 placeholder="Incident ID "
                                             ></b-form-input>
                                             <b-input-group-append>
                                                 <b-button :disabled="!filter" @click="filter = ''">Search</b-button>
                                             </b-input-group-append>
                                         </b-input-group>
                                     </b-col>
                                 </b-row>
                                    <b-row>
                                        <b-col>
                                            <b-row class="my-1">
                                                <b-col sm="1">
                                                    <label>Step</label>
                                                </b-col>
                                                <b-col sm="4">
                                                    <b-form-input v-model="marine.incident.Step1" type="text" ></b-form-input>
                                                </b-col>
                                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Add</b-button>
                                            </b-row>

                                        </b-col>

                                        <b-col>

                                        </b-col>
                                    </b-row>
                                    <b-row >
                                        <b-col>
                                            <label>Step 1</label>
                                            <b-form-input v-model="marine.incident.Step1" type="text" ></b-form-input>
                                        </b-col>
                                        <b-col>
                                            <label>Step 2</label>
                                            <b-form-input v-model="marine.incident.Step2" type="text" ></b-form-input>
                                        </b-col>
                                        <b-col>
                                            <label>Step 3</label>
                                            <b-form-input v-model="marine.incident.Step3" type="text" ></b-form-input>
                                        </b-col>
                                        <b-col>
                                            <label>Step 4</label>
                                            <b-form-input v-model="marine.incident.Step4" type="text" ></b-form-input>
                                        </b-col>
                                    </b-row>
                                    <b-row class="d-flex justify-content-end">
                                        <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1 mt-1">Save Action</b-button>
                                        <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1 mt-1">Close</b-button>
                                    </b-row>
                                </b-form>
                            </b-card>
                        </b-col>
                    </b-row-->

                    <!-- Zero configuration table -->
                    <b-card class="card">
                            <b-row>
                                <b-col>
                                    <b-card title="VHF Log/Incident List">
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
                                                 responsive
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
                                                <!--a size="sm"  class="text-primary" data-toggle="modal" href="#" data-target="#border-less"><i class="bx bx-edit cursor-pointer"></i> </a>
                                                <a target="_self" href="#" class="text-primary"><i class="bx bx-show  cursor-pointer"></i></a-->
                                                <a  v-b-toggle.collapse-1  size="sm" target="_self" href="#" class="text-primary"> <i class="bx bx-show cursor-pointer"></i></a>
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
                    <!--/ Zero configuration table -->
                    
                    
<!--b-row>
    <b-col class="mt-2 d-flex justify-content-left">
      <b-button
        lg="6"
        size="md"
        class="btn-outline-dark"
        type="reset"
        v-on:click="isHiddenn = !isHiddenn"
      >
        <i class="bx bx-plus-circle cursor-pointer"></i> Add
      </b-button>
    </b-col>
  </b-row>
                    
<!-- Zero configuration table -->
  <!--section id="basic-datatable" v-if="isHiddenn">
    <b-row>
      <b-col>
          asfsfsdf
          
      </b-col>
    </b-row>
  </section-->
  <!--/ Zero configuration table -->

                    
                    
            
            <b-collapse id="collapse-1">
                <h5>Action Take For <b>FIRE ON DECK</b> By</h5>
                    <b-row>
                            <b-col md="4">
                                <b-card  title="">
                                    <h5>Waker Khan<small>&nbsp;&nbsp;ID: 205089</small></h5>
                                    <b-row >
                                        <b-col md="2"> </b-col>
                                        <b-col md="5">
                                            <b-form-group  label="New Action"  label-size="sm" label-for="type_of_class">
                                                <b-form-input  id="type_of_class"  v-model="marine.classType"  type="text" size="sm" required  placeholder="Action"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="5">
                                            <b-form-group  label="Date" label-size="sm" label-for="type_of_class">
                                                <date-picker v-model="marine.incident.datetime"  width="100%"  type="datetime" lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="12" class="d-flex justify-content-end">
                                            <b-button type="submit" id="basic_sub_btn" size="sm" class="btn btn-dark shadow mb-1">Add</b-button>
                                        </b-col>
                                    </b-row>

                                    <b-card-text class="card-content"> 
                                                <ul class="widget-timeline mb-0">
                                                     <li class="timeline-items timeline-icon-danger active">
                                                        <div class="timeline-time">17:30 <br>11/25/19</div>
                                                       <h6 class="timeline-title">3 men sent
                                                            <a  v-b-toggle.collapse-2  size="sm"  v-b-tooltip.hover title="Description"> <i class="bx bx-chevron-down cursor-pointer"></i></a>
                                                            <b-col md="10">
                                                                <b-collapse id="collapse-2" class="border">
                                                                    <p class="card-text p-1">Comments contents Here</p>
                                                                    <b-col class="d-flex justify-content-end">
                                                                        <a size="sm"  class="text-primary"  href="#" ><i class="bx bx-edit cursor-pointer"></i> </a>
                                                                        <a size="sm"  class="text-primary"  href="#"><i class="bx bx-check-square  cursor-pointer"></i></a>
                                                                    </b-col>
                                                                </b-collapse>
                                                            </b-col>
                                                       </h6>
                                                       <!--p class="timeline-text">2 hours ago</p>
                                                       <div class="timeline-content">
                                                         <img src="" alt="document" height="23" width="1    9"
                                                           class="mr-50">New Order.pdf
                                                       </div-->
                                                     </li>
                                                     <li class="timeline-items timeline-icon-warning active">
                                                       <div class="timeline-time">18:30<br>11/25/19</div>
                                                       <h6 class="timeline-title">Fire Extinguished</h6>
                                                       <!--p class="timeline-text">25 minutes ago</p>
                                                       <div class="timeline-content">
                                                         <img src="" alt="document" height="23" width="19"
                                                           class="mr-50">Invoices.pdf
                                                       </div-->
                                                     </li>
                                                     <li class="timeline-items timeline-icon-primary active">
                                                       <div class="timeline-time">17:30<br>11/25/19</div>
                                                       <h6 class="timeline-title">Ship sent</h6>
                                                       <!--p class="timeline-text">4 minutes ago</p-->
                                                     </li>
                                                     <li class="timeline-items timeline-icon-success active pb-0">
                                                       <div class="timeline-time">17:00<br>11/25/19</div>
                                                       <h6 class="timeline-title">Action on Course</h6>
                                                       <!--p class="timeline-text">4 minutes ago</p-->
                                                     </li>
                                                 </ul>
                                        </b-card-text>
                                    </b-card>
                            </b-col>
                            <b-col md="4">
                                <b-card  title="Akram Khan">
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
                            <b-col md="4">
                                <b-card  title="Babol Khan">
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
            </b-collapse>
                    
                </div>
       </div>


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
                marine:{'incident':{
                     incidentID: 1,
                     datetime: new Date(),
                     location : null,
                     shipname : null,
                     category : null,
                }
            },
            
            /* location: [{ text: 'Select One', value: null }, 'Karnofuli River', 'Outer Anchorage Alfa', 'Outer Anchorage Charli','Port Crossing Area'],
             shipname: [{ text: 'Select One', value: null }, 'MV Augusta', 'NJ Tribedi', 'MV Titan'],
             category: [{ text: 'Select One', value: null }, 'Collision with other ship', 'Fire on board', 'Crew Fall from ship'],*/
                    
            show: true,
                
                fields: [
                    {key: 'incidentId', label: 'Incident ID', sortable: true, sortDirection: 'desc'},
                    {key: 'incidentCategory', label: 'Incident Category', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'location', label: 'Location', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'shipName', label: 'Ship Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'incidentDescription', label: 'Incident Description', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'action', label: 'Action Taken', sortable: true, sortDirection: 'desc', class: 'text-center'},
                ],
                items: [
                    {incidentId: '00001', incidentCategory: 'Fire', location: 'Alpha', shipName: 'MV Augusta', incidentDescription: 'Fire On Deck',  action: ''},
                    {incidentId: '00002', incidentCategory: 'Theft', location: 'Bravo', shipName: 'MV Simon', incidentDescription: 'Crew Fall Form Deck',  action: ''},
                    {incidentId: '00003', incidentCategory: 'Collision', location: 'Mooring Area', shipName: 'MV Queen', incidentDescription: 'Collision With Queen Maria',  action: ''},
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
            this.$store.commit("setBreadcrumb", { link: "#", label: "Radio Control Room"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Incident" });
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
