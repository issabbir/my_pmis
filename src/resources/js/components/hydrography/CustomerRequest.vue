<template>
    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card title="Customer Request">
                        <div class="container col-md-9">
                            <form-wizard title subtitle color="#394C62">
                                <!-- tab 1 content -->
                                <tab-content title="Request Form" class="mb-3">
                                    <label>Basic Details</label>
                                    <hr>
                                    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                        <b-row>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="FIRST NAME"
                                                    label-for="firstName"
                                                >
                                                    <b-form-input
                                                        id="firstName"
                                                        v-model="customerRequest.fname"
                                                        type="text"
                                                        required
                                                        placeholder=" Enter First Name"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="LAST NAME"
                                                    label-for="lastName"
                                                >
                                                    <b-form-input
                                                        id="lastName"
                                                        v-model="customerRequest.lname"
                                                        type="text"
                                                        required
                                                        placeholder="Enter Last Name "
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="COMPANY NAME"
                                                    label-for="companyName"
                                                >
                                                    <b-form-input
                                                        id="companyName"
                                                        v-model="customerRequest.companyName"
                                                        type="text"
                                                        required
                                                        placeholder="Enter Company Name "
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="DESIGNATION"
                                                    label-for="designation"
                                                >
                                                    <b-form-input
                                                        id="firstName"
                                                        v-model="customerRequest.designation"
                                                        type="text"
                                                        required
                                                        placeholder=" Enter Designation"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col md="4">
                                                <b-form-group
                                                    label="EMAIL"
                                                    label-for="email"
                                                >
                                                    <b-form-input
                                                        id="email"
                                                        v-model="customerRequest.email"
                                                        type="text"
                                                        required
                                                        placeholder=" Enter Email"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="4">
                                                <b-form-group
                                                    label="PASSWORD"
                                                    label-for="password"
                                                >
                                                    <b-form-input
                                                        id="firstName"
                                                        v-model="customerRequest.password"
                                                        type="text"
                                                        required
                                                        placeholder=" Enter Password"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="4">
                                                <b-form-group
                                                    label="CONFIRM PASSWORD"
                                                    label-for="confirmPassword"
                                                >
                                                    <b-form-input
                                                        id="confirmPassword"
                                                        v-model="customerRequest.confirmPassword"
                                                        type="text"
                                                        required
                                                        placeholder=" Enter Confirm Password"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <label>Contact Details</label>
                                        <hr>
                                         <b-row>
                                             <b-col md="4">
                                                 <b-form-group
                                                     label="ADDRESS LINE 1"
                                                     label-for="addressLine1"
                                                 >
                                                     <b-form-input
                                                         id="addressLine1"
                                                         v-model="customerRequest.addressLine1"
                                                         type="text"
                                                         required
                                                         placeholder=" Enter House No/Flat no ..."
                                                     ></b-form-input>
                                                 </b-form-group>
                                             </b-col>
                                             <b-col md="4">
                                                 <b-form-group
                                                     label="ADDRESS LINE 2"
                                                     label-for="addressLine2"
                                                 >
                                                     <b-form-input
                                                         id="addressLine1"
                                                         v-model="customerRequest.addressLine2"
                                                         type="text"
                                                         required
                                                         placeholder=" Enter Society/Area name."
                                                     ></b-form-input>
                                                 </b-form-group>
                                             </b-col>
                                             <b-col md="4">
                                                 <b-form-group
                                                     label="City"
                                                     label-for="city"
                                                 >
                                                     <b-form-input
                                                         id="city"
                                                         v-model="customerRequest.city"
                                                         type="text"
                                                         required
                                                         placeholder=" Enter City name"
                                                     ></b-form-input>
                                                 </b-form-group>
                                             </b-col>

                                         </b-row>
                                        <b-row>
                                            <b-col md="4">
                                                <b-form-group
                                                    label="STATE"
                                                    label-for="state"
                                                >
                                                    <b-form-input
                                                        id="state"
                                                        v-model="customerRequest.state"
                                                        type="text"
                                                        required
                                                        placeholder=" Enter  State Name"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="4">
                                                <b-form-group
                                                    label="Age"
                                                    label-for="age"
                                                >
                                                    <b-form-input
                                                        id="age"
                                                        v-model="customerRequest.age"
                                                        type="text"
                                                        required
                                                        placeholder=" Enter Age"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="4">
                                                <b-form-group
                                                    label="Phone No"
                                                    label-for="phoneNo"
                                                >
                                                    <b-form-input
                                                        id="state"
                                                        v-model="customerRequest.phoneNo"
                                                        type="text"
                                                        required
                                                        placeholder=" Enter Phone No"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>

                                        </b-row>
                                        <b-row>
                                            <b-col md="4">
                                                <b-form-group
                                                    label="Gender"
                                                    label-for="gender"
                                                >
                                                    <b-form-radio-group
                                                        id="radio-group-1"
                                                        v-model="gender"
                                                        :options="e_gender"
                                                        name="radio-options"
                                                    ></b-form-radio-group>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <label> Products Details</label>
                                        <hr>

                                        <b-row>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="SELECT PRODUCT"
                                                    label-for="product "
                                                >
                                                    <b-form-select v-model="customerRequest.product" :options="e_product"></b-form-select>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="PRODUCT QTY"
                                                    label-for="productQty"
                                                >
                                                    <b-form-input
                                                        id="state"
                                                        v-model="customerRequest.productQty"
                                                        type="text"
                                                        required
                                                        placeholder=" product Qty"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="FORMAT"
                                                    label-for="format "
                                                >
                                                    <b-form-select v-model="customerRequest.format" :options="e_format"></b-form-select>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="EXPECTED DELIVERY DATE"
                                                    label-for="date"
                                                >
                                                    <date-picker v-model="date"  type="datetime"  width ="100%" lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <label> Customer Note</label>
                                        <hr>

                                        <b-row>
                                            <b-col>
                                                <b-form-group
                                                    label="Note"
                                                    label-for="product"
                                                >
                                                    <b-form-textarea
                                                        id="note"
                                                        size="lg"
                                                        placeholder="Note"
                                                    ></b-form-textarea>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                    </b-form>
                                </tab-content>

                                <tab-content title="Approval" class="mb-5">
                                    <b-form>
                                        <b-row>
                                            <b-col>
                                                <b-card title=" Wait For Approval">
                                                    <b-row>
                                                        <b-col sm="2" md="2" class="my-1">
                                                            <b-form-group
                                                                label="Per page"
                                                                label-cols-sm="6"
                                                                label-cols-md="6"
                                                                label-cols-lg="6"
                                                                label-align-sm="left"
                                                                label-size="sm"
                                                                label-for="perPageSelect"
                                                                class="mb-0">
                                                                <b-form-select
                                                                    v-model="perPage"
                                                                    id="perPageSelect"
                                                                    size="sm"
                                                                    :options="pageOptions"></b-form-select>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col sm="3" md="3" class="my-1 ml-auto">
                                                            <b-input-group size="sm">
                                                                <b-form-input
                                                                    v-model="filter"
                                                                    type="search"
                                                                    label-align-sm="right"
                                                                    id="filterInput"
                                                                    placeholder="Type to Search"
                                                                ></b-form-input>
                                                                <b-input-group-append>
                                                                    <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                                                                </b-input-group-append>
                                                            </b-input-group>
                                                        </b-col>
                                                    </b-row>
                                                    <b-table striped hover show-empty
                                                             small
                                                             stacked="md"
                                                             :items="items"
                                                             :fields="fields"
                                                             :current-page="currentPage"
                                                             :per-page="perPage"
                                                             :filter="filter"
                                                             :filterIncludedFields="filterOn"
                                                             :sort-by.sync="sortBy"
                                                             :sort-desc.sync="sortDesc"
                                                             :sort-direction="sortDirection"
                                                             @filtered="onFiltered">

                                                        <template v-slot:cell(action)="row">
                                                            <a size="sm"  class="text-primary" data-toggle="modal" href="#" data-target="#border-less"><i class="bx bx-edit cursor-pointer"></i> </a>
                                                            <a target="_self" href="#" class="text-primary"><i class="bx bx-trash  cursor-pointer"></i></a>

                                                        </template>

                                                    </b-table>
                                                    <b-col sm="12" md="12" class="my-1">
                                                        <b-pagination
                                                            v-model="currentPage"
                                                            :total-rows="totalRows"
                                                            :per-page="perPage"
                                                            align="right"
                                                            size="sm"
                                                            class="my-0"></b-pagination>
                                                    </b-col>
                                                </b-card>
                                            </b-col>

                                        </b-row>
                                    </b-form>
                                </tab-content>
                                <tab-content title="Payment" class="mb-5">

                                    <template>
                                        <b-row class="mb-2">
                                            <b-col md="1">
                                                <b-img v-bind="mainProps" src="https://picsum.photos/250/250/?image=54" height="80"  width="80" rounded="circle" alt="Circle image"></b-img>
                                            </b-col>
                                            <b-col class="mt-1">
                                                <h6> Product Name</h6>
                                                <!--span>
                                                    Awesome App for Project Management
                                                </span-->
                                            </b-col>

                                        </b-row>

                                        <div>
                                            <b-table
                                                id="table-transition-example"
                                                :items="items1"
                                                :fields="fields1"
                                                striped
                                                small
                                                primary-key="a"
                                                :tbody-transition-props="transProps"

                                            ></b-table>

                                        </div>
                                        <hr>
                                        <b-row class="d-flex justify-content-end">
                                            <b-button type="submit" id="basic_sub_btn" variant="outline-primary">Payment</b-button>
                                        </b-row>
                                        <hr>
                                    </template>

                                </tab-content>
                                <tab-content title="Delivery" class="mb-5">
                                    <b-card  class="text-center"  border-variant="black" >
                                        <b-row >
                                            <b-col md="5" offset-md="3">
                                                <h5>Chart Survey</h5>
                                                <label> File Size 1.5MB</label>
                                                <b-button block  variant="outline-success">File Download</b-button>
                                            </b-col>
                                        </b-row>
                                    </b-card>
                                </tab-content>
                            </form-wizard>
                        </div>
                    </b-card>
                </b-col>
            </b-row>

        </div>

    </div>

