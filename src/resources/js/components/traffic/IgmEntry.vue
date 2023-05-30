<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card mb-5"  title="IGM Entry">
                <b-form  class="mb-5" @submit="onSubmit" @reset="onReset">
                    <b-row >
                        <b-col md="4">
                            <b-form-group
                                label="Import Reg No"
                                label-for="import"
                            >
                                <b-form-input
                                    v-model="filter"
                                    type="search"
                                    label-align-sm="right"
                                    id="filterInput"
                                    placeholder="Reg No"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Run Date"
                                label-for="date"
                            >
                                <date-picker v-model="date"  type="datetime"  width ="100%"  lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                            </b-form-group>

                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Stevdor"
                                label-for="stevdor"
                            >
                                <b-form-input
                                    v-model="filter"
                                    type="search"
                                    label-align-sm="right"
                                    id="filterInput"
                                    placeholder="Reg No"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row >
                        <b-col md="4">
                            <b-form-group
                                label="Net Tonnage"
                                label-for="tonnage "
                            >
                                <b-form-input
                                    v-model="quantity"
                                    type="search"
                                    label-align-sm="right"
                                    id="filterInput"
                                    placeholder=" Net tonnage"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Arrive Date"
                                label-for="date"
                            >
                                <date-picker v-model="date1"  type="datetime"  width ="100%"  lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                            </b-form-group>

                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Vessel Name"
                                label-for="vesselName"
                            >
                                <b-form-input
                                    v-model="vesselName"
                                    type="search"
                                    label-align-sm="right"
                                    id="filterInput"
                                    placeholder="Vessel Name"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Master Name"
                                label-for="masterName"
                            >
                                <b-form-input
                                    v-model="masterName"
                                    type="search"
                                    label-align-sm="right"
                                    id="filterInput"
                                    placeholder="Master Name"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Port Shipment"
                                label-for="portShipment"
                            >
                                <b-form-input
                                    v-model="portShipment"
                                    type="search"
                                    label-align-sm="right"
                                    id="filterInput"
                                    placeholder="Port Shipment"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Carrier Name"
                                label-for="carrierName"
                            >
                                <b-form-input
                                    v-model="carrierName"
                                    type="search"
                                    label-align-sm="right"
                                    id="filterInput"
                                    placeholder="Carrier Name"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Com.Landing Date"
                                label-for="landingDate"
                            >
                                <date-picker v-model="landingDate"  type="datetime"  width ="100%"  lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                            </b-form-group>

                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Berth No."
                                label-for="berthNo."
                            >
                                <b-form-input
                                    v-model="berthNo"
                                    type="search"
                                    label-align-sm="right"
                                    id="filterInput"
                                    placeholder="Berth No"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-row>
                                <b-col>
                                    <b-form-group
                                        label="Vog Name"
                                        label-for="vogName"
                                    >
                                        <b-form-input
                                            v-model="vogName"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Vog Name"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                        label="Gear Info"
                                        label-for="gearInfo"
                                    >
                                        <b-form-input
                                            v-model="gearInfo"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="GearInfo"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                        label="Total Container"
                                        label-for="totalContainer"
                                    >
                                        <b-form-input
                                            v-model="totalContainer"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Total Container"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                        </b-col>

                    </b-row>
                    <hr>
                    <h5> MLO Detail</h5>
                    <hr>
                    <b-row>
                        <b-col md="4">

                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Import MLO Code"
                                        label-for="importMLOCode"
                                    >
                                        <b-form-input
                                            v-model="importMLOCode"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Code"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                        label="Import MLO Name"
                                        label-for="importMLOName."
                                    >
                                        <b-form-input
                                            v-model="importMLOName"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Import MLO Name"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="4">
                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Shipping Agent Code"
                                        label-for="shippingAgentCode"
                                    >
                                        <b-form-input
                                            v-model="shippingAgentCode"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Code"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                        <b-form-group
                                            label="Shipping Agent Name"
                                            label-for="shippingAgentName"
                                        >
                                            <b-form-input
                                                v-model="shippingAgentName"
                                                type="text"
                                                label-align-sm="right"
                                                id="filterInput"
                                                placeholder="Shipping Agent Name"
                                            ></b-form-input>
                                        </b-form-group>
                                </b-col>
                            </b-row>

                        </b-col>
                        <b-col md="4">
                            <b-row>
                                <b-col>
                                    <b-form-group
                                        label="Remarks"
                                        label-for="remarks"
                                    >
                                        <b-form-input
                                            v-model="remarks"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Remarks"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                        </b-col>
                        <b-col>
                            <b-row class="d-flex justify-content-end">
                                <b-button type="submit" id="ff" class="btn btn-dark shadow mr-1 mb-2">Add</b-button>
                            </b-row>
                        </b-col>
                    </b-row>
                    <hr>
                    <h5> Container Details</h5>
                    <hr>
                    <b-row>
                        <b-col md="4">
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                        label="Container No"
                                        label-for="containerNo"
                                    >
                                        <b-form-input
                                            v-model="importMLOCode"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Code"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Gross wt"
                                        label-for="grossWt"
                                    >
                                        <b-form-input
                                            v-model="importMLOCode"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Code"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Status"
                                        label-for="status"
                                    >
                                        <b-form-input
                                            v-model="importMLOName"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Import MLO Name"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Seal No"
                                        label-for="sealNo."
                                    >
                                        <b-form-input
                                            v-model="importMLOName"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Import MLO Name"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="4">
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                        label="Import Cargo"
                                        label-for="importCargo"
                                    >
                                        <b-form-input
                                            v-model="shippingAgentCode"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Code"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Cont.Type"
                                        label-for="ContType"
                                    >
                                        <b-form-input
                                            v-model="shippingAgentCode"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Code"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3" >
                                    <b-form-group
                                        label="Depot Name"
                                        label-for="depotName"
                                    >
                                        <b-form-input
                                            v-model="shippingAgentCode"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Code"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Vat"
                                        label-for="vat"
                                    >
                                        <b-form-input
                                            v-model="shippingAgentName"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Shipping Agent Name"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                        </b-col>
                        <b-col md="4">
                            <b-row>
                                <b-col>
                                    <b-form-group
                                        label="size"
                                        label-for="size"
                                    >
                                        <b-form-input
                                            v-model="remarks"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Remarks"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                        label="Hight"
                                        label-for="hight"
                                    >
                                        <b-form-input
                                            v-model="remarks"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Remarks"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                        label="Com Landing"
                                        label-for="comLanding"
                                    >
                                        <b-form-input
                                            v-model="remarks"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Remarks"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group
                                        label="Off-dock ID"
                                        label-for="remarks"
                                    >
                                        <b-form-input
                                            v-model="remarks"
                                            type="text"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Remarks"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                        </b-col>
                        <b-col>
                            <b-row class="d-flex justify-content-end">
                                <b-button type="submit" id="ff" class="btn btn-dark shadow mr-1 mb-2">Add</b-button>
                            </b-row>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row class="d-flex justify-content-end">
                        <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-2 mt-2">Save</b-button>
                        <b-button type="reset" class="btn btn-outline-dark mr-1 mb-2 mt-2">clear</b-button>
                        <b-button type="reset" class="btn btn-outline-dark mr-1 mb-2 mt-2">Exit</b-button>
                    </b-row>

                </b-form>

            </b-card>

            <b-card class="card">
                <b-row>
                    <b-col>
                        <b-card title="MLO Details">
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
                                    <a target="_self" href="#" class="text-primary"><i class="bx bx-show  cursor-pointer"></i></a>

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
            </b-card>


        </div>


    </div>
