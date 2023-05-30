<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card mb-5"  title="Product Request">
                <b-form  class="mb-5" @submit="onSubmit" @reset="onReset">
                    <b-row >
                       <b-col md="4">
                           <b-form-group
                               label="Select Product"
                               label-for="product"
                           >
                          <b-form-select v-model="product" :options="e_product"></b-form-select>
                           </b-form-group>
                       </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Product Quantity"
                                label-for="quantity "
                            >
                                <b-form-select v-model="quantity" :options="e_quantity"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Date & Time"
                                label-for="date"
                            >
                                <date-picker v-model="date"  type="datetime"  width ="100%" lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                            </b-form-group>

                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <b-form-group
                                label="Select Delivery Format"
                                label-for="product"
                            >
                                <b-form-file id="file-default"></b-form-file>
                            </b-form-group>
                        </b-col>
                        <b-col>
                            <b-form-group
                                label="Expected Delivery Date"
                                label-for="date"
                            >
                                <date-picker v-model="date"  type="datetime"  width ="100%" lang="en" format="YYYY-MM-DD hh:mm:ss" confirm></date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col>
                            <b-form-group
                                label="Note If Any"
                                label-for="product"
                            >
                                <b-form-textarea
                                    id="note"
                                    size="lg"
                                    placeholder="Note"
                                ></b-form-textarea>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row class="d-flex justify-content-end">
                        <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-2 mt-2">Submit</b-button>
                        <b-button type="reset" class="btn btn-outline-dark mr-1 mb-2 mt-2">Close</b-button>
                    </b-row>
                </b-form>

            </b-card>


        </div>


    </div>
</template>




<script>
    import DatePicker from "vue2-datepicker";
    export default {
        components: {DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Hydrography"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Product Request"});

        },
        data() {
            return {
                interviwdate: new Date(),
                date: new Date(),

                form: {
                    refno: '',
                    jobTitle: '',
                },
                e_product: [
                    { value: null, text: 'select one' },
                    { value: 'a', text: 'abc' },
                    { value: 'b', text: 'abc' },
                    { value: { C: '3PO' }, text: 'abc' }

                ],
                e_quantity:[
                    { value: null, text: 'select one' },
                    { value: 'a', text: '1' },
                    { value: 'b', text: '2' },
                    { value: 'd', text: '3' }
                ],


                reasonList: [{text: 'Cost of prolonged illness', value: 1},
                    {text: 'Cost of overseas passage', value: 2},
                    {text: 'Cost of marriage or funeral', value: 3},
                    {text: 'Expenses of purchasing house/site or repairing house', value: 4},
                    {text: 'Educational expenses of purchasing of children or dependents or any other important purpose', value: 4}],
                appInstlmntList: [{text: '12', value: 1}, {text: '24', value: 2}, {text: '48', value: 3}],
                show: true,
                resultstatuslist: [{text: 'Pass', value: 1}, {text: 'Fail', value: 2}, {text: 'Expelled', value: 3}],
                boardactionlist: [{text: 'Interview', value: 1}, {text: 'Reject', value: 2}],
                fields: [{key: 'SL', label: 'Sl', sortable: true, sortDirection: 'desc'},
                    {key: 'empid', label: 'Emp Id', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'empname', label: 'Employee Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'appliedamt', label: 'Applied Amount', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'reason', label: 'Reason', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'installment', label: 'Installment', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'action'],
                items: [
                    {SL: '1', empid: '31', empname: 'Waker Khan', appliedamt: '100000', reason: 'House Building',
                        installment: '10', action: ''},
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                },
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if (this.updateIndex > -1) { //update
                    this.tableData.items[this.updateIndex].employee_id = this.form.employee_id;
                    this.tableData.items[this.updateIndex].department_name = this.form.department_name;
                    this.tableData.items[this.updateIndex].designation = this.form.designation;
                    this.tableData.items[this.updateIndex].division_name = this.form.division_name;
                    this.tableData.items[this.updateIndex].financial_code = this.form.financial_code;
                    this.tableData.items[this.updateIndex].shift = this.form.shift;
                } else { //new data add
                    this.tableData.items.push({
                        employee_id: this.form.employee_id,
                        department_name: this.form.department_name,
                        designation: this.form.designation,
                        division_name: this.form.division_name,
                        financial_code: this.form.financial_code,
                        shift: this.form.shift,
                    });
                }
                this.onReset(evt);
            },
            onReset(evt) {
                evt.preventDefault();
                this.employee_id = '';
                this.department_name = '';
                this.designation = '';
                this.division_name = null;
                this.financial_code = null;
                this.shift = null;
                this.updateIndex = -1;
                this.submitBtn = 'Process';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(i, code) {
                this.submitBtn = 'Update';
                this.updateIndex = i;
                let data = this.tableData.items[i];
                console.log(data);
                this.form.employee_id = data.employee_id;
                this.form.department_name = data.department_name;
                this.form.designation = data.designation;
                this.form.division_name = data.division_name;
                this.form.financial_code = data.financial_code;
                this.form.shift = data.shift;
                console.log(this.form);
            },
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            }

        }
    }
</script>

