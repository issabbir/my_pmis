<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked  pt-0">
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0">
                        <b-card title="Tour">
                            <b-card-body class="border">
                                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                                    <b-row>
                                        <b-col md="4">
                                            <b-form-group label="Tour Name" label-for="tourName"
                                                          class="requiredField">
                                                <b-form-input v-model="tour.tour_name" required
                                                              v-validate="'required'"
                                                              name="tour_name" :maxlength="500"></b-form-input>
                                                <span :style="errorMessage">{{ errors.first('tour_name') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group label="Tour Name Bangla" label-for="purpose">
                                                <b-form-input v-model="tour.tour_name_bng" :maxlength="3000"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group label="Tour Type" label-for="tour_type_id"
                                                          class="requiredField">
                                                <v-select v-model="tourType" :options="tourTypeList"
                                                          name="tour_type_id" id="tour_type_id" label="text"
                                                          v-validate="'required'"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('tour_type_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group label="Sponsor" label-for="sponsor">
                                                <b-form-input v-model="tour.sponsor" :maxlength="500"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group label="Sponsor Bangla" label-for="tourName">
                                                <b-form-input
                                                    v-model="tour.sponsor_bng" :maxlength="3000"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group label="Country" label-for="country">
                                                <v-select v-model="country" :options="countyList"
                                                          name="country" id="country" label="text"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group label="Start Date" label-for="section"
                                                          class="requiredField">
                                                <date-picker
                                                    v-model="tour.travel_date"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    required v-validate="'required'"
                                                    name="tour_start_date"
                                                    :not-after="notAfter()"
                                                ></date-picker>
                                                <span :style="errorMessage">{{ errors.first('tour_start_date') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" :class="{pointerEvents:!tour.travel_date}">
                                            <b-form-group label="End Date" label-for="section"
                                                          class="requiredField">
                                                <date-picker
                                                    v-model="tour.return_date"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    :not-before="notBeforeStartDate()"
                                                    required v-validate="'required'"
                                                    name="tour_end_date"
                                                ></date-picker>
                                                <span :style="errorMessage">{{ errors.first('tour_end_date') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group label="Tour Duration"
                                                          label-for="tour_duration">
                                                <b-form-input v-model="tour.tour_duration"
                                                              id="tour_duration"
                                                              name="tour_duration"
                                                              disabled
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="12">
                                            <b-form-group label="Tour Description"
                                                          label-for="tour_description">
                                                <b-form-textarea
                                                    v-model="tour.note" rows="2" max-rows="6"></b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1" :disabled="keepDisable">{{submitBtn}}</b-button>
                                            <b-button type="reset" class="btn btn-outline-dark" :disabled="keepDisable">Cancel</b-button>
                                        </b-col>
                                    </b-row>

                                </b-form>
                            </b-card-body>
                        </b-card>
                        <b-card title="Tour Information List">
                            <b-card-body class="border">
                                <Datatable v-bind:fields="tableData.fields"
                                           v-bind:items="tableData.items"
                                           :totalList="totalList"
                                           :perPage="perPage" :primaryKeyColumnName="'tour_id'">
                                    <template v-slot:actions="{ rows }">
                                        <b-link ml="4" class="text-primary"
                                                @click="editRow(rows.item.tour_id)">
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>
                                        <b-link class="text-danger" v-b-modal="'tour-remove'" @click="deletedItem = rows.item">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>
                                    </template>
                                </Datatable>
                                <b-modal :id="'tour-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                                         @ok="deleteRow()" @hidden="deletedItem = null">
                                    <div>Are you sure you want to delete?</div>
                                </b-modal>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import SideBar from "../partials/sidebar";
    import Datatable from "../../../layouts/common/datatable";
    import ApiRepository from "../../../Repository/ApiRepository";
    import vSelect from 'vue-select';

    export default {
        components: {DatePicker, SideBar, Datatable, vSelect},
        props: ['id'],
        data() {
            return {
                tourType:{'text':'', 'value':''},
                country:{'text':'', 'value':''},
                deletedItem: null,
                keepDisabledEndDate: true,
                keepDisable: false,
                errorMessage: {color: 'red'},
                valueType: this.dateFormatter(),
                tour: {
                    emp_id: null,
                    tour_name: null,
                    tour_name_bng: null,
                    tour_type_id: null,
                    sponsor: null,
                    sponsor_bng: null,
                    note: null,
                    tour_duration: null,
                    travel_date: null,
                    return_date: null,
                    country_id: null,
                },
                updateIndex: -1,
                submitBtn: 'Save',
                show: true,
                tableData: {
                    fields: [
                        {key: 'index', label: 'SL'},
                        {key: "tour_name", label:"Tour", sortable: true},
                        {
                            key: "travel_date", sortable: true, filterByFormatted: true, sortByFormatted: true,
                            formatter: value => {
                                if (value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }
                        },
                        {
                            key: "return_date", sortable: true, filterByFormatted: true, sortByFormatted: true,
                            formatter: value => {
                                if (value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }
                        },
                        {key: "tour_duration", sortable: true},
                        {key: "country.country", label: 'Country', sortable: true},
                        {key: "sponsor", sortable: true},
                        "action"
                    ],
                    items: []
                },

                countyList: [],
                tourTypeList: [],

                totalList: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: "",
                sortDesc: false,
                sortDirection: "asc",
                filter: null,
                filterOn: [],
            };
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Tour"});
            this.allTour();
            this.tour.emp_id = this.id;
        },
        watch: {
            "tour.travel_date": function() {
                this.keepDisabledEndDate = false;
                if(this.tour.travel_date && this.tour.return_date)
                {
                    this.tour.tour_duration = this.getTourDuration(this.tour.travel_date, this.tour.return_date);
                }
            },
            "tour.return_date": function() {
                if(this.tour.travel_date && this.tour.return_date)
                {
                    this.tour.tour_duration = this.getTourDuration(this.tour.travel_date, this.tour.return_date);
                }
            },
            tourType:function (val, oldVal) {
                if(val !== null) {
                    this.tour.tour_type_id = val;
                } else {
                    this.tour.tour_type_id = '';
                }

            },
            country:function (val, oldVal) {
                if(val !== null) {
                    this.tour.country_id = val;
                } else {
                    this.tour.country_id = '';
                }

            }
        },
        methods: {
            notAfter: function() {
                if(this.tour.return_date) {
                    return moment(this.tour.return_date).subtract('1', 'days');
                }
            },
            getTourDuration(start_date, end_date) {
                let duration = moment.duration(moment(end_date).diff(start_date));
                let years = duration.years();
                let months = duration.months();
                let days = duration.days()+1;

                let textDuration = '';
                if(years > 0) {
                    textDuration = `${years} years `;
                }

                if(months > 0) {
                    textDuration += `${months} months `;
                }

                if(days > 0) {
                    textDuration += `${days} days`;
                }

                return textDuration;
            },
            dateFormatter: function () {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null;
                    }
                }
            },
            notBeforeStartDate() {
                if(this.tour.travel_date) {
                    return moment(this.tour.travel_date);
                }
            },
            notAfterToday() {
                return moment().subtract(1, 'days');
            },
            hasEmpId: function () {
                return ((this.id !== undefined) && (this.id > 0));
            },
            allTour() {
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/tours/specific/${this.id}`).then(result => {
                        console.log(result.data);
                        this.countyList = result.data.countries;
                        this.tourTypeList = result.data.tourtypes;
                        this.tableData.items = result.data.tours;
                        this.totalList = result.data.tours.length;
                    });
                }
            },

            onSubmit() {
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.keepDisable = true;
                        // let id = this.$route.params.id;
                        ApiRepository.callApi(
                            ApiRepository.POST_COMMAND,
                            "/pmis/employee/tours",
                            this.tour
                        ).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.onReset();
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                            } else {
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                            }
                            this.allTour();
                            this.keepDisable = false;
                        });
                    }
                });
            },
            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/tours/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.tour = result.data;
                    this.tourType.text = result.data.tour_type.tour_type;
                    this.tourType.value = result.data.tour_type.tour_type_id;
                    this.country = result.data.country;
                    this.tour.tour_id = id;
                });
            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/pmis/employee/tours/${this.deletedItem.tour_id}`).then(result => {
                        if (result.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'success'})
                        } else {
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'error'})
                        }
                        this.deletedItem = null;
                        this.onReset();
                        this.allTour();
                    }).catch(err => {
                        this.deletedItem = null;
                        console.log(err);
                    });
                }
            },
            onReset() {
                // Reset our form values
                this.updateIndex = -1;
                this.deletedItem = null;
                this.submitBtn = 'Save';
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.tour={},
                    this.show = true;
                });
            },


            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1;
            }
        }
    };
</script>
<style scoped>
    .pointerEvents{
        pointer-events: none;
    }
</style>
