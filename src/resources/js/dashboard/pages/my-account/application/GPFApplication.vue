<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">GPF Application</b-card-header>
                <b-card-body class="border">
                    <b-form v-if="emps.length>0" @submit.prevent="onSubmit"  @reset.prevent="onReset">
                        <b-row>
                            <b-col md="6" class="border-right">
                                <b-form-group
                                    label="GPF Percentage"
                                    label-for="input-gpf-percent"
                                    description="Percentage minimum 5% and maximum 25% "
                                >
                                    <b-form-input
                                        id="input-gpf-percent"
                                        :max="25"
                                        :maxlength="5"
                                        :min="5"
                                        type="number"
                                        v-model="formData.percent"
                                        @keyup="calAmount(formData.percent)"
                                    ></b-form-input>
                                    <span v-if="formData.percent>25" style="color:red">Percentage cannot exceed 25</span>
                                    <span v-if="formData.percent<5" style="color:red">Percentage cannot less than 5</span>
                                </b-form-group>
                                <b-form-group
                                    id="input-gpf"
                                    label="GPF Amount"
                                    label-for="input-gpf-amount"
                                >
                                    <b-form-input
                                        id="input-gpf-amount"
                                        v-model="formData.amount"
                                        readonly
                                        type="text"
                                        class="text-right"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-table  stacked :items="emps" :fields="empFields"></b-table>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button type="submit" variant="success">Submit</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                    <p v-else class="text-danger text-center">You are not allowed to apply for GPF</p>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Nominee List</b-card-header>
                <b-card-body class="border">
                    <b-table striped bordered :small="true" :items="items" :fields="fields">
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                    </b-table>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../../../Repository/ApiRepository";
    import moment from "moment";

    export default {
        name: "GPFApplication",
        data(){
            return {
                formData: {
                    emp_id: '',
                    emp_code: '',
                    gpf_id: '',
                    officeOrderNo: '',
                    officeOrderDate: '',
                    status: 'N',
                    amount: 0,
                    percent: 0,
                    basic_amt: 0
                },
                emps: [],
                empFields: [
                    {key:'emp_name',label:'Employee Name'},
                    {key:'emp_code',label:'Employee Code'},
                    {key:'designation'},
                    {key:'department_name',label:'Department'},
                    {key:'basic_amt',label:'Basic Amount'}
                ],
                items: [],
                fields: [
                    { key: 'index', label: 'SL', sortable: true },
                    { key: 'nominee_name', sortable: true },
                    { key: 'relationship.text', label: 'Relationship', sortable: true },
                    {
                        key: 'autistic_yn',
                        formatter: (value) => {
                            if(value == 'Y'){
                                return 'YES'
                            } else if(value == 'N'){
                                return 'NO'
                            } else {
                                return ''
                            }
                        },
                        label: 'Autistic',
                        sortable: true},
                    {
                        key: 'percentage',
                        formatter: (value) => {
                            if (value > 0){
                                return value + '%'
                            } else {
                                return '0%'
                            }
                        },
                    }
                ]
            }
        },
        mounted() {
            this.loadEmployee()
            this.loadNominee()
        },
        watch: {
            "formData.percent":function (val, oldVal) {
                this.calAmount(val)
            }
        },
        methods: {
            onSubmit() {
                this.formData.officeOrderDate = moment(this.formData.officeOrderDate).format('YYYY-MM-DD');
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/providentFund/employees/add`, this.formData).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                })
            },
            onReset() {

            },
            loadEmployee() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominees/current-employee`).then(res => {
                    this.emps = res.data;
                    if(res.data[0].basic_amt == null || res.data[0].basic_amt==''|| res.data[0].basic_amt==undefined){
                        this.formData.basic_amt=0;
                    }else{
                        this.formData.basic_amt=parseFloat(res.data[0].basic_amt);
                    }
                    if(res.data[0].gpf_pct == null || res.data[0].gpf_pct==''|| res.data[0].gpf_pct==undefined){
                        this.formData.percent=5;
                    } else {
                        this.formData.percent=res.data[0].gpf_pct;
                    }
                    this.formData.emp_code = res.data[0].emp_code
                    this.formData.emp_id = res.data[0].emp_id
                    this.calAmount(this.formData.percent)
                });
            },
            calAmount(val) {
                let percent =parseFloat(val);
                this.formData.amount = (parseFloat(this.formData.basic_amt)*percent)/100;
            },
            loadNominee() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominees/current-employee-nominee`).then(res => {
                    this.items = res.data.data.filter(a=>a.nominee_for_id == 1);
                });
            },
        }
    }
</script>

<style scoped>

</style>
