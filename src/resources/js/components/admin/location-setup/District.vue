<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">District Setup</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>

                            <b-col lg="4">
                                <div class="form-group">
                                    <label >District Name</label>
                                    <b-form-input class="uppercase" v-model="locationDistrict.geo_district_name" required  type="text"></b-form-input>
                                </div>
                            </b-col>
                            <b-col lg="4">
                                <div class="form-group">
                                    <label >District Name (Bangla)</label>
                                    <b-form-input class="uppercase" v-model="locationDistrict.geo_district_name_bng" required  type="text"></b-form-input>
                                </div>
                            </b-col>
                            <b-col lg="4">
                                <div class="form-group">
                                    <label >Division</label>
                                    <b-form-select v-model="locationDistrict.geo_division_id" required :options="divisions" ></b-form-select>
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
                <b-card-header header-bg-variant="dark" header-text-variant="white">District List</b-card-header>
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
            this.$store.commit("setBreadcrumb", { link: "#", label: "District" });
            this.allDivisions();
            this.fetchAll();
        },
        data() {
            return {
                locationDistrict: {
                    geo_district_id: '',
                    geo_district_name: '',
                    geo_district_name_bng: '',
                    geo_division_id: '',
                },
                submitBtn: 'Save',
                tableData: {
                    fields: [
                        {key:'index', label:'SL', sortable:false},
                        {key:'geo_district_name', label: 'DISTRICT NAME', sortable:true},
                        {key:'geo_district_name_bng', label: 'DISTRICT NAME (BANGLA)', sortable:true},
                        {key:'division.geo_division_name', label: 'DIVISION', sortable:true},
                        {key: 'action', class:'text-center'}
                    ],
                    items:[ ],
                    totalItems: 1,
                    perPage: 10,
                },

                divisions: [],

            }
        },
        methods: {
            allDivisions() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND,'/admin/location-setup/divisions-dropdown').then(result=>{
                     this.divisions = result.data;
                });
            },
            fetchAll() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND,'/admin/location-setup/all-districts').then(result=>{
                    this.tableData.items = result.data;
                    this.tableData.totalItems = result.data.length
                });
            },
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND,'/admin/location-setup/districts',this.locationDistrict).then(result =>{
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
                this.locationDistrict = {
                    geo_district_id: '',
                    geo_district_name: '',
                    geo_district_name_bng: '',
                    geo_division_id: '',
                }
            },
            editRow(item) {
                this.submitBtn = 'Update';
                this.locationDistrict = {
                    geo_district_id: item.geo_district_id,
                    geo_district_name: item.geo_district_name,
                    geo_district_name_bng: item.geo_district_name_bng,
                    geo_division_id: item.geo_division_id
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