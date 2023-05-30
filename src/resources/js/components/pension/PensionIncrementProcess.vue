<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pension Increment Process</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col class="d-flex justify-content-center">
                            <b-button variant="primary" @click="modalShow" size="lg">Process the Increment</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
            <b-modal ref="confirmation-modal" title="Process Confirmation" header-text-variant="primary" title-variant="primary" ok-title="Process" @ok="submit">
                <h6 class="text-warning">Do you really want to process the Pension Increment?</h6>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../Repository/ApiRepository";

    export default {
        name: "PensionIncrementProcess",
        methods: {
            modalShow(){
                this.$refs['confirmation-modal'].show()
            },
            submit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/increment-process`).then(response => {
                    if (response.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: response.data.o_status_message, type: 'success'});
                    } else {
                        this.$notify({group: 'pmis', text: response.data.o_status_message, type: 'error'});
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
