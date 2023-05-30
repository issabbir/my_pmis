<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Nominee</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col>
                                <b-row>
                                    <b-col md="3">
                                        <b-form-group label="Employee" label-for="emp_code" class="requiredField">
                                            <v-select
                                                label="option_name"
                                                v-model="selectedEmployee"
                                                :options="employeeList"
                                                @search="searchEmployee"
                                                required
                                                id="emp_code"
                                                name="emp_code"
                                            >
                                                <template #selected-option="{ option_name }">
                                                    <div style="display: flex; align-items: baseline;">
                                                        {{ option_name }}
                                                    </div>
                                                </template>
                                                <template #search="{attributes, events}">
                                                    <input
                                                        class="vs__search"
                                                        :required="!nominee.emp_id"
                                                        v-bind="attributes"
                                                        v-on="events"
                                                    />
                                                </template>
                                            </v-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Name"
                                            label-for="nominee_name"  class="requiredField"
                                        >
                                            <b-form-input
                                                id="nominee_name"
                                                name="nominee_name"
                                                v-model="nominee.nominee_name"
                                                type="text"
                                                :maxlength="200"
                                                v-validate="'required'" required
                                                placeholder="Name"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Relationship"
                                            label-for="relationship_nominee"  class="requiredField"
                                        >
                                            <b-form-select v-model="nominee.relationship_id" :options="relationshipWithNomineeList"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Percentage(%)"
                                            label-for="percentage"
                                        >

                                            <b-form-input
                                                id="percentage"
                                                v-model="nominee.percentage"
                                                type="text"
                                                placeholder="percentage(%)"
                                                name="percentage"
                                                :maxlength="3"
                                                v-validate="'decimal:2|max_value:100'"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3">
                                        <b-form-group
                                            label="Contact No."
                                            label-for="contact_no"
                                        >
                                            <b-form-input
                                                id="contact_no"
                                                v-model="nominee.nominee_contact_no"
                                                type="text"
                                                name="nominee_contact_no"
                                                v-validate="{ numeric: true, regex: /^01[5-9]\d{8}$/ }"
                                                :maxlength="15"
                                                placeholder="Contact No."
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="E-mail"
                                            label-for="nominee_email"
                                        >
                                            <b-form-input
                                                id="nominee_email"
                                                v-model="nominee.nominee_email"
                                                type="text"
                                                name="nominee_email"
                                                placeholder="E-mail"
                                                :maxlength="50"
                                                v-validate="'email'"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Date of Birth"
                                            label-for="nominee_dob" class="requiredField"
                                        >
                                            <date-picker v-model="nominee.nominee_dob" width="100%" required v-validate="'required'" name="nominee_dob" input-class="form-control"  type="date" lang="en" format="DD-MM-YYYY" :value-type="valueType" :editable="false" :not-after="notAfterToday()"> Nominee DOB</date-picker>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Marital Status"
                                            label-for="nominee_marital_status_id"
                                        >
                                            <b-form-select v-model="nominee.marital_status_id" :options="maritalStatusList"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Gender"
                                            label-for="nominee_gender"
                                        >
                                            <b-form-select v-model="nominee.gender_id" :options="genderList"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Address Line 1"
                                            label-for="address_line_1">
                                            <b-form-input
                                                id="address_line_1"
                                                v-model="nominee.address_line_1"
                                                type="text"
                                                placeholder="Address Line 1"
                                                name="address_line_1"
                                                :maxlength="500"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Address Line 2"
                                            label-for="address_line_2">
                                            <b-form-input
                                                id="address_line_2"
                                                v-model="nominee.address_line_2"
                                                type="text"
                                                placeholder="Address Line 2"
                                                name="address_line_2"
                                                :maxlength="500"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="District"
                                            label-for="district"
                                            class="requiredField">
                                            <b-form-select v-model="nominee.district_id" :options="district_ids" @input="geoDistrictChange(nominee.district_id)"></b-form-select>

                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            class="requiredField"
                                            label="THANA/UPAZILA"
                                            label-for="thana_id">
                                            <b-form-select v-model="nominee.thana_id" :options="thana_ids"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="post code"
                                            label-for="post_code">
                                            <b-form-input
                                                id="postcode"
                                                v-model="nominee.post_code"
                                                v-validate="'numeric|length:4'"
                                                type="text"
                                                placeholder="Enter Postcode"
                                                name="post_code"
                                                :maxlength="4"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Medical ID" label-for="medical_id">
                                            <b-form-input :maxlength="20" id="medical_id" v-model="nominee.medical_id" name="medical_id"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Bank"
                                            label-for="nominee_bank">
                                            <b-form-select v-model="nominee.bank_id" :options="bankList" @input="bankChange(nominee.bank_id)"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Branch"
                                            label-for="nominee_branch">
                                            <b-form-select v-model="nominee.branch_id" :options="branchList"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Account No"
                                            label-for="nominee_acc_no">
                                            <b-form-input
                                                id="nominee_acc_no"
                                                v-model="nominee.nominee_acc_no"
                                                type="text"
                                                name="nominee_acc_no"
                                                placeholder="Acc No"
                                                :maxlength="500"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            class="requiredField"
                                            label="Approved"
                                            label-for="approved_yn">
                                            <b-form-radio-group
                                                v-model="nominee.approved_yn"
                                                :options="approved_yn_options"
                                                name="approved_yn" required  v-validate="'required'"
                                            ></b-form-radio-group>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="2" class="text-center profileImage">
                               <b-card class="m-0" style="border: 1px solid #eff1f2;">
                                   <b-card-text >
                                       <b-img id="nominee_pic" fluid :src="nominee.nominee_photo ? nominee.nominee_photo : '/images/avatar.png'" ></b-img>
                                   </b-card-text>
                               </b-card>
                                <label for="nominee_photo" class="btn btn-secondary col-md-12" style="cursor: pointer">
                                    <i class="bx bx-upload"></i>&nbsp;Upload Image
                                </label>
                                <b-form-file @change="encodeFile"
                                             id="nominee_photo"
                                             class="bg-primary"
                                             size="sm"
                                             accept="image/png,image/jpg,image/jpeg" name="nominee_photo" v-validate.reject="'image|size:100'" style="display: none"
                                >
                                </b-form-file>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1">{{submitBtn}}</b-button>&nbsp;
                                <b-button type="reset" class="btn btn-outline-dark">Cancel</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card title="Nominee List">
                <b-card-body class="border">
                    <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage" >
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary"
                                    @click="editRow(rows.item)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                            <b-link class="text-danger" v-b-modal="'nominee-remove'" @click="deletedItem = rows.item">
                                <i class="bx bx-trash cursor-pointer"></i>
                            </b-link>
                        </template>
                    </Datatable>
                    <b-modal :id="'nominee-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                             @ok="deleteRow()" @hidden="deletedItem = null">
                        <div>Are you sure you want to delete?</div>
                    </b-modal>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from "moment";
    export default {
        name: "nominee",
        components: {DatePicker, Datatable, vSelect, vcss},
        data(){
            return {
                selectedEmployee: {},
                employeeList: [],
                relationshipWithNomineeList: [{'value': '', 'text': 'Select Relationship with Nominee'}],
                valueType: this.dateFormatter(),
                relationships: {},
                errorMessage: {color: 'red'},
                nominee: {
                    nominee_photo: ''
                },
                perPage: 10,
                items: [],
                totalList: '',
                fields:[

                ],
                maritalStatusList:[{'value': '', 'text': 'Select Marital status'}],
                authTypeList:[{'value': '', 'text': 'Select Authentication Type'}],
                bankList:[{'value': '', 'text': 'Select Bank'}],
                branchList:[{'value': '', 'text': 'Select Branch'}],
                genderList:[{'value': '', 'text': 'Select Gender'}],
                district_ids: [{'value': '', 'text': 'Select District'}],
                thana_ids: [{'value': '', 'text': 'Select Thana/Upazilla'}],
                maritalStatus:{},
                approved_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                submitBtn:'Save'
            }
        },
        mounted() {
            this.loadTable()
        },
        methods:{
            onSubmit(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/nominee`, this.nominee).then(response => {
                    if (response.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: response.data.o_status_message, type: 'success'});
                        this.onReset()
                        this.loadTable()
                    } else {
                        this.$notify({group: 'pmis', text: response.data.o_status_message, type: 'error'});
                    }
                })
            },
            onReset(){
                this.nominee = {}
            },
            loadTable(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/nominee`, this.formData).then(response => {
                    if (response.data){
                        this.items = response.data
                        this.totalList = response.data.length
                    }
                })
            },
            getNomineePhoto(event){
                let currObj = this;
                let input = event.target;
                if (input.files && input.files[0]) {
                    this.$validator.validate('nominee_photo', currObj.nominee.nominee_photo).then(function() {
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            currObj.nominee.nominee_photo = e.target.result;
                        };
                        reader.readAsDataURL(input.files[0]);
                        currObj.nominee.nominee_photo_name = input.files[0].name;
                        currObj.nominee.nominee_photo_type = input.files[0].name.split('.').pop();
                    }).catch(err => {
                        console.log('image error');
                    });

                }
            },
            searchEmployee(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/employee-search/${id}`).then(response => {
                        this.employeeList = response.data
                    })
                }
            },
            notAfterToday() {
                return moment().subtract(1, 'days')
            },
            encodeFile(e){
                let file_limit = 2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='image/png'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        vm.nominee.nominee_photo_type = type
                        vm.nominee.nominee_photo_name = name
                        reader.readAsDataURL(file)
                        reader.onload = (file)=>{
                            vm.nominee.nominee_photo = reader.result
                            console.log(vm.nominee.nominee_photo)
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'});
                    }

                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'});
                    return;
                }
            },
            dateFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null
                    }
                }
            },
            bankChange(id){
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/branches/${id}`).then(result => {
                        this.branchList = result.data;
                    })
                }
            },
            geoDistrictChange(id){
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-thanas/${id}`).then(result => {
                        this.thana_ids = result.data
                    })
                }
            },
            editRow(){

            },
            deleteRow(){

            },
            preloadData(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominees/specific/${id}`).then(res => {
                    if(this.relationshipWithNomineeList.length <=1) {
                        this.relationshipWithNomineeList = this.relationshipWithNomineeList.concat(res.data.relationships);
                    }

                    if(this.maritalStatusList.length <=1) {
                        this.maritalStatusList = this.maritalStatusList.concat(res.data.maritalStatuses);
                    }

                    if(this.authTypeList.length <=1) {
                        this.authTypeList = this.authTypeList.concat(res.data.authdocs);
                    }

                    if(this.bankList.length <=1) {
                        this.bankList = this.bankList.concat(res.data.banks);
                    }

                    if(this.genderList.length <=1) {
                        this.genderList = this.genderList.concat(res.data.genders);
                    }

                    if(this.district_ids.length <= 1) {
                        this.district_ids = this.district_ids.concat(res.data.district_ids);
                    }
                });
            }
        },
        computed:{

        },
        watch:{
            selectedEmployee: function (val, oldVal) {
                if (val != null){
                    this.nominee.emp_id = val.emp_id;
                    this.preloadData(val.emp_id)
                }
            }
        }
    }
</script>

<style>
    .file-upload-form, .image-preview {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        padding: 20px;
    }
    img.preview {
        width: 200px;
        background-color: white;
        border: 1px solid #DDD;
        padding: 5px;
    }
    #nominee_pic, #nominee_doc{
        height: 180px !important;
        width: 100%;
    }
</style>
