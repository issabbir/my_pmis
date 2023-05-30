<template>
    
</template>

<script>
    import DatePicker from "vue2-datepicker";
    export default {
    components: {DatePicker},
            mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
    this.$store.commit("setBreadcrumb", {link: "#", label: "Suppliers & Customers"});
    this.$store.commit("setBreadcrumb", {link: "#", label: "Supplier Entry"});
    },
            data() {
    return {
    supplierEntry: {},
            show: true,
            updateIndex: - 1,
            submitBtn: "Save",
            paymentHold: [
            {text: "All Invoice", value: "All Invoice"},
            {text: "Unmatched Invoice", value: "Unmatched Invoice"},
            {text: "Invalided Invoice", value: "Invalided Invoice"}
            ],
            paymentPurposeOptions: [
            {text: "Purchasing", value: "Purchasing"},
            {text: "Payment", value: "Payment"},
            {text: "RFQ Only", value: "RFQ Only"}
            ],
            paymentMethodOptions: [
            {text: "Bill Payble", value: "Bill Payble"},
            {text: "Electronic", value: "Electronic"},
            {text: "Cheque", value: "Cheque"}
            ],
            voucherCurencyList: [
            {text: "BDT", value: "BDT"},
            {text: "USD", value: "USD"}
            ],
            voucherMatchOptions: [
            {text: "PO", value: "PO"},
            {text: "Receipt", value: "Receipt"}
            ],
            voucherAmountLimitOptios: [{text: "Immediate", value: "Immediate"}],
            supplierList: [{text: "", value: ""}],
            taxRegistrationNoList: [{text: "", value: ""}],
            countryList: [{text: "Bangladesh", value: "1"},
            {text: "China", value: "2"},
            {text: "India", value: "3"},
            {text: "Pakistan", value: "4"}, ],
            cityList: [{text: "Dhaka", value: "1"},
            {text: "Chittagong", value: "2"},
            {text: "Rajshahi", value: "1 "},
            {text: "Hong Kong", value: "1 "},
            {text: "Macau", value: "1 "},
            {text: "Beijing", value: "1 "},
            ],
            CCList:[{text: "880", value: "880"},
            {text: "86", value: "86"},
            {text: "91", value: "91"}]
            };
    },
    
        methods: {
            onSubmit(evt) {
            },
            onReset(evt) {
                evt.preventDefault();
                this.employee_id = "";
                this.department_name = "";
                this.designation = "";
                this.division_name = null;
                this.financial_code = null;
                this.shift = null;
                this.updateIndex = -1;
                this.submitBtn = "Save";
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(i, code) {
                this.submitBtn = "Update";
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
    };
</script>

