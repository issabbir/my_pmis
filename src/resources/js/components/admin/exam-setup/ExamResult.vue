<template>
    <b-row class="content-wrapper">
        <b-col class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <b-card-header>
                            <h4 class="card-title">Exam Result Setup</h4>
                        </b-card-header>
                        <b-card-text class="card-content">
                            <b-card-body mb="2">
                                <b-form @submit="onSubmit" @reset="onReset">
                                    <!--<fieldset class="border p-2">-->
                                        <!--<legend class="w-auto ">Exam Result Setup</legend>-->
                                        <b-row>
                                            <!--b-col lg="4">
                                                <b-form-group
                                                        id="fieldset-1"
                                                        label="ID"
                                                        label-for="input-id">
                                                    <b-form-input v-model="examResultSetup.id" disabled id="input-id" type="text"
                                                                  placeholder="ID"></b-form-input>
                                                </b-form-group>
                                            </b-col-->
                                            <b-col lg="6">
                                                <b-form-group
                                                        id="fieldset-2"
                                                        label="Result"
                                                        label-for="input-result">
                                                    <b-form-input v-model="examResultSetup.result" required id="input-result"
                                                                  type="text" placeholder="Result"></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col lg="6">
                                                <b-form-group
                                                        id="fieldset-3"
                                                        label="Result(Bangla)"
                                                        label-for="input-description">
                                                    <b-form-input v-model="examResultSetup.resultbangla" required
                                                                  id="input-description" type="text"
                                                                  placeholder="Description"></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                    <b-row>
                                        <b-col class="mt-2 d-flex justify-content-end">
                                            <b-button lg="6" size="md" variant="dark mr-1" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                            <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                    <!--</fieldset>-->
                                </b-form>
                            </b-card-body>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>

                <b-row>
                    <b-col>
                        <b-card class="card">
                            <div class="card-content">
                                <b-card-text class="card-body">
                                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" >
                                        <template v-slot:actions="{ rows }">
                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item.id, rows.item.id)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                            <b-link class="text-danger" @click="deleteRow(rows.item.id, rows.item.id)">
                                                <i class="bx bx-trash cursor-pointer"></i>
                                            </b-link>
                                        </template>
                                    </Datatable>
                                </b-card-text>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>
        </b-col>
    </b-row>
</template>

<script>
    import ApiRepository from '../../../Repository/ApiRepository';
    import Datatable from '../../../layouts/common/datatable';
    const URL = 'admin.examsetup.examresult';
    const PRIMARY_KEY = 'id';

    export default {
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Exam Setup"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Exam Result" });
            this.allExamResult();
        },
        components: {
            Datatable
        },
        data() {
            return {
                examResultSetup: { },
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                tableData: {
                    fields: [{key: 'exam_result_id', label: 'ID', sortable: true}, {key: 'exam_result', label: 'Result Name', sortable: true},{key: 'exam_result_bng', label: 'Result Name(Bangla)', sortable: true}, 'action'],
                    items: []
                },
            }
        },
          methods: {
            allExamResult() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/exam-setup/exam-results').then(result => {
                    this.exam_result_id = result.data.exam_result_id;
                    this.tableData.items = result.data.examresult;
                    this.totalList = result.data.examresult.length;
                });
            },
            onSubmit: function (evt) {
                evt.preventDefault();
                if (this.updateIndex > 0) {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/exam-setup/exam-results', this.examResultSetup).then(result => {
                        this.allExamResult();
                        this.onReset();
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/exam-setup/exam-results', this.examResultSetup).then(result => {
                        this.allExamResult();
                        this.onReset();
                    }).catch(function (error) {
                        console.log(error);
                    });
                }

            },
            onReset(evt) {
                this.examResultSetup = {
                    fin_code:null
                };
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/admin/exam-setup/exam-results/${id}`).then(result=>{
                    this.submitBtn = 'Update';
                    this.examResultSetup= result.data.examresult;
                });
            },
            deleteRow(id) {
                 if(confirm("Do you really want to delete?")){
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/exam-setup/exam-results/${id}`).then(result=>{
                        this.allExamResult();
                   });
                 }

            }
        }
    }
</script>
