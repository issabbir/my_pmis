<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Death Registration List For Approval</b-card-header>
                <b-card-body class="border">
                    <Datatable :fields="fields" :totalList="totalList" :perPage="perPage" :items="items">
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary" @click="openModal(rows.item)">
                                <i class="bx bx-cog cursor-pointer"></i>
                            </b-link>
                            <b-link v-if="rows.item.attachment" ml="4" class="text-primary" @click="showAttachment(rows.item.attachment)">
                                <i class="bx bx-download cursor-pointer"></i>
                            </b-link>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <b-modal
                id="modal-prevent-closing"
                ref="approve-modal"
                title="Death Registration Approval"
                @ok="submit(1)"
                @cancel="submit(-1)"
                @hide="reset"
            >
                    <b-form-group
                        label="Comment"
                        label-for="approve_reject_comment"
                    >
                        <b-form-textarea
                            id="approve_reject_comment"
                            v-model="modalData.approve_reject_comment"
                        ></b-form-textarea>
                    </b-form-group>
                <template #modal-footer="{ ok, cancel, hide }">
                    <b-button size="sm" variant="success" @click="ok()">Approve</b-button>
                    <b-button size="sm" variant="danger" @click="cancel()">Reject</b-button>
                    <b-button size="sm" variant="outline-secondary" @click="hide('forget')">Close</b-button>
                </template>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import Datatable from '../../layouts/common/datatable'
    import ApiRepository from "../../Repository/ApiRepository"
    import moment from "moment";
    export default {
        name: "DeathRegistrationApproval",
        components: {Datatable},
        data(){
            return {
                totalList: 1,
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'emp_name', label: 'Employee Name', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'emp_code', label: 'Employee Code', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {
                        key: 'death_date',
                        label: 'Date of Death',
                        sortable: true,
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortDirection: 'desc',
                        class: 'text-left'},
                    {key: 'informer_name', label: 'Informer Name', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {
                        key: 'approve_status',
                        label: 'Approve Status',
                        sortable: true,
                        formatter: value => {
                            if(value == 0) {
                                return 'Pending'
                            } else if(value == -1) {
                                return  'Rejected'
                            } else if(value == 1) {
                                return 'Approved'
                            } else {
                                return ''
                            }
                        },
                        sortDirection: 'desc',
                        class: 'text-left'
                    },
                    {key: 'action', label: 'Action', class: 'text-center'}
                ],
                perPage:10,
                items: [],
                modalData: {
                    register_id: '',
                    approve_status: 0,
                    approve_reject_comment: ''
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Death Registration Application"});
            this.loadDeathRegistration()
        },
        methods: {
            submit(value){
                this.modalData.approve_status = value
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/pension/approve-death-registration/${this.modalData.register_id}`, this.modalData).then(response => {
                    this.loadDeathRegistration()
                    this.$notify({group: 'pmis', text: 'Death registration successfully updated!', type: 'success'});
                }).catch(error => {
                    this.$notify({group: 'pmis', text: 'Invalid operation!', type: 'error'});
                })
            },
            reset(){
                this.$refs['approve-modal'].hide()
                this. modalData = {
                    register_id: '',
                    approve_status: 0,
                    approve_reject_comment: ''
                }
            },
            openModal(item){
                this.$refs['approve-modal'].show()
                this.modalData.register_id = item.register_id
            },
            showAttachment(data) {
                const win = window.open("","_blank");
                let html = '';
                html += '<html>';
                html += '<body style="margin:0!important">';
                html += '<embed width="100%" height="100%" src="'+data+'"/>';
                html += '</body>';
                html += '</html>';
                setTimeout(() => {
                    win.document.write(html);
                }, 0);
            },
            loadDeathRegistration(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/unapproved-death-registration-list`).then(response => {
                    if (response.data){
                        this.items = response.data
                        this.totalList = response.data.length
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
