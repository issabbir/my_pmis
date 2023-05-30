<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Journal Entry Form</h4>
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
                        <b-col lg="6">
                          <!-- Journal -->
                          <b-row>
                            <b-col lg="4">
                              <label>Journal</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.JournalTop"
                                :options="Journallist"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Ledger -->
                          <b-row>
                            <b-col lg="4">
                              <label>Ledger</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.Ledger"
                                :options="ledgerTop"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Source -->
                          <b-row>
                            <b-col lg="4">
                              <label>Source</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.sourceTop"
                                :options="sourceTop"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- New Journal btn -->
                          <b-row>
                            <b-col class="mt-2 d-flex justify-content-left">
                              <b-button lg="6" size="md" class="btn-outline-dark" type="reset">
                                <i class="bx bxs-plus-circle cursor-pointer"></i> New Journal
                              </b-button>
                            </b-col>
                          </b-row>
                        </b-col>
                        <b-col lg="6">
                          <!-- Period -->
                          <b-row>
                            <b-col lg="4">
                              <label>Period</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.Periodtop"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Period"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Currency -->
                          <b-row>
                            <b-col lg="4">
                              <label>Currency</label>
                            </b-col>
                            <b-col class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.Currency1"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Currency"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Status -->
                          <b-row>
                            <b-col lg="4">
                              <label>Status</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.Status"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Status"
                              ></b-form-input>
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
            </b-card-text>
          </b-card>
        </b-col>
      </b-row>

      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-content">
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
                        <b-col lg="3">
                          <!-- Journal -->
                          <b-row>
                            <b-col lg="4">
                              <label>Journal</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.JournalMid"
                                :options="Journallist"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Journal Description -->
                          <b-row>
                            <b-col lg="4">
                              <label>Journal Description</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.JDescription"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Journal Description"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Ledger -->
                          <b-row>
                            <b-col lg="4">
                              <label>Ledger</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.JournalMid"
                                :options="Journallist"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Period -->
                          <b-row>
                            <b-col lg="4">
                              <label>Period</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.Periodbdy"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Period"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Balance Type -->
                          <b-row>
                            <b-col lg="4">
                              <label>Balance Type</label>
                            </b-col>
                            <b-col class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.bType"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Balance Type"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="3">
                          <!-- Category -->
                          <b-row>
                            <b-col lg="4">
                              <label>Category</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.Category1"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Category"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Transaction Date -->
                          <b-row>
                            <b-col lg="4">
                              <label>Transaction Date</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <date-picker
                                v-model="form.TransactionDate"
                                width="100%"
                                input-class="form-control"
                                type="date"
                                lang="en"
                                format="YYYY-MM-DD"
                              ></date-picker>
                            </b-col>
                          </b-row>

                          <!-- Document Number -->
                          <b-row>
                            <b-col lg="4">
                              <label>Document Number</label>
                            </b-col>
                            <b-col class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.DNumber"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Document Number"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Tax -->
                          <b-row>
                            <b-col lg="4">
                              <label>Tax</label>
                            </b-col>
                            <b-col class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.Tax"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Tax"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                          
                        <!-- Remarks -->
                          <b-row>
                            <b-col lg="4">
                              <label>Remarks</label>
                            </b-col>
                            <b-col class="col-md-8 form-group">
                              <b-form-textarea
                                    id="textarea"
                                    v-model="form.Remarks"
                                    placeholder="Enter something..."
                                    rows="3"
                                  ></b-form-textarea>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="3">
                          <!-- Currency -->
                          <b-row>
                            <b-col lg="4">
                              <label>Currency</label>
                            </b-col>
                            <b-col class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.Currency"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Currency"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Date -->
                          <b-row>
                            <b-col lg="4">
                              <label>Date</label>
                            </b-col>
                            <b-col class="col-md-8 form-group">
                              <date-picker
                                v-model="form.date2"
                                width="100%"
                                input-class="form-control"
                                type="date"
                                lang="en"
                                format="YYYY-MM-DD"
                              ></date-picker>
                            </b-col>
                          </b-row>

                          <!-- Type -->
                          <b-row>
                            <b-col lg="4">
                              <label>Type</label>
                            </b-col>
                            <b-col class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.Typebdy"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Type"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Rate -->
                          <b-row>
                            <b-col lg="4">
                              <label>Rate</label>
                            </b-col>
                            <b-col class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.Rate"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Rate"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="3">
                          <fieldset class="border p-2">
                            <legend class="w-auto">Reverse</legend>
                            <!-- Date -->
                            <b-row>
                              <b-col lg="4">
                                <label>Date</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <date-picker
                                  v-model="form.date56"
                                  width="100%"
                                  input-class="form-control"
                                  type="date"
                                  lang="en"
                                  format="YYYY-MM-DD"
                                ></date-picker>
                              </b-col>
                            </b-row>

                            <!-- Period -->
                            <b-row>
                              <b-col lg="4">
                                <label>Period</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.Periodre"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Period"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Method -->
                            <b-row>
                              <b-col lg="4">
                                <label>Method</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.Method"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Method"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Status -->
                            <b-row>
                              <b-col lg="4">
                                <label>Status</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.Status96"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Status"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <b-row>
                              <b-col class="mt-2 d-flex justify-content-end">
                                <b-button lg="6" size="md" variant="dark" type="submit">Reverse</b-button>&nbsp;
                              </b-col>
                            </b-row>
                          </fieldset>
                        </b-col>
                      </b-row>
                    </b-col>
                  </b-row>
                </b-form>
              </div>
              <b-card-text class="card-body">
                <div class="table-responsive">
                  <b-table
                    striped
                    hover
                    show-empty
                    small
                    bordered
                    :items="tableData.items"
                    :current-page="currentPage"
                    er-page="perPage"
                    :filter="filter"
                    ort-by.sync="sortBy"
                    ort-desc.sync="sortDesc"
                    ort-direction="sortDirection"
                    :fields="tableData.fields"
                    responsive
                  >
                    <template v-slot:cell(AccountCode)="row">
                      <b-form-input
                        v-model="form.tabAccountCode"
                        required
                        id="input-id"
                        type="text"
                      ></b-form-input>
                    </template>
                    <template v-slot:cell(Debit)="row">
                      <b-form-input v-model="form.tabDebit" required id="input-id" type="text"></b-form-input>
                    </template>
                    <template v-slot:cell(Credit)="row">
                      <b-form-input v-model="form.tabCredit" required id="input-id" type="text"></b-form-input>
                    </template>
                    <template v-slot:cell(Description)="row">
                      <b-form-input
                        v-model="form.tabDescription"
                        required
                        id="input-id"
                        type="text"
                      ></b-form-input>
                    </template>
                    <template v-slot:cell(Remarks)="row">
                      <b-form-input v-model="form.tabRemarks" required id="input-id" type="text"></b-form-input>
                    </template>
                    <template v-slot:cell(action)="row">
                      <b-button size="sm" class="mr-2">Add</b-button>
                    </template>
                  </b-table>
                </div>
              </b-card-text>
              <hr />
              <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                <b-row class="my-1 d-flex justify-content-end">
                  <b-col md="4">
                    <table style="width:100%;border-collapse: collapse;">
                      <tr>
                        <th class="pb-1">Total Debit:</th>
                        <td class="pb-1">-</td>
                      </tr>

                      <tr>
                        <th class="pb-1">Total Debit:</th>
                        <td class="pb-1">-</td>
                      </tr>
                    </table>
                  </b-col>
                </b-row>
              </b-form>
              <hr />
              <div class="mt-2 d-flex justify-content-end">
                <b-button b-button lg="6" size="md" variant="dark" type="submit">Save</b-button>&nbsp;
                <b-button b-button lg="6" size="md" variant="dark" type="submit">Edit</b-button>&nbsp;
                <b-button b-button lg="6" size="md" variant="dark" type="submit">Create Accounting</b-button>&nbsp;
              </div>
            </div>
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
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Accounts & Finance"
    });
    this.$store.commit("setBreadcrumb", { link: "#", label: "General Ledger" });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Journals" });
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
        Periodbdy: "1-Jun-2019",
        Typebdy: "User",
        shift: null
      },
      show: true,
      updateIndex: -1,
      submitBtn: "Save",

      tableData: {
        fields: [
          { key: "AccountCode", label: "Account Code" },
          { key: "Debit", label: "Debit" },
          { key: "Credit", label: "Credit" },
          { key: "Description", label: "Description" },
          { key: "Remarks", label: "Remarks" },
          { key: "action", label: "Action" }
        ],
        items: [
          {
            AccountCode: "",
            Debit: "",
            Credit: "",
            Description: "",
            Remarks: ""
          }
          //   },
          //   {
          //     Line: "2",
          //     AccountCode: "100.2234.230",
          //     Debit: "",
          //     Credit: "1234566",
          //     Description: "-",
          //     Remarks: "-"
          //   }
        ]
      },
      accnolist: [
        { value: null, text: "Please select" },
        { value: "011091003", text: "011091003" },
        { value: "011091004", text: "011091004" },
        { value: "011091005", text: "011091005" },
        { value: "011091006", text: "011091006" }
      ],

      Journallist: [
        { value: null, text: "Please select" },
        { value: "011091003", text: "011091003" },
        { value: "011091004", text: "011091004" },
        { value: "011091005", text: "011091005" },
        { value: "011091006", text: "011091006" }
      ],
      sourceTop: [
        { value: null, text: "Please select" },
        { value: "Machanical Dept.", text: "Machanical Dept." }
      ],
      ledgerTop: [
        { value: null, text: "Accounts Payables" },
        { value: "BillReceivables", text: "Bill Receivables" },
        { value: "CashManagement", text: "Cash Management" },
        { value: "FixedAsset", text: "Fixed Asset" }
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
