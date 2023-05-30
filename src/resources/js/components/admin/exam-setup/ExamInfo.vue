<template>
    <b-row class="content-wrapper">
        <b-col class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <b-card-header>
                            <h4 class="card-title">Exam Info Setup</h4>
                        </b-card-header>
                        <b-card-text class="card-content">
                            <b-card-body mb="2">
                                <b-form @submit="onSubmit" @reset="onReset">
                                    <!--<fieldset class="border p-2">-->
                                    <!--<legend class="w-auto ">Exam Info Setup</legend>-->
                                    <b-row>
                                        <b-col lg="4">
                                            <b-form-group
                                                id="fieldset-2"
                                                label="Name"
                                                label-for="input-name">
                                                <b-form-input v-model="examInfoSetup.name" required id="input-name"
                                                              type="text" placeholder="Name"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col lg="4">
                                            <b-form-group
                                                id="fieldset-3"
                                                label="Name(Bangla)"
                                                label-for="input-description">
                                                <b-form-input v-model="examInfoSetup.nameBangla" required
                                                              id="input-description" type="text"
                                                              placeholder="Description"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col lg="4">
                                            <b-form-group
                                                id="fieldset-4">
                                                <label class="d-block">Type</label>
                                                <b-form-checkbox
                                                    id="checkbox-1"
                                                    v-model="examInfoSetup.examInsType"
                                                    name="checkbox-1"
                                                    value="Y"
                                                    unchecked-value="N"
                                                    >Public </b-form-checkbox>
                                            </b-form-group>
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
    //const URL = 'admin.examsetup.examinfo';
  //  const PRIMARY_KEY = 'id';

    export default {
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Exam Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Exam Info"});
            this.allExamInfo();
        },
        components: {
            Datatable
        },
        data() {
            return {
                examInfoSetup: {  },
                show: true,
                submitBtn: 'Save',
                tableData: {
                    fields: [{key: 'exam_id', label: 'ID', sortable: true}, {key: 'exam_name',  label: 'Exam Name', sortable: true},{key: 'exam_name_bng',  label: 'Exam Name(Bangla)', sortable: true},{key: 'public_yn',  label: 'Type', sortable: true}, {key: 'action', sortable: false}],
                    items: []
                },
            }
        },
          methods: {
            allExamInfo() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/exam-setup/exam-infos').then(result => {
                    this.exam_name = result.data.exam_name;
                    this.tableData.items = result.data.examinfodata;
                    this.totalList = result.data.examinfodata.length;
                });
            },
            onSubmit: function (evt) {
                evt.preventDefault();
                if (this.updateIndex > 0) {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/exam-setup/exam-infos', this.examInfoSetup).then(result => {
                        this.allExamInfo();
                        this.onReset();
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/exam-setup/exam-infos', this.examInfoSetup).then(result => {
                        this.allExamInfo();
                        this.onReset();
                    }).catch(function (error) {
                        console.log(error);
                    });
                }

            },
            onReset(evt) {
                this.examInfoSetup = {
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
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/admin/exam-setup/exam-infos/${id}`).then(result=>{
                    this.submitBtn = 'Update';
                    this.examInfoSetup= result.data.examinfodata;
                });
            },
            deleteRow(id) {
                 if(confirm("Do you really want to delete?")){
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/exam-setup/exam-infos/${id}`).then(result=>{
                        this.allExamInfo();
                   });
                 }

            }
        }
    }
</script>
