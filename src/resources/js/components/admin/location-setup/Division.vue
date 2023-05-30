<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col >
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Division Setup</h4>
                        </div>
                        <div class="card-content">
                            <b-card-text class="card-body mb-2">

                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <!--<fieldset class="border p-2">-->
                                        <!--<legend class="w-auto ">Division Setup</legend>-->
                                        <b-row>
                                            <b-col lg="4">
                                                <div class="form-group">
                                                    <label >ID</label>
                                                    <b-form-input v-model="locationDivision.division_id" required  type="text" placeholder="ID"></b-form-input>
                                                </div>
                                            </b-col>
                                            <b-col lg="4">
                                                <div class="form-group">
                                                    <label >Division Name</label>
                                                    <b-form-input v-model="locationDivision.division_name" required  type="text" placeholder="Division Name"></b-form-input>
                                                </div>
                                            </b-col>
                                            <b-col lg="4">
                                                <div class="form-group">
                                                    <label >Description</label>
                                                    <b-form-input v-model="locationDivision.description" required  type="text" placeholder="Description"></b-form-input>

                                                </div>
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

                            </b-card-text>
                        </div>
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
                                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" >
                                        <template v-slot:actions="{ rows }">
                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item.division_id)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                            <b-link class="text-danger" @click="deleteRow(rows.item.division_id)">
                                                <i class="bx bx-trash cursor-pointer"></i>
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
    export default {
        components: {
            Datatable
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Location Setup"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Division" });
            this.fetchAll();
        },
        data() {
            return {
                locationDivision: {},
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                tableData: {
                    fields: [{key:'division_id', label:'ID', sortable:true }, {key:'division_name', label:'Division Name'},  'action'],
                    items:[]                },
                /*division_options: [
                    { value: null, text: 'Please select' },
                    { value: 'Member(Engineering)', text: 'Member (Engineering)' },
                    { value: 'Chairman', text: 'Chairman' },
                    { value: 'Member(Harbour & Marine)', text: 'Member(Harbour & Marine)' },
                    { value: 'Member(Finance)', text: 'Member(Finance)' },
                    { value: 'Member(Engineering)', text: 'Member(Engineering)' },
                ],*/

            }
        },
        methods: {
            fetchAll() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND,'/admin/location-setup/divisions').then(result=>{
                    this.tableData.items = result.data;
                    this.totalList = result.data.length;
                 });
            },
            onSubmit(evt) {
                evt.preventDefault();
                 if(this.updateIndex > 0){
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/location-setup/divisions/${this.updateIndex}`, this.locationDivision).then(result => {
                        this.fetchAll();
                        this.onReset();
                    }).catch(function(error) {
                        console.log(error);
                    });
                }else{
                     ApiRepository.callApi(ApiRepository.POST_COMMAND,'/admin/location-setup/divisions',this.locationDivision).then(result=>{
                        this.tableData.items = result.data;
                        this.onReset();
                    }).catch(function(error) {
                        console.log(error);
                    });
                }
            },
            onReset(evt) {
                this.locationDivision = {};
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });

            },
            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/admin/location-setup/divisions/${id}`).then(result=>{
                    this.submitBtn = 'Update';
                    this.locationDivision = result.data.division;
                });

            },
            deleteRow(id) {
                if(confirm("Do you really want to delete?")){
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/location-setup/divisions/${id}`).then(result=>{
                        this.fetchAll();
                    });
                }
            }

        }
    }
</script>
