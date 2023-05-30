<template>
    <div class="content-body">
        <div class="col-md-12 col-sm-12 pr-md-0">
            <b-card>
                <b-card-header>Notification Details</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="3">
                            <b-form-group
                                label="At"
                                label-for="insert_date"
                            >
                                <b-form-input id="insert_date" readonly v-model="notification.insert_date"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="12">
                            <b-form-group
                                label="Note"
                                label-for="note"
                            >
                                <b-form-textarea id="note" readonly v-model="notification.note"></b-form-textarea>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../Repository/ApiRepository";

    export default {
        name: "Notification",
        props: ['id'],
        data(){
            return {
                notification : {
                    insert_by: '',
                    insert_date: '',
                    module_id: '',
                    note: "",
                    notification_id: "",
                    notification_to: "",
                    priority: '',
                    read_yn: "",
                    target_url:''
                }
            }
        },
        mounted() {
            this.getNotification()
        },
        methods: {
            getNotification(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/pmis/employee/get-notification/${this.id}`).then(result => {
                    this.notification = result.data;
                });
            }
        }
    }
</script>

<style scoped>

</style>
