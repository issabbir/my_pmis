<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Period Form</h4>
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
                    <b-col lg="4">
                      <!-- Ledger -->
                      <b-row>
                        <b-col lg="4">
                          <label>Ledger</label>
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

                      <!-- Status -->
                      <b-row>
                        <b-col lg="4">
                          <label>Status</label>
                        </b-col>
                        <b-col lg="8" class="form-group">
                          <multiselect
                            v-model="form.statuslist"
                            :options="statuslist"
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
                            v-model="form.employee_id"
                            required
                            id="input-id"
                            type="text"
                            placeholder="Period"
                          ></b-form-input>
                        </b-col>
                      </b-row>
                    </b-col>
                    <b-col class="col-md-4 col-12">
                      <fieldset class="border p-2">
                        <legend class="w-auto">Fiscal Years</legend>
                        <b-col lg="12">
                          <!-- From -->
                          <b-row>
                            <b-col lg="4">
                              <label>From</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-select id="Form" v-model="form.formmodel" :options="formList"></b-form-select>
                            </b-col>
                          </b-row>
                          <!-- To -->
                          <b-row>
                            <b-col lg="4">
                              <label>To</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-select id="Form" v-model="form.formmodel" :options="formList"></b-form-select>
                            </b-col>
                          </b-row>
                        </b-col>
                      </fieldset>
                    </b-col>
                    <b-col class="col-md-4 col-12">
                      <fieldset class="border p-2">
                        <legend class="w-auto">Period number</legend>
                        <b-col lg="12">
                          <!-- From -->
                          <b-row>
                            <b-col lg="4">
                              <label>From</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-select id="Form" v-model="form.formmodel" :options="formList"></b-form-select>
                            </b-col>
                          </b-row>
                          <!-- To -->
                          <b-row>
                            <b-col lg="4">
                              <label>To</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-select id="Form" v-model="form.formmodel" :options="formList"></b-form-select>
                            </b-col>
                          </b-row>
                        </b-col>
                      </fieldset>
                    </b-col>
                  </b-row>
                  <b-row>
                    <b-col class="mt-2 d-flex justify-content-end">
                      <b-button lg="6" size="md" class="btn-outline-dark" type="reset">
                        <i class="bx bx-search cursor-pointer"></i>Search
                      </b-button>
                    </b-col>
                  </b-row>

                  <!--</fieldset>-->
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
              <b-card-text class="card-body">
                <div class="table-responsive">
                  <b-table
                    striped
                    hover
                    show-empty
                    small
                    :items="education"
                    :current-page="currentPage"
                    er-page="perPage"
                    :filter="filter"
                    ort-by.sync="sortBy"
                    ort-desc.sync="sortDesc"
                    ort-direction="sortDirection"
                    :fields="examCenter"
                    responsive
                    bordered
                  >
                    <template v-slot:cell(Status)="row">
                      <b-form-select v-model="selected" class>
                        <option value="Open">Open</option>
                        <option value="Close">Close</option>
                      </b-form-select>
                    </template>
                    <template v-slot:cell(Period)="row">
                      <b-form-input id="examCenter" v-model="form.Period" placeholder="Period"></b-form-input>
                    </template>
                    <template v-slot:cell(Number)="row">
                      <b-form-input id="examCenter" v-model="form.Number" placeholder="Number"></b-form-input>
                    </template>
                    <template v-slot:cell(FromDate)="row">
                      <date-picker
                        v-model="form.FromDate"
                        width="100%"
                        input-class="form-control"
                        type="date"
                        lang="en"
                        format="YYYY-MM-DD"
                      ></date-picker>
                    </template>
                    <template v-slot:cell(ToDate)="row">
                      <date-picker
                        v-model="form.ToDate"
                        width="100%"
                        input-class="form-control"
                        type="date"
                        lang="en"
                        format="YYYY-MM-DD"
                      ></date-picker>
                    </template>

                    <template v-slot:cell(action)="row">
                      <b-button size="sm" class="mr-2">Add</b-button>
                    </template>
                  </b-table>
                </div>

                <div class="table-responsive">
                  <b-table
                    striped
                    hover
                    show-empty
                    small
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
                    <template v-slot:cell(action)="row">
                      <b-form-checkbox
                        id="checkbox-1"
                        v-model="action"
                        name="checkbox-1"
                        value="accepted"
                        unchecked-value="not_accepted"
                      ></b-form-checkbox>
                    </template>
                  </b-table>
                </div>
              </b-card-text>
              <div class="mt-2 d-flex justify-content-end">
                <b-button lg="6" size="md" variant="dark" type="submit">Open</b-button>&nbsp;
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
      this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
      this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"});
      this.$store.commit("setBreadcrumb", {link: "#", label: "Period"});
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
        shift: null,
        formmodel : null,
      },
      show: true,
      updateIndex: -1,
      submitBtn: "Save",

      formList: [
          { text: 'Select One', value: null }, 
          'One',
          'Two'
      ],

      examCenter: [
        { key: "Status", label: "Status", sortable: true },
        { key: "Period", label: "Period", sortable: true },
        { key: "Number", label: "Number", sortable: true },
        { key: "FromDate", label: "From Date", sortable: true },
        { key: "ToDate", label: "To Date", sortable: true },
        "Action"
      ],
      education: [
        {
          Status: "",
          Period: "",
          Number: "",
          FromDate: "",
          ToDate: "",
          Action: ""
        }
      ],
      tableData: {
        fields: [
          { key: "action", label: "" },
          { key: "SL", label: "ID" },
          { key: "Status", label: "Status" },
          { key: "Period", label: "Period" },
          { key: "Number", label: "Number" },
          { key: "FromDate", label: "From Date" },
          { key: "ToDate", label: "To Date" }
        ],
        items: [
          {
            SL: "1",
            Status: "Open",
            Period: "Jun-19",
            Number: "11",
            FromDate: "01-Jan-19",
            ToDate: "01-Jun-19"
          },
          {
            SL: "1",
            Status: "Open",
            Period: "Jun-19",
            Number: "11",
            FromDate: "01-Jan-19",
            ToDate: "01-Jun-19"
          },
          {
            SL: "1",
            Status: "Open",
            Period: "Jun-19",
            Number: "11",
            FromDate: "01-Jan-19",
            ToDate: "01-Jun-19"
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
      statuslist: [
        { value: null, text: "Please select" },
        { value: "Any", text: "Any" },
        { value: "Open", text: "Open" },
        { value: "Close", text: "Close" }
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
