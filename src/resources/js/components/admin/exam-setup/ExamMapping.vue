<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Exam Mapping </h4>
                        </div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                                    <b-row >
                                        <b-col >
                                            <b-row class="ml-1">
                                                <b-col lg="3">
                                                    <b-form-group id="exam_id" label="Exam " label-for="input-name" class="requiredField">
                                                        <b-form-select
                                                            v-model="examMapping.exam_id"
                                                            required
                                                            :options="exam_options"
                                                        ></b-form-select>
                                                    </b-form-group>
                                                </b-col>

                                                <b-col lg="3">
                                                    <label class="typo__label">Exam Body</label>
                                                    <multiselect
                                                        v-model="examMapping.exam_body_id"
                                                        tag-placeholder="Add this as new tag"
                                                        placeholder="Search or add an Exam Body"
                                                        label="exam_body_name"
                                                        track-by="exam_body_id"
                                                        :options="exam_body_options"
                                                        :multiple="true"
                                                    ></multiselect>

<!--                                                    <pre class="language-json"><code>{{ value  }}</code></pre>-->
                                                </b-col>

                                                <b-col lg="3">
                                                    <label class="typo__label">Exam Subject</label>
                                                    <multiselect v-model="examMapping.exam_subject_id"
                                                                 tag-placeholder="Add subject"
                                                                 placeholder=" Search or Add subject"
                                                                 label="exam_subject_name"
                                                                 track-by="exam_subject_id"
                                                                 :options="exam_subject_options"
                                                                 :multiple="true"  >
                                                    </multiselect>
                                                    <!--                                                    <pre class="language-json"><code>{{ value  }}</code></pre>-->
                                                </b-col>

                                                <b-col lg="3">
                                                    <label class="typo__label">Result Type</label>
                                                    <multiselect
                                                        v-model="examMapping.exam_result_type_id"
                                                                 tag-placeholder="Add this as new tag"
                                                                 placeholder="Search or add a Result Type"
                                                                 label="exam_result_type"
                                                                 track-by="exam_result_type_id"
                                                                 :options="exam_result_options"
                                                                 :multiple="true"
                                                    ></multiselect>
                                                    <!--                                                    <pre class="language-json"><code>{{ value  }}</code></pre>-->
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="mt-2 d-flex justify-content-end">
                                            <b-button lg="6" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                            <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                        </b-col>
                                    </b-row>

                                    <!--</fieldset>-->
                                </b-form>
                            </div>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>

            <!-- Zero configuration table -->
            <section id="basic-datatable">

                <b-row>
                    <b-col>
                        <b-card class="card">
                            <div class="card-content">
                                <b-card-text class="card-body">

                                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">
                                        <template v-slot:actions="{ rows }">
                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                        </template>
                                        <template v-slot:action7="{ rows }">
                                            <b-badge class='mr-1' variant="primary" v-for="data in rows.item.exam_bodies" :key="data.exam_body_id">{{data.exam_body_name}}</b-badge>
                                        </template>
                                        <template v-slot:action2="{ rows }">
                                            <b-badge class='mr-1 bg-info' variant="info"  v-for="data in rows.item.exam_subjects" :key="data.exam_subject_id">{{data.exam_subject_name}}</b-badge>
                                        </template>
                                        <template v-slot:action3="{ rows }">
                                            <b-badge class='mr-1 bg-success' variant="success" v-for="data in rows.item.exam_result_types" :key="data.exam_result_id">{{data.exam_result_type}}</b-badge>
                                        </template>
                                    </Datatable>
                                </b-card-text>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>
            </section>
            <!--/ Zero configuration table -->

        </div>


    </div>
</template>

<script>
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import Multiselect from 'vue-multiselect';
    export default {
        components: {

            Multiselect,
            Datatable,vSelect,vcss
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Exam"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Exam Mapping" });
            this.allSections();
        },
        data() {
            return {
                exam_body_options: [ ],
                exam_subject_options:[ ],
                exam_options: [ ],
                exam_result_options:[ ],
                searchParam: '',

                examMapping: {
                    exam_id:null,
                    exam_body_id:null,
                    exam_subject_id:null,
                    exam_result_type_id:null,
                },
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                totalList:0,
                perPage:5,
                tableData: {
                    fields: [
                        {key: 'exam_name', 'label': 'Exam Body Name', sortable:true},
                        {key:'action7', label:'Exam Bodies',sortable:false} ,
                        {key:'action2', label:'Exam Subjects',sortable:false} ,
                        {key:'action3', label:'Exam Result Types',sortable:false} ,
                        'action'
                    ],
                    items: []
                },

            }
        },
        methods: {

            allSections(){
                   ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/exam-setup/exam-mapping').then(res => {
                    // this.sections = res.data.sections;
                    this.exam_options = res.data.exam;
                    this.tableData.items = res.data.exams;
                    this.totalList = res.data.exams.length;
                    this.exam_subject_options = res.data.examSubject;
                    this.exam_result_options = res.data.examResultType;
                    this.exam_body_options = res.data.exambody;
                });

            },

            onSubmit(evt) {
                evt.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND,'/admin/exam-setup/exam-mapping',this.examMapping).then(res => {


                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.allSections();
                        this.onReset();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                })

            },
            onReset(evt) {
                this.examMapping = {
                    exam_id:null,
                    exam_body_id:null,
                    exam_subject_id:null,
                    exam_result_type_id:null
                };
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(item) {
                this.examMapping.exam_id = item.exam_id;
                this.examMapping.exam_body_id =item.exam_bodies;
                this.examMapping.exam_subject_id = item.exam_subjects;
                this.examMapping.exam_result_type_id = item.exam_result_types;
            },

            searchByExamName() {
                let exam_id = this.searchParam.exam_id;
                //console.log(this.searchParam);
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/exam-setup/exam-mapping/${exam_id} `).then(result => {
                    console.log(result.data);
                    this.tableData.items = result.data;
                    //console.log(result.data);
                }).catch(err => {
                    console.log('error');
                });
            },
            clear() {
                this.searchParam = null,
                    this.fetchData();
            },
            deleteRow($id) {
                if($id > 0){
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/exam-setup/exam-mapping/${$id}`).then(
                        result =>{
                            this.allSections();
                        }
                    ).catch(function (error) {
                        console.log(error);
                    })
                }
            }

        }
    }
</script>
