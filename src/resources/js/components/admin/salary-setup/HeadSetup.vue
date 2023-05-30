<template>
    <b-col class="content-wrapper">
        <b-col class="content-body">
            <b-row >
                <b-col>
                    <b-card class="card">
                        <b-card-header>
                            <h4 class="card-title">Salary Head Setup</h4>
                        </b-card-header>
                        <b-col class="card-content">
                            <b-card-text class="card-body mb-2">

                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}" ></b-form-input>
                                    <b-row>
                                        <b-col lg="6">
                                            <b-row>
                                                <!--b-col lg="6">
                                                    <b-form-group
                                                            id="fieldset-1"
                                                            label="ID"
                                                            label-for="input-id"
                                                    >
                                                        <b-form-input v-model="salaryHeadSetup.id" required id="input-id" type="text" placeholder="ID"></b-form-input>
                                                    </b-form-group>
                                                </b-col-->

                                                <b-col lg="6">
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="Salary Head Code"
                                                        label-for="input-id"
                                                        >
                                                        <b-form-input v-model="salaryHeadSetup.sal_head_code" required id="input-id" type="text" placeholder="Salary Head Code"></b-form-input>
                                                    </b-form-group>
                                                </b-col>

                                            </b-row>
                                            <b-row>
                                                <b-col  md="6">
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="Head Name"
                                                        label-for="input-id"
                                                        >
                                                        <b-form-input v-model="salaryHeadSetup.sal_head_name" required id="input-id" type="text" placeholder="Head Name"></b-form-input>
                                                    </b-form-group>

                                                </b-col>
                                                <b-col  md="6">
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="Short Name"
                                                        label-for="input-id"
                                                        >
                                                        <b-form-input v-model="salaryHeadSetup.sal_head_short_name" required id="input-id" type="text" placeholder="Short Name"></b-form-input>
                                                    </b-form-group>

                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="Description"
                                                        label-for="input-id"
                                                        >
                                                        <b-form-input v-model="salaryHeadSetup.sal_head_description" required id="input-id" type="text" placeholder="Description"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col lg="2"><label>Head Type</label></b-col>
                                                <b-col lg="9">
                                                    <b-form-group>
                                                        <b-form-radio-group v-model="salaryHeadSetup.sal_head_type">
                                                            <b-form-radio value="A">Allowance</b-form-radio>
                                                            <b-form-radio value="D">Deduction</b-form-radio>
                                                        </b-form-radio-group>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col lg="8">
                                                    <b-row>
                                                        <b-col lg="3">
                                                            <label>Portion</label>
                                                        </b-col>
                                                        <b-col lg="9">
                                                            <b-form-group>

                                                                <b-form-radio-group  v-model="salaryHeadSetup.sal_promo_depend">
                                                                    <b-form-radio value="G">Amount</b-form-radio>
                                                                    <b-form-radio value="B">% of Basic</b-form-radio>
                                                                </b-form-radio-group>
                                                            </b-form-group>
                                                        </b-col>
                                                    </b-row>

                                                </b-col>
                                                <b-col lg="4">

                                                    <b-form-group>
                                                        <b-form-input v-model="salaryHeadSetup.sal_promo_amt" required type="text" placeholder="amount"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col lg="8">
                                                    <b-row>
                                                        <b-col lg="3">
                                                            <label>Pay</label>
                                                        </b-col>
                                                        <b-col lg="9">
                                                            <b-form-group>

                                                                <b-form-radio-group id="radio-group-2" v-model="salaryHeadSetup.sal_pay_depend"   name="radio-sub-component">
                                                                    <b-form-radio value="F">Full</b-form-radio>
                                                                    <b-form-radio value="P">Partial</b-form-radio>
                                                                </b-form-radio-group>
                                                            </b-form-group>
                                                        </b-col>
                                                    </b-row>

                                                </b-col>
                                                <b-col lg="4">
                                                    <b-form-group >
                                                        <b-form-input v-model="salaryHeadSetup.sal_pay_amt" required type="text" placeholder="amount"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>

                                                <b-col>
                                                    <b-form-group>
                                                        <label>COA Code</label>
                                                        <b-form-select v-model="salaryHeadSetup.sal_head_coa_code" required :options="coa_code_options" ></b-form-select>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>

                                                <b-col lg="6">
                                                    <b-form-group>
                                                        <label>Sub Code</label>
                                                        <b-form-input v-model="salaryHeadSetup.sal_head_coa_subcode"  required type="text" placeholder="1234"></b-form-input>
                                                    </b-form-group>
                                                </b-col>

                                                <b-col lg="6">
                                                    <b-form-group>
                                                        <label>Sub Code-1</label>
                                                        <b-form-input v-model="salaryHeadSetup.sal_head_coa_subcode1"  required type="text" placeholder="5468"></b-form-input>
                                                    </b-form-group>
                                                </b-col>

                                            </b-row>

                                        </b-col>

                                        <b-col lg="6">
                                            <fieldset class="border p-2">
                                                <legend class="w-auto ">Employee Specification</legend>

                                                <b-row>
                                                    <b-col lg="3"> <label class="d-block">Employee Type</label></b-col>
                                                    <b-col lg="9">
                                                        <b-form-group>
                                                            <b-form-radio-group
                                                                v-model="salaryHeadSetup.sal_head_emp_type"
                                                                :options="emp_type_options"></b-form-radio-group>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>


                                                <b-row>
                                                    <b-col lg="3"><label class="d-block">Deputation Only</label></b-col>
                                                    <b-col lg="9">
                                                        <b-form-group>
                                                            <b-form-checkbox v-model="salaryHeadSetup.sal_head_isdepution" value="Y" unchecked-value="N"></b-form-checkbox>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>


                                                <b-form-group>
                                                    <label>Department</label>
                                                    <b-form-select v-model="salaryHeadSetup.sal_head_department" required :options="department_options" ></b-form-select>
                                                </b-form-group>


                                                <b-row>
                                                    <b-col lg="3"><label class="d-block">Religion</label></b-col>
                                                    <b-col lg="9">
                                                        <b-form-group>
                                                            <b-form-radio-group v-model="salaryHeadSetup.sal_head_req_religion"  :options="religion_options"></b-form-radio-group>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>

                                                <b-row>
                                                    <b-col lg="3"><label class="d-block">Tribal Only</label></b-col>
                                                    <b-col lg="9">
                                                        <b-form-group>
                                                            <b-form-checkbox v-model="salaryHeadSetup.sal_head_istribal" value="Y" unchecked-value="N"></b-form-checkbox>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>




                                            </fieldset>

                                        </b-col>

                                    </b-row>
                                    <b-row>
                                        <b-col class="mt-2 d-flex justify-content-end">
                                            <b-button lg="6" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                            <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                </b-form>

                            </b-card-text>
                        </b-col>
                    </b-card>
                </b-col>
            </b-row>




            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-content">
                            <b-card-text class="card-body">
                                <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" >
                                    <template v-slot:actions="{ rows }">
                                        <b-link ml="4" class="text-primary"
                                                @click="editRow(rows.item.id, rows.item.id)">
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>
                                        <b-link class="text-danger" @click="deleteRow(rows.item.id, rows.item.id)">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>
                                    </template>
                                </Datatable>
                            </b-card-text>
                        </div>
                    </b-card>
                </b-col>
            </b-row>
        </b-col>


    </b-col>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Salary Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Salary Head Setup"});
            this.dataList();
        },
        data() {
            return {
                salaryHeadSetup: {},
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                tableData: {
                    fields: [{key: 'sal_head_code', sortable: true}],
                    items: []
                },
                emp_type_options: [
                    {value: 'A', text: 'All'},
                    {value: 'O', text: 'Officer'},
                    {value: 'S', text: 'Staff'},
                ],
                coa_code_options: [
                    {value: '001', text: '8000-Salary Allowance'},
                    {value: '002', text: '8000-Salary Allowance'},
                    {value: '003', text: '9000-Salary Allowance'},
                ],
                department_options: [
                    {value: 'F', text: 'Finance & Accounting'},
                    {value: 'A', text: 'Administration'},
                    {value: 'H', text: 'Hydrography'},
                ],
                religion_options: [
                    {value: 'I', text: 'Islam'},
                    {value: 'C', text: 'Christan'},
                    {value: 'B', text: 'Buddhu'},
                    {value: 'H', text: 'Hindu'},
                    {value: 'A', text: 'All'},
                ],

            }
        },
        methods: {
            dataList() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/salary-setup/head-setups').then(result => {
                    this.tableData.items = result.data;

                });
            },

            onSubmit(evt) {
                evt.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/salary-setup/head-setups', this.salaryHeadSetup);
            },

        }
       /* onReset(evt) {
            evt.preventDefault();
            this.id = '';

            this.updateIndex = -1;
            this.submitBtn = 'Save';
            this.show = false;
            this.$nextTick(() => {
                this.show = true;
            });

        },
        editRow(i) {
            this.submitBtn = 'Update';
            this.updateIndex = i;
            let data = this.tableData.items[i];
            console.log(data);

        },
        deleteRow(i) {
            if (i > -1) {
                this.tableData.items.splice(i, 1);
            }
        }*/

    }
</script>

