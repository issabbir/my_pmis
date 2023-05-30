<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked" style="padding-top:0px;">
                <b-row>
                    <b-col md="12" sm="12" class="pr-md-0">
                        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                            <b-card title="Address">
                                <b-card-body class="border">
                                    <b-row>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Address Type"
                                                label-for="address_type_id"
                                                class="requiredField">
                                                <v-select v-model="addressTypes" :options="address_type_ids"
                                                          name="address_type_id" id="address_type_id" label="text"
                                                          class="uppercase"
                                                >
                                                    <template #search="{attributes, events}">
                                                        <input
                                                            class="vs__search"
                                                            :required="addressTypes.value==''"
                                                            v-bind="attributes"
                                                            v-on="events"
                                                        />
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Both Address are same"
                                                label-for="same_as">
                                                <b-form-checkbox
                                                    id="same_as"
                                                    v-model="address.same_as"
                                                    name="same_as"
                                                    value="Y"
                                                    unchecked-value="N">
                                                    Yes
                                                </b-form-checkbox>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>

                                        <b-col md="3">
                                            <b-form-group
                                                label="ADDRESS LINE 1"
                                                label-for="address_line_1">
                                                <b-form-textarea
                                                    size="sm"
                                                    v-model="address.address_line_1"
                                                    class="uppercase"
                                                    placeholder="ADDRESS LINE 1"
                                                    id="address_line_1"
                                                    name="address_line_1"
                                                    :maxlength="500">
                                                </b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="ADDRESS LINE 1 Bng"
                                                label-for="address_line_1_bng">
                                                <b-form-textarea
                                                    size="sm"
                                                    class="uppercase"
                                                    placeholder="ADDRESS LINE 1 Bng"
                                                    v-model="address.address_line_1_bng"
                                                    id="address_line_1_bng"
                                                    name="address_line_1_bng"
                                                    :maxlength="3000">
                                                </b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="ADDRESS LINE 2"
                                                label-for="address_line_2">
                                                <b-form-textarea
                                                    v-model="address.address_line_2"
                                                    size="sm"
                                                    class="uppercase"
                                                    placeholder="ADDRESS LINE 2"
                                                    id="address_line_2"
                                                    name="address_line_2"
                                                    :maxlength="500">
                                                </b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="ADDRESS LINE 2 Bng"
                                                label-for="address_line_2_bng">
                                                <b-form-textarea
                                                    v-model="address.address_line_2_bng"
                                                    size="sm"
                                                    class="uppercase"
                                                    placeholder="ADDRESS LINE 2 Bng"
                                                    id="address_line_2_bng"
                                                    name="address_line_2_bng"
                                                    :maxlength="3000">
                                                </b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Division"
                                                label-for="division"
                                                class="requiredField">
                                                <v-select v-model="divisions" :options="division_ids"
                                                          @input="geoDivisionChange"
                                                          name="division_id" id="division_id" label="text"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input
                                                            class="vs__search"
                                                            :required="divisions.value==''"
                                                            v-bind="attributes"
                                                            v-on="events"
                                                        />
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="3">
                                            <b-form-group
                                                label="District"
                                                label-for="district"
                                                class="requiredField">
                                                <v-select v-model="districts" :options="district_ids"
                                                          @input="geoDistrictChange"
                                                          name="district_id" id="district_id" label="text"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input
                                                            class="vs__search"
                                                            :required="districts.value==''"
                                                            v-bind="attributes"
                                                            v-on="events"
                                                        />
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="THANA/UPAZILA"
                                                label-for="thana"
                                                class="requiredField">
                                                <v-select v-model="thanas" :options="thana_ids"
                                                          name="thana_id" id="thana_id" label="text"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input
                                                            class="vs__search"
                                                            :required="thanas.value==''"
                                                            v-bind="attributes"
                                                            v-on="events"
                                                        />
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="3">
                                            <b-form-group
                                                label="post code"
                                                label-for="post_code">
                                                <b-form-input
                                                    id="postcode"
                                                    v-model="address.post_code"
                                                    v-validate="'numeric|length:4'"
                                                    type="text"
                                                    placeholder="Enter Postcode"
                                                    name="post_code"
                                                    :maxlength="4">
                                                </b-form-input>
                                                <span :style="errorMessage">{{ errors.first('post_code') }}</span>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1" :disabled="keepDisable">{{submitBtn}}</b-button>
                                            <b-button type="reset" class="btn btn-outline-dark" :disabled="keepDisable">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                </b-card-body>
                            </b-card>
                        </b-form>
                        <b-card title="Address list">
                            <b-card-body class="border">
                                <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'emp_address_id'">
                                    <template v-slot:actions="{ rows }">
                                        <b-link ml="4" class="text-primary"
                                                @click="editRow(rows.item.emp_address_id)">
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>
                                        <b-link class="text-danger" v-b-modal="'address-remove'" @click="deletedItem = rows.item">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>
                                    </template>
                                </Datatable>
                                <b-modal :id="'address-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                                         @ok="deleteRow()" @hidden="deletedItem = null">
                                    <div>Are you sure you want to delete?</div>
                                </b-modal>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker'
    import vSelect from 'vue-select';
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        name: "my-account-address",
        components: { DatePicker, Datatable,vSelect},
        data() {
            return {
                deletedItem: null,
                keepDisable: false,
                errorMessage: {color: 'red'},
                approved_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                divisions: {'text':'','value':''},
                districts: {'text':'','value':''},
                thanas: {'text':'','value':''},
                addressTypes:{'text':'','value':''},
                same_as:'N',
                address: {
                    emp_address_id: '',
                    address_type_id:'',
                    address_line_1:'',
                    address_line_1_bng:'',
                    address_line_2:'',
                    address_line_2_bng:'',
                    division_id:'',
                    district_id:'',
                    thana_id:'',
                    post_code:'',
                    same_as:'N',
                    old_division_id:'',
                    old_district_id:'',
                    approved_yn: 'N'
                },

                selected: 'first',
                address_type_ids: [{'value': '', 'text': 'Select Address type'}],
                division_ids: [{'value': '', 'text': 'Select Division'}],
                district_ids: [{'value': '', 'text': 'Select District'}],
                thana_ids: [{'value': '', 'text': 'Select Thana/Upazilla'}],
                updateIndex:-1,
                submitBtn: 'Save',
                show: true,
                fields: [
                    {key: 'index', label: 'SL'},
                    {
                        key: 'address_type.address_type', 'label': "Address Type", sortable: true
                    },
                    {key: 'geo_division.geo_division_name', label:'Division', sortable: true},
                    {key: 'geo_district.geo_district_name', label:"District", sortable: true},
                    {key: 'geo_thana.geo_thana_name', label:"Thana", sortable: true},
                    {key: 'post_code', label:"Post Code", sortable: true},
                    'action'],
                items: [],
                totalList: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "My Account"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "My Address"});
            this.loadData();
            this.address.emp_id = this.$store.getters.user.emp_id;
            console.log("tested!!");
        },
        watch: {
            divisions:function(val,oldVal) {
                if(val !== null) {
                    this.address.division_id = val;
                } else {
                    this.address.division_id = '';
                }
            },
            districts:function(val,oldVal) {
                if(val !== null) {
                    this.address.district_id = val;
                } else {
                    this.address.district_id = '';
                }
            },
            thanas:function(val,oldVal) {
                if(val !== null) {
                    this.address.thana_id = val;
                } else {
                    this.address.thana_id = '';
                }
            },
            addressTypes:function(val,oldval){
                if(val !== null) {
                    this.address.address_type_id = val;
                } else {
                    this.address.address_type_id = '';
                }
            },
        },
        methods: {
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            geoDivisionChange(id){

                let division_id=(typeof(id))=='string'?id:id['value'];
                if(this.address.old_division_id){
                    if(division_id!=this.address.old_division_id){
                        this.districts = {
                            text: '',
                            value: ''
                        };
                        this.thanas = {
                            text: '',
                            value: ''
                        };
                    }
                } else {
                    this.districts = {
                        text: '',
                        value: ''
                    };
                    this.thanas = {
                        text: '',
                        value: ''
                    };
                }
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-districts/${division_id}`).then(result => {
                    this.district_ids = result.data;
                });
            },
            geoDistrictChange(id){
                if(id){
                    let district_id=(typeof(id))=='string'?id:id['value'];
                    if(this.address.old_district_id){
                        if(district_id!=this.address.old_district_id){
                            this.thanas={
                                text: '',
                                value: ''
                            };
                        }
                    } else {
                        this.thanas={
                            text: '',
                            value: ''
                        };
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-thanas/${district_id}`).then(result => {
                        this.thana_ids = result.data;
                    });
                }
            },
            hasEmpId: function() {
                return ((this.$store.getters.user.emp_id !== undefined) && (this.$store.getters.user.emp_id > 0));
            },
            loadData: function() {
                // console.log(this.$store.getters.user.emp_id)
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/addresses/specific/${this.$store.getters.user.emp_id}`).then(res => {
                        if(this.address_type_ids.length <=1) {
                            this.address_type_ids = this.address_type_ids.concat(res.data.address_type_ids);
                        }

                        if(this.division_ids.length <=1) {
                            this.division_ids = this.division_ids.concat(res.data.division_ids);
                        }
                        this.items = res.data.data;
                        this.totalList = res.data.data.length;
                    });
                }
            },
            onSubmit() {
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.keepDisable = true;
                        if(this.updateIndex > 0) {
                            ApiRepository.callApi(ApiRepository.PUT_COMMAND,`/pmis/employee/addresses/${this.updateIndex}`,this.address).then(result => {
                                if (result.data.o_status_code == 1) {
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                                    this.onReset();
                                } else{
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                                }
                                this.loadData();
                                this.keepDisable = false;
                            });
                        }else {
                            ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/addresses", this.address).then(result => {
                                if (result.data.o_status_code == 1) {
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                                    this.onReset();
                                } else{
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                                }
                                this.loadData();
                                this.keepDisable = false;
                            });
                        }
                    }
                });

            },
            onReset() {
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.deletedItem = null;
                this.show = false;
                this.$nextTick(() => {
                    this.address= {
                        emp_address_id: '',
                        address_type_id:'',
                        address_line_1:'',
                        address_line_1_bng:'',
                        address_line_2:'',
                        address_line_2_bng:'',
                        division_id:'',
                        district_id:'',
                        thana_id:'',
                        post_code:'',
                        same_as:'N',
                        old_division_id:'',
                        old_district_id:'',
                        approved_yn: 'N'
                    };
                    this.divisions={
                        text: '',
                        value: ''
                    };
                    this.districts = {
                        text: '',
                        value: ''
                    };
                    this.thanas = {
                        text: '',
                        value: ''
                    };
                    this.addressTypes = {
                        text: '',
                        value: ''
                    };
                    this.district_ids = []
                    this.thana_ids = []
                    this.show = true
                })
            },
            onFiltered(filteredItems) {
                this.totalList = filteredItems.length;
                this.currentPage = 1
            },
            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/pmis/employee/addresses/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.address = result.data;
                    this.addressTypes=result.data.address_type;
                    this.divisions=result.data.geo_division;
                    this.address.old_division_id=result.data.geo_division.geo_division_id;
                    this.address.old_district_id=result.data.geo_district.geo_district_id;
                    this.districts=result.data.geo_district;
                    this.thanas=result.data.geo_thana;
                    this.geoDivisionChange(result.data.division_id);
                    this.geoDistrictChange(result.data.district_id);
                });

            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/pmis/employee/addresses/${this.deletedItem.emp_address_id}`).then( result => {
                        if (result.data.o_status_code == 1) {
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                        } else{
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                        }
                        this.deletedItem = null;
                        this.onReset();
                        this.loadData();
                    }).catch(err => {
                        this.deletedItem = null;
                        console.log(err);
                    });
                }

            }
        }
    }
</script>


<style>
    .uppercase { text-transform: uppercase; }
</style>
