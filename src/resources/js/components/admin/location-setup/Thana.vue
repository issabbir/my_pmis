<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Upazila/Thana Setup</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>

                            <b-col lg="3">
                                <div class="form-group">
                                    <label >Upazila/Thana Name</label>
                                    <b-form-input class="uppercase" v-model="locationThana.geo_thana_name" required></b-form-input>
                                </div>
                            </b-col>
                            <b-col lg="3">
                                <div class="form-group">
                                    <label >Upazila/Thana Name (Bangla)</label>
                                    <b-form-input class="uppercase" v-model="locationThana.geo_thana_name_bng" required></b-form-input>
                                </div>
                            </b-col>
                            <b-col lg="3">
                                <div class="form-group">
                                    <label >District</label>
                                    <b-form-select v-model="locationThana.geo_district_id" required :options="districts" ></b-form-select>
                                </div>
                            </b-col>
                            <b-col lg="3">
                                <div class="form-group">
                                    <label >Division</label>
                                    <b-form-input readonly v-model="locationThana.geo_division_name" required ></b-form-input>
                                </div>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button lg="6" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Upazila/Thana List</b-card-header>
                <b-card-body class="border">
                    <Datatable :fields="tableData.fields" :items="tableData.items" :total-list="tableData.totalItems" :per-page="tableData.perPage">
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary"
                                    @click="editRow(rows.item)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                            <!-- <b-link class="text-danger" @click="deleteRow(rows.item.id, rows.item.id)">
                                 <i class="bx bx-trash cursor-pointer"></i>
                             </b-link>-->
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        components: {
            Datatable
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Location Setup"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Upazila/Thana" });
            this.allDivisions();
            this.fetchAll();
        },
        data() {
            return {
                locationThana: {
                    geo_thana_id: '',
                    geo_thana_name: '',
                    geo_thana_name_bng: '',
                    geo_district_id: '',
                    geo_division_name: ''
                },
                submitBtn: 'Save',
                tableData: {
                    fields: [
                        {key:'index', label:'SL', sortable:false},
                        {key:'geo_thana_name', label: 'Upazila/THANA NAME', sortable:true},
                        {key:'geo_thana_name_bng', label: 'Upazila/THANA NAME (BANGLA)', sortable:true},
                        {key:'district.geo_district_name', label: 'DISTRICT', sortable:true},
                        {key:'district.division.geo_division_name', label: 'DIVISION', sortable:true},
                        {key: 'action', class:'text-center'}
                    ],
                    items:[ ],
                    totalItems: 1,
                    perPage: 10,
                },

                districts: [],

            }
        },
        watch: {
            'locationThana.geo_district_id':function (val, oldVal) {
                if(val){
                    this.locationThana.geo_division_name = this.districts.filter(a=>a.value == val)[0].geo_division_name
                }
            }
        },
        methods: {
            allDivisions() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND,'/admin/location-setup/districts').then(result=>{
                    this.districts = result.data;
                });
            },
            fetchAll() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND,'/admin/location-setup/thanas').then(result=>{
                    this.tableData.items = result.data;
                    this.tableData.totalItems = result.data.length
                });
            },
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND,'/admin/location-setup/thanas',this.locationThana).then(result =>{
                    if(result.data.o_status_code == 1){
                        this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'success'});
                        this.fetchAll()
                        this.onReset()
                    } else {
                        this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'error'});
                    }

                })
            },
            onReset() {
                this.submitBtn = 'Save';
                this.locationThana = {
                    geo_thana_id: '',
                    geo_thana_name: '',
                    geo_thana_name_bng: '',
                    geo_district_id: '',
                    geo_division_name: ''
                }
            },
            editRow(item) {
                this.submitBtn = 'Update';
                this.locationThana = {
                    geo_thana_id: item.geo_thana_id,
                    geo_thana_name: item.geo_thana_name,
                    geo_thana_name_bng: item.geo_thana_name_bng,
                    geo_district_id: item.geo_district_id,
                    geo_division_name: item.district.division.geo_division_name
                }
            },
            deleteRow(i) {

            }

        }
    }
</script>
<style scoped>
  .uppercase { text-transform: uppercase; }
</style>