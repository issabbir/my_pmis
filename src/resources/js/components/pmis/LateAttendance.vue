<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Late Attendance</h4>
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
                        <b-col  md="4">
                            <b-row>
                                <b-col md="3">
                                 <label>Date</label>
                                </b-col>
                                <b-col md="9" class="form-group">
                                 <date-picker
                                   v-model="form.datetimechln"
                                   width="100%"
                                   input-class="form-control"
                                   type="date"
                                   lang="en"
                                   format="YYYY-MM-DD"
                                 ></date-picker>
                                </b-col>
                            </b-row>
                        </b-col>
                       
                        <b-col  md="4">
                           <b-row>
                                <b-col lg="3">
                                  <label>Department</label>
                                </b-col>
                                <b-col lg="9" class="form-group">
                                  <b-form-select v-model="form.department" :options="department"></b-form-select>
                                </b-col>
                          </b-row>
                        </b-col>
                        
                        <b-col  md="4">
                            <b-row>
                                <b-col lg="3">
                                  <label>Status</label>
                                </b-col>
                                <b-col lg="9" class="form-group">
                                  <b-form-select v-model="form.status" :options="status"></b-form-select>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    
                    <b-row>
                        <b-col  md="4">
                           <b-row>
                                <b-col lg="3">
                                  <label>Job Title</label>
                                </b-col>
                                <b-col lg="9" class="form-group">
                                  <b-form-select v-model="form.title" :options="title"></b-form-select>
                                </b-col>
                          </b-row>
                        </b-col>
                        
                        <b-col  md="4">
                            <b-row>
                                <b-col lg="3">
                                  <label>Section</label>
                                </b-col>
                                <b-col lg="9" class="form-group">
                                  <b-form-select v-model="form.section" :options="section"></b-form-select>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-row class="mt-1">
                        <b-col class="d-flex justify-content-end">
                          <b-button md="6" size="md" type="submit" variant="dark">Search</b-button>&nbsp;
                          <b-button class="btn-outline-dark" md="6" size="md" type="reset">Cancel</b-button>
                        </b-col>
                      </b-row>
                    
                    
            <!---b-row>
                    <b-col>
                      <b-row>
                        <b-col lg="6">
                          <b-row>
                            <b-col lg="4">
                              <label>Date</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <date-picker
                                v-model="form.datetimechln"
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
                              <label>Status</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-select v-model="form.status" :options="status"></b-form-select>
                            </b-col>
                          </b-row>

                          <b-row>
                            <b-col lg="4">
                              <label>Section</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-select v-model="form.section" :options="section"></b-form-select>
                            </b-col>
                          </b-row>
                        </b-col>
                        <b-col lg="6">
                          <b-row>
                            <b-col lg="4">
                              <label>Department</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-select v-model="form.department" :options="department"></b-form-select>
                            </b-col>
                          </b-row>

                          <b-row>
                            <b-col lg="4">
                              <label>Job Title</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-select v-model="form.title" :options="title"></b-form-select>
                            </b-col>
                          </b-row>
                          <b-row class="mt-3">
                            <b-col class="d-flex justify-content-end">
                              <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button>&nbsp;
                            </b-col>
                          </b-row>
                        </b-col>
                      </b-row>
                    </b-col>
                  </b-row--->
                    
  

                  <!--</fieldset>-->
                </b-form>
              </div>
            </b-card-text>
          </b-card>
        </b-col>
      </b-row>
      <b-card>
        <b-card-text>
          <!--b-table striped hover :items="items"></b-table-->

          <Datatable
            v-bind:fields="tableDataLateAtt.fields"
            v-bind:items="tableDataLateAtt.items"
            v-bind:pageColSize="4"
            v-bind:searchColSize="5"
          >
            <template v-slot:actions="{ rows }">
              <b-form-checkbox></b-form-checkbox>
            </template>

            <template v-slot:action2="{ rows }">
              <b-form-input v-model="position"></b-form-input>
            </template>
          </Datatable>
        </b-card-text>
      </b-card>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import DatePicker from "vue2-datepicker";
import Datatable from "../../layouts/common/datatable";

export default {
  components: {
    Multiselect,
    DatePicker,
    Datatable
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
      tableDataLateAtt: {
        fields: [
          { key: "Emp_Id", sortable: true },
          { key: "Name", sortable: true },
          { key: "Department", sortable: true },
          { key: "Designation", sortable: true },
          { key: "Status", sortable: true },
          { key: "In_time", sortable: true },
          { key: "Last_Day_Out_Time", sortable: true },
          { key: "Total_Late_Nov_19", sortable: true }
        ],

        items: [
          {
            Emp_Id: "50002",
            Name: "Mr Karim",
            Department: "Computer Center",
            Designation: "Sr. Computer operator",
            Status: "Officer",
            In_time: "9:40 AM",
            Last_Day_Out_Time: "5:10 PM",
            Total_Late_Nov_19: "5"
          },
          {
            Emp_Id: "50015",
            Name: "Mr Rana",
            Department: "Computer Center",
            Designation: "Sr. Computer operator",
            Status: "Officer",
            In_time: "9:40 AM",
            Last_Day_Out_Time: "5:10 PM",
            Total_Late_Nov_19: "3"
          },
          {
            Emp_Id: "50023",
            Name: "Mr Razib",
            Department: "Computer Center",
            Designation: "Sr. Computer operator",
            Status: "Officer",
            In_time: "9:40 AM",
            Last_Day_Out_Time: "5:10 PM",
            Total_Late_Nov_19: "7"
          }
        ]
      },
      form: {
        status: null,
        section: null,
        department: null,
        title: null
      },
      show: true,
      updateIndex: -1,
      submitBtn: "Save",
      status: [
        { text: "All", value: null },
        { text: "Officer", value: "Officer" },
        { text: "Staff", value: "Staff" }
      ],
      department: [
        { text: "All", value: null },
        { text: "Administration", value: "Administration" },
        { text: "Secratariat", value: "Secratariat" }
      ],
      title: [
        { text: "All", value: null },
        { text: "Personal Officer", value: "PersonalOfficer" },
        { text: "Computer Oparator", value: "ComputerOparator" }
      ],
      section: [
        { text: "All", value: null },
        { text: "Dummy Data", value: "DummyData" },
        { text: "Dummy Data", value: "DummyData" }
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
