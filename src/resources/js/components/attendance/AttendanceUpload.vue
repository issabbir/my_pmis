<template>
    <b-container fluid>
        <b-form enctype="multipart/form-data" @submit="onSubmit" method='post' action="/attendance/upload" >
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Attendance Upload</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="4">
                            <b-form-group>
                                <b-row>
                                    <b-col md="4">
                                        <label>Month</label>
                                    </b-col>
                                    <b-col md="8">
                                        <b-form-select  required :options="months_years_options" name="month_year"></b-form-select>
                                    </b-col>
                                </b-row>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-col>
                                <b-form-file name="file" required></b-form-file>
                            </b-col>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button id="add" size="md" type="submit" variant="dark" >Add</b-button> &nbsp;
                                <b-button size="md" class="btn-outline-dark" @click="clearFiles" type="reset"> Reset</b-button>
                            </b-col>
                        </b-col>
                        <b-col md="4">
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
            <input type="hidden" name="_token" v-model="csrf" />
        </b-form>
    </b-container>
</template>

<script>
import Vue from 'vue';
import vSelect from 'vue-select';
import ApiRepository from "../../Repository/ApiRepository";
import moment from "moment";

export default {

components: { Vue,vSelect },
    data() {
        return {
            month_year: '',
            files: '',
            csrf:'',
            uploadError: null,
            currentStatus: null,
            show: true,
            updateIndex:-1,
            //submitBtn: 'Add New Booking',
            resetBtn: 'Reset',
            totalList:0,
            remarks:null,
            perPage:10,
            index:1,
            months_years_options: [],
            modalShow: false
        };
    },
    mounted() {
        this.$store.commit("setBreadcrumbEmpty");
        this.$store.commit("setBreadcrumb", {link: "#", label: "Attendance"});
        this.$store.commit("setBreadcrumb", {link: "#", label: "Attendance"});
        this.$store.commit("setBreadcrumb", {link: "#", label: "Attendance Upload"});
        this.csrf = axios.defaults.headers.common['X-CSRF-TOKEN'];
        this.$store.commit('processEnd');
        this.loadData();
    },
    computed: {},
    methods: {
        loadData: function () {
            ApiRepository.callApi(ApiRepository.GET_COMMAND, '/attendance/attendances').then(res => {
                this.months_years_options = res.data.months_years_options;
                this.attendanceSearch.month_year =  moment().format('YYYY-MM');
            });
        },
        clearFiles() {
            this.$refs['file'].reset();
        },
        onSubmit:function() {
            this.$store.commit('processStart');
        }
    }};
</script>
