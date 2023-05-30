<template>
    <div>
    <button :class="classes" @click="click(data)" title="Update">
        <span>
            <i class='bx bxs-detail' ></i>
        </span>
    </button>
     <a :href="renderPaySlip(data)" v-if=false target="_blank" class="btn btn-info btn-sm"><i class='bx bxs-file-pdf'></i> Pay slip</a>
    </div>
</template>

<script>

    export default {
        data()  { return  {
            reportPaySlip: {
                xdo: '/~weblogic/PR/Emp_pay_slip.xdo',
                type: "pdf",
                bill_code: 81, //Bill code instead of biller code.
                pr_month: '',
                pr_year:'',
                emp_code:"",
                filename: 'Payroll_Salary'
            }
          }
        },
        props: {
            data: {},
            name: {},
            click: {},
            meta: {},
            classes: {}
        },
        methods: {
            renderPaySlip:function(data){
                this.reportPaySlip.bill_code = data.bill_code; //Bill code instead of biller code.
                this.reportPaySlip.pr_year = data.pr_year;
                this.reportPaySlip.pr_month = data.pr_month_id;
                this.reportPaySlip.emp_code = data.emp_code;
                this.reportPaySlip.type='pdf';
                let params = this.reportPaySlip;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                return '/report/render?' + queryString;
            },
        }
    }
</script>