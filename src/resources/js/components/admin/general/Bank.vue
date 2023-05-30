<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Bank</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="10">
                                <b-row>
                                    <b-col lg="12">
                                        <b-form-group
                                          label="Bank Name"
                                          label-for="bank_name"
                                          class="requiredField"

                                        >
                                            <b-form-input class="text-uppercase" v-model="banks.bank_name" id="bank_name" type="text" ></b-form-input>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.banks.bank_name.$error && !$v.banks.bank_name.required}">Bank name is required!</div>
                                        </b-form-group>
                                    </b-col>
                                    <b-col lg="12">
                                        <b-form-group
                                          label="ব্যাংকের নাম"
                                          label-for="bank_name_bng"
                                        >
                                            <b-form-input class="text-uppercase" v-model="banks.bank_name_bng" id="bank_name_bng" type="text" ></b-form-input>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.banks.bank_name_bng.$error && !$v.banks.bank_name_bng.required}">ব্যাংকের নাম লিখুন!</div>
                                        </b-form-group>
                                    </b-col>
                                    <b-col lg="12">
                                        <b-form-group
                                          label="Bank Code"
                                          label-for="bank_code"
                                        >
                                            <b-form-input class="text-uppercase" v-model="banks.bank_code" id="bank_code" type="text" ></b-form-input>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.banks.bank_code.$error && !$v.banks.bank_code.required}">Bank code is required!</div>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="2" class="text-center profileImage">
                                <b-card class="m-0" style="border: 1px solid #eff1f2;">
                                    <b-card-text >
                                        <img id="profilepic" :src="banks.bank_logo ? banks.bank_logo : '/images/bank-logo.png'"  class="img-fluid" alt="...">
                                    </b-card-text>
                                </b-card>
                                <label style="width:100%" class="btn btn-primary"> Logo
                                    <input class="uploadImage"  type="file"  name="emp_photo" @change="getLogo" accept="image/png,image/jpg,image/jpeg"/>
                                </label>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.banks.bank_logo.$error && !$v.banks.bank_logo.required}">Select bank logo</div>
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
                <b-card-header header-bg-variant="dark" header-text-variant="white">Bank List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary"
                                    @click="editRow(rows.item)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                            <b-link class="text-danger" @click="deleteRow(rows.item.bank_id)">
                                <i class="bx bx-trash cursor-pointer"></i>
                            </b-link>
                        </template>
                        <template v-slot:action2="{ rows }">
                            <b-img :src="rows.item.bank_logo? rows.item.bank_logo:'/images/bank-logo.png'" width="30" height="30"></b-img>
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
    const {required} = require("vuelidate/lib/validators");

    export default {
        components: {
            Datatable
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "General"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Bank" });
            this.allBanks();
        },
        data() {
            return {
                banks: {
                    bank_id: '',
                    bank_name: '',
                    bank_name_bng: '',
                    bank_code: '',
                    bank_logo: ''
                },
                submitBtn: 'Save',
                totalList:1,
                perPage:5,
                tableData: {
                    fields: [
                        {key:'index', label:'SL', sortable:true},
                        {key:'bank_name', sortable:true},
                        {key:'bank_name_bng', sortable:true},
                        {key:'bank_code', sortable:true},
                        {key:'action2', label: 'Logo'},
                        {key: 'action', class: 'text-center'}
                    ],
                    items:[]
                },


            }
        },
        validations: {
            banks: {
                bank_id: {},
                bank_name: {required},
                bank_name_bng:{ },
                bank_code: {},
                bank_logo: {}
            }
        },
        methods: {
            getLogo(event) {
                let currObj = this;
                let input = event.target;
                let reader = new FileReader();
                if (input.files && input.files.length > 0) {
                    reader.onload = (e) => {
                        currObj.banks.bank_logo = e.target.result;
                    }
                }
                reader.readAsDataURL(input.files[0]);
            },
            allBanks(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/general/banks').then(result => {
                    this.tableData.items = result.data.banks;
                    this.totalList = result.data.banks.length;
                });
            },
            onSubmit: function () {
                this.$v.$touch();
                this.$v.banks.$touch();
                if (!this.$v.banks.$invalid){
                    if(this.banks.bank_id > 0){
                        ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/general/bank/${this.banks.bank_id}`, this.banks).then(result => {
                            if(result.data == true){
                                this.$notify({group: 'pmis', text: 'Bank updated successfully!', type: 'success'});
                            }
                            this.allBanks();
                            this.onReset();
                        }).catch(function(error) {
                            console.log(error);
                        });
                    }else{
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/general/bank', this.banks).then(result => {
                            if(result.data == true){
                                this.$notify({group: 'pmis', text: 'Bank inserted successfully!', type: 'success'});
                            } else {
                                this.$notify({group: 'pmis', text: 'The bank is already exist!', type: 'error'});
                            }
                            this.allBanks();
                            this.onReset();
                        });
                    }
                }


              },
            onReset(evt) {
                this.banks = {
                    bank_id: '',
                    bank_name: '',
                    bank_name_bng: '',
                    bank_code: '',
                    bank_logo: ''
                };
                this.submitBtn = 'Save';
                this.$v.$reset()
            },
            editRow(item) {
                 this.banks = {
                     bank_id: item.bank_id,
                     bank_name: item.bank_name,
                     bank_name_bng: item.bank_name_bng,
                     bank_code: item.bank_code,
                     bank_logo: item.bank_logo
                 }
                this.submitBtn = 'Update';
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
                            ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/general/bank/${id}`).then(result=>{
                                if(result == true){
                                    this.$notify({group: 'pmis', text: 'Bank updated successfully!', type: 'success'});
                                }
                                this.allBanks();
                            });
                        }
                    })
                    .catch(err => {

                    })
            }

        }
    }
</script>
<style scoped>
    #profilepic{
        height: 140px !important;
        width: 100%;
    }
    .uploadImage {
        display: none;
    }
</style>
