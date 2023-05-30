<template>
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">My Attendance</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="loadAttendance">
                        <b-row>
                            <b-col md="5">
                                <b-form-group
                                    label="Year"
                                    label-for="year"
                                    label-cols-md="3"
                                >
                                    <b-form-select required id="year" :options="yearOptions" v-model="formData.year"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="5">
                                <b-form-group
                                    label="Month"
                                    label-for="month"
                                    label-cols-md="3"
                                >
                                    <b-form-select required id="month" value-field="month_id" text-field="month_name" :options="monthOptions" v-model="formData.month"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="2">
                                <b-button type="submit">Search</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                    <Datatable :items="items" :perPage="perPage" :fields="fields" :totalList="totalList"></Datatable>
                </b-card-body>
            </b-card>
        </div>
</template>

<script>
    import Datatable from "../../../layouts/common/datatable";
    import ApiRepository from "../../../Repository/ApiRepository";
    import moment from "moment";

    export default {
        name: "Attendance",
        components: {Datatable},
        data() {
            return {
                formData: {
                    month: '',
                    year: ''
                },
                fields: [
                    {key: 'index', label: 'Sl.', sortable: true},
                    {key: 'roster_date', label: 'Date', orderDate: true},
                    {key: 'roster_day', label: 'Day', orderDate: true},
                    {key: 'presence', label: 'presence', sortable: true},
                    {key: 'in_time', label: 'In Time', sortable: true},
                    {key: 'out_time', label: 'Out Time', sortable: true}
                ],
                items: [],
                perPage: 5,
                totalList: 1,
                yearOptions: [],
                monthOptions: [],
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "dashboard", label: "Dashboard"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account", label: "My Account"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account/attendance", label: "My Attendance"});
            this.loadYear()
            this.loadMonth()
        },
        methods: {
            loadAttendance() {
                this.items = []
                this.totalList = 1
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/api/attendance`, this.formData).then(result => {
                    if (result.data.data.attendance.length > 0){
                        this.items = result.data.data.attendance
                        this.totalList = this.items.length
                    } else {
                        this.$notify({group: 'pmis', text: 'Sorry! you do not have any record.', type: 'error'});
                    }
                });
            },
            loadYear(){
                const years = []
                const dateStart = moment('1900')
                const dateEnd = moment().subtract(1, 'years')
                while (dateEnd.diff(dateStart, 'years') >= 0) {
                    years.push(dateStart.format('YYYY'))
                    dateStart.add(1, 'year')
                }
                this.yearOptions = years.sort(function(a, b){return b-a})

            },
            loadMonth(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/api/month/list`, this.formData).then(result => {
                    this.monthOptions = result.data.data.months
                });
            }
        }
    }
</script>

<style scoped>

</style>
