<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Search Payment (Income Tax) Entry</h4>
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
                          <b-row>
                            <b-col lg="4">
                              <label>Section</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.Section"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Section"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                        </b-col>
                        <b-col lg="4">
                          <b-row>
                            <b-col lg="4">
                              <label>Voucher Date From</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <date-picker
                                v-model="form.datetime1"
                                width="100%"
                                input-class="form-control"
                                type="date"
                                lang="en"
                                format="YYYY-MM-DD"
                              ></date-picker>
                            </div>
                          </b-row>
                        </b-col>
                        <b-col lg="4">
                          <b-row>
                            <b-col lg="4">
                              <label>Date To</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <date-picker
                                v-model="form.datetime1"
                                width="100%"
                                input-class="form-control"
                                type="date"
                                lang="en"
                                format="YYYY-MM-DD"
                              ></date-picker>
                            </div>
                          </b-row>
                          <b-row class="mt-2 d-flex justify-content-end">
                            <b-button lg="6" size="md" class="btn-outline-dark" type="reset">
                              <i class="bx bx-search cursor-pointer"></i> Search
                            </b-button>
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
      this.$store.commit("setBreadcrumb", {link: "#", label: "Payment Income Tax Search"});
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
          { key: "VoucherNoRef", label: "Voucher No Ref", sortable: true },
          { key: "NaturalAccount", label: "Natural Account", sortable: true },
          { key: "SubAccount", label: "Sub Account", sortable: true },
          { key: "action", label: "View" }
        ],
        items: [
          {
            VoucherNoRef: "CW-123",
            NaturalAccount: "2140",
            SubAccount: "41040"
          }
        ]
      }
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
