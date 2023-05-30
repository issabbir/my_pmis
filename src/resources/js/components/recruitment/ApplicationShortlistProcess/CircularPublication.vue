<template>
  <div class="content-wrapper">
        <div class="content-body">
            <Datatable v-bind:fields="fields" v-bind:items="items" > 
                <template slot="actions" v-bind:row="row">   
                         <a size="sm"  class="mr-2 btn btn btn-dark shadow btn-sm" href="/recruitment#/job-application"> Apply Online </a>
                         <a size="sm"  class="mr-2 btn btn btn-dark shadow btn-sm" href="/recruitment#/publication-list-view"> View Job </a>
                </template> 
              </Datatable>
        </div>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker'
import Datatable from '../../../layouts/common/datatable';
    export default {
        components: { DatePicker,Datatable },
        data(){
           return {
                fields: [{key: 'SL', sortable: true},{key: 'jobTitle', sortable: true}, {key: 'LastDate', sortable: true}, {key: 'numerOfPost', sortable: true}, 'action'],
                items: [
                        {isActive: true,  SL:'1', jobTitle: 'Senior Programmer', LastDate: '20/11/2009', numerOfPost: '10' },
                        { SL:'2', jobTitle: 'Jonior Operator', LastDate: '08/07/2009', numerOfPost: '30' },
                        { SL:'3', jobTitle: 'Grreer', LastDate: '10/10/2009', numerOfPost: '50'},
                        { SL:'4', jobTitle: 'Asst. System Analyst', LastDate: '20/11/2009', numerOfPost: '10' },
                        { SL:'5', jobTitle: 'Senior Programmer', LastDate: '15/06/2009', numerOfPost: '5' },
                        { SL:'6', jobTitle: 'Senior Programmer', LastDate: '15/06/2009', numerOfPost: '5' },
                        { SL:'7', jobTitle: 'Senior Programmer', LastDate: '15/06/2009', numerOfPost: '5'},
                        { SL:'8', jobTitle: 'Senior Programmer', LastDate: '15/06/2009', numerOfPost: '5' },
                        { SL:'9', jobTitle: 'Senior Programmer', LastDate: '15/06/2009', numerOfPost: '5' },
                      ]
              }
         },
        props: ['row'],
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Online Recruitment" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Application Short List" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Publication List" });
            //this.totalRows = this.items.length
        },
         methods: {
              actionBtn(item, index, button) {
                this.infoModal.title = `Row index: ${index}`
                this.infoModal.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            }
         },

    }

</script>


<style scoped>

</style>
