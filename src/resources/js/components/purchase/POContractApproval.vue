<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <b-button
              class="justify-content-left btn-outline-dark"
              lg="6"
              size="md"
              type="reset"
              href="/purchase/#/purchase-order"
            >
              <i class="bx bx-chevrons-left cursor-pointer"></i> Back
            </b-button>
            <br />
            <br />
            <b-card-text class="card-content">
              <div class="table-responsive">
                <h4>PO/Contract Number Approval Following Lines</h4>

                <b-table
                  bordered
                  striped
                  hover
                  show-empty
                  small
                  :items="tableDataApproval.items"
                  :current-page="currentPage"
                  er-page="perPage"
                  :filter="filter"
                  ort-by.sync="sortBy"
                  ort-desc.sync="sortDesc"
                  ort-direction="sortDirection"
                  :fields="tableDataApproval.fields"
                  responsive
                >
                  <template v-slot:cell(Status)="row">
                    <b-form-select v-model="selected" class>
                      <option value="Open">Open</option>
                      <option value="Close">Close</option>
                    </b-form-select>
                  </template>

                  <template v-slot:cell(Amount)="row">
                    <b-form-input
                      v-model="form.amt"
                      required
                      id="input-id"
                      type="text"
                      :value="amt"
                    ></b-form-input>
                  </template>
                </b-table>
              </div>
              <hr />
              <div class="invoice-subtotal pt-50">
                <div class="row">
                  <div class="col-md-5 col-12"></div>
                  <div class="col-lg-5 col-md-7 offset-lg-2 col-12">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                        <span class="invoice-subtotal-title">Total Amount:</span>
                        <h6 class="invoice-subtotal-value mb-0">200</h6>
                      </li>
                      <hr />
                      <li class="list-group-item border-0 pb-0">
                        <b-button
                          variant="dark"
                          class="btn btn-primary btn-block subtotal-preview-btn"
                        >Approve</b-button>
                      </li>
                    </ul>
                  </div>
                </div>
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
        amt: "200",
        financial_code: null,
        shift: null
      },
      show: true,
      updateIndex: -1,
      submitBtn: "Save",

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
            Contract: "Goods",
            ItemCode: "FA19883",
            ItemDescription: "Round table",
            Status: "",
            BudgetAccount: "12346854",
            Amount: "PCS"
          }
        ]
      },
      PerchasingMethodlist: [
        { value: null, text: "Please select" },
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
