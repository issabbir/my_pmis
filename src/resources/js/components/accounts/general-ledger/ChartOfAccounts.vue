<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h3 class="card-title">Chart of Accounts</h3>
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
                          <b-row>
                            <b-col lg="4">
                              <label>Account Code</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.AccountCode"
                                :options="AccountCodeList"
                                :show-labels="false"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <b-row>
                            <b-col lg="4">
                              <label>Active Date</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <date-picker
                                v-model="form.ActiveDate"
                                width="100%"
                                input-class="form-control"
                                type="date"
                                lang="en"
                                format="YYYY-MM-DD"
                              ></date-picker>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="6">
                          <b-row>
                            <b-col lg="4">
                              <label>Account Description</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.AccountDescription"
                                :options="AccountDescriptionList"
                                :show-labels="false"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <b-row>
                            <b-col lg="4">
                              <label>Inactive Date</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <date-picker
                                v-model="form.InactiveDate"
                                width="100%"
                                input-class="form-control"
                                type="date"
                                lang="en"
                                format="YYYY-MM-DD"
                              ></date-picker>
                            </b-col>
                          </b-row>
                        </b-col>
                      </b-row>
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
                <h3 class="card-title">COA Setup</h3>
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
                  <template v-slot:cell(AccountCode)="row">
                    <b-form-input id="examCenter" v-model="form.examCenter" placeholder="Code"></b-form-input>
                  </template>
                  <template v-slot:cell(AccountDescription)="row">
                    <b-form-input id="rollFrom" v-model="form.rollFrom" placeholder="Description"></b-form-input>
                  </template>
                  <template v-slot:cell(Parent)="row">
                    <b-form-select v-model="form.religion" :options="parent"></b-form-select>
                  </template>
                  <template v-slot:cell(Enable)="row">
                    <b-form-checkbox
                      id="checkbox-1"
                      v-model="status"
                      name="checkbox-1"
                      value="accepted"
                      unchecked-value="not_accepted"
                    ></b-form-checkbox>
                  </template>
                  <template v-slot:cell(InActive)="row">
                    <b-form-checkbox
                      id="checkbox-2"
                      v-model="status"
                      name="checkbox-2"
                      value="accepted"
                      unchecked-value="not_accepted"
                    ></b-form-checkbox>
                  </template>
                  <template v-slot:cell(EnableDate)="row">
                    <date-picker
                      v-model="form.datetimeen"
                      width="100%"
                      input-class="form-control"
                      type="date"
                      lang="en"
                      format="YYYY-MM-DD"
                    ></date-picker>
                  </template>
                  <template v-slot:cell(InactiveDate)="row">
                    <date-picker
                      v-model="form.datetimein"
                      width="100%"
                      input-class="form-control"
                      type="date"
                      lang="en"
                      format="YYYY-MM-DD"
                    ></date-picker>
                  </template>
                  <template v-slot:cell(AllowBudgeting)="row">
                    <b-form-select v-model="form.AllowBudgeting" :options="allowbudgeting"></b-form-select>
                  </template>
                  <template v-slot:cell(AllowPosting)="row">
                    <b-form-select v-model="form.AllowPosting" :options="allowposting"></b-form-select>
                  </template>
                  <template v-slot:cell(AccountTypes)="row">
                    <b-form-select v-model="form.AccountTyes" :options="accountyes"></b-form-select>
                  </template>
                  <template v-slot:cell(action)="row">
                    <b-button size="sm" class="mr-2">Add</b-button>
                  </template>
                </b-table>
              </b-card-text>
              <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                <b-row>
                  <b-col class="mt-2 d-flex justify-content-end">
                    <b-button lg="6" size="md" variant="dark" type="submit">Save</b-button>
                  </b-col>
                </b-row>
              </b-form>
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
  components: { DatePicker, Multiselect },
  mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Accounts & Finance"
    });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Setup" });
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Chart Of Accounts"
    });
  },
  data() {
    return {
      form: {
        employee_id: "",
        department_name: "",
        designation: "",
        division_name: null,
        financial_code: null,
        religion: null,
        AllowBudgeting: null,
        AllowPosting: null,
        AccountTyes: null,
        shift: null
      },
      show: true,
      updateIndex: -1,
      submitBtn: "Search",
      examCenter: [
        { key: "AccountCode", label: "Account Code", sortable: true },
        {
          key: "AccountDescription",
          label: "Account Description",
          sortable: true
        },
        { key: "Parent", label: "Parent", sortable: true },
        { key: "Enable", label: "Enable", sortable: true },
        { key: "InActive", label: "Inactive", sortable: true },
        { key: "EnableDate", label: "Enable Date", sortable: true },
        { key: "InactiveDate", label: "Inactive Date", sortable: true },
        { key: "AllowBudgeting", label: "Allow Budgeting", sortable: true },
        { key: "AllowPosting", label: "Allow Posting", sortable: true },
        { key: "AccountTypes", label: "Account Types", sortable: true },
        "action"
      ],
      education: [
        {
          AccountCode: "",
          AccountDescription: "",
          Parent: "",
          Enable: "",
          InActive: "",
          EnableDate: "",
          InactiveDate: ""
        }
      ],
      parent: [
        { text: "Select", value: null },
        { text: "Fixed Asset", value: "Fixed Asset" },
        { text: "Current Asset", value: "Current Asset" }
      ],
      allowbudgeting: [
        { text: "Select", value: null },
        { text: "Yes", value: "Yes" },
        { text: "No", value: "No" }
      ],
      allowposting: [
        { text: "Select", value: null },
        { text: "Yes", value: "Yes" },
        { text: "No", value: "No" }
      ],
      accountyes: [
        { text: "Select", value: null },
        { text: "Yes", value: "Yes" },
        { text: "No", value: "No" }
      ],
      AccountCodeList: [
        { value: "01991", text: "01991" },
        { value: "01991", text: "01993" },
        { value: "01991", text: "01989" },
        { value: "01991", text: "01978" },
        { value: "01991", text: "01966" }
      ],
      AccountDescriptionList: [
        {
          value: "InterestIncomeBankAccount",
          text: "Interest Income Bank Account"
        },
        { value: "InterestIncomeFDR", text: "Interest Income FDR" },
        { value: "InterestIncomeSTD", text: "Interest Income STD" },
        { value: "OfficeEquipment", text: "Office Equipment" }
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

