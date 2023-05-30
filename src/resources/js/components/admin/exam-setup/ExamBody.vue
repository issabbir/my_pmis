<template>
    <b-row class="content-wrapper">
        <b-col class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <b-card-header>
                            <h4 class="card-title">Exam Body Setup</h4>
                        </b-card-header>
                        <b-card-text class="card-content">
                            <b-card-body mb="2">
                                <b-form @submit="onSubmit" >
                                    <!--<fieldset class="border p-2">-->
                                    <!--<legend class="w-auto ">Exam Body Setup</legend>-->
                                    <b-row>
                                        <!--b-col lg="6">
                                            <b-form-group
                                                id="fieldset-1"
                                                label="ID"
                                                label-for="input-id">
                                                <b-form-input v-model="examBodySetup.exam_body_id" disabled id="input-id" type="text" placeholder="ID"></b-form-input>
                                            </b-form-group>
                                        </b-col-->
                                        <b-col lg="6">
                                            <b-form-group
                                                id="fieldset-2"
                                                label="Name"
                                                label-for="input-name">
                                                <b-form-input v-model="examBodySetup.p_exam_body_name" required id="input-name" type="text" placeholder="Exam Body"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col lg="6">
                                            <b-form-group
                                                id="fieldset-3"
                                                label="Exam Name(Bangla)"
                                                label-for="input-description">
                                                <b-form-input v-model="examBodySetup.p_exam_body_name_bng" required id="input-description" type="text" placeholder="Description"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col lg="6">
                                            <b-form-group
                                                id="fieldset-4">
                                                <label class="d-block">Type</label>
                                                <b-form-checkbox
                                                    id="checkbox-1"
                                                    v-model="examBodySetup.p_foreign_yn"
                                                    name="checkbox-1"
                                                    value="Y"
                                                    unchecked-value="N"
                                                    >Foreign </b-form-checkbox>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
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
                                                @click="editRow(tableData.items.exam_body_id)">
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

    export default {
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Exam Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Exam Body"});
            this.allExamBody();


        },
        components: {
            Datatable
        },
        data() {
            return {
                examBodySetup: {},
                type_options: [
                ],
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                tableData: {
                    fields: [{key: 'exam_body_id', label: 'ID', sortable: true}, {key: 'exam_body_name', sortable: true}, {key: 'exam_body_bng', sortable: true}, {key: 'foreign_yn', "label": "type", sortable: true}, {key: 'action', sortable: false}],
                    items: []
                },
            }
        },
        methods: {
            allExamBody() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/exam-setup/exam-bodies').then(result => {
                    this.exam_body_name = result.data.exam_body_name;
                    this.tableData.items = result.data.exambody;
                    this.totalList = result.data.exambody.length;
                });
            },
            onSubmit: function (evt) {
                evt.preventDefault();
                let that = this;
                if (this.updateIndex > 0) {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/exam-setup/exam-bodies', this.examBodySetup).then(result => {
                        //this.allExamBody();

                        this.onReset();

                    }).catch(function (error) {
                        console.log(error);
                    });
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/exam-setup/exam-bodies', this.examBodySetup).then(result => {
                        //this.allExamBody();
                        this.exam_body_name = result.data.exam_body_name;
                        this.tableData.items = result.data.exambody;
                        this.totalList = result.data.exambody.length;

                        that.$successMessage(result.data.message);

                        this.onReset();
                    }).catch(function (error) {
                        console.log(error);
                    });
                }

            },
            onReset(evt) {
                this.examBodySetup = {
                    
                };
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(id) {
                alert(id);
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.PUT_COMMAND,`/admin/exam-setup/exam-bodies/${id}`).then(result=>{
                    this.submitBtn = 'Update';
                    this.examBodySetup = result.data.exambody;
                });
            },
            deleteRow(id) {
                 if(confirm("Do you really want to delete?")){
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/exam-setup/exam-bodies/${id}`).then(result=>{
                        this.examBodySetup = result.data.exambody;
                   });
                 }

            }
        }

    }
</script>
