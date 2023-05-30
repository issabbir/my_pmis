<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Adding STD Details</h4>
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
                          <!-- Bank Name -->
                          <b-row>
                            <b-col lg="4">
                              <label>Bank Name</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.bankname"
                                :options="bankNameList"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Branch Name -->
                          <b-row>
                            <b-col lg="4">
                              <label>Branch Name</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.bankbr"
                                :options="bankbrNameList"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- STD Account Name -->
                          <b-row>
                            <b-col lg="4">
                              <label>STD Account Name</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.STDAccountName"
                                :options="accnamelist"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- STD Account -->
                          <b-row>
                            <b-col lg="4">
                              <label>STD Account</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.STDAccount"
                                required
                                id="input-id"
                                type="text"
                                placeholder="STD Account"
                              ></b-form-input>
                            </div>
                          </b-row>

                          <!-- Opening Date -->
                          <b-row>
                            <b-col lg="4">
                              <label>Opening Date</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <date-picker
                                v-model="form.OpeningDate"
                                width="100%"
                                input-class="form-control"
                                type="date"
                                lang="en"
                                format="YYYY-MM-DD"
                              ></date-picker>
                            </div>
                          </b-row>

                          <!-- STD Tenor -->
                          <b-row>
                            <b-col lg="4">
                              <label>STD Tenor</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.STDTenor"
                                required
                                id="input-id"
                                type="text"
                                placeholder="STD Tenor"
                              ></b-form-input>
                            </div>
                          </b-row>
                        </b-col>
                        <b-col lg="6">
                          <!-- STD Amount -->
                          <b-row>
                            <b-col lg="4">
                              <label>STD Amount</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.STDAmount"
                                required
                                id="input-id"
                                type="text"
                                placeholder="STD Amount"
                              ></b-form-input>
                            </div>
                          </b-row>

                          <!-- STD Rate -->
                          <b-row>
                            <b-col lg="4">
                              <label>STD Rate</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.STDRate"
                                required
                                id="input-id"
                                type="text"
                                placeholder="STD Rate"
                              ></b-form-input>
                            </div>
                          </b-row>

                          <!-- Interest -->
                          <b-row>
                            <b-col lg="4">
                              <label>Interest</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.Interest"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Interest"
                              ></b-form-input>
                            </div>
                          </b-row>

                          <!-- Total Amount -->
                          <b-row>
                            <b-col lg="4">
                              <label>Total Amount</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.TotalAmount"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Total Amount"
                              ></b-form-input>
                            </div>
                          </b-row>

                          <!-- Status -->
                          <b-row>
                            <b-col lg="4">
                              <label>Status</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-select v-model="selected" class>
                                <option value="Open">Open</option>
                                <option value="Close">Close</option>
                              </b-form-select>
                            </b-col>
                          </b-row>

                          <!-- Save Button -->
                          <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                              <b-button
                                lg="6"
                                size="md"
                                class="btn-outline-dark"
                                type="reset"
                                href="/accounts/#/std-details"
                              >Save</b-button>
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
      this.$store.commit("setBreadcrumb", {link: "#", label: "Cash Management"});
      this.$store.commit("setBreadcrumb", {link: "#", label: "STD Details Entry"});

  },
  data() {
    return {
      form: {
        employee_id: "",
        department_name: "",
        designation: "",
        bankname: null,
        bankbr: null,
        accname: null,
        accno: null,
        financial_code: null,
        shift: null
      },
      show: true,
      updateIndex: -1,
      submitBtn: "Save",
      accnolist: [
        { value: null, text: "Please select" },
        { value: "011091003", text: "011091003" },
        { value: "011091004", text: "011091004" },
        { value: "011091005", text: "011091005" },
        { value: "011091006", text: "011091006" }
      ],
      accnamelist: [
        { value: null, text: "Please select" },
        { value: "CPA", text: "CPA" },
        { value: "Others", text: "Others" }
      ],
      bankbrNameList: [
        { value: null, text: "Please select" },
        { value: "Agrabad", text: "Agrabad" },
        { value: "Sadar", text: "Sadar" },
        { value: "Port", text: "Port" }
      ],
      bankNameList: [
        { value: null, text: "Please select" },
        { value: "NRBC Bank", text: "NRBC Bank" },
        { value: "Pubali Bank", text: "Pubali Bank" },
        { value: "Standered Chartered Bank", text: "Standered Chartered Bank" },
        { value: "United Commarcial Bank", text: "United Commarcial Bank" },
        { value: "Eastern Bank", text: "Eastern Bank" }
      ],
      financial_code_options: [
        { value: null, text: "Please select" },
        { value: 97040, text: "97040" },
        { value: 97041, text: "97041" },
        { value: 97042, text: "97042" },
        { value: 97043, text: "97043" },
        { value: 97044, text: "97044" },
        { value: 97045, text: "97045" },
        { value: 97046, text: "97046" },
        { value: 90720, text: "90720" },
        { value: 90631, text: "90631" },
        { value: 90730, text: "90730" },
        { value: 90810, text: "90810" },
        { value: 90490, text: "90490" }
      ],
      shift_options: [
        { value: null, text: "Please select" },
        { value: "1", text: "1" },
        { value: "2", text: "2" },
        { value: "3", text: "3" },
        { value: "4", text: "4" },
        { value: "5", text: "5" },
        { value: "6", text: "6" },
        { value: "7", text: "7" }
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

