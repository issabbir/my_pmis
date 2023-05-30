<template>
  <!-- BEGIN: Content-->
  <div class="content-wrapper">
    <div class="content-body admitCard">
      <b-row>
        <b-col md="8">
          <b-card title>
            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
              <b-row class="my-1">
                <b-col md="2">
                  <img
                    width="150px"
                    height="100%"
                    :src="'data:image/jpeg;base64,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'"
                  />
                </b-col>
                <b-col md="8" align="center">
                  <h3>Chittagong Port Authority</h3>
                  <p>Bandor Bhaban,Chattogram-4100</p>
                  <p>www.cpa.gov.bd</p>
                </b-col>

                <b-col md="2" align="right">
                  <p>
                    <b>Registered</b>
                  </p>
                </b-col>
              </b-row>

              <br />
              <br />
              <b-row class="my-1">
                <b-col md="4">
                    <table style="width:100%">
                        <tr>
                            <th class="pb-1">Roll no:</th>
                            <td class="pb-1">1</td>
                        </tr>
                        <tr>
                            <th class="pb-1">Applicant Id:</th>
                            <td class="pb-1">ASA-003</td>
                        </tr>
                        <tr>
                            <th class="pb-1">No :</th>
                            <td class="pb-1">19.07.0000.181.11.81.0007</td>
                        </tr>
                    </table>
                </b-col>
              </b-row>

              <br />
              <br />

              <b-row class="my-1">
                <b-col md="7">
                  <p><b>Sender:</b></p>
                  <p>Chief Personal Officer</p>
                  <p>Chittagong Port Authority</p>
                  <p>Chattogram-4100</p>
                </b-col>

                <b-col md="2" align="left">
                  <p><b>Date: 01/01/2019</b></p>
                  <p><b>Receiver:</b><p>
                  <p>Ridoy Khan</p>
                  <p>Son Of Ripon khan</p>
                  <p>H#112,F#98,R#114</p>
                  <p>Halishahor,Chittagong</p>
                </b-col>
                <b-col md="3" align="left">
                  <img
                    width="200px"
                    height="100%"
                    :src="'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiOBcnv1xTyyjyIJnuPx6pfkG1ay_7qzdMZdjPAVnBGwTBmInF&s'"
                  />
                </b-col>
              </b-row>

              <br />
              <br />
              <b-row class="my-1">
                <b-col md="3"></b-col>
                <b-col md="6" align="center">
                  <h5 style="text-decoration: underline;letter-spacing: 1px;font-weight:600">Subject: Written test for Asst. System Analist.</h5>
                </b-col>
              </b-row>
              <b-row class="my-1">
                <b-col>
                  <p>You are invited to sit for a written exam for the position of Asst. System Analist for CPA according to your application. The details is listed below:</p>
                </b-col>
                <br />
                <br />
              </b-row>
              <b-row class="my-1">
                <b-col md="4">
                    <table style="width:100%;border-collapse: collapse;">
                        <tr>
                            <th class="pb-1">Date:</th>
                            <td class="pb-1">Friday, 16/12/2019</td>
                          </tr>

                        <tr>
                             <th class="pb-1">Time:</th>
                             <td class="pb-1">9:30 AM</td>
                         </tr>
                        <tr>
                              <th class="pb-1">Location:</th>
                              <td class="pb-1">Bandor College, Chittagong Port</td>
                        </tr>
                    </table>
                </b-col>
              </b-row>

              <br />
              <br />
              <br />
              <b-row class="my-1">
                <b-col md="11">
                  <p><b>Instractions:</b></p>
                  <p>1. Your supervisor should let you know who your examiners will be as it is important that you ensure you are familiar with their work and any particular approach that they may take when examining your thesis.</p>
                  <p>2. Your supervisor should let you know who your examiners will be as it is important that you ensure you are familiar with their work and any particular approach that they may take when examining your thesis.</p>
                  <p>3. Your supervisor should let you know who your examiners will be as it is important that you ensure you are familiar with their work and any particular approach that they may take when examining your thesis.</p>
                  <p>4. Your supervisor should let you know who your examiners will be as it is important that you ensure you are familiar with their work and any particular approach that they may take when examining your thesis.</p>
                  <p>5. Your supervisor should let you know who your examiners will be as it is important that you ensure you are familiar with their work and any particular approach that they may take when examining your thesis.</p>
                </b-col>
              </b-row>
                <br />
              <br />

               <b-row class="my-1 d-flex justify-content-end">
                <b-col md="4">
                  <div class="text-center">
                      <img
                        width="200px"
                        height="200px"
                        :src="'https://mir-s3-cdn-cf.behance.net/project_modules/disp/94e6e19301171.560cc16302799.jpg'"
                    />
                    <p>Chief Personal Officer</p>
                    <p>Chittagong Port Authority</p>
                    <p>&</p>
                    <p>Member Secretary</p>
                    <p>Recruitment Committee</p>
                  </div>
                </b-col>
              </b-row>
            </b-form>
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
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Online Recruitment"
    });
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Application Shotlist"
    });
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Apllicant Profile"
    });
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
  line-height: 12px;
}
</style>
