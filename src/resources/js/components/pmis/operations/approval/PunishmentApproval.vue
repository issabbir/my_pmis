<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pending Punishment List</b-card-header>
                <b-card-body>
                    <Datatable v-bind:fields="fields" v-bind:items="items" :perPage="perPage" :totalList="totalList" responsive>
                        <template v-slot:actions="{ rows }">
                           <a v-b-modal.process_modal @click="renderModal(rows.item)">
                               <i class="bx bx-cog cursor-pointer"></i>
                           </a>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <div>
                <b-modal id="process_modal" centered ok-title="Process" :title="'Punishment Processing For '+formData.emp_name">
                    <b-row>
                        <b-col md="12">
                            <ul>
                                <li>Employee Code: {{formData.emp_code}}</li>
                                <li>Punishment Type {{formData.punishment_type}}</li>
                                <li>Order No: {{formData.order_ref_number}}</li>
                                <li>Order Date: {{formData.order_date}}</li>
                            </ul>
                        </b-col>

                        <b-col>
                            <b-form-group
                                label="Approve Note"
                                label-for="approve_note"
                            >
                                <b-form-textarea
                                    id="approve_note"
                                    v-model="formData.approve_note"
                                    placeholder="Approve Note"
                                    rows="1"
                                    max-rows="6"
                                ></b-form-textarea>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <template #modal-footer="{ ok, cancel, hide }">
                        <b-button size="sm" variant="success" @click="processed()">Approve</b-button>
                        <b-button size="sm" variant="outline-secondary" @click="rejected()">Reject</b-button>
                        <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
                    </template>
                </b-modal>
            </div>
        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../../../Repository/ApiRepository";
    import Datatable from '../../../../layouts/common/datatable';
    import moment from "moment";
    export default {
        name: "PunishmentApproval",
        components: {Datatable},
        data() {
            return {
                formData: {
                    punishment_id: '',
                    emp_id: '',
                    emp_name: '',
                    designation: '',
                    dpt_division_name: '',
                    department_name: '',
                    process_yn: '',
                    approve_status: '',
                    note: '',
                    approve_note: '',
                    punishment_type: ''
                },
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'emp_code', label: 'Employee Code', sortable: true},
                    {key: 'emp_name', label: 'Employee Name', sortable: true},
                    {key: 'punishment_type', sortable: true},
                    {key: 'order_ref_number', label: 'Office Order Number', sortable: true},
                    {
                        key: 'order_date',
                        label: 'Office Order Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true
                    },
                    {
                        key: 'start_date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true
                    },
                    {key: 'end_order_ref_no'},
                    {
                        key: 'end_order_date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                    },
                    {
                        key: 'end_date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true
                    },
                    {
                        key: 'process_yn',
                        label: 'Process Status',
                        sortable: true,
                        formatter: value => {
                            if(value == 'Y') {
                                return 'Processed'
                            } else if (value == 'N') {
                                return 'Not Processed'
                            } else {
                                return ''
                            }
                        }
                    }, {key: 'last_updated_by', label: 'Last Updated By', sortable: true},
                    {
                        key: 'action',
                        label: 'Action',
                        class: 'text-center'
                    }

                ],
                items: [],
                perPage: 5,
                totalList: 1
            }
        },
        computed:{

        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Operations"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Approval"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Punishment"});
            this.loadTable()
        },
        watch:{

        },
        methods: {
            renderModal(item) {
                this.formData = item;
            },
            processed() {
                this.formData.approve_status = 'A'
                this.formData.process_yn = 'Y'
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/punishments-approval`, this.formData).then(result => {
                    if(result.data.o_status_code == 1){
                        this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'success'});
                        this.loadTable()
                    } else {
                        this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'error'});
                    }
                }).catch(err => {
                    this.$notify({group: 'pmis', text: err, type: 'error'});
                });
                this.$nextTick(() => {
                    this.$bvModal.hide('process_modal')
                })
            },
            rejected() {
                this.formData.approve_status = 'R'
                this.formData.process_yn = 'N'
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/operation/punishments-approval`, this.formData).then(result => {
                    if(result.data.o_status_code == 1){
                        this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'success'});
                        this.loadTable()
                    } else {
                        this.$notify({group: 'pmis', text: result.data.o_status_message, type: 'error'});
                    }
                }).catch(err => {
                    this.$notify({group: 'pmis', text: err, type: 'error'});
                    console.log('error');
                });
                this.$nextTick(() => {
                    this.$bvModal.hide('process_modal')
                })
            },
            loadTable(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/punishments-approval`).then(result => {
                    this.items = result.data;
                    this.totalList = result.data.length
                }).catch(err => {
                    console.log('error');
                });
            }
        }
    }
</script>

<style scoped>

</style>
