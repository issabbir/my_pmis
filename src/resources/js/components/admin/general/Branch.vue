<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <b-card-header header-bg-variant="dark" header-text-variant="white">Bank Branch Setup</b-card-header>

                        <b-card-body class="border">
                            <div class="card-body mb-2">
                                <b-form @submit.prevent="onSubmit" @reset="onReset">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                                    <!--<fieldset class="border p-2">-->
                                        <!--<legend class="w-auto"> Administrative Department Setup</legend>-->
                                        <b-row>
                                            <b-col>
                                                <b-row>

                                                    <b-col md="3">
                                                        <b-form-group label="Branch Name" label-for="branch_name" class="required">
                                                            <b-form-input class="text-uppercase" v-model="branch.branch_name" required id="branch_name" type="text"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="Branch Name Bangla" label-for="branch_name_bng">
                                                            <b-form-input class="text-uppercase" v-model="branch.branch_name_bng" id="branch_name_bng" type="text" ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="Bank Name" label-for="bank_id" class="required">
                                                            <b-form-select
                                                              class="select2"
                                                              id="bank_id"
                                                              v-model="branch.bank_id"
                                                              text-field="bank_name"
                                                              value-field="bank_id"
                                                              :options="banks"
                                                              required
                                                            >
                                                            </b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="Routing No" label-for="routing_no" class="">
                                                            <b-form-input class="text-uppercase" v-model="branch.routing_no"  id="routing_no" type="text"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="Address" label-for="branch_address" class="">
                                                            <b-form-input class="text-uppercase" v-model="branch.branch_address"  id="branch_address" type="text"></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                          label="District"
                                                          label-for="geo_district_id">
                                                            <v-select v-model="selectedDistrict"
                                                                      :options="districtOptions"
                                                                      name="geo_district_id"
                                                                      id="geo_district_id"
                                                                      @input="loadThana(selectedDistrict.value)"
                                                                      label="text"
                                                                      class="uppercase">
                                                                <template #search="{attributes, events}">
                                                                    <input class="vs__search"
                                                                           v-bind="attributes" v-on="events"/>
                                                                </template>
                                                            </v-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                          label="Thana"
                                                          label-for="geo_thana_id">
                                                            <v-select v-model="selectedThana"
                                                                      :options="thanaOptions"
                                                                      name="geo_thana_id"
                                                                      id="geo_thana_id"
                                                                      label="text"
                                                                      class="uppercase">
                                                                <template #search="{attributes, events}">
                                                                    <input class="vs__search"
                                                                           v-bind="attributes" v-on="events"/>
                                                                </template>
                                                            </v-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group label="Post Code" label-for="post_code" class="">
                                                            <b-form-input class="text-uppercase" v-model="branch.post_code"  id="post_code" type="text"></b-form-input>
                                                        </b-form-group>
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
                        </b-card-body>
                    </b-card>
                </b-col>
            </b-row>
            <!-- Zero configuration table -->
            <section id="basic-datatable">
                <b-row>
                    <b-col>
                        <b-card class="card">
                            <div class="card-content">
                                <b-card-header header-bg-variant="dark" header-text-variant="white">Bank Branch List</b-card-header>
                                <b-card-body class="border">
                                        <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage" :filterIncludedFields="includedFields">
                                            <template v-slot:actions="{ rows }">
                                                <b-link ml="4" class="text-primary"
                                                        @click="editRow(rows.item)">
                                                    <i class="bx bx-edit cursor-pointer"></i>
                                                </b-link>
                                                <b-link class="text-danger" @click="deleteRow(rows.item.branch_id)">
                                                    <i class="bx bx-trash cursor-pointer"></i>
                                                </b-link>
                                            </template>
                                        </Datatable>
                                </b-card-body>
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
    import 'vue-select/dist/vue-select.css';
    export default {
        components: {
            Datatable,
            vSelect
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "General"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Branch" });
            this.allBranches();
            this.allBanks();
            this.loadDistricts()
        },
        data() {
            return {
                selectedDistrict: {text: '', value: ''},
                districtOptions: [],
                selectedThana: {text: '', value: ''},
                thanaOptions: [],
                branch: {
                    bank_id: '',
                    branch_name: '',
                    branch_name_bng: '',
                    routing_no: '',
                    branch_address: '',
                    geo_district_id: '',
                    geo_district: '',
                    geo_thana_id: '',
                    geo_thana: '',
                    post_code: ''
                },
                banks: [],
                updateIndex:-1,
                submitBtn: 'Save',
                totalList:0,
                perPage:10,
                includedFields:['branch_name','bank_name'],
                tableData: {
                    fields: [
                        {key: 'branch_name',label: 'Branch Name', sortable:true},
                        {key: 'routing_no',label: 'Routing No', sortable:true},
                        {key:'bank_name',label: 'Bank Name', sortable:true},
                        {key: 'branch_address',label: 'Branch Address', sortable:true},
                        {key: 'geo_district', label: 'District', sortable:true},
                        {key: 'geo_thana', label: 'Thana', sortable:true},
                        {key: 'post_code',label: 'Post Code', sortable:true},
                        {key: 'action', class: 'text-center'}
                    ],
                    items:[]
                },
            }
        },
        watch: {
            selectedDistrict: function (val, oldVal) {
                if(val.value){
                    this.branch.geo_district = val.text
                    this.branch.geo_district_id = val.value
                } else {
                    this.branch.geo_district = ''
                    this.branch.geo_district_id = ''
                }
            },
            selectedThana: function (val, oldVal) {
                if(val.value){
                    this.branch.geo_thana = val.text
                    this.branch.geo_thana_id = val.value
                } else {
                    this.branch.geo_thana = ''
                    this.branch.geo_thana_id = ''
                }
            }
        },
        methods: {
            allBranches(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/general/branches').then(result => {
                    this.tableData.items = result.data.branches;
                    this.totalList = result.data.branches.length;
                });
            },
            allBanks(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/general/banks').then(result => {
                    this.banks = result.data.banks;
                });
            },
            loadDistricts(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/location-setup/districts').then(result => {
                    this.districtOptions = result.data;
                });
            },
            loadThana(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-thanas/${id}`).then(result => {
                    this.thanaOptions = result.data;
                });
            },
            onSubmit: function () {
                if(this.updateIndex > 0){
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/general/branch/${this.updateIndex}`, this.branch).then(result => {
                        if (result.data.status_code == 1) {
                            this.allBranches();
                            this.onReset();
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'success'});
                        }else{
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'error'});
                        }
                        }).catch(function(error) {
                             console.log(error);
                             this.$notify({group: 'pmis', text: error, type: 'error'});
                      });
                }else{
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/general/branch', this.branch).then(result => {
                        if (result.data.status_code == 1) {
                            this.allBranches();
                            this.onReset();
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'success'});
                        }else{
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'error'});
                        }
                        }).catch(function(error) {
                             console.log(error);
                            this.$notify({group: 'pmis', text: error, type: 'error'});
                      });
                }

              },
            onReset(evt) {
                this.branch = {
                    bank_id: '',
                    branch_name: '',
                    branch_name_bng: '',
                    routing_no: '',
                    branch_address: '',
                    geo_district_id: '',
                    geo_district: '',
                    geo_thana_id: '',
                    geo_thana: '',
                    post_code: ''
                };
                this.selectedThana = {text: '', value: ''}
                this.selectedDistrict = {text: '', value: ''}
                this.updateIndex = -1;
                this.submitBtn = 'Save';
            },
            editRow(item) {
                this.updateIndex = item.branch_id;
                this.submitBtn = 'Update';
                this.branch = item;
                this.selectedDistrict = {
                    text: item.geo_district,
                    value: item.geo_district_id
                }
                this.loadThana(item.geo_district_id)
                this.selectedThana = {
                    text: item.geo_thana,
                    value: item.geo_thana_id
                }
            },
            deleteRow(id) {
                this.$bvModal.msgBoxConfirm('Please confirm that you want to delete', {
                    title: 'Please Confirm',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                    .then(value => {
                        if(value == true) {
                            ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/general/branch/${id}`).then(result=>{
                                if(result == true){
                                    this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'success'});
                                }
                                this.allBranches();
                            });
                        }
                    })
                    .catch(err => {
                        console.log(error);
                    })
                 }


        }
    }
</script>

