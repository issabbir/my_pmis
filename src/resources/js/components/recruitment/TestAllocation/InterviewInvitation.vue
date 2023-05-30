<template>
    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card title="Interview Invitation">
                            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                <b-row>
                                    <b-col>
                                    <b-row class="my-1">
                                        <b-col md="3">
                                        <label>Ref No</label>
                                        </b-col>
                                        <b-col md="9">
                                        <b-form-select v-model="form.religion" :options="religion"></b-form-select>
                                        </b-col>
                                    </b-row>
                                    </b-col>
                                    <b-col>
                                    <b-row class="my-1">
                                        <b-col md="3">
                                        <label>Job Title</label>
                                        </b-col>
                                        <b-col md="9">
                                        <b-form-select v-model="form.religion" :options="religion"></b-form-select>
                                        </b-col>
                                    </b-row>
                                    </b-col>
                                    <b-col>
                                    <b-row class="my-1">
                                        <b-col md="3">
                                        <label>Board Name</label>
                                        </b-col>
                                        <b-col md="9">
                                        <b-form-select v-model="form.religion" :options="religion"></b-form-select>
                                        </b-col>
                                    </b-row>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="4">
                                        <b-row class="my-1">
                                            <b-col md="3">
                                            <label>DATE</label>
                                            </b-col>
                                            <b-col md="9">
                                            <date-picker v-model="interviwdate" width="100%" input-class="form-control" type="datetime" lang="en" format="YYYY-MM-DD hh:mm:ss"></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-col>
                                    <b-col md="4">
                                        <b-row class="my-1">
                                            <b-col md="3">
                                            <label>Location</label>
                                            </b-col>
                                            <b-col md="9">
                                            <b-form-input id="interview_loc" placeholder="Location"></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-col>
                                </b-row>
                                <b-row class="d-flex justify-content-end">
                                    <b-button variant="secondary">Save</b-button>&nbsp;
                                    <b-button variant="secondary">Cancel</b-button>
                                </b-row>
                            </b-form>

                    </b-card>
                    <b-row>
                        <b-col>
                            <b-card title="Interview Invitation List">
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
                                                size="sm"></b-form-select>
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
                                <b-table striped hover show-empty :items="items" :current-page="currentPage" :per-page="perPage" :filter="filter" :sort-by.sync="sortBy"
                                         :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                                         <template v-slot:cell(actions)="row">
                                          <b-button size="sm" @click="info(row.item, row.index, $event.target)" class="mr-1">
                                            Info modal
                                        </b-button>
                                        <b-button size="sm" @click="row.toggleDetails">
                                            {{ row.detailsShowing ? 'Hide' : 'Show' }} Details
                                        </b-button>
                                    </template>
                                </b-table>
                                <b-col sm="12" md="12" class="my-1">
                                    <b-pagination
                                        v-model="currentPage" :total-rows="totalRows" :per-page="perPage"
                                        align="right"
                                        size="sm"
                                        class="my-0"
                                        ></b-pagination>
                                </b-col>
                            </b-card>
                        </b-col>

                    </b-row>
                </b-col>
            </b-row>

        </div>

    </div>

</template>

<script>
    import DatePicker from 'vue2-datepicker'
            export default {
                components: {DatePicker},

                data() {
                    return {
                        interviwdate: new Date(),
                        form: {
                            refno: '',
                            jobTitle: '',
                            board_name: '',
                            interviwdate: '',
                            interview_loc: '',
                        },
                        refnoData: [{text: 'Select', value: null}],
                        jobTitleData: [{text: 'Select', value: null}],
                        boardNameData: [{text: 'Select', value: null}],
                        show: true,
                        items: [
                            {SL: '1', refno: '0009/19', jobtitle: 'Senior Programmer', interviwboard: 'Board-11', date: '15/12/2019 09:30AM', Place: 'Bondar School', action: ''},
                            {SL: '2', refno: '0009/20', jobtitle: 'Programmer', interviwboard: 'Board-12', date: '15/12/2019 09:30AM', Place: 'Bondar School', action: ''},
                            {SL: '3', refno: '0009/21', jobtitle: 'Senior Programmer', interviwboard: 'Board-13', date: '15/12/2019 09:30AM', Place: 'Bondar School', action: ''}
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
                    this.$store.commit("setBreadcrumb", { link: "#", label: "Online Recruitment"});
                    this.$store.commit("setBreadcrumb", { link: "#", label: "Test Allocation"});
                    this.$store.commit("setBreadcrumb", { link: "#", label: "Interview Invitation" });
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
                    info(item, index, button) {
                        this.infoModal.title = `Row index: ${index}`
                        this.infoModal.content = JSON.stringify(item, null, 2)
                        this.$root.$emit('bv::show::modal', this.infoModal.id, button)
                    },
                    resetInfoModal() {
                        this.infoModal.title = ''
                        this.infoModal.content = ''
                    },
                    onFiltered(filteredItems) {
                        // Trigger pagination to update the number of buttons/pages due to filtering
                        this.totalRows = filteredItems.length
                        this.currentPage = 1
                    }
                }

            }
</script>
