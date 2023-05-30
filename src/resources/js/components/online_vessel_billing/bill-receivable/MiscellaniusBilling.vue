<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Miscellaneous Bill (Lighter Vessels & Others)</h4>
                        </div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text"
                                                  :style="{'display':'none'}"></b-form-input>

                                    <fieldset class="border p-2">
                                        <b-row>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Bill Type"
                                                    label-for="billType"
                                                    >
                                                    <b-form-select v-model="selected" class="">
                                                        <option>Please select a Bill Type</option>
                                                        <option value="1">Lighter Bill</option>
                                                        <option value="2">Nevy Bill</option>
                                                        <option value="3">Other Bill</option>
                                                    </b-form-select>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Bill No"
                                                    label-for="billNo"
                                                    >
                                                    <b-form-input
                                                        id="billNo"
                                                        v-model="form.billNo"
                                                        type="text"
                                                        required
                                                        placeholder="bill No"
                                                        ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-form-group
                                                    label="Bill Date"
                                                    label-for="billDate"
                                                    >
                                                    <date-picker v-model="form.datetime" width="100%"
                                                                 input-class="form-control" type="date" lang="en"
                                                                 format="YYYY-MM-DD">Date
                                                    </date-picker>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="3">
                                                <b-col class="mt-2 d-flex justify-content-start">
                                                    <b-button lg="6" size="md" variant="dark" type="submit">Search</b-button>
                                                </b-col>
                                            </b-col>
                                        </b-row>
                                    </fieldset>
                                    <b-row class="pt-2">
                                        <b-col md="6">
                                            <b-row>
                                                <b-col md="6">
                                                    <b-form-group
                                                        label="Vessel Name"
                                                        label-for="vesselName"
                                                        >
                                                        <b-form-input
                                                            id="vesselName"
                                                            v-model="form.vessel_name"
                                                            type="text"
                                                            required
                                                            placeholder="Vessel Name"
                                                            ></b-form-input>
                                                    </b-form-group>
                                                </b-col>

                                                <b-col md="6">
                                                    <b-form-group
                                                        label="Registration/ROT No"
                                                        label-for="rotNo"
                                                        >
                                                        <b-form-input
                                                            id="rotNo"
                                                            v-model="form.rot_no"
                                                            type="text"
                                                            required
                                                            placeholder="Registration/ROT No"
                                                            ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                <b-col md="6">
                                                    <b-form-group
                                                        label="Vessel Flag"
                                                        label-for="vesselFlag">
                                                        <b-form-input
                                                            id="vesselFlag"
                                                            v-model="form.vessel_flag"
                                                            type="text"
                                                            required
                                                            placeholder="Vessel Flag"
                                                            ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="6">
                                                    <b-form-group
                                                        label="Deck Cargo"
                                                        label-for="deckCargo">
                                                        <b-form-input
                                                            id="deckCargo"
                                                            v-model="form.deck_cargo"
                                                            type="text"
                                                            required
                                                            placeholder="Deck Cargo"
                                                            ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col md="6">
                                                    <b-form-group
                                                        label="Master Name"
                                                        label-for="masterName"
                                                        >
                                                        <b-form-input
                                                            id="masterName"
                                                            v-model="form.master_name"
                                                            type="text"
                                                            required
                                                            placeholder="master Name"
                                                            ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="6">
                                                    <b-form-group
                                                        label="Outer Date"
                                                        label-for="outerDate"
                                                        >
                                                        <date-picker v-model="form.datetime" width="100%"
                                                                     input-class="form-control" type="date" lang="en"
                                                                     format="YYYY-MM-DD">Date
                                                        </date-picker>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <fieldset class="border p-1">
                                                <b-row>
                                                    <b-col md="6">
                                                        <b-form-group
                                                            label="Bearthing Date"
                                                            label-for="bearthingDate"
                                                            >
                                                            <date-picker v-model="form.datetime" width="100%"
                                                                         input-class="form-control" type="date" lang="en"
                                                                         format="YYYY-MM-DD">Date
                                                            </date-picker>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                                <b-row>
                                                    <b-col md="6">
                                                        <b-form-group
                                                            label="Time From"
                                                            label-for="timeFrom"
                                                            >
                                                            <date-picker v-model="form.datetime" width="100%"
                                                                         input-class="form-control" type="date" lang="en"
                                                                         format="hh:mm:ss">Date
                                                            </date-picker>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                        <b-form-group
                                                            label="Time To"
                                                            label-for="timeTo"
                                                            >
                                                            <date-picker v-model="form.datetime" width="100%"
                                                                         input-class="form-control" type="date" lang="en"
                                                                         format="hh:mm:ss">Date
                                                            </date-picker>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                            </fieldset>
                                        </b-col>
                                        <b-col md="6">
                                            <b-row>
                                                <b-col md="6">
                                                    <b-form-group
                                                        label="Agent Code"
                                                        label-for="agentCode"
                                                        >
                                                        <b-form-input
                                                            id="agentCode"
                                                            v-model="form.agent_code"
                                                            type="text"
                                                            required
                                                            placeholder="Agent Code"
                                                            ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="6">
                                                    <b-form-group
                                                        label="Jetty Name"
                                                        label-for="jettyName"
                                                        >
                                                        <b-form-input
                                                            id="jettyName"
                                                            v-model="form.jetty_name"
                                                            type="text"
                                                            required
                                                            placeholder="Jetty Name"
                                                            ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col md="6">
                                                    <b-form-group
                                                        label="Slip No"
                                                        label-for="slipNo">
                                                        <b-form-input
                                                            id="slipNo"
                                                            v-model="form.slip_no"
                                                            type="text"
                                                            required
                                                            placeholder="Slip No"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="6">
                                                    <b-form-group
                                                        label="Conversion Rate"
                                                        label-for="conversionRate">
                                                        <b-form-input
                                                            id="conversionRate"
                                                            v-model="form.conversion_rate"
                                                            type="text"
                                                            required
                                                            placeholder="Conversion Rate"
                                                            ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row>

                                                <b-col md="6">
                                                    <b-form-group
                                                        label="GRT"
                                                        label-for="grt"
                                                        >
                                                        <b-form-input
                                                            id="lastPort"
                                                            v-model="form.grt"
                                                            type="text"
                                                            required
                                                            placeholder="GRT"
                                                            ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="6">
                                                    <b-form-group
                                                        label="Remarks"
                                                        label-for="remarks"
                                                        >
                                                        <b-form-input
                                                            id="remarks"
                                                            v-model="form.remarks"
                                                            type="text"
                                                            required
                                                            placeholder="Remarks"
                                                            ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <fieldset class="border p-1">
                                                <b-row>
                                                    <b-col md="6">
                                                        <b-form-group
                                                            label="Leaving Date"
                                                            label-for="leavinggDate"
                                                            >
                                                            <date-picker v-model="form.datetime" width="100%"
                                                                         input-class="form-control" type="date" lang="en"
                                                                         format="YYYY-MM-DD">Date
                                                            </date-picker>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                                <b-row>
                                                    <b-col md="6">
                                                        <b-form-group
                                                            label="Time From"
                                                            label-for="timeFrom"
                                                            >
                                                            <date-picker v-model="form.datetime" width="100%"
                                                                         input-class="form-control" type="date" lang="en"
                                                                         format="hh:mm:ss">Date
                                                            </date-picker>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                        <b-form-group
                                                            label="Time To"
                                                            label-for="timeTo"
                                                            >
                                                            <date-picker v-model="form.datetime" width="100%"
                                                                         input-class="form-control" type="date" lang="en"
                                                                         format="hh:mm:ss">Date
                                                            </date-picker>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                            </fieldset>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col class="mt-2 d-flex justify-content-end">
                                            <b-button lg="6" size="md" variant="dark" type="submit">{{submitBtn}}
                                            </b-button>&nbsp;
                                        </b-col>
                                    </b-row>
                                    <!--</fieldset>-->
                                </b-form>
                            </div>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <!-- Zero configuration table -->
            <b-card class="card">
                <!--<div class="card-header">
                    <h4 class="card-title">Payble Invoice Entry Form</h4>
                </div>-->
                <b-card-text class="card-content">
                    <b-card-body>
                        <b-table
                            striped
                            hover
                            show-empty
                            small
                            :items="vesselItems"
                            :current-page="currentPage"
                            :per-page="perPage"
                            :filter="filter"
                            :sort-by.sync="sortBy"
                            :sort-desc.sync="sortDesc"
                            :sort-direction="sortDirection"
                            :fields="vesselFields"
                            responsive>
                            <template v-slot:cell(itemCode)="row">
                                  <b-form-select v-model="itemCode" :options="itemCodeList"></b-form-select>
                            </template>
                            <template v-slot:cell(naturalAccount)="row">
                                      <b-form-select v-model="naturalAccount" :options="naturalAccountList"></b-form-select>
                            </template>
                            <!--template v-slot:cell(uom)="row">
                                      <b-form-input v-model="uom"></b-form-input>
                            </template>
                            <template v-slot:cell(rate)="row">
                                      <b-form-input v-model="rate"></b-form-input>
                            </template-->
                            <template v-slot:cell(qty)="row">
                                      <b-form-input v-model="qty"></b-form-input>
                            </template>
                            <!--template v-slot:cell(move)="row">
                                      <b-form-input v-model="move"></b-form-input>
                            </template>
                            <!--template v-slot:cell(amount)="row">
                                      <b-form-input v-model="amount"></b-form-input>
                            </template>
                            <template v-slot:cell(vat)="row">
                                      <b-form-input v-model="vat"></b-form-input>
                            </template-->
                        </b-table>
                    </b-card-body>
                </b-card-text>
            </b-card>
            <!--/ Zero configuration table -->
        </div>


    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker'
            export default {
                components: {DatePicker},
                mounted() {
                    this.$store.commit("setBreadcrumbEmpty");
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Bill Receivable"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Vessel Billing"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Miscellanius Billing"});
                },
                data() {
                    return {
                        form: {
                            datetime: new Date(),
                        },
                        show: true,
                        updateIndex: -1,
                        submitBtn: 'Save',
                        vesselFields: [
                            {key: 'itemCode', label: 'Item Code', sortable: true, sortDirection: 'desc'},
                            {key: 'naturalAccount', label: 'Natural Account', sortable: true, sortDirection: 'desc',
                                class: 'text-center'},
                            {key: 'uom', label: 'UOM', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'rate', label: 'Rate', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'qty', label: 'QTY', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'move', label: 'Move', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'amount', label: 'Amount', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'vat', label: 'VAT', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'total', label: 'Total', sortable: true, sortDirection: 'desc', class: 'text-center'}
                        ],
                        vesselItems: [
                            {uom: '', rate: '', qty: '10000.00', move: '', amount: '', vat: '',total:' '},
                            {uom: '', rate: '', qty: '10000.00', move: '', amount: '', vat: '',total:' '},
                        ],

                        itemCodeList: [
                            {value: 1, text: '1010'},
                            {value: 2, text: '1020'}
                        ],
                        naturalAccountList: [
                            {value: 1, text: '1010'},
                            {value: 2, text: '1020'}
                        ],

                        division_options: [
                            {value: null, text: 'Please select'},
                            {value: 'Member(Engineering)', text: 'Member (Engineering)'},
                            {value: 'Chairman', text: 'Chairman'},
                            {value: 'Member(Harbour & Marine)', text: 'Member(Harbour & Marine)'},
                            {value: 'Member(Finance)', text: 'Member(Finance)'},
                            {value: 'Member(Engineering)', text: 'Member(Engineering)'},
                        ],
                        financial_code_options: [
                            {value: null, text: 'Please select'},
                            {value: 97040, text: '97040'},
                            {value: 97041, text: '97041'},
                            {value: 97042, text: '97042'},
                            {value: 97043, text: '97043'},
                            {value: 97044, text: '97044'},
                            {value: 97045, text: '97045'},
                            {value: 97046, text: '97046'},
                            {value: 90720, text: '90720'},
                            {value: 90631, text: '90631'},
                            {value: 90730, text: '90730'},
                            {value: 90810, text: '90810'},
                            {value: 90490, text: '90490'},
                        ],
                        shift_options: [
                            {value: null, text: 'Please select'},
                            {value: '1', text: '1'},
                            {value: '2', text: '2'},
                            {value: '3', text: '3'},
                            {value: '4', text: '4'},
                            {value: '5', text: '5'},
                            {value: '6', text: '6'},
                            {value: '7', text: '7'},
                        ]

                    }
                },
            }
</script>

