<template>
  <!-- BEGIN: Content-->
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card title>
            <div class="container col-md-12">
              <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                <br />
                <br />
                <b-row>
                  <b-col md="5">
                    <h2>Exam Attendance</h2>
                  </b-col>
                </b-row>
                <br/>
                <br/>
                <b-row>
                  <b-col md="1">
                    <p>Adv. No:</p>
                  </b-col>
                  <b-col md="2">
                    <b-form-select v-model="form.religion" :options="religion"></b-form-select>
                  </b-col>

                  <b-col md="1">
                    <p>Job</p>
                  </b-col>
                  <b-col md="2">
                    <b-form-select v-model="form.religion" :options="religion"></b-form-select>
                  </b-col>

                </b-row>

                <b-row style="float:right; margin:10px">
                  <b-button variant="secondary">Search</b-button>&nbsp;
                  <b-button variant="secondary">Print</b-button>
                </b-row>
                <br/>
                <br/>
                <br/>
<hr>
                <b-row>
                    <b-col md="2">
                    <p>Adv. No.</p>
                    </b-col>
                    <b-col md="10">
                    <p>
                        <b>09/2019</b>
                    </p>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col md="2">
                    <p>Job</p>
                    </b-col>
                    <b-col md="10">
                    <p>
                        <b>Asst. System Analist</b>
                    </p>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col md="2">
                    <p>Date</p>
                    </b-col>
                    <b-col md="10">
                    <p>
                        <b>Friday, 16/12/2019</b>
                    </p>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col md="2">
                    <p>Time</p>
                    </b-col>
                    <b-col md="10">
                    <p>
                        <b>9:30 AM</b>
                    </p>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col md="2">
                    <p>Location</p>
                    </b-col>
                    <b-col md="10">
                    <p>
                        <b>Chittagong College, Chittagong Port</b>
                    </p>
                    </b-col>
                </b-row>
              </b-form>
              <br />
              <br />
              <div>
                <b-table
                  striped
                  hover
                  show-empty
                  :items="items"
                  :current-page="currentPage"
                  :per-page="perPage"
                  :filter="filter"
                  :sort-by.sync="sortBy"
                  :sort-desc.sync="sortDesc"
                  :sort-direction="sortDirection"
                  :fields="fields"
                  responsive="sm"
                ></b-table>
              </div>
            </div>
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
      sortBy: "Date",
      sortDesc: false,
      fields: [
        { key: "SL", sortable: true },
        { key: "Roll", sortable: true },
        { key: "Room No", sortable: true },
        { key: "Name", sortable: true },
        { key: "Signature", sortable: true }
      ],
      items: [
        {
          SL: 1,
          Roll: 1,
          "Room No": "101",
          Name: "Morshed Khan",
          Signature: ""
        },
        {
          SL: 2,
          Roll: 2,
          "Room No": "102",
          Name: "Rashid Latif",
          Signature: ""
        },
        {
          SL: 3,
          Roll: 3,
          "Room No": "102",
          Name: "Tofael Ahmed",
          Signature: ""
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
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Online Recruitment"
    });
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Test Allocation"
    });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Attendance" });
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
