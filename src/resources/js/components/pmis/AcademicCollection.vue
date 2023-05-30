<template>
    <div class="content-body">
        <b-card  v-if="can_update">
            <b-card-header header-bg-variant="dark" header-text-variant="white">Academic</b-card-header>
            <b-card-body class="border">
                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                class="requiredField"
                                label="Name of Exam"
                                label-for="exam_id"

                            >
                                <v-select v-model.trim="exam" :options="exams"
                                          name="exam_id" id="exam_id" label="text"
                                          class="uppercase"
                                          @input="examChange(exam.value)">
                                    <template #search="{attributes, events}">
                                        <input
                                            class="vs__search"
                                            v-bind="attributes"
                                            v-on="events"/>
                                    </template>
                                </v-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.academic.exam_id.$error && !$v.academic.exam_id.required}">Exam is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Subject/Group/Major"
                                label-for="subject"
                                class="requiredField">
                                <v-select
                                    v-model.trim="selectedSubject"
                                    :options="SubjectOptions"
                                    name="exam_subject_id"
                                    id="exam_subject_id"
                                    label="text"
                                    class="uppercase"
                                >
                                    <template #search="{attributes, events}">
                                        <input
                                            class="vs__search"
                                            v-bind="attributes"
                                            v-on="events"/>
                                    </template>
                                </v-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.academic.subject.$error && !$v.academic.subject.required}">Subject is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Subject/Group/Major(Bangla)"
                                label-for="subject">
                                <b-form-input
                                    id="subject_bng"
                                    v-model="academic.subject_bng"
                                    type="text"
                                    readonly
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Result Type"
                                class="requiredField"
                                label-for="exam_result_type">
                                <v-select v-model="resultType" :options="exam_result_types" @input="typeChange(resultType.value)"
                                          name="exam_result_type_id" id="exam_result_type_id" label="text" value="value"
                                          class="uppercase">
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events" />
                                    </template>
                                </v-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.academic.exam_result_type_id.$error && !$v.academic.exam_result_type_id.required}">Result type is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Result"
                                class="requiredField"
                                label-for="exam_result">
                                <v-select v-model="result" :options="resultOptions"
                                          name="exam_result" id="exam_result" label="exam_result" value="exam_result_id"
                                          class="uppercase">
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events" />
                                    </template>Agra, Uttar Pradesh, India
                                </v-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.academic.exam_result_id.$error && !$v.academic.exam_result_id.required}">Result is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                :label="academic.exam_result_type_id==3 ||academic.exam_result_type_id==4?'Points':'Marks'"
                                label-for="exam_result">
                                <b-form-input
                                    id="exam_result"
                                    name="Point"
                                    v-model.trim="$v.academic.exam_result.$model"
                                    type="text"
                                >
                                </b-form-input>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.academic.exam_result.$error && !$v.academic.exam_result.required}">Point is required!</div>
                                <div :class="{'invalid-feedback':true ,'d-block': academic.max_value < academic.exam_result}">Value should not exceed {{academic.max_value}}!</div>
                                <div :class="{'invalid-feedback':true ,'d-block':academic.min_value > academic.exam_result}">Value should not less than {{academic.min_value}}!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                class="requiredField"
                                label="Passing Year"
                                label-for="passing_year">
                                <date-picker v-model.trim="$v.academic.passing_year.$model"
                                             width="100%"
                                             input-class="form-control"
                                             type="year" lang="en"
                                             name="passing_year"
                                             format="YYYY"
                                             :value-type="valueType"
                                             :editable="false"
                                             :not-after="notAfterYears()">
                                </date-picker>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.academic.passing_year.$error && !$v.academic.passing_year.required}">Passing year is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Exam Body"
                                class="requiredField"
                                label-for="board">
                                <v-select v-model="examBody" :options="exam_bodys"
                                          name="board" id="board" label="text"
                                          @input="examBodyChange(examBody.value)"
                                          class="uppercase">
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.academic.exam_body_id.$error && !$v.academic.exam_body_id.required}">Exam body is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Institution Name"
                                label-for="institute_name">
                                <v-select v-model="selectedInstitute" :options="institutes"
                                          name="board" id="institute_name" label="text"
                                          class="uppercase">
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.academic.institute_name.$error && !$v.academic.institute_name.required}">Institution name is required!</div>
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
                    <template v-slot:action2="{ rows }">
                        <span v-if="rows.item.approved_yn == 'Y'" class="text-success text-center">Approved</span>
                        <span class="text-danger text-center" v-else>Pending</span>
                    </template>
                </Datatable>
                <b-modal :id="'academic-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                         @ok="deleteRow()" @hidden="deletedItem = null">
                    <div>Are you sure you want to delete?</div>
                </b-modal>
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
    const {required, requiredIf, maxLength, minLength, maxValue, email} = require("vuelidate/lib/validators");

    export default {
        components: {DatePicker, Datatable, vSelect},
        props: ['id'],
        data() {
            return {
                can_update: false,
                hidenseek: true,
                exam: { text:'', value:'' },
                selectedSubject: {'text':'', 'value':'', 'exam_subject_name_bng': ''},
                selectedInstitute: {'text':'', 'value':''},
                examBody: {'text':'', 'value':''},
                result: {
                    exam_result:'',
                    exam_result_id: '',
                    min_value:'',
                    max_value: ''
                },
                resultType: {'text':'','value':''},
                deletedItem: null,
                keepDisable: false,
                pointValidationRule: 'max_value:5',
                valueType: this.yearFormatter(),
                errorMessage: {color: 'red'},
                item:{},
                academic: {
                    emp_education_id: '',
                    exam_id: '',
                    exam_subject_id: '',
                    subject: '',
                    subject_bng: '',
                    exam_result_type_id: '',
                    exam_result: '',
                    exam_result_id: '',
                    exam_body_id: '',
                    institute_id: '',
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
                    {key: 'result.text', label: 'Result', sortable: true},
                    {key: 'exam_result', label: 'Marks/Points', sortable: true},
                    {key: 'passing_year', sortable: true},
                    {key: 'action2', label: 'Status'}
                ],
                items: [],
                exams: [{'value': '', 'text': 'Select Exam'}],
                exam_bodys: [{'value': '', 'text': 'Select Exam Body'}],
                institutes: [{'value': '', 'text': 'Select Institute'}],
                SubjectOptions: [{'value': '', 'text': 'Select Group/Subject'}],
                exam_result_types:[{'value': '', 'text': 'Select Result Type'}],
                resultOptions:[{exam_result_id: '', exam_result: 'Select Result'}],
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
        validations: {
            academic: {
                emp_education_id: {},
                exam_id:{required },
                subject: {required},
                subject_bng: {},
                exam_result_type_id: {required},
                exam_result_id: {required},
                exam_result: {required},
                exam_body_id: {required},
                institute_name: {},
                passing_year: {required},
                prv_external_attribute_yn:{},
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Academic"});
            this.academic.emp_id = this.id;
            this.loadData()
            this.canUpdate()
        },
        watch: {
            can_update: function(val, oldVal){
                if(val){
                    this.fields.push({key: 'action', class: 'text-center'})
                }
            },
            exam:function(val,oldVal) {
                if(val !== null) {
                    this.academic.exam_id = val.exam_id;
                } else {
                    this.academic.exam_id = '';
                }
            },
            result:function(val,oldVal) {
                if(val !== null) {
                    this.academic.exam_result_id = val.exam_result_id;
                    this.academic.max_value = val.max_value;
                    this.academic.min_value = val.min_value;
                } else {
                    this.academic.exam_result_id = '';
                }
            },
            selectedSubject: function(val,oldVal){
                if(val !== null) {
                    this.academic.exam_subject_id = val.exam_subject_id;
                    this.academic.subject = val.exam_subject_name;
                    this.academic.subject_bng = val.exam_subject_name_bng;
                } else {
                    this.academic.exam_subject_id = ''
                    this.academic.subject = ''
                    this.academic.subject_bng = ''
                }
            },
            selectedInstitute: function(val,oldVal){
                if(val !== null) {
                    this.academic.institute_id = val.value;
                    this.academic.institute_name = val.text;
                } else {
                    this.academic.institute_id = ''
                    this.academic.institute_name = ''
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
            canUpdate(){
                this.can_update = this.$store.getters.permissions.includes('CAN_UPDATE')
            },
            examChange(id){
                this.exam_bodys = []
                this.exam_result_types = []
                this.SubjectOptions = []
                this.examBody = {text: '', value: ''}
                this.resultType = {text: '', value: ''}
                this.selectedSubject = {text: '', value: ''}
                if(id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/exam-bodies-by-exam/${id}`).then(result => {
                        this.exam_bodys = result.data
                    })
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/result-type-by-exam/${id}`).then(result => {
                        this.exam_result_types = result.data
                    })
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/subject-by-exam/${id}`).then(result => {
                        this.SubjectOptions = result.data
                    })
                }
            },
             examBodyChange(id){
                if(id){
                     ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/institute-by-body/${id}`).then(result => {
                        this.institutes = result.data;
                    });
                }
            },
            typeChange(id){
                if(id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/result-by-type/${id}`).then(result => {
                        this.resultOptions = result.data;
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
                this.$v.$touch();
                this.academic.emp_id = this.id;
                if(this.resultType.external_attribute_yn == 'N'){
                    this.academic.exam_result=this.resultType.exam_result_type;
                }
                this.$v.academic.$touch();
                if (!this.$v.academic.$invalid){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/academics", this.academic).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.onReset();
                            this.loadData();
                            this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                        } else{
                            this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                        }
                    });
                }
            },
            loadData: function () {
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/academics/specific/${this.id}`).then(res => {
                        if(this.exams.length <=1) {
                            this.exams = this.exams.concat(res.data.exams);
                        }
                        this.items = res.data.data;
                        this.totalList = res.data.data.length;
                    });
                }
            },
            onReset() {
                this.deletedItem = null;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.academic = {
                        emp_education_id: '',
                        exam_id: '',
                        exam_subject_id: '',
                        subject: '',
                        subject_bng: '',
                        exam_result_type_id: '',
                        exam_result: '',
                        exam_body_id: '',
                        institute_id: '',
                        institute_name: '',
                        passing_year: '',
                        prv_external_attribute_yn:''
                    }
                    this.exam = { text:'', value:'' }
                    this.selectedSubject = {text:'', value:'', exam_subject_name_bng: ''}
                    this.selectedInstitute = {text:'', value:''}
                    this.examBody = {text:'', value:''}
                    this.resultType = {text:'',value:''}
                    this.result = {
                        exam_result:'',
                        exam_result_id: '',
                        min_value:'',
                        max_value: ''
                    }
                    this.exam_bodys = [{'value': '', 'text': 'Select Exam Body'}]
                    this.institutes = [{'value': '', 'text': 'Select Institute'}]
                    this.SubjectOptions = [{'value': '', 'text': 'Select Group/Subject'}]
                    this.exam_result_types =[{'value': '', 'text': 'Select Result Type'}]
                    this.resultOptions =[{exam_result_id: '', exam_result: 'Select Result'}]
                    this.show = true
                    this.$v.$reset()
                })
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1;
            },
            editRow(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/academics/${id}`).then(result => {
                    this.submitBtn = 'Update'
                    this.academic.emp_education_id = result.data.emp_education_id
                    this.academic.prv_external_attribute_yn = result.data.result_type ? result.data.result_type.external_attribute_yn : ''
                    this.exam = result.data.exam
                    this.examChange(result.data.exam.value)
                    this.selectedSubject = result.data.exam_subject
                    this.resultType = result.data.selectedResultType
                    this.typeChange(result.data.selectedResultType.value)
                    this.result = result.data.result
                    this.academic.exam_result = result.data.exam_result
                    this.examBody = result.data.exam_body
                    this.examBodyChange(result.data.exam_body_id)
                    this.selectedInstitute = result.data.institute
                    this.academic.passing_year = result.data.passing_year
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
            },
            maxvalue(){
                if (this.academic.exam_result_type_id == 3){
                    return 5
                } else {
                    return 4
                }
            }

        }
    }
</script>

