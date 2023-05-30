<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Exam Body Mapping </h4>
                        </div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                                    <b-row >
                                        <b-col >
                                            <b-row class="ml-1">
                                                <b-col lg="4">
                                                    <b-form-group id="exam_id" label="Exam Body New" label-for="input-name" class="requiredField">
                                                        <b-form-select
                                                            v-model="examMapping.exam_body_id"
                                                            required
                                                            :options="exam_options"
                                                        ></b-form-select>
                                                    </b-form-group>
                                                </b-col>

                                                <b-col lg="4">
                                                    <label class="typo__label">Institute</label>
                                                    <multiselect v-model="examMapping.institute_id"
                                                                 tag-placeholder="Add Institute"
                                                                 placeholder="Search or add Institute"
                                                                 label="institute_name" track-by="institute_id"
                                                                 :options="institute_options"
                                                                 :multiple="true"
                                                                 >

                                                    </multiselect>
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
<!--                                        <template v-slot:actions="{ rows }">-->
<!--                                            <b-link ml="4" class="text-primary"-->
<!--                                                    @click="editRow(rows.item)">-->
<!--                                                <i class="bx bx-edit cursor-pointer"></i>-->
<!--                                            </b-link>-->
<!--                                        </template>-->

                                        <template v-slot:actions="{ rows }">
                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                        </template>
                                        <template v-slot:action7="{ rows }">
                                            <b-badge class='mr-1' variant="primary" v-for="data in rows.item.institutes" :key="data.institute_id">{{data.institute_name}}</b-badge>
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
            this.$store.commit("setBreadcrumb", { link: "#", label: "Exam Body Mapping" });
            this.allSections();
        },

        data() {
            return {
                examMapping: {
                    exam_body_id:null,
                    institute_id:null,
                },
                searchParam: '',
                institute_options:[],
                exam_options: [],

                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                totalList:0,
                perPage:5,
                tableData: {
                    fields: [
                        //{key: 'section_id'},
                        {key: 'index', label: 'SL', class: 'text-center'},
                        {key: 'exam_body_name', 'label': 'Exam Body Name', sortable:true},
                        {key:'action7', label:'Institute Name',sortable:false} ,
                        //{key:'institute_name', label:'Institute Name',sortable:true} ,
                        // {key:'department_name', label: 'Department Name', sortable:true},
                        'action'
                    ],
                    items: []
                },

            }
        },
        methods: {
            allSections(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/exam-setup/exam-body-mapping').then(res => {
                    // this.sections = res.data.sections;
                    this.tableData.items = res.data.exambodyinstitutes;
                    this.totalList = res.data.exambodyinstitutes.length;
                    this.exam_options = res.data.exambody;
                    this.institute_options= res.data.institutes;
                });

            },

            onSubmit(evt) {
                evt.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND,'/admin/exam-setup/exam-body-mapping',this.examMapping).then(res => {


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
                    exam_body_id:null,
                    institute_id:null
                };
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },

            editRow(item) {
                this.examMapping.exam_body_id = item.exam_body_id;
                this.examMapping.institute_id = item.institutes;
                this.submitBtn = 'Update';
            },

            searchByExamBodyName() {
                let exam_body_id = this.searchParam.exam_body_id;
                //console.log(this.searchParam);
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/exam-setup/search-by-examBodyId/${exam_body_id} `).then(result => {
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
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/exam-setup/exam-body-mapping/${$id}`).then(
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















<!--commented code -&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;-->





<!--<template>-->
<!--    <div class="content-wrapper">-->
<!--        <div class="content-body">-->
<!--            <b-row>-->
<!--                <b-col>-->
<!--                    <b-card class="card">-->
<!--                        <div class="card-header">-->
<!--                            <h4 class="card-title">Exam Body Mapping </h4>-->
<!--                        </div>-->
<!--                        <b-card-text class="card-content">-->
<!--                            <div class="card-body mb-2">-->
<!--                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">-->
<!--                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>-->
<!--                                    <b-row >-->
<!--                                        <b-col >-->
<!--                                            <b-row class="ml-1">-->
<!--                                                <b-col lg="4">-->
<!--                                                    <b-form-group id="exam_id" label="Exam Body" label-for="input-name" class="requiredField">-->
<!--                                                        <b-form-select-->
<!--                                                            v-model="examMapping.exam_body_id"-->
<!--                                                            required-->
<!--                                                            :options="exam_options"-->
<!--                                                        ></b-form-select>-->
<!--                                                    </b-form-group>-->
<!--                                                </b-col>-->

<!--                                                <b-col lg="4">-->
<!--                                                    <label class="typo__label">Institute</label>-->
<!--                                                    <multiselect v-model="examMapping.institute_id"-->
<!--                                                                 tag-placeholder="Add Institute"-->
<!--                                                                 placeholder="Search or add Institute"-->
<!--                                                                 label="institute_name" track-by="institute_id"-->
<!--                                                                 :options="institute_options"-->
<!--                                                                 :multiple="true"-->
<!--                                                    >-->

<!--                                                    </multiselect>-->
<!--                                                </b-col>-->


<!--                                            </b-row>-->
<!--                                        </b-col>-->
<!--                                    </b-row>-->
<!--                                    <b-row>-->
<!--                                        <b-col class="mt-2 d-flex justify-content-end">-->
<!--                                            <b-button lg="6" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;-->
<!--                                            <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>-->
<!--                                        </b-col>-->
<!--                                    </b-row>-->

<!--                                    &lt;!&ndash;</fieldset>&ndash;&gt;-->
<!--                                </b-form>-->
<!--                            </div>-->
<!--                        </b-card-text>-->
<!--                    </b-card>-->
<!--                </b-col>-->
<!--            </b-row>-->

<!--            &lt;!&ndash; Zero configuration table &ndash;&gt;-->
<!--            <section id="basic-datatable">-->

<!--                <b-row>-->
<!--                    <b-col>-->
<!--                        <b-card class="card">-->
<!--                            <div class="card-content">-->
<!--                                <b-card-text class="card-body">-->

<!--                                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">-->
<!--                                        &lt;!&ndash;                                        <template v-slot:actions="{ rows }">&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                            <b-link ml="4" class="text-primary"&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                                    @click="editRow(rows.item)">&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                                <i class="bx bx-edit cursor-pointer"></i>&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                            </b-link>&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                        </template>&ndash;&gt;-->

<!--                                        <template v-slot:actions="{ rows }">-->
<!--                                            <b-link ml="4" class="text-primary"-->
<!--                                                    @click="editRow(rows.item)">-->
<!--                                                <i class="bx bx-edit cursor-pointer"></i>-->
<!--                                            </b-link>-->
<!--                                        </template>-->
<!--                                        <template v-slot:action7="{ rows }">-->
<!--                                            <b-badge class='mr-1' variant="primary" v-for="data in rows.item.institutes" :key="data.institute_id">{{data.institute_name}}</b-badge>-->
<!--                                        </template>-->
<!--                                    </Datatable>-->
<!--                                </b-card-text>-->
<!--                            </div>-->
<!--                        </b-card>-->
<!--                    </b-col>-->
<!--                </b-row>-->
<!--            </section>-->
<!--            &lt;!&ndash;/ Zero configuration table &ndash;&gt;-->

<!--        </div>-->


<!--    </div>-->
<!--</template>-->

<!--<script>-->
<!--    import Datatable from '../../../layouts/common/datatable';-->
<!--    import ApiRepository from "../../../Repository/ApiRepository";-->
<!--    import vSelect from 'vue-select';-->
<!--    import vcss from 'vue-select/dist/vue-select.css';-->
<!--    import Multiselect from 'vue-multiselect';-->
<!--    export default {-->
<!--        components: {-->
<!--            Multiselect,-->
<!--            Datatable,vSelect,vcss-->
<!--        },-->
<!--        mounted() {-->
<!--            this.$store.commit("setBreadcrumbEmpty");-->
<!--            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});-->
<!--            this.$store.commit("setBreadcrumb", { link: "#", label: "Exam"});-->
<!--            this.$store.commit("setBreadcrumb", { link: "#", label: "Exam Body Mapping" });-->
<!--            this.allSections();-->
<!--        },-->
<!--        data() {-->
<!--            return {-->
<!--                examMapping: {-->
<!--                    exam_body_id:null,-->
<!--                    institute_id:null,-->
<!--                },-->
<!--                searchParam: '',-->
<!--                institute_options:[],-->
<!--                exam_options: [],-->

<!--                show: true,-->
<!--                updateIndex:-1,-->
<!--                submitBtn: 'Save',-->
<!--                totalList:0,-->
<!--                perPage:5,-->
<!--                tableData: {-->
<!--                    fields: [-->
<!--                        //{key: 'section_id'},-->
<!--                        {key: 'index', label: 'SL', class: 'text-center'},-->
<!--                        {key: 'exam_body_name', 'label': 'Exam Body Name', sortable:true},-->
<!--                        {key:'action7', label:'Institute Name',sortable:false} ,-->
<!--                        //{key:'institute_name', label:'Institute Name',sortable:true} ,-->
<!--                        // {key:'department_name', label: 'Department Name', sortable:true},-->
<!--                        'action'-->
<!--                    ],-->
<!--                    items: []-->
<!--                },-->

<!--            }-->
<!--        },-->
<!--        methods: {-->
<!--            allSections(){-->
<!--                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/exam-setup/exam-body-mapping').then(res => {-->
<!--                    // this.sections = res.data.sections;-->
<!--                    this.tableData.items = res.data.exambodyinstitutes;-->
<!--                    this.totalList = res.data.exambodyinstitutes.length;-->
<!--                    this.exam_options = res.data.exambody;-->
<!--                    this.institute_options= res.data.institutes;-->
<!--                });-->

