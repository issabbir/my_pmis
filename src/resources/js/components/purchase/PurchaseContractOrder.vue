<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Purchase/Contract Order</h4>
              <b-row>
                <b-col class="d-flex justify-content-end">
                  <b-dropdown id="dropdown-1" text="Action" class="m-md-1">
                    <b-dropdown-item>Duplicate</b-dropdown-item>
                    <b-dropdown-item>Delete</b-dropdown-item>
                    <b-dropdown-item>Cancel Document</b-dropdown-item>
                    <b-dropdown-item>Validate</b-dropdown-item>
                    <b-dropdown-item href="/purchase/#/purchase-order-approve">Approve</b-dropdown-item>
                  </b-dropdown>
                  <b-dropdown id="dropdown-1" text="Manage" class="m-md-1"></b-dropdown>
                  <b-dropdown id="dropdown-1" text="Save" class="m-md-1"></b-dropdown>
                  <b-dropdown id="dropdown-1" text="Submit" class="m-md-1"></b-dropdown>
                </b-col>
              </b-row>
            </div>
            <b-card-text class="card-content">
              <div class="card-body mb-2">
                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                  <b-form-input
                    v-model="updateIndex"
                    required
                    id="input-update-index"
                    type="text"
                    :style="{'display':'none'}"
                  ></b-form-input>
                  <b-row>
                    <b-col>
                      <b-row>
                        <b-col lg="4">
                          <!-- Oparating Unit -->
                          <b-row>
                            <b-col lg="4">
                              <label>Oparating Unit</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.OparatingUnit"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Oparating Unit"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Department Name -->
                          <b-row>
                            <b-col lg="4">
                              <label>Department Name</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.DepartmentName"
                                :options="DepartmentNamelist"
                                :custom-label="nameWithLang"
                                label="text"
                                track-by="name"
                                :show-labels="false"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Perchasing Method -->
                          <b-row>
                            <b-col lg="4">
                              <label>Perchasing Method</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.PerchasingMethod"
                                :options="PerchasingMethodlist"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                                :show-labels="false"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Fund Status -->
                          <b-row>
                            <b-col lg="4">
                              <label>Fund Status</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.FundStatus"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Fund Status"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Perchaser -->
                          <b-row>
                            <b-col lg="4">
                              <label>Perchaser</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-select v-model="selected" class>
                                <option value="Open">Mr. Waker Khan</option>
                              </b-form-select>
                            </b-col>
                          </b-row>

                          <!-- Description -->
                          <b-row>
                            <b-col lg="4">
                              <label>Description</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.Description"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Description"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Ship to Location -->
                          <b-row>
                            <b-col lg="4">
                              <label>Ship to Location</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.ShiptoLocation"
                                :options="ShiptoLocationlist"
                                :show-labels="false"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="4">
                          <!-- PO Contract No -->
                          <b-row>
                            <b-col lg="4">
                              <label>PO Contract No</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.POContractNo"
                                required
                                id="input-id"
                                type="text"
                                placeholder="PO Contract No"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- PO Contract Date -->
                          <b-row>
                            <b-col lg="4">
                              <label>PO Contract Date</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <date-picker
                                v-model="form.POContractDate"
                                width="100%"
                                input-class="form-control"
                                type="date"
                                lang="en"
                                format="YYYY-MM-DD"
                              ></date-picker>
                            </b-col>
                          </b-row>

                          <!-- Creation Date -->
                          <b-row>
                            <b-col lg="4">
                              <label>Creation Date</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <date-picker
                                v-model="form.CreationDate"
                                width="100%"
                                input-class="form-control"
                                type="date"
                                lang="en"
                                format="YYYY-MM-DD"
                              ></date-picker>
                            </b-col>
                          </b-row>

                          <!-- Supplier Code -->
                          <b-row>
                            <b-col lg="4">
                              <label>Supplier Code</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.SupplierCode"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Supplier Code"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Supplier Name -->
                          <b-row>
                            <b-col lg="4">
                              <label>Supplier Name</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.SupplierName"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Supplier Name"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Supplier Address -->
                          <b-row>
                            <b-col lg="4">
                              <label>Supplier Address</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.SupplierAddress"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Supplier Address"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Remarks -->
                          <b-row>
                            <b-col lg="4">
                              <label>Remarks</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.Remarks"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Remarks"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="4">
                          <!-- Currency -->
                          <b-row>
                            <b-col lg="4">
                              <label>Currency</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.Currency"
                                :options="Currencylist"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Rate -->
                          <b-row>
                            <b-col lg="4">
                              <label>Rate</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.Rate"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Rate"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- PO Amount -->
                          <b-row>
                            <b-col lg="4">
                              <label>PO Amount</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.POAmount"
                                required
                                id="input-id"
                                type="text"
                                placeholder="PO Amount"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Total Tax -->
                          <b-row>
                            <b-col lg="4">
                              <label>Total Tax</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.TotalTax"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Total Tax"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Total Amount -->
                          <b-row>
                            <b-col lg="4">
                              <label>Functional Amount(BDT)</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.TotalAmount"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Functional Amount(BDT)"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Status -->
                          <b-row>
                            <b-col lg="4">
                              <label>Status</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-select v-model="selected" class>
                                <option value="Open">Approve</option>
                                <option value="Close">In Process</option>
                                <option value="Close">Cancel</option>
                                <option value="Close">Incomplete</option>
                              </b-form-select>
                            </b-col>
                          </b-row>
                          <!-- Search btn -->
                          <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                              <b-button lg="6" size="md" class="btn-outline-dark" type="reset">
                                <i class="bx bx-search cursor-pointer"></i>Search
                              </b-button>
                            </b-col>
                          </b-row>
                        </b-col>
                      </b-row>
                    </b-col>
                  </b-row>
                </b-form>
              </div>
              <hr />
              <b-card no-body>
                <b-tabs card>
                  <b-tab title="Terms" active>
                    <b-row>
                      <b-col>
                        <b-row>
                          <b-col lg="4">
                            <!-- Freight Terms -->
                            <b-row>
                              <b-col lg="4">
                                <label>Freight Terms</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.FreightTerms"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Freight Terms"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Shipping Methods -->
                            <b-row>
                              <b-col lg="4">
                                <label>Shipping Methods</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.ShippingMethods"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Shipping Methods"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>
                          <b-col lg="4">
                            <!-- Payment Terms -->
                            <b-row>
                              <b-col lg="4">
                                <label>Payment Terms</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.PaymentTerms"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Payment Terms"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Required Acknowledgement -->
                            <b-row>
                              <b-col lg="4">
                                <label>Required Acknowledgement</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.RequiredAcknowledgement"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Required Acknowledgement"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>
                        </b-row>
                      </b-col>
                    </b-row>
                  </b-tab>
                  <b-tab title="Note & Attachment">
                    <b-row>
                      <b-col>
                        <b-row>
                          <b-col lg="6">
                            <b-row>
                              <b-col lg="4">
                                <label>Note To Supplier</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-textarea
                                  id="textarea1"
                                  v-model="text"
                                  placeholder="Note To Supplier..."
                                  rows="3"
                                  max-rows="6"
                                ></b-form-textarea>
                              </b-col>
                            </b-row>
                          </b-col>
                          <b-col lg="6">
                            <b-row>
                              <b-col lg="4">
                                <label>Note To Receiver</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-textarea
                                  id="textarea"
                                  v-model="text"
                                  placeholder="Note To Receiver..."
                                  rows="3"
                                  max-rows="6"
                                ></b-form-textarea>
                              </b-col>
                            </b-row>
                          </b-col>
                        </b-row>
                      </b-col>
                    </b-row>
                  </b-tab>
                </b-tabs>
              </b-card>
              <hr />
              <b-card no-body>
                <b-tabs card>
                  <b-tab title="Lines" active>
                    <div class="table-responsive">
                      <b-table
                        bordered
                        striped
                        hover
                        show-empty
                        small
                        :items="tableDataLines.items"
                        :current-page="currentPage"
                        er-page="perPage"
                        :filter="filter"
                        ort-by.sync="sortBy"
                        ort-desc.sync="sortDesc"
                        ort-direction="sortDirection"
                        :fields="tableDataLines.fields"
                        responsive
                      >
                        <template v-slot:cell(Action)="row">
                          <b-button size="sm" class="mr-2">Add</b-button>
                        </template>
                        <template v-slot:cell(Types)="row">
                          <b-form-input v-model="form.tabTypes" required id="input-id" type="text"></b-form-input>
                        </template>
                        <template v-slot:cell(ItemCode)="row">
                          <b-form-input
                            v-model="form.tabItemCode"
                            required
                            id="input-id"
                            type="text"
                          ></b-form-input>
                        </template>
                        <template v-slot:cell(ItemDescription)="row">
                          <b-form-input
                            v-model="form.tabItemDescription"
                            required
                            id="input-id"
                            type="text"
                          ></b-form-input>
                        </template>
                        <template v-slot:cell(CategoryName)="row">
                          <b-form-input
                            v-model="form.tabCategoryName"
                            required
                            id="input-id"
                            type="text"
                          ></b-form-input>
                        </template>
                        <template v-slot:cell(UOM)="row">
                          <b-form-input v-model="form.tabUOM" required id="input-id" type="text"></b-form-input>
                        </template>
                        <template v-slot:cell(Qty)="row">
                          <b-form-input v-model="form.tabQty" required id="input-id" type="text"></b-form-input>
                        </template>
                        <template v-slot:cell(Price)="row">
                          <b-form-input v-model="form.tabPrice" required id="input-id" type="text"></b-form-input>
                        </template>
                        <template v-slot:cell(Ordered)="row">
                          <b-form-input
                            v-model="form.tabOrdered"
                            required
                            id="input-id"
                            type="text"
                          ></b-form-input>
                        </template>
                        <template v-slot:cell(Brand)="row">
                          <b-form-input v-model="form.tabBrand" required id="input-id" type="text"></b-form-input>
                        </template>
                        <template v-slot:cell(Origin)="row">
                          <b-form-input v-model="form.tabOrigin" required id="input-id" type="text"></b-form-input>
                        </template>
                        <template v-slot:cell(Fund)="row">
                          <b-form-input v-model="form.tabFund" required id="input-id" type="text"></b-form-input>
                        </template>
                        <template v-slot:cell(Request)="row">
                          <b-form-input
                            v-model="form.tabRequest"
                            required
                            id="input-id"
                            type="text"
                          ></b-form-input>
                        </template>
                      </b-table>
                    </div>
                  </b-tab>
                  <b-tab title="Distribution">
                    <div class="table-responsive">
                      <b-table
                        bordered
                        striped
                        hover
                        show-empty
                        small
                        :items="tableDataDistribution.items"
                        :current-page="currentPage"
                        er-page="perPage"
                        :filter="filter"
                        ort-by.sync="sortBy"
                        ort-desc.sync="sortDesc"
                        ort-direction="sortDirection"
                        :fields="tableDataDistribution.fields"
                        responsive
                      ></b-table>
                    </div>
                  </b-tab>
                </b-tabs>
              </b-card>
            </b-card-text>
          </b-card>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import DatePicker from "vue2-datepicker";

