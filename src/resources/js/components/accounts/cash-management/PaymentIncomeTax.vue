<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Payment (Income Tax)</h4>
              <div class="mt-2 d-flex justify-content-end">
                <b-button
                  lg="6"
                  size="md"
                  variant="dark"
                  type="submit"
                  href="/accounts/#/payment-income-tax-search"
                >
                  <i class="bx bx-search cursor-pointer"></i> Search
                </b-button>
              </div>
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
                              <label>Bill Register</label>
                            </b-col>
                            <b-col lg="8" class="form-group">

                                    <multiselect
                                        v-model="form.billreg"
                                        :options="billreg"
                                        :custom-label="nameWithLang"
                                        placeholder="Select one"
                                        label="text"
                                        track-by="name"
                                    ></multiselect>

                            </b-col>
                          </b-row>

                          <b-row>
                            <b-col lg="4">
                              <label>Voucher No</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.voucno"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Voucher No"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                          <b-row>
                            <b-col lg="4">
                              <label>Supplier Code</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.suppcode"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Supplier Code"
                              ></b-form-input>
                            </div>
                          </b-row>

                          <b-row>
                            <b-col lg="4">
                              <label>Status</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <multiselect
                                v-model="form.status"
                                :options="approvalstatus"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </div>
                          </b-row>
                          <b-row>
                            <b-col lg="4">
                              <label>Natural Accounts</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.natacc"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Natural Accounts"
                              ></b-form-input>
                            </div>
                          </b-row>
                          <b-row>
                            <b-col lg="4">
                              <label>Cheque No</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.chqno"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Cheque No"
                              ></b-form-input>
                            </div>
                          </b-row>
                        </b-col>
                        <b-col lg="6">
                          <b-row>
                            <b-col lg="4">
                              <label>Section</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.section"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Section"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                          <b-row>
                            <b-col lg="4">
                              <label>Voucher Date</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <date-picker
                                v-model="form.vouchDate"
                                width="100%"
                                input-class="form-control"
                                type="date"
                                lang="en"
                                format="YYYY-MM-DD"
                              ></date-picker>
                            </b-col>
                          </b-row>

                          <b-row>
                            <b-col lg="4">
                              <label>Supplier</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.supp"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Supplier"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <b-row>
                            <b-col lg="4">
                              <label>Description</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.desc"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Description"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <b-row>
                            <b-col lg="4">
                              <label>Remarks</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.remarks"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Remarks"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                          <b-row class="mt-2 d-flex justify-content-end">
                            <b-button lg="6" size="md" variant="dark" type="submit">Process</b-button>
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
                  ></b-table>
                </div>
              </b-card-text>

              <hr />
              <div class="invoice-subtotal pt-50">
                <div class="row">
                  <div class="col-md-5 col-12"></div>
                  <div class="col-lg-5 col-md-7 offset-lg-2 col-12">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                        <span class="invoice-subtotal-title">Total Amount:</span>
                        <h6 class="invoice-subtotal-value mb-0">5665</h6>
                      </li>
                      <li class="list-group-item border-0 pb-0">
                        <b-button
                          variant="dark"
                          class="btn btn-primary btn-block subtotal-preview-btn"
                        >Approve & Forword</b-button>
                      </li>
                    </ul>
                  </div>
                </div>
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
      this.$store.commit("setBreadcrumb", {link: "#", label: "Cash Management"});
      this.$store.commit("setBreadcrumb", {link: "#", label: "Payment Income Tax"});
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

      examCenter: [
        { key: "LineNo", label: "Line No", sortable: true },
        { key: "VoucherNoRef", label: "Voucher (# Ref)", sortable: true },
        { key: "VoucherDateRef", label: "Voucher Date  (# Ref)", sortable: true },
        { key: "NaturalAccount", label: "Natural Account", sortable: true },
        { key: "SubAccount", label: "Sub Account", sortable: true },
        { key: "Amount", label: "Amount", sortable: true },
          { key: "Remarks", label: "Remarks", sortable: true },
        "Action"
      ],
      education: [
        {
          LineNo: "",
          VoucherNoRef: "",
          VoucherDateRef: "",
          NaturalAccount: "",
          SubAccount: "",
          Amount: "",
            Remarks:"",
          Action: ""
        }
      ],
      tableData: {
        fields: [
          { key: "LineNo", label: "Line No" },
          { key: "VoucherNoRef", label: "Voucher No (#Ref)" },
          { key: "VoucherDateRef", label: "Voucher Date (#Ref)" },
          { key: "NaturalAccount", label: "Natural Account" },
          { key: "SubAccount", label: "Sub Account" },
          { key: "Amount", label: "Amount" },
            { key: "Remarks", label: "Remarks"}
        ],
        items: [
          {
            LineNo: "1",
            VoucherNoRef: "CW-123",
            VoucherDateRef: "25-09-19",
            NaturalAccount: "2140",
            SubAccount: "41040",
            Amount: "5665",
              Remarks:""
          },
          {
            LineNo: "--",
            VoucherNoRef: "--",
            VoucherDateRef: "--",
            NaturalAccount: "--",
            SubAccount: "--",
            Amount: "--"
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

        billreg: [

            { value: "Bill Revenue", text: "Bill Revenue" },
            { value: "Capital expenditure", text: "Capital Expenditure" }
        ],
      approvalstatus: [
        { value: null, text: "Please select" },
        { value: "Approved", text: "Approved" },
        { value: "In Process", text: "In Process" }
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
