<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Assets Retirement</h4>
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
                          <!-- Asset Code -->
                          <b-row>
                            <b-col lg="4">
                              <label>Asset Code</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.ledger"
                                :options="ledgerlist"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Asset Description -->
                          <b-row>
                            <b-col lg="4">
                              <label>Asset Description</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.employee_id"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Asset Description"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Asset Type -->
                          <b-row>
                            <b-col lg="4">
                              <label>Asset Type</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.employee_id"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Asset Type"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                        </b-col>
                        <b-col lg="4">
                          <!-- Asset Depertment -->
                          <b-row>
                            <b-col lg="4">
                              <label>Asset Depertment</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <multiselect
                                v-model="form.ledger"
                                :options="ledgerlist"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </div>
                          </b-row>

                          <!-- Group Name -->
                          <b-row>
                            <b-col lg="4">
                              <label>Group Name</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.ledger"
                                :options="ledgerlist"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Category -->
                          <b-row>
                            <b-col lg="4">
                              <label>Category</label>
                            </b-col>
                            <b-col class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.employee_id"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Category"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="4">
                          <!-- PO Number -->
                          <b-row>
                            <b-col lg="4">
                              <label>PO Number</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.employee_id"
                                required
                                id="input-id"
                                type="text"
                                placeholder="PO Number"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Party Code -->
                          <b-row>
                            <b-col lg="4">
                              <label>Party Code</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.employee_id"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Party Code"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Party Name -->
                          <b-row>
                            <b-col lg="4">
                              <label>Party Name</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.employee_id"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Party Name"
                              ></b-form-input>
                            </div>
                          </b-row>

                          <!-- Search Button -->
                          <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                              <b-button
                                lg="6"
                                size="md"
                                class="btn-outline-dark"
                                type="reset"
                                v-on:click="isHidden = !isHidden"
                              >Search</b-button>&nbsp;
                              <b-button lg="6" size="md" class="btn-outline-dark" type="reset">Clear</b-button>
                            </b-col>
                          </b-row>
                        </b-col>
                      </b-row>
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
      <section id="basic-datatable" v-if="isHidden">
        <b-row>
          <b-col>
            <b-card class="card">
              <div class="card-content">
                <div class="card-body mb-2">
                  <h4 class="card-title">Assets Details</h4>
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
                            <!-- Asset Code -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Code</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Asset Code"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Asset Type -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Type</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Asset Type"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Asset Description -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Description</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Asset Description"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Asset Depertment -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Depertment</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <multiselect
                                  v-model="form.ledger"
                                  :options="ledgerlist"
                                  :custom-label="nameWithLang"
                                  placeholder="Select one"
                                  label="text"
                                  track-by="name"
                                ></multiselect>
                              </b-col>
                            </b-row>
                          </b-col>
                          <b-col lg="4">
                            <!-- Asset Location -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Location</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Asset Location"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Group -->
                            <b-row>
                              <b-col lg="4">
                                <label>Group</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Group"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Category -->
                            <b-row>
                              <b-col lg="4">
                                <label>Category</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Category"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Sold To -->
                            <b-row>
                              <b-col lg="4">
                                <label>Sold To</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Sold To"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>
                          <b-col lg="4">
                            <!-- Reference -->
                            <b-row>
                              <b-col lg="4">
                                <label>Reference</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Reference"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Retire Date -->
                            <b-row>
                              <b-col lg="4">
                                <label>Retire Date</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <date-picker
                                  v-model="form.dateProrate"
                                  width="100%"
                                  input-class="form-control"
                                  type="date"
                                  lang="en"
                                  format="YYYY-MM-DD"
                                ></date-picker>
                              </b-col>
                            </b-row>

                            <!-- Status -->
                            <b-row>
                              <b-col lg="4">
                                <label>Status</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Status"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Life -->
                            <b-row>
                              <b-col lg="4">
                                <label>Life</label>
                              </b-col>
                              <b-col lg="4" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Year"
                                ></b-form-input>
                              </b-col>
                              <b-col lg="4" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Month"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>
                        </b-row>
                      </b-col>
                    </b-row>

                    <!--</fieldset>-->
                  </b-form>

                  <hr />

                  <h4 class="card-title">Retirement Details</h4>
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
                          <b-col lg="6">
                            <!-- Current Units -->
                            <b-row>
                              <b-col lg="4">
                                <label>Current Units</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Current Units"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Current Cost -->
                            <b-row>
                              <b-col lg="4">
                                <label>Current Cost</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Current Cost"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Units Retired -->
                            <b-row>
                              <b-col lg="4">
                                <label>Units Retired</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Units Retired"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Retired Cost -->
                            <b-row>
                              <b-col lg="4">
                                <label>Retired Cost</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Retired Cost"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Retirement Type -->
                            <b-row>
                              <b-col lg="4">
                                <label>Retirement Type</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <multiselect
                                  v-model="form.ledger"
                                  :options="ledgerlist"
                                  :custom-label="nameWithLang"
                                  placeholder="Select one"
                                  label="text"
                                  track-by="name"
                                ></multiselect>
                              </b-col>
                            </b-row>
                          </b-col>
                          <b-col lg="6">
                            <!-- Retirement Convention -->
                            <b-row>
                              <b-col lg="4">
                                <label>Retirement Convention</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Retirement Convention"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Proceedes of Sales -->
                            <b-row>
                              <b-col lg="4">
                                <label>Proceedes of Sales</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Proceedes of Sales"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Cost of Removal -->
                            <b-row>
                              <b-col lg="4">
                                <label>Cost of Removal</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Cost of Removal"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Gain Lost Amount -->
                            <b-row>
                              <b-col lg="4">
                                <label>Gain Lost Amount</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Gain Lost Amount"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Remarks -->
                            <b-row>
                              <b-col lg="4">
                                <label>Remarks</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.employee_id"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Remarks"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>
                        </b-row>
                      </b-col>
                    </b-row>

                    <!--</fieldset>-->
                  </b-form>
                </div>

                <div class="mt-2 d-flex justify-content-end">
                  <b-button lg="6" size="md" variant="dark" type="submit">Save</b-button>&nbsp;
                  <b-button lg="6" size="md" variant="dark" type="submit" disabled>Retirement</b-button>
                </div>
                <div class="mt-2 d-flex justify-content-end">
                  <p style="color:red;">Retirement button enable according to backend.</p>
                </div>
              </div>
            </b-card>
          </b-col>
        </b-row>
      </section>
      <!--/ Zero configuration table -->
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
      this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
      this.$store.commit("setBreadcrumb", {link: "#", label: "Fixed Asset"});
      this.$store.commit("setBreadcrumb", {link: "#", label: "Asset Retirement"});
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
        shift: null
      },
      show: true,
      updateIndex: -1,
      submitBtn: "Save",

      tableFields: [
        "SL",
        "DateinService",
        "LifeYear",
        "Month",
        "Cost",
        "ExpanceAmount",
        "Quantity",
        "Remarks",
        "Action"
      ],
      fieldItems: [
        {
          SL: "",
          DateinService: "",
          LifeYear: "",
          Month: "",
          Cost: "",
          ExpanceAmount: "",
          Quantity: "",
          Remarks: "",
          Action: ""
        }
      ],
      tableData: {
        fields: [
          { key: "line", label: "Line" },
          { key: "Bank_Name", label: "Bank Name" },
          { key: "Branch_Name", label: "Branch Name" },
          { key: "STD_Account_Name", label: "STD Account Name" },
          { key: "STD_Account", label: "STD Account" },
          { key: "Opening_Date", label: "Opening Date" },
          { key: "STD_Tenor", label: "STD Tenor" },
          { key: "STD_Amount", label: "STD Amount" },
          { key: "STD_Rate", label: "STD Rate" },
          { key: "Interest", label: "Interest" },
          { key: "Total_Amount", label: "Total Amount" },
          { key: "Status", label: "Status" },
          { key: "Action", label: "Action" }
        ],
        items: [
          {
            line: 1,
            Bank_Name: "Pubali Bank",
            Branch_Name: "Agrabad",
            STD_Account_Name: "CPA-FDR",
            STD_Account: 1240,
            Opening_Date: "30-Dec-2019",
            STD_Tenor: "1 Year",
            STD_Amount: "01-Jan-2019",
            STD_Rate: "31-Dec-2019",
            Interest: 100000,
            Total_Amount: "8%",
            Status: "Open"
          }
        ]
      },
      accnolist: [
        { value: null, text: "Please select" },
        { value: "011091003", text: "011091003" },
        { value: "011091004", text: "011091004" },
        { value: "011091005", text: "011091005" },
        { value: "011091006", text: "011091006" }
      ],
      ledgerlist: [
        { value: null, text: "Please select" },
        { value: "Acconts Payables", text: "Acconts Payables" },
        { value: "Bill Receivables", text: "Bill Receivables" },
        { value: "Cash Management", text: "Cash Management" },
        { value: "Fixed Assets", text: "Fixed Assets" }
      ],
      partynamelist: [
        { value: null, text: "Please select" },
        { value: "ABC Company", text: "ABC Company" },
        { value: "XYZ Pvt. Ltd.", text: "XYZ Pvt. Ltd." }
      ],
      approvalstatus: [
        { value: null, text: "Please select" },
        { value: "Open", text: "Open" },
        { value: "Close", text: "Close" },
        { value: "Not Open", text: "Not Open" }
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
