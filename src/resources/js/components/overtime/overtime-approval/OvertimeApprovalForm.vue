<!--template>
    <b-form @submit="onSubmit" @reset="onReset">
        <b-card title="Overtime Approval">
            <b-card-text>
                <b-row>
                    <b-col>
                        <label>Employee Id</label>
                        <b-form-select  v-model="overtimeapproval.empID" :options="empIDList"></b-form-select>
                    </b-col>
                    <b-col>
                        <label  for="department">Department</label>
                        <b-form-select  id="department" v-model="overtimeapproval.department" :options="departmentList"></b-form-select>
                    </b-col>
                    <b-col>
                        <label  for="section">Section</label>
                        <b-form-select  id="section" v-model="overtimeapproval.section" :options="sectionList"></b-form-select>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <label  for="fromDate">From Date</label>
                         <date-picker width="100%"  input-class="form-control" v-model="overtimeapproval.fromDate"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                    </b-col>
                    <b-col>
                        <label  for="endDate">End Date</label>
                         <date-picker width="100%"  input-class="form-control" v-model="overtimeapproval.endDate"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
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
                overtimeapproval:{ },
                 empIDList: [
                    {value: null, text: 'Select One'},
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
                console.log(JSON.stringify(this.overtimeapproval))
                 //this.$emit('clicked', this.form)
                 },
                onReset(evt) {
                    evt.preventDefault();
                    // Reset our form values
                    this.overtimeapproval.empID = null;
                    this.overtimeapproval.department = null;
                    this.overtimeapproval.section = null;
                    this.overtimeapproval.fromDate =  '';
                    this.overtimeapproval.endDate =  '';
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
