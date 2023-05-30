<template>
    <div class="content-body">
        <b-card class="bg-transparent ">
            <b-card-body class="pills-stacked pt-0">
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0">
                        <b-card title="Academic">
                            <b-card-body class="border">
                                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                                    <b-row>
                                        <b-col md="3">
                                            <b-form-group
                                                class="requiredField"
                                                label="Name of Exam"
                                                label-for="exam_id">
                                                <v-select v-model="exam" :options="exams"
                                                          name="exam_id" id="exam_id" label="text"
                                                          class="uppercase"
                                                          @input="examChange(exam.value)"
                                                          required v-validate="'required'">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('exam_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Subject/Group/Major"
                                                label-for="subject"
                                                class="requiredField">
                                                <b-form-input
                                                    id="subject"
                                                    name="subject"
                                                    v-model="academic.subject"
                                                    type="text"
                                                    required
                                                    placeholder="Subject"
                                                    v-validate="'required'"
                                                    :maxlength="500">
                                                </b-form-input>
                                                <span :style="errorMessage">{{ errors.first('subject') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Subject/Group/Major(Bangla)"
                                                label-for="subject">
                                                <b-form-input
                                                    id="subject_bng"
                                                    v-model="academic.subject_bng"
                                                    type="text"
                                                    :maxlength="3000"
                                                    placeholder="Subject Name In Bangla"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Result"
                                                class="requiredField"
                                                label-for="exam_result_type">
                                                <v-select v-model="resultType" :options="exam_result_types"
                                                          name="exam_result_type_id" id="exam_result_type_id" label="text" value="value"
                                                          class="uppercase"
                                                          required v-validate="'required'">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('exam_result_type_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="3" v-if="resultType.external_attribute_yn=='Y'">
                                            <b-form-group
                                                label="Point"
                                                label-for="exam_result">
                                                <b-form-input
                                                    id="exam_result"
                                                    name="point"
                                                    v-model="academic.exam_result"
                                                    type="text"
                                                    :maxlength="4"
                                                    v-validate="pointValidationRule"
                                                    required
                                                    placeholder="point">
                                                </b-form-input>
                                                <span :style="errorMessage">{{ errors.first('point') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Exam Body"
                                                class="requiredField"
                                                label-for="board">
                                                <v-select v-model="examBody" :options="exam_bodys"
                                                          name="board" id="board" label="text"
                                                          required v-validate="'required'"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('board') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Institution Name"
                                                label-for="institute_name">
                                                <b-form-input
                                                    id="institute_name"
                                                    v-model="academic.institute_name"
                                                    type="text"
                                                    required
                                                    placeholder="Institute name"
                                                    :maxlength="500">
                                                </b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                class="requiredField"
                                                label="Year"
                                                label-for="passing_year">
                                                <date-picker v-model="academic.passing_year"
                                                             width="100%"
                                                             input-class="form-control"
                                                             type="year" lang="en"
                                                             name="passing_year"
                                                             format="YYYY" :value-type="valueType" :editable="false" :not-after="notAfterYears()" required v-validate="'required'">
                                                </date-picker>
                                                <span :style="errorMessage">{{ errors.first('passing_year') }}</span>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1" :disabled="keepDisable">{{submitBtn}}</b-button>&nbsp;
                                            <b-button type="reset" class="btn btn-outline-dark" :disabled="keepDisable">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </b-card-body>
                        </b-card>
                        <b-card title="Academic Information List">
                            <b-card-body class="border">
                                <Datatable v-bind:fields="fields"
                                           v-bind:items="items"  :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'emp_education_id'">
                                    <template v-slot:actions="{ rows }">
                                        <b-link ml="4" class="text-primary"
                                                @click="editRow(rows.item.emp_education_id)">
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>

                                        <b-link class="text-danger" v-b-modal="'academic-remove'" @click="deletedItem = rows.item">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>

                                    </template>
                                </Datatable>
                                <b-modal :id="'academic-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
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
    import DatePicker from 'vue2-datepicker';
    import SideBar from "../partials/sidebar";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    import vSelect from 'vue-select';

    export default {
        components: {DatePicker, SideBar, Datatable, vSelect},
        props: ['id'],
        data() {
            return {
                exam: {'text':'', 'value':''},
                examBody: {'text':'', 'value':''},
                resultType: {'text':'','value':''},
                deletedItem: null,
                keepDisable: false,
                pointValidationRule: 'max_value:5',
                valueType: this.yearFormatter(),
                errorMessage: {color: 'red'},
                item:{},
                academic: {
                    exam_id: '',
                    subject: '',
                    subject_bng: '',
                    exam_result_type_id: '',
                    exam_result: '',
                    exam_body_id: '',
                    institute_name: '',
                    passing_year: '',
                    prv_external_attribute_yn:'',
                },
                submitBtn: 'Save',
                show: true,
                fields: [{key: 'index', label: 'SL'},
                    {key: 'exam.exam_name', label: 'exam Name', sortable: true},
                    {key: 'subject', label: 'Subject', sortable: true},
                    {key: 'exam_body.exam_body_name', label: 'Exam Body', sortable: true},
                    {key: 'institute_name', label: 'Institutue', sortable: true},
                    {key: 'result_type.exam_result_type', label: 'Result Type', sortable: true},
                    {key: 'exam_result', label: 'Exam Result', sortable: true},
                    {key: 'passing_year', sortable: true}, 'action'],
                items: [],
                exams: [{'value': '', 'text': 'Select Exam'}],
                exam_bodys: [{'value': '', 'text': 'Select Board'}],
                exam_result_types:[{'value': '', 'text': 'Select result type'}],
                results: [],
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Academic"});
            this.academic.emp_id = this.id;
            this.loadData();
        },
        watch: {
            exam:function(val,oldVal) {
                if(val !== null) {
                    this.academic.exam_id = val.exam_id;
                } else {
                    this.academic.exam_id = '';
                }
            },
            examBody:function(val,oldVal) {
                if(val !== null) {
                    this.academic.exam_body_id = val.value;
                } else {
                    this.academic.exam_body_id = '';
                }
            },
            resultType:function(val,oldVal) {
                if(val !== null) {
                    this.academic.exam_result_type_id = val.exam_result_type_id;
                    if(this.academic.prv_external_attribute_yn !='Y' && val.external_attribute_yn!=this.academic.prv_external_attribute_yn){
                        this.academic.exam_result=''
                    }
                } else {
                    this.academic.exam_result_type_id = '';
                }
            },
            "academic.exam_result_type_id": function() {
                let result_type = this.exam_result_types.find(row => {
                    return row.exam_result_type_id == this.academic.exam_result_type_id;
                });

                if(result_type) {
                    let exam_result_type_id = result_type.exam_result_type_id;
                    if(exam_result_type_id) {
                        if(exam_result_type_id ==4) {
                            this.pointValidationRule = 'max_value:4';
                        }else{
                            this.pointValidationRule = 'max_value:5';
                        }
                    }
                 }

                }
        },
        methods: {
            examChange(id){
              if(id){
                  ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/exam-bodies-by-exam/${id}`).then(result => {

                      this.exam_bodys = result.data;
                  });
              }
            },
             examBodyChange(id){
                if(id){
                     ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/institutes/${id}`).then(result => {
                        this.institutes = result.data;
                    });
                }
            },
            hasEmpId: function() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            yearFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY") : null;
                    }
                }
            },
            notAfterYears() {
                return moment();
            },
            onSubmit() {
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.keepDisable = true;
                        this.academic.emp_id = this.id;
                        if(this.resultType.external_attribute_yn=='N'){
                            this.academic.exam_result=this.resultType.exam_result_type;
                        }
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/academics", this.academic).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.onReset();
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                            } else{
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                            }
                            this.loadData();
                            this.keepDisable = false;
                        });
                    }
                });
            },
            loadData: function () {
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/academics/specific/${this.id}`).then(res => {
                        if(this.exams.length <=1) {
                            this.exams = this.exams.concat(res.data.exams);
                        }
                        this.items = res.data.data;
                        this.exam_result_types=res.data.result_types;
                        this.totalList = res.data.data.length;
                    });
                }
            },
            onReset() {
                this.deletedItem = null;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.academic={};
                    this.exam='';
                    this.examBody='';
                    this.resultType ='';
                    this.show = true
                })
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1;
            },
            editRow(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/academics/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.academic = result.data;
                    this.academic.prv_external_attribute_yn=result.data.result_type.external_attribute_yn;
                    console.log(this.academic);
                    this.exam=result.data.exam;
                    this.examBody=result.data.exam_body;
                    this.resultType = result.data.selectedResultType;
                    this.examBodyChange(result.data.exam_body_id);
                });
            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/pmis/employee/academics/${this.deletedItem.emp_education_id}`).then(result => {
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

