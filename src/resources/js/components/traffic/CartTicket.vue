<template>
    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <div class="content-body">
            <h4 class="text-center "> Cart Ticket</h4>


            <div>
                <b-form @submit="onSubmit" @reset="onReset" v-if="show ">

                    <b-row class="my-1">
                        <b-col sm="6">
                            <label>Rotation No</label>

                            <b-form-input v-model="marine.incident.incidentID8" type="text"  placeholder="Rotation No" ></b-form-input>
                        </b-col>

                        <b-col sm="6">


                            <label>Job No</label>

                            <b-form-input v-model="marine.incident.incidentID8" type="text" placeholder="Job No"  ></b-form-input>
                        </b-col>

                    </b-row>


                </b-form>

            </div>

            <b-card title="Required Information">
                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                    <b-row>
                        <b-col>
                            <b-row >
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>Line No</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID8" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>

                                <!--Blank col for margin maintenance  starts -->
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">

                                        </b-col>
                                        <b-col sm="9">

                                        </b-col>
                                    </b-row>
                                </b-col>
                                <!--Blank col for margin maintenance ends -->
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>Shade/Yard No</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID8" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row> <!--first row ends-->
                            <!--<b-row >
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
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>LM Rep.</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID6" type="text" ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>&lt;!&ndash;second row ends&ndash;&gt;-->
                            <b-row class="col-md-">
                                <b-col>
                                    <b-row class="my-1 ">
                                        <b-col sm="3">
                                            <label>Release Order No.</label>
                                        </b-col>
                                        <b-col sm="9" >
                                            <b-form-input v-model="marine.incident.incidentID7" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>Of</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID8" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>

                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>Gate No</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID8" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>

                            </b-row> <!--3rd row-->

                            <b-row class="col-md-">
                                <b-col>
                                    <b-row class="my-1 ">
                                        <b-col sm="3">
                                            <label>Ex S/S</label>
                                        </b-col>
                                        <b-col sm="9" >
                                            <b-form-input v-model="marine.incident.incidentID7" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>No</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID8" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>

                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>Consignee</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID8" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>

                            </b-row> <!--4th row-->
                            <b-row class="col-md-">
                                <b-col>
                                    <b-row class="my-1 ">
                                        <b-col sm="3">
                                            <label>B/E</label>
                                        </b-col>
                                        <b-col sm="9" >
                                            <b-form-input v-model="marine.incident.incidentID7" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>
                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>Of</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID8" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>

                                <b-col>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>Truck No</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input v-model="marine.incident.incidentID8" type="text"  ></b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>

                            </b-row> <!--3rd row-->


                        </b-col>

                    </b-row>

                </b-form>
            </b-card>
        </div>

        <b-row>
            <b-col>
                <b-card title=" ">
                    <template>
                        <div>
                            <b-table striped bordered hover fixed  :items="items" white-space: nowrap></b-table>
                        </div>
                    </template>
                </b-card>
            </b-col>
        </b-row>


        <div>
            <b-form @submit="onSubmit" @reset="onReset" v-if="show ">

                <b-row class="my-1">
                    <b-col sm="3">
                        <label>Total Package (in Word)</label>

                        <!--  <b-form-input v-model="marine.incident.incidentID8" type="text"  placeholder="Thirteen" ></b-form-input>-->
                    </b-col>

                    <b-col sm="9">
                        <b-form-input v-model="marine.incident.incidentID8" type="text" placeholder="Thirteen"  ></b-form-input>
                    </b-col>

                </b-row>


            </b-form>

        </div>


        <div>
            <b-form @submit="onSubmit" @reset="onReset" v-if="show ">

                <b-row class="my-1">
                    <b-col sm="3">
                        <label>Received the Above in Full, For:</label>

                        <!-- <b-form-input v-model="marine.incident.incidentID8" type="text"  placeholder="Insert name Of Consignee" ></b-form-input>-->
                    </b-col>

                    <b-col sm="9">
                        <b-form-input v-model="marine.incident.incidentID8" type="text"  placeholder="Insert name Of Consignee"  ></b-form-input>
                    </b-col>

                </b-row>


            </b-form>

        </div>


        <div>
            <b-card
                title="Checked and Found Correct" class="mb-2">

                <b-row class="col-md-">

                    <b-col>
                        <b-row class="my-1">
                            <b-col sm="3">
                                <label>Date</label>
                            </b-col>
                            <b-col sm="9">
                                <date-picker v-model="marine.incident.datetime"  type="datetime" width="100%" lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                            </b-col>
                        </b-row>
                    </b-col>

                    <b-col>
                        <b-row class="my-1 ">
                            <b-col sm="3">
                                <label></label>
                            </b-col>
                            <b-col sm="9" >
                                <b-form-input v-model="marine.incident.incidentID7" type="text"  placeholder=" Signature" ></b-form-input>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col>
                        <b-row class="my-1">
                            <b-col sm="3">
                                <label></label>
                            </b-col>
                            <b-col sm="9">
                                <b-form-input v-model="marine.incident.incidentID8" type="text" placeholder=" Signature"  ></b-form-input>
                            </b-col>
                        </b-row>
                    </b-col>

                    <b-col>
                        <b-row class="my-1">
                            <b-col sm="3">
                                <label></label>
                            </b-col>
                            <b-col sm="9">
                                <b-form-input v-model="marine.incident.incidentID8" type="text"  placeholder=" Signature" ></b-form-input>
                            </b-col>
                        </b-row>
                    </b-col>

                </b-row> <!--3rd row-->


            </b-card>





        </div>

        <div>
            <b-form @submit="onSubmit" @reset="onReset" v-if="show ">

                <b-row class="my-1">
                    <!--<b-col sm="3">
                        <label>Total Package (in Word)</label>

                        &lt;!&ndash;  <b-form-input v-model="marine.incident.incidentID8" type="text"  placeholder="Thirteen" ></b-form-input>&ndash;&gt;
                    </b-col>-->

                    <b-col sm="12">
                        <b-form-input v-model="marine.incident.incidentID8" type="text" placeholder="N.B. If lost this ticket, immediately contact with the suing authority " readonly ></b-form-input>
                    </b-col>

                </b-row>


            </b-form>

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
                marine:{'incident':{
                        datetime: new Date(),
                        vessel_used:null,
                        sm_no: null,
                    }},
                vessel_used: [{ text: 'Select One', value: null }, 'Bay Cleaner 01', 'Bay Cleaner 02', 'Bay Cleaner 03'],
                sm_no: [{ text: 'Select One', value: null }, '01', '02', '03'],
                show: true,

                items: [
                    { Marks:'' , Description: '', Number: '', ConsecutiveCartsTotal:''},

                    { Marks:'' , Description: '', Number: '', ConsecutiveCartsTotal:''},
                    { Marks:'' , Description: '', Number: '', ConsecutiveCartsTotal:''},
                    { Marks:'' , Description: '', Number: '', ConsecutiveCartsTotal:''},
                    { Marks:'' , Description: '', Number: '', ConsecutiveCartsTotal:''},
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
