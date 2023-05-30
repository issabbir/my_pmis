<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Search Challan/Pay Order Entry</h4>
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
                          <b-row>
                            <b-col md="3">
                              <label>Chalan No</label>
                            </b-col>
                            <b-col md="9" class="form-group">
                              <b-form-input
                                v-model="form.Chalan"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Chalan No"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                        </b-col>
                        <b-col md="4">
                          <b-row>
                            <b-col md="3">
                              <label>Party Code</label>
                            </b-col>
                            <b-col md="9" class="form-group">
                              <b-form-input
                                v-model="form.partyCode"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Party Code"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                        </b-col>
                        <b-col md="4">
                          <b-row>
                            <b-col md="3">
                              <label>Bank Name</label>
                            </b-col>
                            <b-col md="9" class="form-group">
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
                        </b-col>
                    </b-row>
                
                  
                    <b-row>
                        <b-col md="4">
                          <b-row>
                            <b-col md="3">
                              <label>Date From</label>
                            </b-col>
                            <b-col md="9" class="form-group">
                              <date-picker
                                v-model="form.datetime1"
                                width="100%"
                                input-class="form-control"
                                type="date"
                                lang="en"
                                format="YYYY-MM-DD"
                              ></date-picker>
                            </b-col>
                          </b-row>
                        </b-col>
                        <b-col md="4">
                          <b-row>
                            <b-col md="3">
                              <label>Date To</label>
                            </b-col>
                            <b-col md="9" class="form-group">
                              <date-picker
                                v-model="form.datetime1"
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
                    
                    <b-row>
                         <b-col md="12" class="d-flex justify-content-end">
                            <b-button lg="6" size="md" class="btn-outline-dark" type="reset"><i class="bx bx-search cursor-pointer"></i> Search</b-button>
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
              <b-card-text class="card-body">
                <div class="table-responsive">
                  <b-table
                    bordered
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
                      <a
                        size="sm"
                        class="text-primary"
                        data-toggle="modal"
                        href="#"
                        data-target="#border-less"
                      >
                        <i class="bx bx-edit cursor-pointer"></i>
                      </a>
                      <a target="_self" href="#" class="text-danger">
                        <i class="bx bx-trash cursor-pointer"></i>
                      </a>
                    </template>
                  </b-table>
                </div>
              </b-card-text>
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
      this.$store.commit("setBreadcrumb", {link: "#", label: "Cash Management"});
      this.$store.commit("setBreadcrumb", {link: "#", label: "Challan Entry"});
      this.$store.commit("setBreadcrumb", {link: "#", label: "Challan Entry Search"});
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

      tableData: {
        fields: [
          { key: "ChallanNo", label: "Challan No", sortable: true },
          {
            key: "TotalBillAmount",
            label: "Total Bill Amount",
            sortable: true
          },
          { key: "action", label: "View" }
        ],
        items: [
          {
            ChallanNo: "H-100245",
            TotalBillAmount: "10027056"
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
      partycodelist: [
        { value: null, text: "Please select" },
        { value: "011091003", text: "011091003" },
        { value: "011091004", text: "011091004" },
        { value: "011091005", text: "011091005" },
        { value: "011091006", text: "011091006" }
      ],
      partynamelist: [
        { value: null, text: "Please select" },
        { value: "ABC Company", text: "ABC Company" },
        { value: "XYZ Pvt. Ltd.", text: "XYZ Pvt. Ltd." }
      ],
      approvalstatus: [
        { value: null, text: "Please select" },
        { value: "Approved", text: "Approved" },
        { value: "Not Approved", text: "Not Approved" }
      ],
      bankNameList: [
        { value: null, text: "Please select" },
        { value: "NRBC Bank", text: "NRBC Bank" },
        { value: "Pubali Bank", text: "Pubali Bank" },
        { value: "Standered Chartered Bank", text: "Standered Chartered Bank" },
        { value: "United Commarcial Bank", text: "United Commarcial Bank" },
        { value: "Eastern Bank", text: "Eastern Bank" }
      ],
      bankbrNameList: [
        { value: null, text: "Please select" },
        { value: "Agrabad", text: "Agrabad" },
        { value: "Sadar", text: "Sadar" },
        { value: "Port", text: "Port" }
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
