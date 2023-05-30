<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Set Up Budgetary Control</h4>
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
                          <!-- Control Budget Filter -->
                          <b-row>
                            <b-col lg="4">
                              <label>Control Budget Filter</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-checkbox
                                id="checkbox-1"
                                v-model="status"
                                name="checkbox-1"
                                value="accepted"
                                unchecked-value="not_accepted"
                              >
                                <p>Enable Budgetry Control for the Ledger of All journals</p>
                              </b-form-checkbox>
                            </b-col>
                          </b-row>

                          <!-- Projects -->
                          <b-row>
                            <b-col lg="4">
                              <label></label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-checkbox
                                id="checkbox-2"
                                v-model="status1"
                                name="checkbox-2"
                                value="accepted"
                                unchecked-value="not_accepted"
                              >Projects</b-form-checkbox>
                            </b-col>
                          </b-row>

                          <!-- Disabled -->
                          <b-row>
                            <b-col lg="4">
                              <label></label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-checkbox
                                id="checkbox-3"
                                v-model="status2"
                                name="checkbox-3"
                                value="accepted"
                                unchecked-value="not_accepted"
                              >Disabled</b-form-checkbox>
                            </b-col>
                          </b-row>

                          <!-- Enable Encumbrance Accounting -->
                          <b-row>
                            <b-col lg="4">
                              <label></label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-checkbox
                                id="checkbox-4"
                                v-model="status3"
                                name="checkbox-4"
                                value="accepted"
                                unchecked-value="not_accepted"
                              >Enable Encumbrance Accounting</b-form-checkbox>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="4">
                          <!-- Encumbrance Accounting -->
                          <b-row>
                            <b-col lg="4">
                              <label>Encumbrance Accounting</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.EncumbranceAccounting"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Encumbrance Accounting"
                              ></b-form-input>
                            </div>
                          </b-row>

                          <!-- Search Button -->
                          <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                              <b-button lg="6" size="md" class="btn-outline-dark" type="reset">Save</b-button>
                            </b-col>
                          </b-row>
                        </b-col>
                      </b-row>
                    </b-col>
                  </b-row>
                </b-form>
              </div>
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
                  <template v-slot:cell(Enable)="row">
                    <b-form-checkbox
                      id="checkbox-6"
                      v-model="status6"
                      name="checkbox-6"
                      value="accepted"
                      unchecked-value="not_accepted"
                    ></b-form-checkbox>
                  </template>
                </b-table>
              </div>
            </b-card-text>
          </b-card>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
export default {
  components: {},
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
      form: {},
      show: true,
      updateIndex: -1,

      tableData: {
        fields: [
          { key: "Journal", label: "Journal", sortable: true },
          { key: "JournalCategory", label: "Journal Category", sortable: true },
          { key: "Enable", label: "Enable" },
          { key: "EnableDate", label: "Enable Date", sortable: true },
          { key: "EnableDate", label: "Enable Date", sortable: true },
          { key: "DisableDate", label: "Disable Date", sortable: true }
        ],
        items: [
          {
            Journal: 1,
            JournalCategory: 1,
            Enable: "",
            EnableDate: 1,
            EnableDate: 1,
            DisableDate: 1
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
