<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Exam Body Entry </h4>
                        </div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">

                                <b-form @submit="onSubmit" @reset="onReset"  >
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text"
                                                  :style="{'display':'none'}"></b-form-input>
                                    <b-row>
                                        <b-col>
                                            <b-row class="ml-1">
                                                <b-col lg="4">
                                                    <b-form-group id="exam_name" label="Exam Name"
                                                                  label-for="input-name" class="requiredField">
                                                        <b-form-input
                                                            v-model="examMapping.exam_name"
                                                            required
                                                        ></b-form-input>
                                                    </b-form-group>
                                                </b-col>

                                                <b-col lg="4">
                                                    <b-form-group id="exam_name_bangla" label="Exam Name Bangla"
                                                                  label-for="input-bangla-name">
                                                        <b-form-input
                                                            v-model="examMapping.exam_name_bng"
                                                        ></b-form-input>
                                                    </b-form-group>
                                                </b-col>

                                                <b-col lg="4">
                                                    <b-form-group id="public_yn" label="Public Y/N"
                                                                  v-slot="{ ariaDescribedby }"
                                                                  label-for="input-public_yn" class="">
                                                        <b-form-radio-group
                                                            id="radio-group-1"
                                                            v-model="examMapping.public_yn"
                                                            :options="publicOptions"
                                                            :aria-describedby="ariaDescribedby"
                                                            name="radio-options"
                                                        ></b-form-radio-group>
                                                    </b-form-group>

                                                </b-col>


                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <b-row>

                                        <b-col class="mt-2 d-flex justify-content-end">
                                            <b-button lg="6" size="md" variant="dark" type="submit">
                                                {{submitBtn}}
                                            </b-button>&nbsp;


                                            <b-button lg="6" size="md" class="btn-outline-dark" type="reset">Cancel
                                            </b-button>
                                        </b-col>
                                    </b-row>
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
                                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items"
                                               :totalList="totalList" :perPage="perPage">

                                        <template v-slot:actions="{ rows }">

                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                            ||


                                            <b-link ml="4" class="text-primary"
                                                    @click="deleteRow(rows.item.exam_id)">
                                                <i class="bx bx-trash  cursor-pointer danger " style="color: red"></i>
                                            </b-link>

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

    export default {
        components: {
            Datatable, vSelect, vcss
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Exam"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Exam Body Entry"});
            this.allSections();
        },

        data() {
            return {
                examMapping: {
                    exam_name: null,
                    exam_name_bng: null,
                    public_yn: 'N',
                    exam_id: null
                },
                publicOptions: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                searchParam: '',
                institute_options: [],
                exam_options: [],
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                totalList: 0,
                perPage: 5,

                tableData: {
                    fields: [
                        //{key: 'section_id'},
                        {key: 'index', label: 'SL', class: 'text-center'},
                        {key: 'exam_name', 'label': 'Exam Name', sortable: true},
                        {
                            key: 'public_yn', 'label': 'Public',
                            formatter: (value, key, item) => {
                                return (value == 'Y') ? 'YES' : 'NO';
                            },
                            sortable: true
                        },
                        'action'
                    ],

                    items: []
                },


            }
        },
        methods: {
            allSections() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/exam-setup/exam-body-datatable').then(res => {
                    // this.sections = res.data.sections;

                    this.tableData.items = res.data;
                    // console.log(this.tableData.items = res.data);
                    this.totalList = res.data.length;
                    this.exam_options = res.data.exambody;
                    // this.institute_options = res.data.institutes;
                });

            },




    onSubmit(evt) {
                evt.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/exam-setup/exam-body-store', this.examMapping).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.allSections();
                        this.onReset();
                    } else{
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                })

            },
            editRow(item) {

                this.examMapping.exam_id = item.exam_id;
                this.examMapping.exam_name = item.exam_name;
                this.examMapping.exam_name_bng = item.exam_name_bng;
                this.examMapping.public_yn = item.public_yn;
                this.submitBtn = 'Update';
            },
            onReset() {
                this.examMapping = {
                    exam_id: null,
                    exam_name: null,
                    exam_name_bng: null,
                    public_yn: 'N',
                };

                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },

            deleteRow(item) {
                if (item > 0) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/admin/exam-setup/exam-body-delete/` + item).then(
                        res => {
                            if(res.data.o_status_code == 99){
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                            }else{
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                this.allSections();
                            }

                        }
                    ).catch(function (error) {
                        // this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    })
                }
            }

        }
    }
</script>


