<template>
  <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card title="Filter">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                <b-row>
                                    <b-col>
                                        <b-row class="my-1">
                                        <b-col md="3">
                                            <label>Job TItle :</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-select v-model="form.jobTitle" :options="jobTitleList"></b-form-select>
                                        </b-col>
                                    </b-row>
                                    </b-col>
                                    <b-col>
                                        <b-row class="my-1">
                                        <b-col md="3">
                                            <label>Education :</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-select v-model="form.education" :options="educationList"></b-form-select>
                                        </b-col>
                                    </b-row>
                                    </b-col>
                                    <b-col>
                                        <b-row class="my-1">
                                        <b-col md="3">
                                            <label>Subject:</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-select v-model="form.subject" :options="subjectList"></b-form-select>
                                        </b-col>
                                    </b-row>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col>
                                        <b-row class="my-1">
                                        <b-col md="3">
                                            <label>Gender :</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-select v-model="form.gender" :options="genderList"></b-form-select>
                                        </b-col>
                                    </b-row>
                                    </b-col>
                                    <b-col>
                                        <b-row class="my-1">
                                        <b-col md="3">
                                            <label>Quata :</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-select v-model="form.quata" :options="quataList"></b-form-select>
                                        </b-col>
                                    </b-row>
                                    </b-col>
                                    <b-col>
                                        <b-row class="my-1">
                                        <b-col md="3">
                                            <label>Age:</label>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-input v-model="form.jobTitle" type="text"></b-form-input>
                                        </b-col>
                                    </b-row>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col class="d-flex justify-content-end">
                                        <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Submit</b-button> &nbsp;
                                        <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button>
                                    </b-col>
                                </b-row>
                        </b-form>
                    </b-card>
                </b-col>
            </b-row>

             <b-row>
                        <b-col>

                            <b-card title="Short List">
                                <b-row>
                                    <b-col md="12" class="mb-2">
                                        <b-table   striped :items="jobDetails">

                                        </b-table>
                                    </b-col>

                                <b-col sm="2" md="2" class="my-1">
                                    <b-form-group
                                    label="Per page"
                                    label-cols-sm="6"
                                    label-cols-md="6"
                                    label-cols-lg="6"
                                    label-align-sm="left"
                                    label-size="sm"
                                    label-for="perPageSelect"
                                    class="mb-0"
                                    >
                                    <b-form-select
                                        v-model="perPage"
                                        id="perPageSelect"
                                        size="sm"
                                        :options="pageOptions"
                                    ></b-form-select>
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
                                 <b-table striped hover show-empty :items="items" :current-page="1" :per-page="10" :filter="filter" :sort-by.sync="sortBy"
                                          :sort-desc.sync="sortDesc" :sort-direction="sortDirection" :fields="fields" responsive="sm">
                                <template v-slot:cell(select)="row">
                                    <b-form-checkbox id="status" v-model="status"  value="accepted"> </b-form-checkbox>
                                </template>
                                <template v-slot:cell(action)="row">
                                     <a  href="recruitment#/applicant-profile" class="btn btn btn-dark btn-sm"> View CV </a>
                                </template>
                                </b-table>
                                <b-col sm="12" md="12" class="my-1">
                                    <b-pagination
                                    v-model="currentPage"
                                    :total-rows="totalRows"
                                    :per-page="perPage"
                                    align="right"
                                    size="sm"
                                    class="my-0"
                                    ></b-pagination>
                                </b-col>
                                <b-row class="mt-3">
                                        <b-col class="d-flex justify-content-end ">
                                            <b-button type="button" class="btn btn-dark shadow mr-1 mb-1">Short List</b-button> &nbsp;
                                            <b-button type="button" class="btn btn-dark shadow  mb-1 mr-1">Deny</b-button> &nbsp;
                                            <b-button type="button" class="btn btn-dark shadow  mb-1 mr-1">Block</b-button>
                                        </b-col>
                                </b-row>
                            </b-card>
                        </b-col>

                    </b-row>
        </div>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker'
    export default {
        components: { DatePicker },
        data(){
           return {
               status:[],
               form: {
                incidentID: '001254',
                description: '',
                subject: null,
                education: null,
                jobTitle: null,
                gender: null,
                quata: null,
                },
                jobTitleList:[{ text: 'Select One', value: null }, 'Senior Programmer', 'Jonior Operator', 'Grreer','Asst. System Analyst'],
                educationList:[{ text: 'Select One', value: null }, 'M.SC', 'B.SC (Hons)'],
                subjectList:[{ text: 'Select One', value: null }, 'Computer Science', 'EEE'],
                genderList:[{ text: 'Select One', value: null }, 'Male', 'Female', 'Others'],
                quataList:[{ text: 'Select One', value: null }, 'Freedom Fighter', 'General', 'Dependent'],
                show:true,
                fields: [
                            {key: 'SL', sortable: true},
                            {key: 'applicationID', sortable: true},
                            {key: 'Name', sortable: true},
                            {key: 'District', sortable: true},
                            {key: 'quata', sortable: true},
                            'action',
                            'select'
                       ],
                items: [
                        {isActive: true,  SL:'1', applicationID: 'ASA-003', Name: 'Hridoy Khan', District: 'Chittangong', quata: 'Freedom Fighter' },
                        {isActive: true,  SL:'2', applicationID: 'ASA-004', Name: 'Sakib Al Hasan', District: 'Khulna', quata: 'General' },
                        {isActive: true,  SL:'3', applicationID: 'ASA-005', Name: 'Mosfiqur Rahim', District: 'Rajshahi', quata: 'Dependent' },
                        {isActive: true,  SL:'4', applicationID: 'ASA-006', Name: 'Hridoy Khan', District: 'Chittangong', quata: 'Freedom Fighter' },
                      ],
                jobDetails: [
                    {JobTitle: 'Senior Programmer', 'Adv. ID': '06/2019', NoOfPost: '30', Views: '35',Application: '5', Status: 'Not Reviewed', Expires: '20/11/2019' },
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
            this.$store.commit("setBreadcrumb", { link: "#", label: "Online Recruitment" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Application Short List" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Short List" });
            this.totalRows = this.items.length
        },
         methods: {
                onSubmit(evt) {
                    evt.preventDefault()
                    console.log(JSON.stringify(this.form))
                    },
                    onReset(evt) {
                        evt.preventDefault()
                        // Reset our form values
                        this.form.incidentID = ''
                        this.form.description = ''
                        this.form.category = null
                        this.form.location = null
                        this.form.shipname = null
                        // Trick to reset/clear native browser form validation state
                        this.show = false
                        this.$nextTick(() => {
                        this.show = true
                        })
                },
             },
              actionBtn(item, index, button) {
                this.infoModal.title = `Row index: ${index}`
                this.infoModal.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }

    }

</script>


<style scoped>

</style>
