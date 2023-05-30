<template>
  <!-- BEGIN: Content-->
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card title="Scheduling">
            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
              <b-row>
                <b-col>
                  <b-row class="my-1">
                    <b-col md="3">
                      <label>Adv No.</label>
                    </b-col>
                    <b-col md="9">
                      <b-form-input v-model="form.fatherName" type="text" placeholder="Adv. No"></b-form-input>
                    </b-col>
                  </b-row>
                </b-col>
                <b-col>
                  <b-row class="my-1">
                    <b-col md="3">
                      <label>Date Time</label>
                    </b-col>
                    <b-col md="9">
                      <date-picker
                        v-model="pubdate"
                        width="100%"
                        input-class="form-control"
                        type="date"
                        lang="en"
                        format="YYYY-MM-DD"
                      ></date-picker>
                    </b-col>
                  </b-row>
                </b-col>
                <b-col>
                  <b-row class="my-1">
                    <b-col md="3">
                      <label>Exam Type</label>
                    </b-col>
                    <b-col md="9">
                      <b-form-select v-model="form.religion" :options="examtyp"></b-form-select>
                    </b-col>
                  </b-row>
                </b-col>
              </b-row>
              <br/>
              <br/>

                <b-row>
                    <b-col>
                        <fieldset class="border p-2">
                            <legend class="w-auto" style="font-size:18px;">Exam Center Allocation</legend>
                            <b-table bordered hover :items="education" :fields="examCenter">
                                <template v-slot:cell(ExamCenter)="row">
                                        <b-form-input id="examCenter" v-model="form.examCenter" placeholder="Chittagong College"></b-form-input>
                                </template>
                                <template v-slot:cell(RollFrom)="row">
                                        <b-form-input id="rollFrom" v-model="form.rollFrom" placeholder="1001"></b-form-input>
                                </template>
                                <template v-slot:cell(To)="row">
                                        <b-form-input id="To" v-model="form.To" placeholder="1725"></b-form-input>
                                </template>
                                <template v-slot:cell(action)="row">
                                        <b-button size="sm"  class="mr-2"> Add </b-button>
                                </template>
                            </b-table>
                            </fieldset>
                    </b-col>
                </b-row>
                <br/>
              <b-row class="d-flex justify-content-end">
                <b-button variant="secondary">Submit</b-button>&nbsp;
                <b-button variant="secondary">Reset</b-button>
              </b-row>
            </b-form>
            <br>
            <br>
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
                >

                </b-table>
              </div>
          </b-card>
        </b-col>
      </b-row>
    </div>
  </div>

  <!-- END: Content-->
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
        { key: "Adv.No.", sortable: true },
        { key: "Job Title", sortable: true },
        { key: "Date", sortable: true },
        { key: "Time", sortable: true },
        { key: "Roll", sortable: true },
        { key: "Total Candidate", sortable: true }
      ],
      items: [
        {
          SL: 1,
          "Adv.No.": "09/2019",
          "Job Title": "Asst. System Analist",
          Date: "20 SEP 2019",
          Time: "10:00 AM",
          Roll: "10 to 35",
          "Total Candidate": "20"
        },
        {
          SL: 2,
          "Adv.No.": "09/2019",
          "Job Title": "Asst. Programmer",
          Date: "20 SEP 2019",
          Time: "11:00 AM",
          Roll: "105 to 200",
          "Total Candidate": "70"
        }
      ],

      appDeadline: new Date(),
      pubdate: new Date(),
      quota: "not_accepted",
      form: {
        email: "",
        name: "",
        food: null,
        examtyp: null,
        checked: []
      },
      examtyp: [
                    { text: 'Viva', value: 'Viva' },
                    { text: 'Written', value: 'Written' }
               ],
      selected: null,
      examCenter : ['ExamCenter','RollFrom','To','action'],
      education: [
                      { 'ExamCenter': 'Chittagong College', RollFrom: '1001', To: '1725' },
                    ],
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
                    this.$store.commit("setBreadcrumb", { link: "#", label: "Online Recruitment"});
                    this.$store.commit("setBreadcrumb", { link: "#", label: "Test Allocation"});
                    this.$store.commit("setBreadcrumb", { link: "#", label: "Scheduling" });
                    this.totalRows = this.items.length
   },
  methods: {
    formSubmitted() {
      alert("Form submitted!");
    },
    onSubmit(evt) {
      evt.preventDefault();
      alert(JSON.stringify(this.form));
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
