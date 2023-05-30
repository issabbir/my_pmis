<template>
    <div>
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">
                Result Type Entry
            </b-card-header>
            <b-card-body class="border">
                <b-form @submit.prevent="Submit" @reset.prevent="Reset">
                    <b-row>
                        <b-col>
                            <b-form-group label="Result" label-for="result">
                                <b-form-input
                                    id="result"
                                    v-model="formData.exam_result"
                                    placeholder="Result"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col>
                            <b-form-group label="Result (In Bengali)" label-for="result_in_bengali">
                                <b-form-input
                                    id="result_in_bengali"
                                    v-model="formData.exam_result_bng"
                                    placeholder="Result in Bengali"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col>
                            <b-form-group label="Result Type" label-for="result_type">
                                <b-form-input
                                    id="result_type"
                                    v-model="formData.result_type"
                                    placeholder="Result Type"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row >
                        <b-col class="d-flex justify-content-end">
                            <b-button-group>
                                <b-button variant="primary" type="submit">Submit</b-button>
                                <b-button variant="secondary" type="reset" >Reset</b-button>
                            </b-button-group>
                        </b-col>
                    </b-row>
                </b-form>
            </b-card-body>
        </b-card>
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Result Type List</b-card-header>
            <b-card-body class="border">
                 <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :sort-by.sync="tableData.sortBy" :currentPage="tableData.currentPage" :perPage="tableData.perPage" :totalList="tableData.totalRows">
                    <template v-slot:actions="{ rows }">
                        <a size="sm" @click="EditRow(rows.item)"><i class="bx bx-edit cursor-pointer"></i> </a>
                    </template>
                </Datatable>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import ApiRepository from "../../../Repository/ApiRepository";
    import Datatable from '../../../layouts/common/datatable';
    export default {
        name: "ResultTypeEntry",
        components: {Datatable},
        data() {
            return {
                submitButton: 'Save',
                formData:{
                    exam_result: '',
                    exam_result_bng: '',
                    result_type: '',
                    exam_result_id:null
                },
                tableData:{
                    fields: [
                        {key:'result_type', label:'Result Type', sortable: true},
                        {key:'exam_result', label:'Exam Result'},
                        {key:'exam_result_bng', label:'Exam Result (Bengali)'},
                        {key:'action'}
                    ],
                    items:[],
                    sortBy: 'result_type',
                    currentPage: 1,
                    perPage: 5,
                    totalRows:1
                },

            }
        },
        mounted() {
            this.ResultTypeList();
        },
        methods: {
            Submit(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/admin/exam-setup/exam-results`, this.formData).then(response => {
                    if (response.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.Reset();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        this.Reset();
                    }
                }).catch(err => {
                    console.log('error');
                });
            },
            Reset(){
                this.formData = {}
            },
            EditRow(item){
                this.formData = item;
                this.submitButton = "Update";
            },
            ResultTypeList(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/exam-setup/exam-results`).then(response => {
                   this.tableData.items = response.data.exam_result;
                   this.tableData.totalRows = this.tableData.items.length;
                    console.log(response.data.exam_result);
                }).catch(err => {
                    console.log('error');
                });
            }
        }
    }
</script>

<style scoped>

</style>
