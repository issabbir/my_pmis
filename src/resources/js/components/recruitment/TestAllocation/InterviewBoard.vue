<template>
  <!-- BEGIN: Content-->
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card title="Interview Board">
            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
              <b-row>
                <b-col>
                  <b-row class="my-1">
                    <b-col md="3">
                      <label>Job Title</label>
                    </b-col>
                    <b-col md="9">
                      <b-form-select v-model="form.religion" :options="religion"></b-form-select>
                    </b-col>
                  </b-row>
                </b-col>
                <b-col>
                  <b-row class="my-1">
                    <b-col md="3">
                      <label>Board No.</label>
                    </b-col>
                    <b-col md="9">
                      <b-form-input v-model="form.fatherName" type="text" placeholder="Board No."></b-form-input>
                    </b-col>
                  </b-row>
                </b-col>
                <b-col>
                  <b-row class="my-1">
                    <b-col md="3">
                      <label>Board Name</label>
                    </b-col>
                    <b-col md="9">
                      <b-form-input v-model="form.fatherName" type="text" placeholder="Board Name"></b-form-input>
                    </b-col>
                  </b-row>
                </b-col>
              </b-row>
              <b-row>
                <b-col md="4">
                  <b-row class="my-1">
                    <b-col md="3">
                      <label>Board Member</label>
                    </b-col>
                    <b-col md="9">
                      <b-form-select v-model="form.religion" :options="religion"></b-form-select>
                    </b-col>
                  </b-row>
                </b-col>
                <b-col md="4">

                </b-col>
              </b-row>
              <b-row class="d-flex justify-content-end">
                <b-button variant="secondary">Submit</b-button>&nbsp;
                <b-button variant="secondary">Reset</b-button>
              </b-row>
            </b-form>
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
                  <template v-slot:cell(action)="row">
                    <b-button size="sm" class="mr-2">Apply Online</b-button>
                  </template>
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
        { key: "Job Title", sortable: true },
        { key: "Interview Board", sortable: true }
      ],
      items: [
        {
          SL: 1,
          "Job Title": "Asst. System Analist",
          "Interview Board": "Board 11"
        },
        {
          SL: 2,
          "Job Title": "Asst. Software Engineer",
          "Interview Board": "Board 12"
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
            this.$store.commit("setBreadcrumb", { link: "#", label: "Online Recruitment"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Test Allocation"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Interview Board" });
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