export default {
  components: {
    Multiselect,
    DatePicker
  },
  mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", { link: "#", label: "Administration" });
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Employee Position"
    });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Department" });
  },
  data() {
    return {
      form: {
        employee_id: "",
        department_name: "",
        designation: "",
        Status: null,
        bankbr: null,
        accname: null,
        accno: null,
        financial_code: null,
        OparatingUnit: "Chittagong Port Authority",
        shift: null
      },
      show: true,
      updateIndex: -1,
      submitBtn: "Save",

      tableDataLines: {
        fields: [
          //   { key: "Line", label: "Line", sortable: true },
          { key: "Types", label: "Types", sortable: true },
          { key: "ItemCode", label: "Item Code", sortable: true },
          { key: "ItemDescription", label: "Item Description", sortable: true },
          { key: "CategoryName", label: "Category Name", sortable: true },
          { key: "UOM", label: "UOM", sortable: true },
          { key: "Qty", label: "Qty", sortable: true },
          { key: "Price", label: "Price", sortable: true },
          { key: "Ordered", label: "Ordered", sortable: true },
          { key: "Brand", label: "Brand", sortable: true },
          { key: "Origin", label: "Origin", sortable: true },
          { key: "Fund", label: "Fund", sortable: true },
          { key: "Request", label: "Request", sortable: true },
          { key: "Action", label: "Action" }
        ],
        items: [
          //   {
          //     Line: "1",
          //     Types: "Goods",
          //     ItemCode: "FA19883",
          //     ItemDescription: "Round table",
          //     CategoryName: "Furniture & Fixture",
          //     UOM: "PCS",
          //     Qty: "2",
          //     Price: "40,000",
          //     Ordered: "80,000",
          //     Brand: "",
          //     Origin: "Bangladesh",
          //     Fund: "Passed",
          //     Request: "Passed"
          //   }

          {
            Types: "",
            ItemCode: "",
            ItemDescription: "",
            CategoryName: "",
            UOM: "",
            Qty: "",
            Price: "",
            Ordered: "",
            Brand: "",
            Origin: "",
            Fund: "",
            Request: ""
          }
        ]
      },
      tableDataDistribution: {
        fields: [
          { key: "Line", label: "Line", sortable: true },
          { key: "Types", label: "Types", sortable: true },
          { key: "ItemCode", label: "Item Code", sortable: true },
          {
            key: "POChargeAccount",
            label: "PO Charge Account",
            sortable: true
          },
          { key: "BudgetAccount", label: "Budget Account", sortable: true },
          { key: "Tax", label: "Tax", sortable: true },
          { key: "TotalTax", label: "Total Tax", sortable: true },
          {
            key: "ConversationDate",
            label: "Conversation Date",
            sortable: true
          },
          {
            key: "ConversationRate",
            label: "Conversation Rate",
            sortable: true
          }
        ],
        items: [
          {
            Line: "1",
            Types: "Goods",
            ItemCode: "FA19883",
            POChargeAccount: "100.00.424.10",
            BudgetAccount: "100.00.423.10",
            Tax: "0",
            TotalTax: "0",
            ConversationDate: "1",
            ConversationRate: "1"
          }
        ]
      },
      tableDataApproval: {
        fields: [
          { key: "Line", label: "Line", sortable: true },
          { key: "Contract", label: "Contract", sortable: true },
          { key: "ItemCode", label: "Item Code", sortable: true },
          { key: "ItemDescription", label: "Item Description", sortable: true },
          { key: "Status", label: "Status", sortable: true },
          { key: "BudgetAccount", label: "Budget Account", sortable: true },
          { key: "Amount", label: "Amount", sortable: true }
        ],
        items: [
          {
            Line: "1",
            Types: "Goods",
            ItemCode: "FA19883",
            ItemDescription: "Round table",
            CategoryName: "Furniture & Fixture",
            Qty: "2",
            UOM: "PCS",
            Price: "40,000",
            Ordered: "80,000",
            Fund: "Passed",
            Request: "Passed"
          }
        ]
      },
      ShiptoLocationlist: [
        { value: "CentralStore", text: "Central Store" },
        { value: "Jetty", text: "Jetty" }
      ],
      DepartmentNamelist: [
        { value: "Mechanical", text: "Mechanical" },
        { value: "Civil", text: "Civil" },
        { value: "Electrical", text: "Electrical" },
        { value: "CentralStore", text: "Central Store" },
        { value: "Traffic", text: "Traffic" },
        { value: "Merine", text: "Merine" },
        { value: "Hydrography", text: "Hydrography" },
        { value: "Administration", text: "Administration" },
        { value: "Medical", text: "Medical" },
        { value: "Planning", text: "Planning" },
        { value: "FinanceandAccounting", text: "Finance & Accounting" },
        { value: "AuditandInspaction", text: "Audit & Inspaction" }
      ],
      PerchasingMethodlist: [
        { value: "LTM", text: "LTM" },
        { value: "OTM", text: "OTM" },
        { value: "DPM", text: "DPM" }
      ],
      Currencylist: [
        { value: null, text: "Please select" },
        { value: "USD", text: "USD" },
        { value: "BDT", text: "BDT" }
      ]
    };
  },
  methods: {
    onSubmit(evt) {
      evt.preventDefault();
      if (this.updateIndex > -1) {
        //update
        this.tableData.items[
          this.updateIndex
        ].employee_id = this.form.employee_id;
        this.tableData.items[
          this.updateIndex
        ].department_name = this.form.department_name;
        this.tableData.items[
          this.updateIndex
        ].designation = this.form.designation;
        this.tableData.items[
          this.updateIndex
        ].division_name = this.form.division_name;
        this.tableData.items[
          this.updateIndex
        ].financial_code = this.form.financial_code;
        this.tableData.items[this.updateIndex].shift = this.form.shift;
      } else {
        //new data add
        this.tableData.items.push({
          employee_id: this.form.employee_id,
          department_name: this.form.department_name,
          designation: this.form.designation,
          division_name: this.form.division_name,
          financial_code: this.form.financial_code,
          shift: this.form.shift
        });
      }
      this.onReset(evt);
    },
    onReset(evt) {
      evt.preventDefault();
      this.employee_id = "";
      this.department_name = "";
      this.designation = "";
      this.division_name = null;
      this.financial_code = null;
      this.shift = null;

      this.updateIndex = -1;
      this.submitBtn = "Save";
      this.show = false;
      this.$nextTick(() => {
        this.show = true;
      });
    },
    editRow(i, code) {
      this.submitBtn = "Update";
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
};
</script>
