<template>
    <b-form @submit="onSubmit" @reset="onReset">
        <b-card title="Overtime Register">
            <b-card-text>
                <b-row>
                    <b-col>
                        <label>Employee Id</label>
                        <b-form-select  v-model="form.empID" :options="empIDList"></b-form-select>
                    </b-col>
                    <b-col>
                        <label  for="department">Department</label>
                        <b-form-select  id="department" v-model="form.department" :options="departmentList"></b-form-select>
                    </b-col>
                    <b-col>
                        <label  for="section">Section</label>
                        <b-form-select  id="section" v-model="form.section" :options="sectionList"></b-form-select>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <label  for="fromDate">From Date</label>
                         <date-picker width="100%"  input-class="form-control" v-model="form.fromDate"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                    </b-col>
                    <b-col>
                        <label  for="endDate">End Date</label>
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
    import DatePicker from 'vue2-datepicker';
    // import Vue from 'vue';
    // import vSelect from 'vue-select';
    // import  vcss from 'vue-select/dist/vue-select.css';
    // import Datatable from '../../../layouts/common/datatable';
    // import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        components: { DatePicker },
        data() {
            return {
                form:{
                    empID:null,
                    department : null,
                    section : null,
                    fromDate : new Date(),
                    endDate : new Date(),
                 },
                 empIDList: [
                    {value: null, text: 'Please select an option'},
                    {value: 'a', text: 'Mr Foo'},
                    {value: 'b', text: 'Mr Bar'}
                ],
                departmentList: [{ text: 'Select One', value: null }, 'Finance & Accounting', 'Administration'],
                sectionList: [{ text: 'Select One', value: null }, 'Computer', 'Billing'],
            };
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Process"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime Process"});
        },
        methods: {
              onSubmit(evt) {
                evt.preventDefault();
                //console.log(JSON.stringify(this.form))
                 this.$emit('clicked', this.form)
                 },
                onReset(evt) {
                    evt.preventDefault();
                    // Reset our form values
                    this.form.empID = null;
                    this.form.department = null;
                    this.form.section = null;
                    this.form.fromDate =  '';
                    this.form.endDate =  '';
                    // Trick to reset/clear native browser form validation state
                    this.show = false;
                    this.$nextTick(() => {
                    this.show = true
                    })
                }
        },
        props: ['message'],
    };
</script>
