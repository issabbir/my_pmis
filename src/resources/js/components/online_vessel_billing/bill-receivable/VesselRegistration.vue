<template>
    <div class="content-wrapper">
        <div class="content-body">

            <b-card class="card">
                <b-card-text class="card-content">
                    <div class="card body mb-2">
                        <b-form @reset="onReset" @submit="onSubmit" v-if="show">
                            <b-card
                                title="Vessel Registration Information"
                                >
                                <b-row>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>REG/ROT NO </label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input  placeholder="REG/ROT NO" v-model="form.regNo">
                                                    </b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>ARRIVAL DATE</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <date-picker
                                                        format="YYYY-MM-DD"
                                                        input-class="form-control"
                                                        lang="en"
                                                        type="date"
                                                        v-model="arrivalDate"
                                                        width="100%">
                                                    </date-picker>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group>
                                            <b-row>
                                                <b-col md="4">
                                                    <label>VESSEL NAME</label>
                                                </b-col>
                                                <b-col md="8">
                                                    <b-form-input
                                                        placeholder="Vessel Name" v-model="form.vesselName">
                                                    </b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-form-group>
                                    </b-col>

                                </b-row>
                            </b-card>
                            <b-row>
                                <b-col class="mt-2 d-flex justify-content-end">
                                    <b-button md="6" size="md" type="submit" variant="dark">{{submitBtn}}</b-button>&nbsp;
                                </b-col>
                            </b-row>
                        </b-form>

                    </div>
                </b-card-text>
            </b-card>
            <!--Table for vessel registration-->
            <b-card>
                <div class="card-header">
                    <h4 class="card-title">Registered Vessel List</h4>
                </div>
                <b-card-text class="card-content">
                    <b-card-body>
                        <b-card-text>
                            <b-row>
                                <b-col sm="2" md="2" class="my-1">
                                    <b-form-group
                                        label="Per page"
                                        label-cols-sm="6"
                                        label-cols-md="6"
                                        label-cols-lg="6"
                                        label-align-sm="left"
                                        label-size="sm"
                                        label-for="perPageSelect"
                                        class="mb-0">
                                        <b-form-select
                                            v-model="perPage"
                                            id="perPageSelect"
                                            size="sm"
                                            :options="pageOptions"></b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="3" md="3" class="my-1 ml-auto">
                                    <b-input-group size="sm">
                                        <b-form-input
                                            v-model="filter"
                                            type="search"
                                            label-align-sm="right"
                                            id="filterInput"
                                            placeholder="Type to Search"
                                            ></b-form-input>
                                        <b-input-group-append>
                                            <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-col>
                            </b-row>
                            <b-table
                                striped
                                hover
                                show-empty
                                small
                                :items="vesselRegistrationItems"
                                :current-page="currentPage"
                                :filter="filter"
                                :per-page="perPage"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                :fields="vesselRegistrationFields"
                                responsive>
                                <template v-slot:cell(action)="row">
                                      <a size="sm"  class="text-primary" data-toggle="modal" href="#" data-target="#border-less"><i class="bx bx-edit cursor-pointer"></i> </a>
                                    <a target="_self" href="#" class="text-danger"><i class="bx bx-trash cursor-pointer"></i></a>

                                </template>
                            </b-table>
                            <b-col sm="12" md="12" class="my-1">
                                <b-pagination
                                    v-model="currentPage"
                                    :total-rows="totalRows"
                                    :per-page="perPage"
                                    align="right"
                                    size="sm"
                                    class="my-0"></b-pagination>
                            </b-col>
                        </b-card-text>

                    </b-card-body>
                </b-card-text>
            </b-card>
        </div>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker'

            export default {
                components: {DatePicker},
                mounted() {
                    this.$store.commit("setBreadcrumbEmpty");
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Bill Receivable"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Vessel Service"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Vessel Registration"});
                },
                data() {
                    return {
                        form: {
                            datetime: new Date()
                        },
                        show: true,
                        updateIndex: -1,
                        submitBtn: 'Save',

                        vesselRegistrationFields: [
                            {key: 'regNo', label: 'Registration No', sortable: true, sortDirection: 'desc'},
                            {
                                key: 'arrivalDate',
                                label: 'Arrival Date',
                                sortable: true,
                                sortDirection: 'desc',
                                class: 'text-center'
                            },
                            {
                                key: 'vesselName',
                                label: 'vessel Name',
                                sortable: true,
                                sortDirection: 'desc',
                                class: 'text-center'
                            }, 'action'
                        ],
                        vesselRegistrationItems: [
                            {regNo: '11215', arrivalDate: '21-Nov-14', vesselName: 'Queen Marry'},
                            {regNo: '21458', arrivalDate: '01-Jan-19', vesselName: 'Alaska'},
                            {regNo: '311458', arrivalDate: '15-Feb-17', vesselName: 'M.V Rustom'},
                        ],

                        division_options: [
                            {value: null, text: 'Please select'},
                            {value: 'Member(Engineering)', text: 'Member (Engineering)'},
                            {value: 'Chairman', text: 'Chairman'},
                            {value: 'Member(Harbour & Marine)', text: 'Member(Harbour & Marine)'},
                            {value: 'Member(Finance)', text: 'Member(Finance)'},
                            {value: 'Member(Engineering)', text: 'Member(Engineering)'},
                        ],
                        financial_code_options: [
                            {value: null, text: 'Please select'},
                            {value: 97040, text: '97040'},
                            {value: 97041, text: '97041'},
                            {value: 97042, text: '97042'},
                            {value: 97043, text: '97043'},
                            {value: 97044, text: '97044'},
                            {value: 97045, text: '97045'},
                            {value: 97046, text: '97046'},
                            {value: 90720, text: '90720'},
                            {value: 90631, text: '90631'},
                            {value: 90730, text: '90730'},
                            {value: 90810, text: '90810'},
                            {value: 90490, text: '90490'},
                        ],
                        shift_options: [
                            {value: null, text: 'Please select'},
                            {value: '1', text: '1'},
                            {value: '2', text: '2'},
                            {value: '3', text: '3'},
                            {value: '4', text: '4'},
                            {value: '5', text: '5'},
                            {value: '6', text: '6'},
                            {value: '7', text: '7'},
                        ]

                    }
                },
            }
</script>

