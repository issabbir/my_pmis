<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked" style="padding-top:0px;">
                <b-card-title>
                    <b-form-checkbox vertical v-model="hidenseek" name="check-button" switch size="lg"></b-form-checkbox>
                </b-card-title>
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0" :class="{'d-none':!hidenseek}">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0" :class="{'col-md-12':!hidenseek}">
                        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="can_update">
                            <b-card title="Experience">
                                <b-card-body class="border">
                                    <b-row>
                                        <b-col md="4">
                                            <b-form-group label="DESIGNATION" label-for="designation"
                                                          class="requiredField">
                                                <b-form-input
                                                    id="designation"
                                                    v-model="experience.designation"
                                                    type="text"
                                                    required
                                                    placeholder="Designation"
                                                    required v-validate="'required'" name="designation"
                                                    :maxlength="100"
                                                ></b-form-input>
                                                <span :style="errorMessage">{{ errors.first('designation') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group label="From Date" label-for="section"
                                                          class="requiredField">
                                                <date-picker
                                                    v-model="experience.work_from"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    :not-after="notAfter()"
                                                    required v-validate="'required'" name="work_from"
                                                ></date-picker>
                                                <span :style="errorMessage">{{ errors.first('work_from') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group label="To Date" label-for="section"
                                                          class="requiredField">
                                                <date-picker
                                                    v-model="experience.work_to"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    :not-before="notBeforeFromDate()"
                                                    :not-after="notAfterToday()"
                                                    required v-validate="'required'" name="work_to"
                                                    :disabled="KeepDisabledWorkTo"
                                                ></date-picker>
                                                <span :style="errorMessage">{{ errors.first('work_to') }}</span>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="4">
                                            <b-form-group label="EMPLOYER NAME" label-for="Emp_name"
                                                          class="requiredField">
                                                <b-form-input
                                                    id="employer_name"
                                                    v-model="experience.employer_name"
                                                    type="text"
                                                    required
                                                    placeholder="Employer Name"
                                                    required v-validate="'required'"
                                                    :maxlength="500"
                                                    name="employer_name"
                                                ></b-form-input>
                                                <span :style="errorMessage">{{ errors.first('employer_name') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="8">
                                            <b-form-group label="EMPLOYER ADDRESS"
                                                          label-for="emp_address"
                                                          class="requiredField">
                                                <b-form-input
                                                    id="employer_address"
                                                    v-model="experience.employer_address"
                                                    type="text"
                                                    required
                                                    placeholder="Employer Address"
                                                    :maxlength="500"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="12">
                                            <b-form-group label="RESPONSIBILITY" label-for="res">
                                                <b-form-textarea
                                                    v-model="experience.responsibility"
                                                    placeholder="Type responsiblity"
                                                    rows="2"
                                                    max-rows="5"
                                                ></b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button-group>
                                                <b-button
                                                    type="submit"
                                                    id="basic_sub_btn"
                                                    variant="primary"
                                                    :disabled="keepDisable">{{submitBtn}}
                                                </b-button>
                                                <b-button type="reset" variant="secondary"
                                                          :disabled="keepDisable">Cancel
                                                </b-button>
                                            </b-button-group>
                                        </b-col>
                                    </b-row>
                                </b-card-body>
                            </b-card>
                        </b-form>
                        <b-card title="Experience List">
                            <b-card-body class="border">
                                <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'experience_id'">
                                    <template v-slot:actions="{ rows }">
                                        <b-link
                                            ml="4"
                                            class="text-primary"
                                            @click="editRow(rows.item.experience_id)"
                                        >
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>
                                        <b-link class="text-danger"
                                                v-b-modal="'experience-remove'"
                                                @click="deletedItem = rows.item">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>
                                    </template>
                                </Datatable>
                                <b-modal :id="'experience-remove'" :centered="true"
                                         title="Please Confirm" size="sm"
                                         buttonSize="sm" okTitle="YES" cancelTitle="NO"
                                         footerClass="p-2" :hideHeaderClose="false"
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

    export default {
        components: {DatePicker, SideBar, Datatable},
        props: ['id'],
        data() {
            return {
                can_update:false,
                hidenseek: true,
                deletedItem: null,
                KeepDisabledWorkTo: true,
                keepDisable: false,
                errorMessage: {color: 'red'},
                valueType: this.dateFormatter(),
                experience: {
                    designation: null,
                    work_from: null,
                    work_to: null,
                    employer_name: null,
                    employer_address: null,
                    responsibility: null,
                },
                selected: "first",
                updateIndex: -1,
                submitBtn: 'Save',
                show: true,
                tableData: {
                    fields: [
                        {key: 'index', label: 'SL'},
                        {key: "designation", sortable: true},
                        {
                            key: "work_from",
                            filterByFormatted: true,
                            sortByFormatted: true,
                            formatter: value => {
                                if (value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            },
                            sortable: true
                        },
                        {
                            key: "work_to",
                            label: 'work till',
                            filterByFormatted: true,
                            sortByFormatted: true,
                            formatter: value => {
                                if (value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            },
                            sortable: true
                        },
                        {key: "employer_name", sortable: true}
                    ],
                    items: []
                },
                totalList: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                text: ""
            };
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Experience"});
            this.allExperience();
            this.experience.emp_id = this.id
            this.canUpdate()
        },
        watch: {
            can_update: function(val, oldVal){
                if(val){
                    this.tableData.fields.push({key: 'action', class: 'text-center'})
                }
            },
            "experience.work_from": function () {
                this.KeepDisabledWorkTo = false
            },
        },
        methods: {
            canUpdate(){
                this.can_update = this.$store.getters.permissions.includes('CAN_UPDATE')
            },
            dateFormatter() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null;
                    }
                }
            },
            notBeforeFromDate() {
                if (this.experience.work_from) {
                    return moment(this.experience.work_from).add('1', 'days');
                }
            },
            notAfter() {
                if (this.experience.work_to) {
                    return moment(this.experience.work_to).subtract('1', 'days');
                } else {
                    return moment().subtract(1, 'days');
                }
            },
            notAfterToday() {
                return moment().subtract(1, 'days');
            },
            hasEmpId: function () {
                return ((this.id !== undefined) && (this.id > 0));
            },
            allExperience() {
                if (this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/experiences/specific/${this.id}`).then(result => {
                        this.tableData.items = result.data.experience;
                        this.totalList = result.data.experience.length;
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
                            "/pmis/employee/experiences",
                            this.experience
                        ).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.onReset();
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                            } else {
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                            }
                            this.allExperience();
                            this.keepDisable = false;
                        });
                    }
                });
            },


            onReset() {
                // Reset our form values

                // Trick to reset/clear native browser form validation state
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.deletedItem = null;
                this.show = false;
                this.$nextTick(() => {
                    this.experience.experience_id = null;
                    this.experience.designation = null;
                    this.experience.work_from = null;
                    this.experience.work_to = null;
                    this.experience.employer_name = null;
                    this.experience.employer_address = null;
                    this.experience.responsibility = null;

                    this.show = true;
                });
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1;
            },

            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(
                    ApiRepository.GET_COMMAND,
                    `/pmis/employee/experiences/${id}`
                ).then(result => {
                    this.submitBtn = "Update";
                    this.experience = result.data;
                    this.experience.experience_id = id;
                });
            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(
                        ApiRepository.DELETE_COMMAND,
                        `/pmis/employee/experiences/${this.deletedItem.experience_id}`
                    ).then(result => {
                        if (result.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'success'})
                        } else {
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'error'})
                        }
                        this.deletedItem = null;
                        this.onReset();
                        this.allExperience();
                    }).catch(err => {
                        this.deletedItem = null;
                        console.log(err);
                    });
                }
            }
        }
    };
</script>

