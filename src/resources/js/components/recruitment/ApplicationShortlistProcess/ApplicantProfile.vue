<template>
  <!-- BEGIN: Content-->
  <div class="content-wrapper">
    <div class="content-body applicationProfile">
      <b-row>
        <b-col>
          <b-card title>
            <legend class="w-auto">Job Circular</legend>
            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
              <b-row>
                <b-col>
                  <b-row class="my-1">
                    <b-col md="2" class="mr-2">
                         <img width="200px" height="100%" :src="'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiOBcnv1xTyyjyIJnuPx6pfkG1ay_7qzdMZdjPAVnBGwTBmInF&s'" />
                     </b-col>
                    <b-col md="3">
                      <h5>Biplob Sarker</h5>
                      <br />
                      <p>+8801625416989</p>
                      <p>sarker@yahoo.com</p>
                      <p>H#112,F#9B,R#114</p>
                      <p>Halisahor, Chittagong</p>
                    </b-col>
                  </b-row>
                </b-col>
              </b-row>
            </b-form>
            <b-card no-body>
              <b-tabs card>
                <b-tab title="General Info" active>
                  <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                    <b-row class="mb-2">
                      <b-col md="5">
                        <h4>Candidate Information</h4>
                      </b-col>
                    </b-row>
                    <b-row>
                      <b-col md="2">
                        <p>Applicant Id</p>
                      </b-col>
                      <b-col md="10">
                        <p>
                          <b>ASA-003</b>
                        </p>
                      </b-col>
                    </b-row>
                    <b-row>
                      <b-col md="2">
                        <p>Full Name</p>
                      </b-col>
                      <b-col md="10">
                        <p>
                          <b>Biplob Sarker</b>
                        </p>
                      </b-col>
                    </b-row>
                    <b-row>
                      <b-col md="2">Gender</b-col>
                      <b-col md="10">
                        <p>
                          <b>Male</b>
                        </p>
                      </b-col>
                    </b-row>
                    <b-row>
                      <b-col md="2">Relegion</b-col>
                      <b-col md="10">
                        <p>
                          <b>Islam</b>
                        </p>
                      </b-col>
                    </b-row>
                    <b-row>
                      <b-col md="2">Date of Birth</b-col>
                      <b-col md="10">
                        <p>
                          <b>01/12/1989</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Age of 20/11/2019</b-col>
                      <b-col md="10">
                        <p>
                          <b>38</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">National ID</b-col>
                      <b-col md="10">
                        <p>
                          <b>568546689233</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Mobile Number</b-col>
                      <b-col md="10">
                        <p>
                          <b>+8801625416989</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Email</b-col>
                      <b-col md="10">
                        <p>
                          <b>sarker@yahoo.com</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Marital Status</b-col>
                      <b-col md="10">
                        <p>
                          <b>Married</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Nationality</b-col>
                      <b-col md="10">
                        <p>
                          <b>Bangladeshi</b>
                        </p>
                      </b-col>
                    </b-row>
                    <br />
                    <b-row>
                      <b-col md="5" class="mb-2">
                        <h3>Candidate Address</h3>
                        <br />
                        <h4>Permanent Address</h4>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Address</b-col>
                      <b-col md="10">
                        <p>
                          <b>H#112,F#9B,R#114</b>
                        </p>
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
                          <b>Halisahor</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Post Code</b-col>
                      <b-col md="10">
                        <p>
                          <b>1521</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Thana</b-col>
                      <b-col md="10">
                        <p>
                          <b>Agrabad</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">District</b-col>
                      <b-col md="10">
                        <p>
                          <b>Chittagong</b>
                        </p>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Division</b-col>
                      <b-col md="10">
                        <p>
                          <b>Chittagong</b>
                        </p>
                      </b-col>
                    </b-row>
                    <br />

                    <b-row>
                      <b-col md="5" class="mb-2">
                        <h4>Present Address</h4>
                      </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="2">Address</b-col>
                      <b-col md="10">
                        <p>
                          <b>H#967(1st Floor), R#15, DOHS Mirpur</b>
                        </p>
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
                </b-tab>
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
import DatePicker from "vue2-datepicker";
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
export default {
  data() {
    return {
      sortBy: "SL",
      sortDesc: false,
      fields_1: [
        { key: "Organization", sortable: true },
        { key: "Position", sortable: true },
        { key: "Start Date", sortable: true },
        { key: "End Date", sortable: true }
      ],
      items_1: [
        {
          Organization: "CNS Limited",
          Position: "Sr. Programmer",
          "Start Date": "01/2014",
          "End Date": "12/2018"
        },
        {
         Organization: "ABC Limited",
          Position: "Programmer",
          "Start Date": "01/2011",
          "End Date": "12/2013"
        },
        {
          Organization: "XYZ Limited",
          Position: "Jr. Programmer",
          "Start Date": "01/2009",
          "End Date": "12/2012"
        }
      ],

      fields_2: [
        { key: "Exam", sortable: true },
        { key: "Subject", sortable: true },
        { key: "Exam Body", sortable: true },
        { key: "Passing Year", sortable: true },
        { key: "Result", sortable: true }
      ],
      items_2: [
        {
          Exam: "B. Sc(Hons.)",
          Subject: "Computer Science",
          "Exam Body": "University of Dhaka",
          "Passing Year": "2009",
          Result: "3.55"
        },
        {
         Exam: "HSC",
          Subject: "Science",
          "Exam Body": "Chittagong Board",
          "Passing Year": "2002",
          Result: "5.00"
        },
        {
          Exam: "SCC",
          Subject: "Science",
          "Exam Body": "Chittagong Board",
          "Passing Year": "2000",
          Result: "5.00"
        }
      ],

      appDeadline: new Date(),
      pubdate: new Date(),
      quota: "not_accepted",
      form: {
        email: "",
        name: "",
        food: null,
        checked: []
      },
      selected: null,
      oadvertismntNo: [{ value: null, text: "07/2009" }],
      selected: null,
      sdepartmntName: [
        { value: null, text: "Select" },
        { value: 1, text: "Computer Center" },
        { value: 2, text: "Administration" }
      ],
      selected: null,
      stitle: [
        { value: null, text: "Select" },
        { value: 1, text: "Assistant System Analyst" },
        { value: 2, text: "Senior Computer Operator" }
      ],
      selected: null,
      sconcerndPerson: [
        { value: null, text: "Select" },
        { value: 1, text: "Waker Khan" }
      ],
      spaygrade: [
        { value: null, text: "Select" },
        { value: 1, text: "01" },
        { value: 2, text: "02" }
      ],
      sgarde: [{ value: null, text: "Select" }],
      show: true
    };
  },
  mounted() {
    this.$store.commit("setBreadcrumbEmpty"); 
    this.$store.commit("setBreadcrumb", { link: "#", label: "Online Recruitment" });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Application Shotlist" });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Apllicant Profile" });
    this.totalRows = this.items.length;
  },
  methods: {
    formSubmitted() {
      //alert("Form submitted!");
    },
    onSubmit(evt) {
      evt.preventDefault();
      //alert(JSON.stringify(this.form));
    },
    onReset(evt) {
      evt.preventDefault();
      // Reset our form values
      this.form.email = "";
      this.form.name = "";
      this.form.food = null;
      this.form.checked = [];
      // Trick to reset/clear native browser form validation state
      this.show = false;
      this.$nextTick(() => {
        this.show = true;
      });
    }
  },
  components: {
    FormWizard,
    DatePicker,
    TabContent
  }
};
</script>


<style  scope>
.applicationProfile p {
  line-height: 14px;
}
</style>
