<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card" style="width: 800px; height: 900px; margin: 70px; padding: 20px">
                <h2 style="text-align: center; text-decoration:underline">চট্টগ্রাম বন্দর কর্তৃপক্ষ</h2>
                <br>
                <div>
                    <p>জিপিএফ/ সিপিএফ/ চুড়ান্ত নিষ্পত্তি/ পেনশন/ বদান্য তহবিলের টাকা প্রদানের নির্দেশিকাঃ</p>
                    <p>
                        বরাবরে,
                        <br>প্রধান নিরীক্ষা কর্মকর্তা
                        <br>চট্টগ্রাম বন্দর কর্তৃপক্ষ,
                        <br> চট্টগ্রাম।
                    </p>
                    <p style="text-align: justify">
                        মহোদয়,
                        <br>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;অনুগ্রহ পূর্বক আমার/ আমার স্বামীর/ পিতার/ মাতার প্রদেয়/ সাধারণ ভবিষ্যত তহবিল/ চুড়ান্ত নিষ্পত্তি/ পেনশন/ বদান্য তহবিলের টাকা নিয়ন্ত্রণকারী কর্মকর্তার সম্মুখে নগদে/ একাউন্টপেয়ি চেকের মাধ্যমে/ পে-অর্ডার/ ডিডি এর মাধ্যমে আমার ব্যাংক হিসাব নং বিএন০১২১২১২৫৫৫৪ ব্যাংকের নামঃ কৃষি ব্যাংক , শাখাঃ মিরপুর-১২, জেলাঃ ঢাকা, এর অনুকূলে পরিশোধের অনুরোধ করা গেল।
                    </p>
                    <p style="text-align: justify">
                        আমি এই মর্মে ঘোষণা করিতেছি যে, উপরোক্ত উপায়ে পরিশোধিত টাকা আমার ব্যক্তিগত ঝুকিতে পরিশোধ করা হইয়াছে বলিয়া গণ্য হইবে। উপরে নির্দেশিত পরিশোধিত পদ্ধতি অনুসরণের ফলে টাকা পরিশোধে কোন প্রকার জটিলতা দেখা দিলে উহার জন্য চট্টগ্রাম বন্দর কর্তৃপক্ষ দায়ী থাকিবেনা মর্মে নিশ্চয়তা প্রদান করিতেছি।
                    </p>
                    <p style="float: right">
                        আপনারই বিশ্বস্ত
                        <br><img style="width: 150px; height: 50px" src="https://www.best-signature.com/wp-content/uploads/2017/01/e20_1.jpg">
                        <br>--------------------- <br>
                        স্বাক্ষর<br>
                        নামঃ মোঃ মেহেদী হাসান<br>
                        পদবীঃ অ্যাসিস্ট্যান্ট সফটওয়্যার ইঞ্জিনিয়ার<br>
                        ডিপার্টমেন্টঃ সফটওয়্যার এন্ড সিস্টেম<br>
                        তারিখঃ ২১/১১/২০১৯
                    </p>
                </div>

            </b-card>
        </div>


    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    //import Datatable from '../../layouts/common/datatable';
    import Datatable from '../../../layouts/common/datatable';

    export default {
        components: {DatePicker, Datatable},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PF Withdraw Print"});
        },
        data() {
            return {
                applyDate: new Date(),
                form: {
                    empId: '',
                    empName: '',
                    designation_id: null,
                    department_id: null,
                    pf_id: ''
                },
                balance_date: new Date(),
                designationList: [{
                    text: 'Select One',
                    value: null
                }, 'Chairman', 'General Manager (A & F)', 'General Manager (Admin)', 'Head Of ICT'],
                departmentList: [{
                    text: 'Select One',
                    value: null
                }, 'Administration', 'Planning', 'Security', 'Finance & Accounts'],
                show: true,
                fields: [{key: 'months', label: 'Months', sortable: true, sortDirection: 'desc'},
                    {key: 'subcription', label: 'Subcription', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'extpf', label: 'Ext. PF/Apr. PF', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'loandrawn', label: 'Loan Deawn', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'loanrepay', label: 'Loan Repay', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'settlement', label: 'Settlement', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'monincome', label: 'Monthly Income', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'action'],
                items: [
                    {
                        months: 'JUL', subcription: '4,848.00', extpf: '0.00', loandrawn: '0.00', loanrepay: '10,000.00',
                        settlement: '0.00', monincome: '1,700.00',action: ''

                    },
                    {
                        months: 'AUG', subcription: '5,090.00', extpf: '0.00', loandrawn: '0.00', loanrepay: '10,000.00',
                        settlement: '0.00', monincome: '1,800.00',action: ''

                    },
                    {
                        months: 'SEP', subcription: '5,900.00', extpf: '0.00', loandrawn: '0.00', loanrepay: '10,000.00',
                        settlement: '0.00', monincome: '2,027.00',action: ''

                    },
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
                console.log(JSON.parse(JSON.stringify(this.academic)));

            },
            onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.form.empId = '',
                    this.form.empName = '';
                this.form.designation_id = null,
                    this.form.department_id = null,
                    this.form.pf_id = '',

                    // Trick to reset/clear native browser form validation state
                    this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })

            },
            /*editRow(i, code) {

            },*/
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            }

            /*onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }*/

        }
    }
</script>

