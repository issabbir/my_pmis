<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked" style="padding-top:0px;">
                <b-card-title>
                    <b-form-checkbox vertical v-model="hidenseek" name="check-button" switch size="lg">
                    </b-form-checkbox>
                </b-card-title>
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0" :class="{'d-none':!hidenseek}">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0" :class="{'col-md-12':!hidenseek}">
                        <b-card title="Contacts" v-if="can_update">
                            <b-card-body class="border">
                                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" >
                                    <b-row>
                                        <b-col md="4" :style="contacts.emp_contacts_id>0?'pointer-events:none':''">
                                            <b-form-group label="Contacts Type" label-for="emp_contact_type_id" class="requiredField">
                                                <v-select v-model="contactTypeList" :options="contactsList"
                                                          name="emp_contact_type_id" id="emp_contact_type_id" label="text"
                                                          class="uppercase"
                                                          required v-validate="'required'">
                                                    <template #search="{attributes, events}">
                                                        <input
                                                            class="vs__search"
                                                            :required="contactTypeList && contactTypeList.emp_contact_type_id==null"
                                                            v-bind="attributes"
                                                            v-on="events"
                                                        />
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('emp_contact_type_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group label="Contact" label-for="emp_contact_info" class="requiredField">
                                                <b-form-input
                                                    id="a"
                                                    v-model="contacts.emp_contact_info"
                                                    type="text"
                                                    :maxlength="50"
                                                    required
                                                    placeholder="" v-validate="contactInfoValidationRule" name="emp_contact"> </b-form-input>
                                                <span :style="errorMessage">{{ errors.first('emp_contact') }}</span>
                                            </b-form-group>
                                        </b-col>
<!--                                        <b-col md="3" v-if="hasPermission('CAN_APPROVE_EMPLOYEE')==true">-->
<!--                                            <b-form-group-->
<!--                                                class="requiredField"-->
<!--                                                label="Approved"-->
<!--                                                label-for="approved_yn">-->
<!--                                                <b-form-radio-group-->
<!--                                                    v-model="contacts.approved_yn"-->
<!--                                                    :options="approved_yn_options"-->
<!--                                                    name="approved_yn" required  v-validate="'required'">-->
<!--                                                </b-form-radio-group>-->
<!--                                                <span :style="errorMessage">{{ errors.first('approved_yn') }}</span>-->
<!--                                            </b-form-group>-->
<!--                                        </b-col>-->
                                        <b-col md="3" class="contacts_btn">
                                            <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1" :disabled="keepDisable">{{submitBtn}}</b-button>
                                            <b-button type="reset" class="btn btn-outline-dark" :disabled="keepDisable">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </b-card-body>
                        </b-card>
                        <b-card title="Contacts List">
                            <b-card-body class="border">
                                <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'emp_contacts_id'">
                                    <template v-slot:actions="{ rows }" v-if="can_update">
                                        <b-link ml="4" class="text-primary"
                                                @click="editRow(rows.item.emp_contacts_id)">
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>

                                        <b-link class="text-danger" v-b-modal="'contact-remove'" @click="deletedItem = rows.item">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>
                                    </template>
                                    <template v-slot:action2="{ rows }">
                                        <span v-if="rows.item.approved_yn == 'Y'" class="text-success text-center">Approved</span>
                                        <span class="text-danger text-center" v-else>Pending</span>
                                    </template>
                                </Datatable>
                                <b-modal :id="'contact-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
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
    import DatePicker from 'vue2-datepicker';
    import vSelect from 'vue-select';
    import SideBar from "../partials/sidebar";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {DatePicker, SideBar, Datatable,vSelect},
        props: ['id'],
        data() {
            return {
                hidenseek: true,
                deletedItem: null,
                keepDisable: false,
                contactInfoValidationRule: "required",
                errorMessage: {color: 'red'},
                approved_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                contactTypeList:{'text':'','value':''},
                contacts: {
                    emp_contacts_id: '',
                    emp_contact_type_id:'',
                    emp_contact_info:'',
                    approved_yn: 'N'
                },
                contactsList:[{'value': '', 'text': 'Select Contact type'}],
                updateIndex: -1,
                submitBtn: 'Save',
                can_update: false,
                fields: [
                  {key: 'index', label: 'SL'},
                    {key: 'contact_type.emp_contact_type', label: 'Contacts Type', sortable: true},
                    {key: 'emp_contact_info', label: 'Contact', sortable: true},
                    {key: 'last_updated_by', label: 'Last Updated By', sortable: true},
                    {key: 'action2' , label: 'Status'}
                ],
                items: [],

                results: [],
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Contacts"});
            this.contacts.emp_id = this.id;
            this.loadData();
            this.canUpdate()
        },
        watch: {
            can_update: function(val, oldVal){
                if(val){
                    this.fields.push({key: 'action', class: 'text-center'})
                }
            },
            contactTypeList:function (val,oldVal) {
                if(val !== null) {
                    this.contacts.emp_contact_type_id = val;
                } else {
                    this.contacts.emp_contact_type_id = '';
                }
            },
            "contacts.emp_contact_type_id": function() {
                let contact_type = this.contactsList.find(row => {
                    return row.emp_contact_type_id == this.contacts.emp_contact_type_id.emp_contact_type_id;
                });

                if(contact_type) {
                    let contact_type_name = contact_type.emp_contact_type;
                    if(contact_type_name) {
                        contact_type_name = contact_type_name.toLowerCase();
                        if(contact_type_name == 'e-mail') {
                            this.contactInfoValidationRule = "required|email";
                        } else if(contact_type_name == 'mobile number') {
                            this.contactInfoValidationRule = { required: true, numeric: true, regex: '\^01[3-9]\\d{8}\$' };
                        } else {
                            this.contactInfoValidationRule = "required";
                        }
                    } else {
                        this.contactInfoValidationRule = "required";
                    }
                } else {
                    this.contactInfoValidationRule = "required";
                }
            },
        },
        methods: {
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            hasEmpId: function() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            onSubmit() {
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.keepDisable = true;
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/contacts", this.contacts).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.onReset();
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                            } else{
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                            }
                            this.loadData();
                            this.keepDisable = false;
                        });
                    }
                });
            },
            loadData: function () {
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/contacts/specific/${this.id}`).then(res => {
                        if(this.contactsList.length <=1) {
                            this.contactsList=this.contactsList.concat(res.data.contact);
                        }
                        this.items = res.data.data;
                        this.totalList = res.data.data.length;

                    });
                }
            },
            canUpdate(){
                this.can_update = this.$store.getters.permissions.includes('CAN_UPDATE')
            },
            onReset() {
                this.updateIndex = -1;
                this.deletedItem = null;
                this.submitBtn = 'Save';
                this.$nextTick(() => {
                    this.contacts = {
                        emp_contacts_id: '',
                        emp_contact_info: '',
                        emp_contact_type_id: '',
                        approved_yn: 'N'
                    }
                    this.contactTypeList = {
                        text: '',
                        value: ''
                    }
                })
            },


            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1;
            },
            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/contacts/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.contacts = result.data;
                    this.contacts.emp_contacts_id = id;
                    this.contactTypeList=result.data.contact_type;
                });
            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/pmis/employee/contacts/${this.deletedItem.emp_contacts_id}`).then( result => {
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
    .contacts_btn{
        margin-top: 19px !important;
    }
    .custom-switch .custom-control-label::before{
        border: 1px solid cadetblue
    }
</style>
