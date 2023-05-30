<template>
        <b-container fluid>
            <b-card >
                <b-card-header header-bg-variant="dark" header-text-variant="white">Attendance Process</b-card-header>
                <b-card-body class="border">
                    <b-form @submit="onSubmit" >
                        <b-row>
                            <b-col md=8 sm=8 lg=8 xl=5 offset-sm=0 offset-md=0 offset-lg=0 offset-xl=3>
                                <b-form-group 
                                id="input-group-3" 
                                label="Month" 
                                label-for="input-3"
                                label-cols-sm="3"
                                label-cols-md="3"
                                label-cols-lg="3"
                                label-align-sm="right"
                                label-align-md="right"
                                >
                                    <b-form-select
                                            id="input-3"
                                            v-model="data.month_id"
                                            :options="items"
                                            required
                                    >
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md=2 sm=2>
                                <b-button type="submit" variant="primary" :disabled="backgroundProcess">
                                    <b-spinner small type="grow" v-if="backgroundProcess"></b-spinner>
                                    <span v-else>Process</span>
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
                
            </b-card>
        </b-container>
</template>

<script>
        import ApiRepository from "../../Repository/ApiRepository";
        import moment from 'moment';
        import {mapState} from 'vuex';
        export default {
            data() {
                return {
                    items:[],
                    data:{month_id:''}
                };
            },
            computed: {
                ...mapState(['backgroundProcess'])
            },
            mounted() {
                this.$store.commit("setBreadcrumbEmpty");
                this.$store.commit("setBreadcrumb", {link: "#", label: "Attendance"});
                this.$store.commit("setBreadcrumb", {link: "#", label: "Attendance"});
                this.$store.commit("setBreadcrumb", {link: "#", label: "Process"});

                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/attendance/months').then( res => {
                    this.items = res.data.months_years_options;
                    let that = this;
                    this.items.forEach(function(item) {
                        if (moment().format('YYYY-MMMM') == item.text.trim()) {
                            that.data.month_id = item.value;
                        }
                    })

                });
            },
            methods: {
                onSubmit(evt) {
                    evt.preventDefault();
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/attendance/process', this.data).then( res => {
                        if (res.data.o_status_code == 1)
                            this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                        else
                            this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                    });
                }
            }
        };
</script>