</template>

<script>
    import DatePicker from 'vue2-datepicker';
    import { FormWizard, TabContent } from "vue-form-wizard";
    import "vue-form-wizard/dist/vue-form-wizard.min.css";
    import Multiselect from 'vue-multiselect';

    // register globally
    //   Vue.component('multiselect', Multiselect)

    export default {
        components: {
            FormWizard,
            DatePicker,
            TabContent,
            Multiselect
        },
        data() {
            return {
                date: new Date(),
                customerRequest:{
                    fname:'',
                    lname:'',
                    companyName:'',
                    designation:'',
                    email:'',
                    password:'',
                    confirmPassword:'',
                    addressLine1:'',
                    addressLine2:'',
                    city:'',
                    state:'',
                    age:'',
                    phoneNo:'',
                    gender:'',
                    product:null,
                    productQty:'',
                    format:null,

                },
                jobCircular: {
                    id: '',
                    advertismntNo: '',
                    departmntName: '',
                    title: null,
                    concerndPerson: null,
                    garde: null,
                    payScale: null,
                    pubdate: '',
                    status: '',
                    appDeadline: '',
                    maxAge: '',
                    type: null,
                    type1: '',
                    totalPost: '',
                    quota: '',
                    general: '',
                    freedomFighter: '',
                    dependent: '',
                    female: '',
                    bank_draft: '',
                    bankDetails: '',
                    isReqAttachmnt: '',
                    minEdulbl: null,
                    subject: null,
                    expreinced: '',
                    minLength: '',
                    areOfExp: null,
                    additionalReq: '',
                },
                selected: null,
                oadvertismntNo: [
                    {value: null, text: '07/2009'}
                ],

                e_gender: [
                    { value: '1', text: 'Male' },
                    { value: '2', text: 'Female' },
                    { value: '3', text: 'Other' },
                ],
                e_product:[
                    { value: null, text: 'Select One' },
                    { value: '1', text: 'Chart' },
                    { value: '2', text: 'Map' },

                ],
                e_format:[
                    { value: null, text: 'Select One' },
                    { value: '1', text: 'Row File' },
                    { value: '2', text: 'CSV' },
                    { value: '2', text: 'PDF' },

                ],

                fields: [{key: 'Products', label: 'Products', sortable: true, sortDirection: 'desc'},
                    {key: 'Qty', label: 'Qty', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'Formate', label: 'Formate', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'ExpectedDate', label: 'Expected Date', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'status', label: 'status', sortable: true, sortDirection: 'desc', class: 'text-center'},

                    'action'],
                items: [
                    {Products: 'Chart', Qty: '1', Formate: 'CSV File', ExpectedDate: '10/01/2019', status: 'Pending',
                         action: ''},
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                },

                transProps: {
                    // Transition name
                    name: 'flip-list'
                },

                fields1: [
                    { key: 'OrderNumber', sortable: true },
                    { key: 'OrderDate', sortable: true },
                    { key: 'Qty', sortable: true },
                    { key: 'Price', sortable: true }
                ],
                items1: [
                    { OrderNumber: '005451', OrderDate: '10/05/2019', Qty: '4' ,Price:'$1260'},
                    //{ OrderNumber: '005452', OrderDate: '15/05/2019', Qty: '4' ,Price:'$1250'},
                   /// { OrderNumber: '005453', OrderDate: '20/05/2019', Qty: '4' ,Price:'$1240'},
                ],
                selected: null,
                sdepartmntName: [
                    {value: null, text: 'Select'}, {value: 1, text: 'Computer Center'}, {value: 2, text: 'Administration'}
                ],
                stitle: [
                    {value: null, text: 'Select'}, {value: 1, text: 'Assistant System Analyst'}, {value: 2, text: 'Senior Computer Operator'}
                ],
                subjectList: [
                    {value: null, text: 'Select'}, {value: 1, text: 'Assistant System Analyst'}, {value: 2, text: 'Senior Computer Operator'}
                ],
                areOfExpList: [
                    {value: null, text: 'Select'}, {value: 1, text: 'Dhaka'}, {value: 2, text: 'Barisal'}
                ],
                selected: null,
                sconcerndPerson: [
                    {value: null, text: 'Select'}, {value: 1, text: 'Waker Khan'}
                ],
                spaygrade: [
                    {value: null, text: 'Select'}, {value: 1, text: '01'}, {value: 2, text: '02'}
                ],
                minEdulblListData: [
                    { name: 'Javascript', code: 'js' }
                ],
                minEdulblList: [
                    { name: 'Vue.js', code: 'vu' },
                    { name: 'Javascript', code: 'js' },
                    { name: 'Open Source', code: 'os' }
                ],
                sgarde: [
                    {value: null, text: 'Select'}
                ],
                minEdulbldata: [
                    'Bsc(Engr)','Bsc(Hons)'
                ],
                show: true
            }
        },
        methods: {
            formSubmitted() {
                alert("Form submitted!");
            },
            onSubmit(evt) {
                evt.preventDefault()
                alert(JSON.stringify(this.form))
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.email = ''
                this.form.name = ''
                this.form.food = null
                this.form.checked = []
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            },
            addTag (newTag) {
                const tag = {
                    name: newTag,
                    code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.minEdulblList.push(tag)
                this.minEdulblListData.push(tag)
            }
        },

    }

</script>