<!--            },-->

<!--            onSubmit(evt) {-->
<!--                evt.preventDefault();-->
<!--                ApiRepository.callApi(ApiRepository.POST_COMMAND,'/admin/exam-setup/exam-body-mapping',this.examMapping).then(res => {-->


<!--                    if (res.data.o_status_code == 1) {-->
<!--                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});-->
<!--                        this.allSections();-->
<!--                        this.onReset();-->
<!--                    } else {-->
<!--                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});-->
<!--                    }-->
<!--                })-->

<!--            },-->
<!--            onReset(evt) {-->
<!--                this.examMapping = {-->
<!--                    exam_body_id:null,-->
<!--                    institute_id:null-->
<!--                };-->
<!--                this.updateIndex = -1;-->
<!--                this.submitBtn = 'Save';-->
<!--                this.show = false;-->
<!--                this.$nextTick(() => {-->
<!--                    this.show = true;-->
<!--                });-->
<!--            },-->

<!--            editRow(item) {-->
<!--                this.examMapping.exam_body_id = item.exam_body_id;-->
<!--                this.examMapping.institute_id = item.institutes;-->
<!--                this.submitBtn = 'Update';-->
<!--            },-->

<!--            searchByExamBodyName() {-->
<!--                let exam_body_id = this.searchParam.exam_body_id;-->
<!--                //console.log(this.searchParam);-->
<!--                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/exam-setup/search-by-examBodyId/${exam_body_id} `).then(result => {-->
<!--                    console.log(result.data);-->
<!--                    this.tableData.items = result.data;-->
<!--                    //console.log(result.data);-->
<!--                }).catch(err => {-->
<!--                    console.log('error');-->
<!--                });-->
<!--            },-->
<!--            clear() {-->
<!--                this.searchParam = null,-->
<!--                    this.fetchData();-->
<!--            },-->
<!--            deleteRow($id) {-->
<!--                if($id > 0){-->
<!--                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/exam-setup/exam-body-mapping/${$id}`).then(-->
<!--                        result =>{-->
<!--                            this.allSections();-->
<!--                        }-->
<!--                    ).catch(function (error) {-->
<!--                        console.log(error);-->
<!--                    })-->
<!--                }-->
<!--            }-->

<!--        }-->
<!--    }-->
<!--</script>-->

