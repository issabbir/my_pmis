<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card mb-5"  title="">
                <b-form  class="mb-5">
                    <b-row >
                        <b-col md="2">
                            <b-form-group
                                label="Invoice# 000756"
                                label-for="invoice"
                            >
                            </b-form-group>
                        </b-col>
                        <b-col md="10" >
                                    <b-row>
                                            <b-col md="5" offset-md="5" class="d-flex justify-content-end" >
                                                <b-form-group
                                                    label="Issue Date:08/10/2019"
                                                    label-for="IssueDate"
                                                >
                                                </b-form-group>
                                            </b-col>
                                        <b-col class="d-flex justify-content-end" >
                                            <b-form-group
                                                label="Due Date:12/10/2019"
                                                label-for="dueDate"
                                            >
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row >
                        <b-col md="6">
                            <h4>Invoice</h4>
                            <b-form-group
                                label="Hydrography"
                                label-for="hy"
                            >
                            </b-form-group>
                        </b-col>
                        <b-col md="6" >
                            <b-row class="d-flex justify-content-end">
                                <b-col md="3">
                                    <b-form-group
                                        label=""
                                        label-for=""
                                    >
                                        <b-img src="https://picsum.photos/300/150/?image=41" fluid alt="Fluid image"></b-img>
                                    </b-form-group>
                                </b-col>

                            </b-row>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row >
                        <b-col md="6">
                            <h6>Bill From</h6>
                            <label>Clevision PVT. LTD. </label><br>
                            <label>9205 Whitemarsh Street New York, NY 10002</label><br>
                            <label>hello@clevision.net</label><br>
                            <label>601-678-8022</label>
                        </b-col>
                        <b-col md="6">
                            <h6>Bill To</h6>
                            <label>Pixinvent PVT. LTD. </label><br>
                            <label>203 Sussex St. Suite B Waukegan, IL 60085</label><br>
                            <label>pixinvent@gmail.com</label><br>
                            <label>987-352-5603</label>

                        </b-col>

                    </b-row>
                    <hr>
                    <template>
                        <div>
                            <b-table :items="items" :fields="fields"></b-table>
                        </div>
                    </template>
                    <b-row >
                        <b-col md="6">
                            <b-form-group
                                label="Thanks for your business"
                                label-for="hy"
                            >
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-row class="d-flex justify-content-end">
                                <b-col md="4">
                                    <b-row>
                                        <b-col>
                                            <label>Subtotal</label><br>
                                            <label>Discount</label><br>
                                            <label>Tax</label><br>
                                        </b-col>
                                        <b-col>
                                            <label>$76.00</label><br>
                                            <label>$ 09.60</label><br>
                                            <label>21%</label><br>
                                        </b-col>
                                    </b-row>

                                </b-col>
                            </b-row>

                            <b-row class="d-flex justify-content-end">
                                <b-col md="4">
                                    <hr>
                                    <b-row>
                                        <b-col>
                                            <label>
                                                Invoice Total
                                            </label><br>
                                            <label>
                                                Paid to date
                                            </label><br>
                                            <label>
                                                Balance (USD)$
                                            </label><br>
                                        </b-col>
                                        <b-col>
                                            <label>$66.00</label><br>
                                            <label>-$ 00.00</label><br>
                                            <label>$ 10,953</label><br>
                                        </b-col>
                                    </b-row>

                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <label for="ab">ADMIN PROCESS:</label>
                            <b-form-select v-model="form.adminProcess" :options="adminProcessList"></b-form-select>
                        </b-col>
                        <b-col >
                            <b-row >
                                <b-col>
                                    <b-form-group v-if="form.adminProcess == 2">
                                        <b-form-checkbox-group
                                            v-model="form.selected1"
                                            :options="options"
                                            name="flavour-2a"
                                            stacked
                                        ></b-form-checkbox-group>
                                    </b-form-group>
                                </b-col>
                            </b-row>


                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <label for="a">Note:</label>
                            <b-form-textarea
                                id="textarea-small"
                                size="lg"
                                placeholder=""
                            ></b-form-textarea>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row class="d-flex justify-content-end">
                        <b-button type="" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-2 mt-2">Submit</b-button>
                        <b-button type="" class="btn btn-outline-dark mr-1 mb-2 mt-2">Close</b-button>
                    </b-row>
                </b-form>

            </b-card>


        </div>


    </div>
</template>


<script>
    export default {
        data() {
            return {

                form:{
                    adminProcess:1,
                    selected1: null,
                    section : null,
                    date : new Date(),
                },
                adminProcessList: [
                    {value:1 ,text:'Back To Admin'}, { value:2 ,text:'Approve',}],

                sectionList: [{ text: 'Select One', value: null }, 'Computer', 'Billing'],

                 // Must be an array reference!
                options: [
                    { text: 'Sabbir (Manager)', value: 'Sabbir (Manager)' },
                    { text: 'Hossain (Programmer)', value: 'Hossain (Programmer)' },
                    { text: 'Rabbi (Programmer)', value: 'Rabbi (Programmer)' }

                ],
                fields: [
                    {
                        key: 'ITEM',
                        sortable: false
                    },
                    {
                        key: 'DESCRIPTION',
                        sortable: false
                    },
                    {
                        key: 'COST',
                        sortable: false
                    },
                    {
                        key: 'QTY',
                        sortable: false
                    },
                    {
                        key: 'PRICE',
                        label: 'Price',
                        sortable: false,
                        class:"text-right",
                        // Variant applies to the whole column, including the header and footer
                        variant: ''
                    }
                ],
                show: true,
                items: [
                    { ITEM: 'Chart', DESCRIPTION: 'Graphical view show', COST: '28',QTY: '1',PRICE: '$28.00', },

                ]
            }

        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Hydrography"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Admin Request List"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Invoice"});
        },
    }
</script>
