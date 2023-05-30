<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked" style="padding-top:0px">
                <b-card-title>
                    <b-form-checkbox vertical v-model="hidenseek" name="check-button" switch size="lg"></b-form-checkbox>
                </b-card-title>
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0" :class="{'d-none':!hidenseek}">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0" :class="{'col-md-12':!hidenseek}">
                        <b-card title="Professional Certificate" v-if="can_update">
                            <b-card-body class="border">
                                <b-form ref="form" @submit.prevent="onSubmit" @reset.prevent="onReset">
                                    <b-row>
                                        <b-col md="3">
                                            <b-form-group label="Certification Name"
                                                          label-for="certification_name"
                                                          class="requiredField">
                                                <b-form-input
                                                    v-model="profcert.certificate_name"
                                                    type="text"
                                                    required
                                                    placeholder="Certification Name"
                                                    required
                                                    :maxlength="500"
                                                    name="certificate_name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="3">
                                            <b-form-group label="Country"
                                                          label-for="certificate_country_id">
                                                <v-select v-model="countries" :options="countryList"
                                                          name="certificate_country_id" id="certificate_country_id" label="text"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group label="DESCRIPTION" label-for="description"
                                                          class="requiredField">
                                                <b-form-input
                                                    v-model="profcert.certificate_description"
                                                    type="text"
                                                    required
                                                    placeholder="Certification Description"
                                                    :maxlength="500"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group label="INSTITUTE Name"
                                                          label-for="CERTIFICATE_INSTITUTE"
                                                          class="requiredField">
                                                <b-form-input
                                                    v-model="profcert.certificate_institute"
                                                    type="text"
                                                    required
                                                    :maxlength="500"
                                                    placeholder="Institute Name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col md="3">
                                            <b-form-group label="CERTIFICATE DATE" label-for="date"
                                                          class="requiredField">
                                                <date-picker
                                                    v-model="profcert.certificate_date"
                                                    input-class="form-control"
                                                    width="100%"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    :not-after="notAfter()"
                                                    required v-validate="'required'"
                                                    name="certificate_date"
                                                ></date-picker>
                                                <span :style="errorMessage">{{ errors.first('certificate_date') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group label="CERTIFICATE EXPIRE DATE"
                                                          label-for="dob">
                                                <date-picker
                                                    v-model="profcert.certificate_expire_date"
                                                    input-class="form-control"
                                                    width="100%"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    :not-before="notBeforeCertificateDate()"
                                                ></date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group
                                                label="CERTIFICATE DOCUMENT"
                                                label-for="certificate_document"
                                            >
                                                <div class="custom-file b-form-file">
                                                    <input type="file" class="custom-file-input"
                                                           @change="getDocument"
                                                           accept="application/msword, application/pdf, image/png, image/jpg, image/jpeg"
                                                           v-validate.reject="'size:500'"
                                                           name="certificate_doc"/>
                                                    <label data-browse="Browse"
                                                           class="custom-file-label">{{profcert.certificate_document_name}}</label>
                                                    <span :style="errorMessage">{{ errors.first('certificate_doc') }}</span>
                                                </div>
                                                <div v-if="hasAuthenticationDocument()">
                                                    <a :href="getAuthenticationDownloaderUrl(profcert.certificate_id)"
                                                       target="_blank">
                                                        {{profcert.certificate_document_name}} </a>
                                                </div>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button-group>
                                                <b-button
                                                    type="submit"
                                                    id="basic_sub_btn"
                                                    variant="primary"
                                                    :disabled="keepDisable"
                                                >{{submitBtn}}
                                                </b-button>
                                                <b-button type="reset" variant="secondary"
                                                          :disabled="keepDisable">Cancel
                                                </b-button>
                                            </b-button-group>
                                        </b-col>
                                    </b-row>
                                    <div class="pr-0 d-flex justify-content-end">

                                    </div>
                                </b-form>
                            </b-card-body>
                        </b-card>
                        <b-card title="Professional Certificate List">
                            <b-card-body class="border">
                                <Datatable
                                    v-bind:fields="fields"
                                    v-bind:items="items" :totalList="totalList"
                                    :perPage="perPage" :primaryKeyColumnName="'certificate_id'">
                                    <template v-slot:actions="{ rows }">
                                        <b-link ml="4" class="text-primary"
                                                @click="editRow(rows.item.certificate_id)">
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>
                                        <b-link class="text-danger"
                                                v-b-modal="'prof-cert-remove'"
                                                @click="deletedItem = rows.item">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>
                                    </template>
                                </Datatable>
                                <b-modal :id="'prof-cert-remove'" :centered="true"
                                         title="Please Confirm" size="sm" buttonSize="sm"
                                         okTitle="YES" cancelTitle="NO" footerClass="p-2"
                                         :hideHeaderClose="false"
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
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import SideBar from "../partials/sidebar";
    import Datatable from "../../../layouts/common/datatable";
    import ApiRepository from "../../../Repository/ApiRepository";
    import vSelect from 'vue-select';

    export default {
        components: {DatePicker, SideBar, Datatable, vSelect},
        props: ['id'],
        data() {
            return {
                can_update: false,
                hidenseek: true,
                countries : {'text':'Bangladesh','value':1},
                deletedItem: null,
                keepDisable: false,
                errorMessage: {color: 'red'},
                valueType: this.dateFormatter(),
                profcert: {
                    emp_id: '',
                    certificate_id: '',
                    certificate_name: '',
                    certificate_country_id: null,
                    certificate_description: '',
                    certificate_institute: '',
                    certificate_date: '',
                    certificate_expire_date: '',
                    certificate_document: null,
                    certificate_document_name: null,
                    certificate_document_type: null
                },
                updateIndex: -1,
                submitBtn: 'Save',
                countryList: [],
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: "certificate_name", sortable: true},
                    {key: "certificate_country.country", label: 'Country', sortable: true},
                    {key: "certificate_institute", sortable: true},
                    {
                        key: "certificate_date", sortable: true, filterByFormatted: true, sortByFormatted: true,
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }
                    },
                    {
                        key: "certificate_expire_date", sortable: true, filterByFormatted: true, sortByFormatted: true,
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }
                    }
                ],
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
            };
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Professional Certificate"});
            this.loadData();
            this.profcert.emp_id = this.id;
            this.canUpdate()
        },

        watch: {
            can_update: function(val, oldVal){
                if(val){
                    this.fields.push({key: 'action', class: 'text-center'})
                }
            },
            countries:function(val,oldVal) {
                if(val !== null) {
                    this.profcert.certificate_country_id = val;
                } else {
                    this.profcert.certificate_country_id = '';
                }
            },

        },
        methods: {
            canUpdate(){
                this.can_update = this.$store.getters.permissions.includes('CAN_UPDATE')
            },
            hasAuthenticationDocument() {
                return (this.profcert.certificate_id && this.profcert.certificate_document);
            },
            getAuthenticationDownloaderUrl(certificateId) {
                return 'pmis/prof-cert/download-authentication-document/' + certificateId;
            },
            notBeforeCertificateDate() {
                if (this.profcert.certificate_date) {
                    return moment(this.profcert.certificate_date).add('1', 'days');
                }
            },
            dateFormatter: function () {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null;
                    }
                }
            },
            notAfter() {
                if (this.profcert.certificate_expire_date) {
                    return moment(this.profcert.certificate_expire_date).subtract('1', 'days');
                } else {
                    return moment().subtract(1, 'days');
                }
            },
            getDocument: function (event) {
                let input = event.target;
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.profcert.certificate_document = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                    this.profcert.certificate_document_name = input.files[0].name;
                    this.profcert.certificate_document_type = input.files[0].name.split('.').pop();
                    console.log('name: ', this.profcert.certificate_document_name);
                    console.log('type: ', this.profcert.certificate_document_type);
                }
            },
            hasEmpId: function () {
                return ((this.id !== undefined) && (this.id > 0));
            },
            loadData() {
                if (this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/prof-certs/specific/${this.id}`).then(result => {
                        this.countryList = result.data.countries;
                        this.items = result.data.certificates;
                        this.totalList = result.data.certificates.length;
                    });
                }
            },

            onSubmit() {
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.keepDisable = true;
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/prof-certs", this.profcert).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.onReset()
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                            } else {
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                            }
                            this.loadData();
                            this.keepDisable = false;
                        });
                    }
                });
            },
            onReset() {
                this.updateIndex = -1
                this.deletedItem = null
                this.submitBtn = 'Save'
                this.$nextTick(() => {
                    this.profcert = {
                        emp_id: this.id,
                        certificate_id: '',
                        certificate_name: '',
                        certificate_country_id: null,
                        certificate_description: '',
                        certificate_institute: '',
                        certificate_date: '',
                        certificate_expire_date: '',
                        certificate_document: null,
                        certificate_document_name: null,
                        certificate_document_type: null
                    }
                    this.countries = {
                        text:'Bangladesh',
                        value:1
                    }
                })
            },
            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/prof-certs/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.profcert = result.data;
                    this.profcert.certificate_id = id;
                    this.countries = result.data.certificate_country;
                });
            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/pmis/employee/prof-certs/${this.deletedItem.certificate_id}`).then(result => {
                        if (result.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'success'})
                        } else {
                            this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'error'})
                        }
                        this.deletedItem = null;
                        this.onReset();
                        this.loadData();
                    }).catch(err => {
                        this.deletedItem = null;
                        console.log(err);
                    });
                }
            },
            onFiltered(filteredItems) {
                this.totalList = filteredItems.length;
                this.currentPage = 1;
            }
        }
    };
</script>
