<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-header header-bg-variant="dark" header-text-variant="white">Traning</b-card-header>

            <b-card-body class="pills-stacked " style="padding-top:0px">

                <b-row>
                        <b-card title="" v-if="can_update">
                            <b-card-body class="border">
                                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                                    <b-row class="mt-2">
                                        <b-col md="3">
                                            <b-form-group
                                                label="Training Name"
                                                label-for="training_name" class="requiredField"
                                            >
                                                <b-form-input
                                                    v-model="training.training_name"
                                                    type="text"
                                                    placeholder="Training Name"
                                                    required v-validate="'required'" name="training_name"
                                                    :maxlength="500"
                                                ></b-form-input>
                                                <span :style="errorMessage">{{ errors.first('training_name') }}</span>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="3">
                                            <b-form-group
                                                label="TRAINING TYPE"
                                                label-for="training_type" class="requiredField"
                                            >
                                                <v-select v-model="trainingTypes" :options="trainingTypeList"
                                                          name="training_type" id="training_type" label="text"
                                                          @input="checkCountryField(trainingTypes.value)"
                                                          required v-validate="'required'"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input :required="!trainingTypes.value" class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('training_type_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3" v-if="enableCountry">
                                            <b-form-group
                                                label="COUNTRY"
                                                label-for="trainig_country_id"
                                            >
                                                <v-select v-model="countries" :options="countryList"
                                                          name="trainig_country_id" id="trainig_country_id" label="text"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="TRAINING INSTITUTE"
                                                label-for="training_institute" class="requiredField"
                                            >
                                                <b-form-input
                                                    v-model="training.training_institute"
                                                    type="text"
                                                    required
                                                    placeholder="Training Institute"
                                                ></b-form-input>

                                            </b-form-group>
                                        </b-col>

                                        <b-col md="3">
                                            <b-form-group
                                                label="TRAINING START DATE"
                                                label-for="training_start_date"
                                            >
                                                <date-picker
                                                    v-model="training.training_start_date"
                                                    input-class="form-control"
                                                    width="100%"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    :not-after="notAfterToday()">
                                                </date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="TRAINING COMPLETION DATE"
                                                label-for="training_completion_date"
                                            >
                                                <date-picker
                                                    v-model="training.training_completion_date"
                                                    input-class="form-control"
                                                    width="100%"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    :not-after="notAfterToday()"
                                                    :disabled = "keepDisabledEndDate"
                                                    :not-before="notBeforeStartDate()">
                                                </date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Training Duration"
                                                label-for="training_duration"
                                            >
                                                <b-form-input
                                                    v-model="training.training_duration"
                                                    type="text"
                                                    name="training_duration"
                                                    placeholder="Duration Of Training"
                                                    disabled
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col :md="training.training_type_id.training_type_id==3?3:6">
                                            <b-form-group
                                                label="TRAINING REPORT"
                                                label-for="uploadImage"
                                            >
                                                <div class="custom-file b-form-file">
                                                    <input type="file" class="custom-file-input" @change="getDocument" accept="application/msword, application/pdf, image/png, image/jpg, image/jpeg" v-validate.reject="'size:500'" name="training_report" />
                                                    <label data-browse="Browse" class="custom-file-label">{{training.training_report_document_name}}</label>
                                                    <span :style="errorMessage">{{ errors.first('training_report') }}</span>
                                                </div>
                                                <div v-if="hasAuthenticationDocument()">
                                                    <a :href="getAuthenticationDownloaderUrl(training.training_id)" target="_blank"> {{training.training_report_document_name}} </a>
                                                </div>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="6">
                                            <b-form-group
                                                label="Training Description"
                                                label-for="training_description"
                                            >
                                                <b-form-textarea
                                                    rows="2"
                                                    max-rows="5"
                                                    v-model="training.training_description"
                                                    placeholder="Training Description"
                                                ></b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group
                                                label="Achievement"
                                                label-for="training_acheivment"
                                            >
                                                <b-form-textarea
                                                    v-model="training.training_acheivment"
                                                    placeholder="Achievement/Add Note/Comment"
                                                    rows="2"
                                                    max-rows="5"
                                                ></b-form-textarea>
                                            </b-form-group>
                                        </b-col>

                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1" :disabled="keepDisable">{{submitBtn}}</b-button>
                                            <b-button type="reset" class="btn btn-outline-dark" @click.prevent="onReset" :disabled="keepDisable">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </b-card-body>
                        </b-card>

                            <b-card-body class="border">
                                <Datatable v-bind:fields="fields"  v-bind:items="items" :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'training_id'">
                                    <template v-slot:actions="{ rows }">
                                        <b-link ml="4" class="text-primary" @click="editRow(rows.item.training_id)"><i class="bx bx-edit cursor-pointer"></i></b-link>
                                        <b-link class="text-danger" v-b-modal="'training-remove'" @click="deletedItem = rows.item"><i class="bx bx-trash cursor-pointer"></i></b-link>
                                    </template>
                                    <template v-slot:action2="{ rows }">
                                        <span v-if="rows.item.approved_yn == 'Y'" class="text-success text-center">Approved</span>
                                        <span class="text-danger text-center" v-else>Pending</span>
                                    </template>
                                </Datatable>
                                <b-modal :id="'training-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                                         @ok="deleteRow()" @hidden="deletedItem = null">
                                    <div>Are you sure you want to delete?</div>
                                </b-modal>
                            </b-card-body>

                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    import vSelect from 'vue-select';

    export default {
        components: { DatePicker, Datatable, vSelect},
        props: ['id'],
        data() {
            return {
                hidenseek: true,
                column:false,
                trainingTypes:{'text':'','value':''},
                countries:{'text':'','value':''},
                deletedItem: null,
                keepDisabledEndDate: true,
                enableCountry: false,
                keepDisable: false,
                errorMessage: {color: 'red'},
                valueType: this.dateFormatter(),
                training: {
                    training_name:'',
                    training_type_id:'',
                    trainig_country_id:'',
                    training_description:'',
                    training_institute:'',
                    training_duration:'',
                    training_start_date: '',
                    training_completion_date:'',
                    training_report_document: null,
                    training_report_document_name: '',
                    training_report_document_type: '',
                    training_acheivment:'',
                },

                countryList: [{'value': '', 'text': 'Select Country'}],
                trainingTypeList:[{'value': '', 'text': 'Select Training type'}],
                updateIndex:-1,
                submitBtn: 'Save',
                can_update: false,


                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'training_name', label: 'Training Name', sortable: true},
                    {key: 'training_type.training_type', label: 'Training Type', sortable: true},
                    {key: 'training_institute', label: 'Training Institute', sortable: true},
                    {key: 'training_duration', label: 'Training Duration',sortable: true},
                    {key: 'training_start_date', label: 'Start Date', sortable: true, filterByFormatted: true, sortByFormatted: true,
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }
                    },
                    {key: 'training_completion_date', label: 'Completion Date', sortable: true, filterByFormatted: true, sortByFormatted: true,
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }
                    },
                    {key: 'action2', label: 'Status'}
                ],

                items: [],

                totalList: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Training"});
            this.training.emp_id = this.id;
            this.loadData()
            this.canUpdate()
        },
        watch: {
            can_update: function(val, oldVal){
                if(val){
                    this.fields.push({key: 'action', class: 'text-center'})
                }
            },
            "training.training_start_date": function() {
                this.keepDisabledEndDate = false;
                if(this.training.training_start_date && this.training.training_completion_date)
                {
                    this.training.training_duration = this.getTrainingDuration(this.training.training_start_date, this.training.training_completion_date);
                }
            },
            "training.training_completion_date": function() {
                if(this.training.training_start_date && this.training.training_completion_date)
                {
                    this.training.training_duration = this.getTrainingDuration(this.training.training_start_date, this.training.training_completion_date);
                }
            },
            trainingTypes:function(val,oldVal) {
                if(val !== null) {
                    this.training.training_type_id = val;
                } else {
                    this.training.training_type_id = '';
                }
            },
            countries:function(val,oldVal) {
                if(val !== null) {
                    this.training.trainig_country_id = val;
                } else {
                    this.training.trainig_country_id = '';
                }
            },
        },
        methods: {
            canUpdate(){
                this.can_update = this.$store.getters.permissions.includes('CAN_UPDATE')
            },
            hasAuthenticationDocument() {
                return (this.training.training_id && this.training.training_report_document);
            },
            getAuthenticationDownloaderUrl(trainingId) {
                return 'pmis/training/download-authentication-document/'+trainingId;
            },
            getTrainingDuration(start_date, end_date) {
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
            notBeforeStartDate() {
                if(this.training.training_start_date) {
                    return moment(this.training.training_start_date);
                }
            },
            checkCountryField(id) {
                if(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/trainings/check-country-field/${id}`, this.training).then(res => {
                        this.enableCountry = res.data.enable_country;
                        this.column = true;
                    });
                } else {
                    this.column = false;
                    this.enableCountry = false;
                }
            },
            dateFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null;
                    }
                }
            },
            notAfterToday() {
                return moment()
            },
            getDocument: function(event) {
                let input = event.target;
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.training.training_report_document = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                    this.training.training_report_document_name = input.files[0].name;
                    this.training.training_report_document_type = input.files[0].name.split('.').pop();
                    console.log('name: ', this.training.training_report_document_name);
                    console.log('type: ', this.training.training_report_document_type);
                }
            },
            hasEmpId: function() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            onSubmit() {
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.keepDisable = true;
                        if(!this.enableCountry) {
                            this.training.trainig_country_id = '';
                        }
                        if(this.updateIndex > 0) {
                            ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/pmis/employee/trainings/${this.updateIndex}`, this.training).then(res => {
                                if (res.data.o_status_code == 1) {
                                    this.onReset();
                                    this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                                } else{
                                    this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                                }
                                this.loadData();
                                this.keepDisable = false;
                            })
                        } else {
                            ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/trainings", this.training).then(res => {
                                if (res.data.o_status_code == 1) {
                                    this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                                } else{
                                    this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                                }
                                this.onReset();
                                this.loadData();
                                this.keepDisable = false;
                            })
                        }
                    }
                });
            },
            loadData: function() {
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/trainings/specific/${this.id}`).then(res => {
                        if(this.countryList.length <=1) {
                            this.countryList = this.countryList.concat(res.data.countryList);
                        }

                        if(this.trainingTypeList.length <=1) {
                            this.trainingTypeList = this.trainingTypeList.concat(res.data.trainingTypeList);
                        }

                        this.items = res.data.data;
                        this.totalList = res.data.data.length;
                    });
                }
            },

            onReset() {
                /*this.countryList = [{'value': '', 'text': 'Select Country'}];
                this.trainingTypeList = [{'value': '', 'text': 'Select Training type'}];*/
                this.enableCountry = false;
                this.updateIndex = -1;
                this.deletedItem = null;
                this.submitBtn = 'Save';
                this.$nextTick(() => {
                    this.training.training_name= '';
                    this.training.training_type_id= '';
                    this.training.trainig_country_id= '';
                    this.training.training_description='';
                    this.training.training_institute= '';
                    this.training.training_duration= '';
                    this.training.training_start_date = '';
                    this.training.training_completion_date= '';
                    this.training.training_report_document= null;
                    this.training.training_report_document_name = '';
                    this.training.training_report_document_type = '';
                    this.training.training_acheivment= '';
                })
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1
            },

            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/pmis/employee/trainings/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.training = result.data;
                    this.trainingTypes = result.data.training_type;
                    this.countries = result.data.training_country;
                    this.checkCountryField(result.data.training_type.value);
                });
            },

            // Delete Row
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/pmis/employee/trainings/${this.deletedItem.training_id}`).then( result => {
                        if (result.data.o_status_code == 1) {
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                        } else{
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                        }
                        this.deletedItem = null;
                        this.onReset();
                        this.loadData();
                    }).catch(err => {
                        this.deletedItem = null;
                        console.log(err);
                    });
                }
            }
        }
    }
</script>

<style>
    #trainingpic{
        height: 180px !important;
        width: 100%;
    }
</style>

