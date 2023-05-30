<template>
    <b-form @submit="onSubmit" @reset="onReset">
        <b-card title="Overtime Process">
            <b-card-text>
                <b-row>
                    <b-col>
                        <label for="department">Department</label>
                        <b-form-select id="department" v-model="overtimeprocess.department" :options="departmentList"></b-form-select>
                    </b-col>
                    <b-col>
                        <label  for="section">Section</label>
                        <b-form-select  id="section" v-model="overtimeprocess.section" :options="sectionList"></b-form-select>
                    </b-col>
                    <b-col>
                        <label  for="date">Date</label>
                        <date-picker width="100%"  input-class="form-control" v-model="overtimeprocess.date"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                    </b-col>
                </b-row>
            </b-card-text>
            <b-row class="mt-3">
                    <b-col class="d-flex justify-content-end ">
                        <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Process</b-button> &nbsp;
                        <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button>
                    </b-col>
            </b-row>
        </b-card>
    </b-form>
</template>

<script>
import DatePicker from 'vue2-datepicker'

    export default {
         components: { DatePicker },
        data() {
            return {
                overtimeprocess:{
                    department : null,
                    section : null,
                    date : new Date(),
                 },
                 departmentList: [{ text: 'Select One', value: null }, 'Finance & Accounting', 'Administration'],
                 sectionList: [{ text: 'Select One', value: null }, 'Computer', 'Billing'],
                 show: true,
             };
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Leave-management"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Request"});
        },

        methods: {
              onSubmit(evt) {
                evt.preventDefault();
                console.log(JSON.stringify(this.overtimeprocess))
                },
                onReset(evt) {
                    evt.preventDefault();
                    // Reset our form values
                    this.overtimeprocess.department = null;
                    this.overtimeprocess.section = null;
                    this.overtimeprocess.date =  '';
                    // Trick to reset/clear native browser form validation state
                    this.show = false;
                    this.$nextTick(() => {
                    this.show = true
                    })
                }
        }
    };
</script>
