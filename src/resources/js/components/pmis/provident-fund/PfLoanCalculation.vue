<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-card>
        <b-card-header header-bg-variant="dark" header-text-variant="white">PF Loan Calculation</b-card-header>
        <b-card-body class="border">
           <b-form @submit="onSubmit" @reset="onReset">
             <b-row>
              <b-col>
                <b-form-select :options="month" @></b-form-select>
              </b-col>
             </b-row>
             <b-row>
                <b-col class="mt-2 d-flex justify-content-end">
                    <b-button md="6" size="md" variant="dark" type="submit">Submit</b-button>&nbsp;
                    <b-button md="6" size="md" class="btn-outline-dark" type="reset">Cancel</b-button>
                </b-col>
            </b-row>
           </b-form>
        </b-card-body>
      </b-card>
    </div>
  </div>
</template>
<script>
  import DatePicker from "vue2-datepicker";
  import Datatable from '../../../layouts/common/datatable';

  export default {
    components: {DatePicker, Datatable},
    mounted() {
        this.$store.commit("setBreadcrumbEmpty");
        this.$store.commit("setBreadcrumb", {link: "#", label: "provident Fund"});
        this.$store.commit("setBreadcrumb", {link: "#", label: "PF Loan Calculation"});
    },
    data(){
      return{
        month:[],
        
      }
    },
    methods:{
      onSubmit(evt) {
        evt.preventDefault()
      },
      onReset(evt) {
        evt.preventDefault()
      }
    }

  }
</script>