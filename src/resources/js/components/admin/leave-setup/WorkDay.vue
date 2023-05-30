<template>
    <b-row class="content-wrapper">
        <b-col class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Work Week</h4>
                        </div>
                        <div class="card-header"></div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>

                                    <!--<fieldset class="border p-2">-->
                                        <!--<legend class="w-auto ">Work Week</legend>-->

                                        <b-row>
                                            <b-col lg="4">
                                                <b-form-group
                                                        id="fieldset-1"
                                                        label="DAY"
                                                        label-for="input-id"
                                                >
                                                    <b-form-input v-model="workDay.day" required id="input-id" type="text" placeholder="Day"></b-form-input>
                                                </b-form-group>
                                            </b-col>

                                            <b-col lg="4">
                                                <b-form-group
                                                        id="fieldset-2"
                                                        label="Status"
                                                        label-for="input-name"
                                                >
                                                    <b-form-select v-model="workDay.work_day_status_id" required :options="status_options" ></b-form-select>
                                                </b-form-group>
                                            </b-col>

                                            <!--<b-col lg="4" class="mt-2">
                                                <b-button lg="6" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                                <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                            </b-col>-->
                                        </b-row>
                                    <b-row>
                                        <b-col class="mt-2 d-flex justify-content-end">
                                            <b-button lg="6" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                            <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                        </b-col>
                                    </b-row>

                                    <!--</fieldset>-->
                                </b-form>

                            </div>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <!-- Zero configuration table -->
            <section id="basic-datatable">
                <b-row>
                    <b-col>
                        <b-card class="card">
                            <div class="card-content">
                                <b-card-text class="card-body">
                                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items">
                                        <template v-slot:actions="{ rows }">
                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item.work_day_id)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                            <b-link class="text-danger" @click="deleteRow(rows.item.work_day_id)">
                                                <i class="bx bx-trash cursor-pointer"></i>
                                            </b-link>
                                        </template>
                                    </Datatable>
                                </b-card-text>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>
            </section>
            <!--/ Zero configuration table -->

        </b-col>


    </b-row>
</template>

<script>
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        components: {
            Datatable
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Leave Setup"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Work day" });
            this.allStatuses();
            this.allWorkDays();
        },
        data() {
            return {
                workDay: { },
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                tableData: {
                    fields: [{key:'work_day_id', label:'id', sortable:true}, {key:'day', sortable:true}, {key: 'status.status', label:'status', sortable:true}, 'action'],
                    items: []
                },
                status_options: [],
            }
        },
        methods: {
            allWorkDays() {
                let that = this;

                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/leave-setup/work-days')
                    .then(function(result){
                        that.tableData.items = result.data;
                    })
                    .catch(function(error) {

                    });
            },
            allStatuses() {
                let that = this;

                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/leave-setup/work-day-statuses-dropdown')
                    .then(function(result){
                        that.status_options = result.data.hrWorkDaySatauses;
                    })
                    .catch(function(error) {
                        // handle errors.
                    });
            },
            onSubmit(evt) {
                let that = this;

                if(this.updateIndex > 0) {
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/leave-setup/work-days/${this.updateIndex}`, this.workDay)
                        .then(function(result){
                            that.allWorkDays();
                        })
                        .catch(function(error){
                            // handle errors.
                        });
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/leave-setup/work-days', this.workDay)
                        .then(function(result){
                            that.allWorkDays();
                        })
                        .catch(function(error){
                            // handle errors.
                        });
                }

                that.onReset();
            },
            onReset(evt) {
                this.workDay = {};
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });

            },
            editRow(id) {
                let that = this;
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/leave-setup/work-days-fetch/${id}`)
                    .then(function(result) {
                        that.submitBtn = 'Update';
                        that.workDay = result.data.hrWorkDay;
                    })
                    .catch(function(error){
                        // handle errors.
                    });
            },
            deleteRow(id) {
                let that = this;
                if (id > -1) {
                    let confirmation = confirm('Are you sure you want to delete this item?');
                    if(confirmation) {
                        ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/admin/leave-setup/work-days/${id}`)
                            .then(function (result) {
                                that.allWorkDays();
                                that.onReset();
                            })
                            .catch(function (error) {
                                // handle errors.
                            });

                        return true;
                    }

                    return false;
                }
            }

        }
    }
</script>
