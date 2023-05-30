<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Enter User</h4>
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
                          <!-- Employee -->
                          <b-row>
                            <b-col lg="4">
                              <label>Employee</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.BudgetYear"
                                :options="BudgetYearList"
                                label="text"
                                track-by="name"
                                :show-labels="false"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Section -->
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
                                readonly
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Pay Grade -->
                          <b-row>
                            <b-col lg="4">
                              <label>Pay Grade</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.PayGrade"
                                required
                                id="input-id"
                                type="text"
                                readonly
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- User Type -->
                          <b-row>
                            <b-col lg="4">
                              <label>User Type</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.UserType"
                                required
                                id="input-id"
                                type="text"
                                readonly
                              ></b-form-input>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="4">
                          <!-- Member Department -->
                          <b-row>
                            <b-col lg="4">
                              <label>Member Department</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.Remarks"
                                required
                                id="input-id"
                                type="text"
                                readonly
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Designation -->
                          <b-row>
                            <b-col lg="4">
                              <label>Designation</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.Designation"
                                required
                                id="input-id"
                                type="text"
                                readonly
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- User Password -->
                          <b-row>
                            <b-col lg="4">
                              <label>User Password</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.UserPassword"
                                required
                                id="input-id"
                                type="text"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <b-row>
                            <b-col lg="4">
                              <b-form-radio name="radio-size" size="sm">Restricted</b-form-radio>
                            </b-col>
                            <b-col lg="4">
                              <b-form-radio name="radio-size" size="sm">Not Restricted</b-form-radio>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="4">
                          <!-- Department -->
                          <b-row>
                            <b-col lg="4">
                              <label>Department</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.Department"
                                required
                                id="input-id"
                                type="text"
                                readonly
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Pay Scale -->
                          <b-row>
                            <b-col lg="4">
                              <label>Pay Scale</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.PayScale"
                                required
                                id="input-id"
                                type="text"
                                readonly
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Retype Password -->
                          <b-row>
                            <b-col lg="4">
                              <label>Retype Password</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.RetypePassword"
                                required
                                id="input-id"
                                type="text"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <br />
                          <br />
                          <br />

                          <!-- Search Button -->
                          <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                              <b-button
                                lg="6"
                                size="md"
                                class="btn-outline-dark"
                                type="reset"
                                v-on:click="isHidden = !isHidden"
                              >
                                <i class="bx bx-save cursor-pointer"></i> Save
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
        financial_code: null,
        shift: null
      },
      show: true,
      updateIndex: -1,
      submitBtn: "Save",

      p_ministrial_yn_options: [
        { text: "Yes", value: "y" },
        { text: "No", value: "n" }
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
