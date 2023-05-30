<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card  title="VHF Log Entry Form">
                <b-form class="mb-5">
                    <b-row>
                        <b-col>
                            <b-row class="my-1">
                                <b-col sm="3">
                                    <label>INCIDENT ID :</label>
                                </b-col>
                                <b-col sm="9">
                                    <b-form-input v-model="marine.vhflog.vhf_id" type="text" ></b-form-input>
                                </b-col>

                            </b-row>
                        </b-col>
                        <b-col>
                            <b-row class="my-1">
                                <b-col sm="3">
                                    <label>DATE & TIME:</label>
                                </b-col>
                                <b-col sm="9">
                                    <date-picker v-model="marine.vhflog.datetime" width="100%" type="datetime" lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col>
                            <b-row class="my-1">
                                <b-col sm="3">
                                    <label>Shipping Agent</label>
                                </b-col>
                                <b-col sm="9">
                                    <b-form-input v-model="marine.vhflog.shippingAgent" type="text" ></b-form-input>
                                </b-col>

                            </b-row>
                        </b-col>
                    </b-row>
                    
                    <b-row>
                        <b-col md="4">
                            <b-row class="my-1">
                               <b-col sm="3">
                                   <label>CATEGORY :</label>
                               </b-col>
                               <b-col sm="9">
                                    <b-form-select id="input-3" v-model="marine.vhflog.category" :options="category" required>  </b-form-select>
                               </b-col>
                           </b-row>
                        </b-col>
                        <b-col md="4">
                            <b-row class="my-1">
                               <b-col sm="3">
                                   <label>Location :</label>
                               </b-col>
                               <b-col sm="9">
                                   <b-form-select id="input-3" v-model="marine.vhflog.location" :options="location" required>  </b-form-select>
                               </b-col>
                           </b-row>
                        </b-col>
                         <b-col md="4">
                            <b-row class="my-1">
                               <b-col sm="3">
                                   <label>Ship Name:</label>
                               </b-col>
                               <b-col sm="9">
                                   <b-form-select id="input-3" v-model="marine.vhflog.shipname" :options="shipname" required>  </b-form-select>
                               </b-col>
                           </b-row>
                        </b-col>
                    </b-row>
                    
                    <b-row>                       
                        <b-col md="4">
                            <b-row class="my-1">
                                <b-col sm="3">
                                    <label>From</label>
                                </b-col>
                                <b-col sm="9">
                                    <b-form-input v-model="marine.vhflog.from" type="text" ></b-form-input>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="4">
                            <b-row class="my-1">
                                <b-col sm="3">
                                    <label>To</label>
                                </b-col>
                                <b-col sm="9">
                                    <b-form-input v-model="marine.vhflog.to" type="text" ></b-form-input>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="4">
                            <b-row class="my-1" >
                                <b-col sm="3">
                                    <label>Comment</label>
                                </b-col>
                                <b-col sm="9">
                                    <b-form-textarea  id="comment" size="md" placeholder="comment"rows="3"  ></b-form-textarea>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    
                    <b-row>                      
                        <b-col md="6">
                            <b-row class="my-1">
                               <b-col md="2">
                                   <label>Description :</label>
                               </b-col>
                               <b-col md="10">
                                     <b-form-textarea id="textarea" v-model="marine.vhflog.description" placeholder="Enter something..." size="md" rows="3" ></b-form-textarea>
                               </b-col>
                               </b-row>
                        </b-col>
                    </b-row>

                    
                    <b-row class="d-flex justify-content-end">
                        <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1 mt-1">Save</b-button>
                        <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1 mt-1"> Cancel</b-button>
                    </b-row>
                </b-form>
            </b-card>
            
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
                                    <a target="_self" href="#" class="text-primary"><i class="bx bxs-right-arrow-square cursor-pointer"></i></a>
                                </template>
                                
                                <template  v-slot:cell(multiselect)="row">    
                                    <multiselect v-model="value" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true">
                                        <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                                    </multiselect>
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

</template>

<script>
    import DatePicker from 'vue2-datepicker'
    import Multiselect from 'vue-multiselect'
    // import marine from '../../json/incident.json';

    export default {
        components: { DatePicker, Multiselect},
        data(){
            return {
                datetime: new Date(),
                incidents: [],
                marine:{'vhflog':{
                        vhf_id: '',
                        datetime: new Date(),
                        issue : null,
                        to : null,
                        from : null,
                        comment:null,
                    }},
                location: [{ text: 'Select One', value: null }, 'Karnofuli River', 'Outer Anchorage Alfa', 'Outer Anchorage Charli','Port Crossing Area'],
                shipname: [{ text: 'Select One', value: null }, 'MV Augusta', 'NJ Tribedi', 'MV Titan'],
                category: [{ text: 'Select One', value: null }, 'Collision with other ship', 'Fire on board', 'Crew Fall from ship','Other'],
                show: true,
                
                /*tableData: {
                    fields: [
                        {key: 'exam_body_id', label: 'ID', sortable: true}, 
                        {key: 'name', sortable: true}, {key: 'description', sortable: true}, 
                        {key: 'exam_body_type.name', "label": "type", sortable: true}, 
                        {key: 'action', sortable: false}],
                    items:[]
                },*/
                
                value: [],
                options: [
                  { name: 'Doc Master', language: 'Doc Master' },
                  { name: 'Harbour Master', language: 'Harbour Master' },
                  { name: 'Deputy Conserv', language: 'Deputy Conserv' }
                ],
                
                fields: [
                    {key: 'incidentId', label: 'Incident ID', sortable: true, sortDirection: 'desc'},
                    {key: 'incidentCategory', label: 'Incident Category', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'location', label: 'Location', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'shipName', label: 'Ship Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'incidentDescription', label: 'Incident Description', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'VHFDATE', label: 'VHF DATE', sortable: true, sortDirection: 'desc', class: 'text-center'},
                     {key: 'multiselect', label: 'FWD', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'action'],
                items: [
                    {incidentId: '00001', incidentCategory: 'Fire', location: 'Alpha', shipName: 'MV Augusta', incidentDescription: 'Fire On Deck', VHFDATE: '10/01/2019', multiselect:'', action: ''},
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
            this.$store.commit("setBreadcrumb", { link: "#", label: "VHF Log" });
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
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

