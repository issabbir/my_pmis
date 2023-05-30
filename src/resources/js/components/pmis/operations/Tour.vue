<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card v-if="hasPermission('CAN_OPERATIONS_CREATE')==true">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Tour Information
                </b-card-header>
                <b-card-body class="border">
                    <b-form
                        @submit.prevent="onSubmit"
                        @reset.prevent="onReset"
                        v-if="show"
                        class="form form-vertical col-md-12 ">
                        <b-row>
                            <b-col sm="3">
                                <b-form-group label="EMPLOYEE CODE" label-for="empCode" class="requiredField">
                                    <v-select
                                        :disbled="disabled"
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchEmpCode"
                                        id="emp_code">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="EMPLOYEE NAME" label-for="empName">
                                    <b-form-input
                                        id="empName"
                                        v-model="tour.emp_name"
                                        required
                                        readonly
                                        placeholder="Employee Name"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="DEPARTMENT NAME" label-for="deptName">
                                    <b-form-input
                                        id="deptName"
                                        v-model="tour.department_name"
                                        required
                                        readonly
                                        placeholder="Department Name"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group
                                    label="DESIGNATION"
                                    label-for="designation"
                                >
                                    <b-form-input
                                        id="designation"
                                        v-model="tour.designation"
                                        required
                                        readonly
                                        placeholder="Designation"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Tour Name" label-for="tourName"
                                              class="requiredField">
                                    <b-form-input v-model="tour.tour_name" required
                                                  name="tour_name" :maxlength="500"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Tour Name Bangla" label-for="purpose">
                                    <b-form-input v-model="tour.tour_name_bng" :maxlength="3000"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Tour Type" label-for="tour_type_id"
                                              class="requiredField">
                                    <v-select
                                        v-model="tourType"
                                        :options="tourTypeList"
                                        name="tour_type_id"
                                        id="tour_type_id"
                                        label="text"
                                        class="uppercase">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" :required="!tour.tour_type_id" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group
                                    label="Tour Purpose"
                                    label-for="tourPurpose"
                                    class="requiredField"
                                >
                                    <b-form-input
                                        id="tourPurpose"
                                        v-model="tour.tour_purpose"
                                        required
                                        placeholder="Tour Purpose"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col sm="3">
                                <b-form-group label="COUNTRY" label-for="country" class="requiredField">
                                    <v-select v-model="selectedCountry"
                                              :options="countries"
                                              label="country" required>
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="SPONSOR" label-for="sponser" class="requiredField">
                                    <b-form-input
                                        id="sponser"
                                        v-model="tour.sponsor"
                                        required
                                        placeholder="Sponser"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Sponsor Bangla" label-for="sponsor_bng">
                                    <b-form-input
                                        v-model="tour.sponsor_bng" id="sponsor_bng" :maxlength="3000"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="ORDER NO" label-for="orderNo" class="requiredField">
                                    <b-form-input
                                        id="orderNo"
                                        v-model="tour.order_no"
                                        required
                                        placeholder="Order No"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group
                                    label="TRAVEL DATE"
                                    label-for="travelDate"
                                    class="requiredField"
                                >
                                    <date-picker
                                        v-model="tour.travel_date"
                                        type="date"
                                        width="100%"
                                        input-class="form-control"
                                        lang="en"
                                        format="DD-MM-YYYY" :editable="false"
                                    ></date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group
                                    label="RETURN DATE"
                                    label-for="returnDate"
                                    class="requiredField"
                                >
                                    <date-picker
                                        v-model="tour.return_date"
                                        type="date"
                                        width="100%"
                                        input-class="form-control"
                                        lang="en"
                                        format="DD-MM-YYYY" :editable="false"
                                    ></date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Tour Duration"
                                              label-for="tour_duration">
                                    <b-form-input v-model="tour.tour_duration"
                                                  id="tour_duration"
                                                  name="tour_duration"
                                                  disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group
                                    label="Attachment"
                                    label-for="attachment"
                                    class="message"
                                >
                                    <b-form-file
                                        @change="encodeFile"
                                        id="attachment"
                                        placeholder="Attachment"
                                    ></b-form-file>
                                </b-form-group>
                            </b-col>
                            <b-col sm="12">
                                <b-form-group label="Description" label-for="note"
                                              class="requiredField">
                                    <b-form-textarea
                                        required
                                        id="note"
                                        rows="1"
                                        max-rows="5"
                                        v-model="tour.note">
                                    </b-form-textarea>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button-group>
                                    <b-button type="submit" variant="primary">{{submitBtn}}</b-button>
                                    <b-button type="reset" variant="secondary">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Tour List</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col sm="4">
                            <b-form-group label="Department Name" label-cols-md="4" label-for="toDeptName">
                                <v-select v-model="searchParam" :options="departmentOptions"
                                          label="department_name" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>

                            </b-form-group>
                        </b-col>
                        <b-col>
                            <div class="pr-0 d-flex justify-content-start">
                                <b-button-group>
                                    <b-button type="button" @click="searchByDepartment()" variant="primary"><i
                                        class='bx bx-search'></i>Search
                                    </b-button>
                                    <b-button type="button" @click="clear()" variant="secondary">Reset</b-button>
                                </b-button-group>
                            </div>
                        </b-col>

                    </b-row>
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items">
                        <template v-slot:actions="{ rows }">
                            <a size="sm" :disabled="hasPermission('CAN_OPERATIONS_CREATE')==false" @click="editRow(rows.item)"> <i class="bx bx-edit cursor-pointer"></i> </a>
                            <a size="sm" :hidden="hasPermission('CAN_OPERATIONS_CREATE')==false" class="text-danger" @click="deleteRow(rows.item.tour_id, rows.index)"> <i
                                class="bx bx-trash cursor-pointer"></i> </a>
                            <a v-b-modal.modal-center :disabled="hasPermission('CAN_OPERATIONS_PROCESS')==false" @click="renderModal(rows.item)"><i
                                class="bx bx-cog cursor-pointer"></i></a>
                            <a size="sm" @click="showAttachmnet(rows.item.attachment)"><i
                                class="bx bx-download cursor-pointer"></i> </a>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <div>
                <b-modal id="modal-center" @ok="processed()" centered ok-title="Process"
                         :title="'Tour Processing For '+tour.emp_name+'<br> Employee Code: '+tour.emp_code">
                    <b-form-group>
                        <b-form-textarea
                            id="description"
                            v-model="tour.approve_note"
                            placeholder="Remarks"
                            rows="1"
                            max-rows="6"
                        ></b-form-textarea>
                    </b-form-group>
                </b-modal>
            </div>
        </div>
    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from '../../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';

    export default {
        components: {DatePicker, Datatable, vSelect, vcss},
        data() {
            return {
                selectedCountry: {
                    country: '',
                    country_id: ''
                },
                keepDisabledEndDate: true,
                tourTypeList: [],
                tourType:{'text':'', 'value':''},
                errorMessage: {color: 'red'},
                selectedEmployee: [],
                empIdList: [],
                disabled: false,
                datetime: new Date(),
                departmentOptions: [],
                searchParam: '',
                submitBtn: 'Save',
                tour: {
                    emp_name: "",
                    department_name: "",
                    department_id: null,
                    designation_id: null,
                    designation: "",
                    tour_purpose: "",
                    tour_duration: '',
                    travel_date: new Date(),
                    return_date: new Date(),
                    sponsor: "",
                    sponsor_bng: "",
                    note: "",
                    approve_note:"",
                    order_no: null,
                    attachment: null,
                    emp_code: null,
                    country: '',
                    emp_id: null,
                    tour_name: '',
                    tour_name_bng: '',
                    tour_type_id: ''
                },
                countries: [],
                show: true,
                tableData: {
                    fields: [
                        {key: 'emp_code', label: 'Employee Code', sortable: true},
                        {key: 'emp_name', label: 'Employee Name', sortable: true},
                        {key: 'travel_date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            },
                            orderDate: true},
                        {key: 'return_date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            },
                            sortable: true},
                        {key: 'country', sortable: true},
                        {key: 'sponsor', sortable: true},
                        'action'],
                    items: []
                }
            };
        },
        watch: {
            "tour.travel_date": function() {
                this.keepDisabledEndDate = false;
                if(this.tour.travel_date && this.tour.return_date)
                {
                    this.tour.tour_duration = this.getTourDuration(this.tour.travel_date, this.tour.return_date)
                }
            },
            "tour.return_date": function() {
                if(this.tour.travel_date && this.tour.return_date)
                {
                    this.tour.tour_duration = this.getTourDuration(this.tour.travel_date, this.tour.return_date)
                }
            },
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.tour.emp_id = val.emp_id;
                    this.tour.emp_code = val.emp_code;
                    this.tour.emp_name = val.emp_name;
                    this.tour.designation = val.designation;
                    this.tour.department_name = val.department_name;
                    this.tour.department_id=val.dpt_department_id;
                    this.tour.designation_id = val.designation_id;
                    this.allTour(val.emp_id)
                }
            },
            tourType:function (val, oldVal) {
                if(val) {
                    this.tour.tour_type_id = val.value;
                } else {
                    this.tour.tour_type_id = '';
                }
            },
            selectedCountry: function (val, oldVal) {
                if(val){
                    this.tour.country_id = val.country_id
                } else {
                    this.tour.country_id = ""
                }
            }

        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Operations"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Tour"});
            this.fetchData();
            this.getFormData();
        },
        created() {
            if(this.tour.travel_date && this.tour.return_date)
            {
                let duration = moment.duration(moment(this.tour.travel_date).diff(this.tour.return_date));
                let years = duration.years();
                let months = duration.months();
                let days = duration.days()+1;

                let textDuration = '';
                if(years > 0) {
                    textDuration = `${years} years `;
                }

                if(months > 0) {
                    textDuration += `${months} months `;
                }

                if(days > 0) {
                    textDuration += `${days} days`;
                }

                this.tour.tour_duration = textDuration;
            }
        },
        methods: {
            onSubmit() {
                let data = this.tour;
                data.travel_date = moment(data.travel_date).format('YYYY-MM-DD');
                data.return_date = moment(data.return_date).format('YYYY-MM-DD');
                if (data.tour_id != null) {
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/operation/tours/${data.tour_id}`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.fetchData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/tours`, data).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.fetchData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }
            },
            deleteRow(tour_id, index) {
                let currObj = this;
                if (confirm("Do you really want to delete?")) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/operation/tours/${tour_id}`).then(res => {
                        if (res.data.o_status_code == 1) {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            currObj.tableData.items.splice(index, 1);
                            this.fetchData();
                            this.tableData.items = currObj.tableData.items;
                            this.totalList = currObj.tableData.items.length;
                        } else {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                    })
                }
            },
            editRow(item) {
                this.tour = item;
                this.selectedCountry={
                    country: item.country,
                    country_id: item.country_id
                }
                this.tourType = {
                    text : item.tour_type,
                    value : item.tour_type_id
                }
                this.setEmployee(item);
                this.submitBtn = 'Update';
                this.disabled = true;
            },
            setEmployee: function (item) {
                this.selectedEmployee = {
                    emp_id: item.emp_id,
                    option_name: item.emp_code + ' ' + item.emp_name,
                    designation: item.designation,
                    department_name: item.department_name,
                    basic_amt: item.basic_from,
                    emp_code: item.emp_code,
                    emp_name: item.emp_name,
                    department_id: item.department_id,
                    dpt_department_id:item.dpt_department_id,
                    designation_id: item.designation_id,
                }
            },
            renderModal(item) {
                this.setEmployee(item)
                this.tour.tour_id = item.tour_id;
                this.tour.approve_note = item.approve_note;
            },
            processed() {
                if (this.tour.tour_id != null) {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/tours/process`, this.tour).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.fetchData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }
            },
            getTourDuration(start_date, end_date) {
                let duration = moment.duration(moment(end_date).diff(start_date));
                let years = duration.years();
                let months = duration.months();
                let days = duration.days()+1;

                let textDuration = '';
                if(years > 0) {
                    textDuration = `${years} years `;
                }

                if(months > 0) {
                    textDuration += `${months} months `;
                }

                if(days > 0) {
                    textDuration += `${days} days`;
                }

                return textDuration;
            },
            onReset() {
                this.selectedEmployee = {emp_id:null};
                this.tour={};
                this.selectedCountry = {
                    country: '',
                    country_id: ''
                }
                this.tourType = {
                    text: '',
                    tour_type_id: ''
                }
                this.submitBtn = 'Save';
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`;
                this.infoModal.content = JSON.stringify(item, null, 2);
                this.$root.$emit("bv::show::modal", this.infoModal.id, button);
            },
            resetInfoModal() {
                this.infoModal.title = "";
                this.infoModal.content = "";
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                        console.log(res.data);
                    })
                }
            },
            fetchData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/tours`).then(result => {
                    this.tableData.items = result.data;
                }).catch(err => {
                    console.log('error');
                });
            },
            allTour(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/tours/specific/${id}`).then(result => {
                    this.tourTypeList = result.data.tourtypes;
                });
            },
            getFormData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/tours/form-data').then(res => {
                    this.countries = res.data.countries;
                    this.departmentOptions = res.data.departments;

                });
            },
            encodeFile(e) {
                let file_limit = 2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.tour.attachment = reader.result;
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
            searchByDepartment() {
                let department_id = this.searchParam.department_id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/tours?department_id=${department_id}`).then(result => {
                    this.tableData.items = result.data;
                    console.log(result.data)
                }).catch(err => {
                    console.log('error');
                });
            },
            clear(){
                this.searchParam=null,
                    this.fetchData();
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            showAttachmnet(data) {
                const win = window.open("","_blank");
                let html = '';
                html += '<html>';
                html += '<body style="margin:0!important">';
                html += '<embed width="100%" height="100%" src="'+data+'"/>';
                html += '</body>';
                html += '</html>';
                setTimeout(() => {
                    win.document.write(html);
                }, 0);
            }

        }
    };
</script>

<style>
    .message label:after{
        content:" (File should not exceed 2MB)";
        color:red
    }
</style>