</template>
<script>
    import DatePicker from "vue2-datepicker";
    export default {
        components: {DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Traffic"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "IGM Entry"});

        },
        data() {
            return {
                interviwdate: new Date(),
                date: new Date(),
                date1:new Date(),
                landingDate:new Date(),

                form: {
                    refno: '',
                    jobTitle: '',

                },
                e_product: [
                    { value: null, text: 'select one' },
                    { value: 'a', text: 'abc' },
                    { value: 'b', text: 'abc' },
                    { value: { C: '3PO' }, text: 'abc' }

                ],
                e_quantity:[
                    { value: null, text: 'select one' },
                    { value: 'a', text: '1' },
                    { value: 'b', text: '2' },
                    { value: 'd', text: '3' }
                ],


                reasonList: [{text: 'Cost of prolonged illness', value: 1},
                    {text: 'Cost of overseas passage', value: 2},
                    {text: 'Cost of marriage or funeral', value: 3},
                    {text: 'Expenses of purchasing house/site or repairing house', value: 4},
                    {text: 'Educational expenses of purchasing of children or dependents or any other important purpose', value: 4}],
                appInstlmntList: [{text: '12', value: 1}, {text: '24', value: 2}, {text: '48', value: 3}],
                show: true,
                resultstatuslist: [{text: 'Pass', value: 1}, {text: 'Fail', value: 2}, {text: 'Expelled', value: 3}],
                boardactionlist: [{text: 'Interview', value: 1}, {text: 'Reject', value: 2}],

                fields: [{key: 'ImportMLOCode', label: 'Import MLO Code', sortable: true, sortDirection: 'desc'},
                    {key: 'ImportMLOName', label: 'Import MLO Name ', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'ShippingAgentCode', label: 'Shipping Agent Code', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'ShippingAgentName', label: 'Shipping Agent Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'Remarks', label: 'Remarks', sortable: true, sortDirection: 'desc', class: 'text-center'},

                    'action'],
                items: [
                    {ImportMLOCode: '1', ImportMLOName: 'Abc', ShippingAgentCode: 'abc', ShippingAgentName: 'abc', Remarks: 'abc',
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
                vesselName:null,
                masterName:null,
                portShipment:null,
                carrierName:null,
                berthNo:null,
                vogName:null,
                gearInfo:null,
                totalContainer:null,
                importMLOCode:null,
                importMLOName:null,
                shippingAgentCode:null,
                shippingAgentName:null,
                remarks:null,
                filterOn: [],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                },
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if (this.updateIndex > -1) { //update
                    this.tableData.items[this.updateIndex].employee_id = this.form.employee_id;
                    this.tableData.items[this.updateIndex].department_name = this.form.department_name;
                    this.tableData.items[this.updateIndex].designation = this.form.designation;
                    this.tableData.items[this.updateIndex].division_name = this.form.division_name;
                    this.tableData.items[this.updateIndex].financial_code = this.form.financial_code;
                    this.tableData.items[this.updateIndex].shift = this.form.shift;
                } else { //new data add
                    this.tableData.items.push({
                        employee_id: this.form.employee_id,
                        department_name: this.form.department_name,
                        designation: this.form.designation,
                        division_name: this.form.division_name,
                        financial_code: this.form.financial_code,
                        shift: this.form.shift,
                    });
                }
                this.onReset(evt);
            },
            onReset(evt) {
                evt.preventDefault();
                this.employee_id = '';
                this.department_name = '';
                this.designation = '';
                this.division_name = null;
                this.financial_code = null;
                this.shift = null;
                this.updateIndex = -1;
                this.submitBtn = 'Process';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(i, code) {
                this.submitBtn = 'Update';
                this.updateIndex = i;
                let data = this.tableData.items[i];
                console.log(data);
                this.form.employee_id = data.employee_id;
                this.form.department_name = data.department_name;
                this.form.designation = data.designation;
                this.form.division_name = data.division_name;
                this.form.financial_code = data.financial_code;
                this.form.shift = data.shift;
                console.log(this.form);
            },
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            }

        }
    }
</script>

