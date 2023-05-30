<template>
    <div class="content-wrapper">
        <div class="content-body">

            <b-card  title="Bill Approval Process">
                <b-card-text class="card-content">
                    <div class="card body mb-2">
                        <b-form @reset="onReset" @submit="onSubmit" v-if="show">
                            <b-row>
                                <b-col  md="6">
                                    <b-row>
                                        <b-col md="2">
                                            <label>Form Date</label>
                                        </b-col>
                                        <b-col md="10" class="form-group">
                                            <date-picker
                                                format="YYYY-MM-DD"
                                                input-class="form-control"
                                                lang="en"
                                                type="date"
                                                v-model="arrivalDate"
                                                width="100%">
                                            </date-picker>
                                        </b-col>
                                    </b-row>
                                </b-col>

                                <b-col  md="6">
                                    <b-row>
                                        <b-col md="2">
                                            <label>Bill No</label>
                                        </b-col>
                                        <b-col md="10" class="form-group">
                                            <b-form-input
                                                placeholder="Bill No" v-model="form.BillNo">
                                            </b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col  md="6">
                                    <b-row>
                                        <b-col md="2">
                                            <label>To  Date</label>
                                        </b-col>
                                        <b-col md="10" class="form-group">
                                            <date-picker
                                                format="YYYY-MM-DD"
                                                input-class="form-control"
                                                lang="en"
                                                type="date"
                                                v-model="arrivalDate"
                                                width="100%">
                                            </date-picker>
                                        </b-col>
                                    </b-row>
                                </b-col>

                                <b-col  md="6">
                                    <b-row>
                                        <b-col lg="2">
                                            <label>Rotation</label>
                                        </b-col>
                                        <b-col md="10" class="form-group">
                                            <b-form-input
                                                placeholder="Rotation" v-model="form.Rotation">
                                            </b-form-input>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col class="d-flex justify-content-end">
                                    <b-button md="6" size="md" type="submit" variant="dark">{{searchBtn}}Search</b-button>&nbsp;
                                </b-col>
                            </b-row>
                        </b-form>

                    </div>
                </b-card-text>
            </b-card>
            <!--Table for vessel registration-->
            <b-card>
                <div class="card-header">
                    <h4 class="card-title">Bill Approval List</h4>
                </div>
                <b-card-text class="card-content">
                    <b-card-body>
                        <b-card-text>

                            <b-table
                                striped
                                hover
                                show-empty
                                small
                                :items="billApprovalItems"
                                :current-page="currentPage"
                                :filter="filter"
                                :per-page="perPage"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                :fields="billApprovalFields"
                                responsive>

                                <template v-slot:cell(select)="row">
                                      <b-form-checkbox id="status" v-model="status"  value="accepted"> </b-form-checkbox> 
                                </template>
                                <template v-slot:cell(accountCombination)="row">
                                          <b-form-select v-model="accountHead" :options="accountHeadList"></b-form-select>
                                </template>

                                <template v-slot:cell(type)="row">
                                          <b-form-select v-model="type" :options="invoiceTypeList"></b-form-select>
                                </template>
                                <template v-slot:cell(action)="row">
                                    <a size="sm"  class="text-primary"  href="#" ><i class="bx bx-file cursor-pointer"></i> </a>
                                </template>
                            </b-table>

                        </b-card-text>

                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button md="6" size="md" type="submit" variant="dark">{{approvforwardBtn}}Approve & Forward</b-button>&nbsp;
                            </b-col>
                        </b-row>

                    </b-card-body>
                </b-card-text>
            </b-card>
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
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Bill Approval"});
                },
                data() {
                    return {
                        form: {
                            datetime: new Date()
                        },
                        show: true,
                        //updateIndex: -1,
                        // searchBtn: 'Search',
                        //  approvforwardBtn:'Approve & Forward',
                        billApprovalFields: [{key: 'select'},
                            {key: 'billNo', label: 'Bill No', sortable: true, sortDirection: 'desc'},
                            {key: 'billDate', label: 'Bill Date', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'rotationNo', label: 'Rotation No', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'rotationDate', label: 'Rotation Date', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'agentCode', label: 'Agent Code', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'shippingAgent', label: 'Shipping Agent', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'createdBy', label: 'Created By', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'forwardTo', label: 'Forward To', sortable: true, sortDirection: 'desc', class: 'text-center'},
                            {key: 'type', label: 'Type', sortable: true, sortDirection: 'desc', class: 'text-center'},'action'
                        ],
                        billApprovalItems: [
                            {select: ' ', billNo: 'FV-0001', billDate: '01-Sep-19', rotationNo: '201913228', rotationDate: '28-Aug-19', agentCode: '2837', shippingAgent: 'Everett Bangladesh', createdBy: 'Amdad', forwardTo: 'U298', type: ''},
                            {select: ' ', billNo: 'FV-0001', billDate: '01-Sep-19', rotationNo: '201913228', rotationDate: '28-Aug-19', agentCode: '2837', shippingAgent: 'Everett Bangladesh', createdBy: 'Amdad', forwardTo: 'U298', type: ''},
                        ],
                        selected: [1],
                        invoiceTypeList: [
                            {value: 1, text: 'In Process'},
                            {value: 2, text: 'Apporoved'},
                            {value: 2, text: 'Cancelled'}
                        ],
                    }
                },
            }
</script>

