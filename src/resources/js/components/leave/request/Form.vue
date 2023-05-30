<template>
    <b-form @submit="onSubmit" @reset="onReset">
        <b-card title="Leave Application">
            <b-card-text>
                <b-row> 
                    <b-col>
                        <label for="department">EMPLOYEE ID</label>
                        <b-form-input id="department" v-model="form.department" type="text" placeholder="Employee ID" disabled></b-form-input>
                    </b-col>
                    <b-col>
                        <label  for="section">EMPLOYEE NAME</label>
                        <b-form-input  id="section" v-model="form.section" type="text" placeholder="Employee Name" disabled></b-form-input>
                    </b-col> 
                    <b-col>
                        <label  for="section">DESIGNATION</label>
                        <b-form-input  id="section" v-model="form.section" type="text" placeholder="Employee Name" disabled></b-form-input>
                    </b-col> 
                </b-row> 
                <b-row> 
                    <b-col>
                        <label for="department">LEAVE TYPE</label>
                        <b-form-input id="department" v-model="form.department" type="text" placeholder="LEAVE TYPE">></b-form-input>
                    </b-col>
                    <b-col>
                        <label  for="section">LEAVE REASON</label>
                        <b-form-input  id="section" v-model="form.section" type="text" placeholder="LEAVE REASON"></b-form-input>
                    </b-col> 
                    <b-col>
                        <label  for="section">ATTACHMENT</label>
                        <b-form-file  id="section" v-model="form.section" type="text" placeholder="ATTACHMENT"></b-form-file>
                    </b-col> 
                </b-row> 
                <b-row>  
                    <b-col>
                        <label  for="section">START DATE</label>
                        <date-picker width="100%"  input-class="form-control" v-model="form.startDate"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                    </b-col> 
                    <b-col>
                        <label  for="section">END DATE</label>
                        <date-picker width="100%"  input-class="form-control" v-model="form.endDate"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                    </b-col> 
                </b-row> 
            </b-card-text> 
            <b-row class="mt-3">
                    <b-col class="d-flex justify-content-end ">
                        <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
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
                form:{
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
                evt.preventDefault()
                console.log(JSON.stringify(this.form))
                },
                onReset(evt) {
                    evt.preventDefault()
                    // Reset our form values
                    this.form.department = null
                    this.form.section = null
                    this.form.date =  '';
                    // Trick to reset/clear native browser form validation state
                    this.show = false
                    this.$nextTick(() => {
                    this.show = true
                    })
                }
        }
    };
</script>
