<template>
    <div>
        <ul class="nav nav-pills flex-column text-center text-md-left">
            <li class="nav-item" v-for="i in nav">
                <router-link :to="urlEnabled(i.link)" class="nav-link d-flex align-items-center" :class="urlEnabledClass(i.link)"><i
                         :class="i.icon"></i>
                    <span> {{i.label}}</span></router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['empId'],
        data() {
            return {
                nav:[
                    {link:this.createUrl('/employee/basic-info'), label:"Basic info", 'icon': "bx bx-cog"},
                    {link:this.createUrl('/employee/contacts'), label:"Contacts",'icon': "bx bx-wrench"},
                    //{link:this.createUrl('/employee/service'), label:"Service",'icon': "bx bx-wrench"},

                    {link:this.createUrl('/employee/address'), label:"Address", 'icon': "bx bx-home"},
                    {link:this.createUrl('/employee/family'), label:"Family",'icon': "bx bx-group"},
                    {link:this.createUrl('/employee/nominee'), label:"Nominee",'icon': "bx bxs-group"},
                    //{link:this.createUrl('/employee/tax-bank'), label:"Salary",'icon': "bx  bxs-dollar-circle"},
                    {link:this.createUrl('/employee/academic'), label:"Academic",'icon': "bx bxs-graduation"},
                    {link:this.createUrl('/employee/training'), label:"Training",'icon': "bx bxs-book"},
                    {link:this.createUrl('/employee/profCert'), label:"Professional Certificate",'icon': "bx bx-certification"},

                    {link:this.createUrl('/employee/experience'), label:"Experience",'icon': "bx bx-history"},
                    {link:this.createUrl('/employee/promotion'), label:"Promotion",'icon': "bx bx-chart"},
                    {link:this.createUrl('/employee/increment'), label:"Increment",'icon': "bx bx-trending-up"},
                    {link:this.createUrl('/employee/punishment'), label:"Punishment",'icon': "bx bx-user-x"},
                    {link:this.createUrl('/employee/transfer'), label:"Transfer",'icon': "bx bx-transfer-alt"},
                    {link:this.createUrl('/employee/tour'), label:"Tour",'icon': "bx bxs-plane-take-off"},

                    {link:this.createUrl('/employee/gpf-subscription'), label:"GPF Subscription",'icon': "bx bx-notification"},
                    {link:this.createUrl('/employee/pf-loan'), label:"PF Loan",'icon': "bx bx-money"},
                    //{link:this.createUrl('/employee/other-qualification'), label:"Other Qualification",'icon': "bx bx-hive"},
                    {link:this.createUrl('/employee/accommodation'), label:"Accommodation",'icon': "bx bx-building-house"},
                    {link:this.createUrl('/employee/attachments'), label:"Attachments",'icon': "bx bx-file"},
                    {link:this.createUrl('/employee/other-record'), label:"Others",'icon': "bx bx-cog"},

                    //{link:this.createUrl('/employee/identification'), label:"Identification",'icon': "bx bx-fingerprint"},
                ]
            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        methods: {
            createUrl(url) {
                if(this.empId !== undefined) {
                    return `${url}/${this.empId}`;
                }

                return `${url}`;
            },
            urlEnabled(url) {
                if(!this.empId || (this.empId === undefined)) {
                    if(url === '/employee/basic-info') {
                        return url;
                    } else if(url !== '/employee/basic-info') {
                           //this.$router.push('/employee/basic-info');
                        return '';
                     }
                }

                return url;
            },
            urlEnabledClass(url) {
                let cssCls = '';
                if(!this.empId || (this.empId === undefined)) {
                    if(url === '/employee/basic-info') {
                        cssCls = '';
                    } else if(url !== '/employee/basic-info') {
                        cssCls = 'disable';
                    }
                }

                return cssCls;
            }
        }
    }
</script>

<style>
    .nav-pills .nav-link.router-link-exact-active, .nav-pills .show > .nav-link {
        color:#FFF;
        background-color:#5A8DEE;
    }

    a.nav-link.d-flex.align-items-center.router-link-exact-active.router-link-active.disable {
        background-color: #f0f2f2  !important;
        color: #000;
    }
</style>
