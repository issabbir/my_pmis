<template>
  <!-- BEGIN: Content-->
  <div class="content-wrapper">
    <div class="content-body applicationProfile">
      <b-row>
        <b-col>
          <b-card title>
            <legend class="w-auto">Employee Details</legend>
            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
              <b-row>
                <b-col>
                  <b-row class="my-3">
                    <b-col md="2" class="mr-2">
                      <img
                        width="200px"
                        height="100%"
                        :src="'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiOBcnv1xTyyjyIJnuPx6pfkG1ay_7qzdMZdjPAVnBGwTBmInF&s'"
                      />
                    </b-col>
                  </b-row>
                </b-col>
              </b-row>
            </b-form>
            <b-card no-body>
              <b-form @submit="onSubmit" @reset="onReset" v-if="show">

                <b-row>
                  <b-col md="5" class="mb-2">
                    <h4>Basic Info</h4>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">
                    <p>Employee Code</p>
                  </b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>
                <b-row>
                  <b-col md="2">
                    <p>Salutation</p>
                  </b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>
                <b-row>
                  <b-col md="2">Full Name</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>
                <b-row>
                  <b-col md="2">Full Name Bangla</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>
                <b-row>
                  <b-col md="2">Father Name</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Father Name Bangla</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Mother Name</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Mother Name Bangla</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Blood Group</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Date of Birth</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Age</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">LPR Date</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Gender</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Marital Status</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Nationality</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Religion</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Identity Symbol</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Identity Symbol Bangla</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Active</b-col>
                  <b-col md="10">
                    <p>
                      <b>DummyData</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="5" class="mb-2">
                    <h4>Present Address</h4>
                  </b-col>
                </b-row>



                <b-row>
                  <b-col md="2">Village</b-col>
                  <b-col md="10">
                    <p>
                      <b>-</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Post Office</b-col>
                  <b-col md="10">
                    <p>
                      <b>Mirpur</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Post Code</b-col>
                  <b-col md="10">
                    <p>
                      <b>1216</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Thana</b-col>
                  <b-col md="10">
                    <p>
                      <b>Mirpur</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">District</b-col>
                  <b-col md="10">
                    <p>
                      <b>Dhaka</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Division</b-col>
                  <b-col md="10">
                    <p>
                      <b>Dhaka</b>
                    </p>
                  </b-col>
                </b-row>
                <br />

                <b-row>
                  <b-col md="5" class="mb-2">
                    <h4>Desired Employment</h4>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Internal Candidate</b-col>
                  <b-col md="10">
                    <p>
                      <b>No</b>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col md="2">Quata</b-col>
                  <b-col md="10">
                    <p>
                      <b>Freedom Fighter</b>
                    </p>
                  </b-col>
                </b-row>
                <br />
              </b-form>
              <b-tabs card>
                <b-tab title="Experience & Education">
                  <h4>Experiences</h4>
                  <b-table
                    striped
                    hover
                    show-empty
                    :items="items_1"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
                    :fields="fields_1"
                    responsive="sm"
                  ></b-table>
                  <br />
                  <h4>Education</h4>
                  <b-table
                    striped
                    hover
                    show-empty
                    :items="items_2"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
                    :fields="fields_2"
                    responsive="sm"
                  ></b-table>
                </b-tab>
                <b-tab title="Payment">
                  <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                    <b-row>
                      <b-col md="5" class="mb-2">
                        <h4>Payment Information</h4>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Bank Name</b-col>
                      <b-col md="10">
                        <p>
                          <b>Sonali bank Limited</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Branch Name</b-col>
                      <b-col md="10">
                        <p>
                          <b>Agrabad Branch</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Amount</b-col>
                      <b-col md="10">
                        <p>
                          <b>500/-</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">BD Number</b-col>
                      <b-col md="10">
                        <p>
                          <b>SB-BD-20191019002</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">BD Date</b-col>
                      <b-col md="10">
                        <p>
                          <b>19/10/2019</b>
                        </p>
                      </b-col>
                    </b-row>
                    <br />
                  </b-form>
                </b-tab>
              </b-tabs>
            </b-card>
          </b-card>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import DatePicker from "vue2-datepicker";
import Datatable from "../../layouts/common/datatable";
import ApiRepository from "../../Repository/ApiRepository";

export default {
  components: {
    Multiselect,
    DatePicker
  },
  props: ["id"],
  mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", { link: "#", label: "Administration" });
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Employee Position"
    });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Department" });
    this.employeeDetails(this.id);
  },
  data() {
    return {
      form: {
        section: null,
        department: null,
        title: null
      },
      // mainProps: { width: 150, height: 150, class: 'm1' },
      show: true,
      updateIndex: -1,
      submitBtn: "Save",
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
    employeeDetails(id) {
      ApiRepository.callApi(
        ApiRepository.GET_COMMAND,
        "/pmis/details-records/" + id
      ).then(res => {
        console.log(res.data);
      });
    },
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
