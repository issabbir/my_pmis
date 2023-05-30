<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row class="justify-content-md-center">
                <b-card class="card HolidayFullcalendar col-md-6 mr-3" >
                    <div class="card-header">
                        <h4 class="card-title">Holiday Calendar</h4>
                    </div>
                    <b-card-text class="card-content">
                        <div class="card-body mb-2">
                            <FullCalendar firstDay='1' defaultView="dayGridMonth" :plugins="calendarPlugins" :events="events"/>
                        </div>
                    </b-card-text>
                </b-card>
                <!--b-card class="card HolidayFullcalendar col-md-5" >
                    <div class="card-header">
                        <h4 class="card-title">Holiday Calendar</h4>
                    </div>
                    <b-card-text class="card-content">
                        <div class="card-body mb-2">
                            <FullCalendar defaultView="" :plugins="calendarPlugins" :events="events"/>
                        </div>
                    </b-card-text>
                </b-card-->
            </b-row>
        </div>
    </div>

</template>


<script>

    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import ApiRepository from "../../Repository/ApiRepository";

    export default {
        components: {
            FullCalendar // make the <FullCalendar> tag available
        },
        data() {
            return {
                calendarPlugins: [ dayGridPlugin ],
                events : [],
                firstDay: "01-01-2020"
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Leave"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Holiday Calendar"});
            this.getHolidays();
        },
        methods:{
            getHolidays(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/leave/holiday-entry/calendar").then(res => {
                    console.log(res.data.holiday);
                    this.events = res.data.holiday;
                });
            },
        }
    }

</script>
<style lang='scss' scoped>

    @import '~@fullcalendar/core/main.css';
    @import '~@fullcalendar/daygrid/main.css';
</style>

