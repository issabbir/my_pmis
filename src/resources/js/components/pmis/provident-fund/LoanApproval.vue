<template>
  <div class="content-wrapper">
        <div class="content-body">
            <b-card id="form_name1">
              <b-card-title>
                <h3 style="float:left">Loan Application</h3>
                <b-form-select for='input-group-1' v-model="searchParams.type" :options="applicationTypes" style="float:right" class="col-md-2"></b-form-select>
              </b-card-title>
                <b-card-text>
                    <b-form @submit="onSubmit">
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                        label-for="input-group-1"
                                        label="Application Type:">
                                    <b-form-select for='input-group-1' v-model="searchParams.type" :options="applicationTypes"></b-form-select>
                                </b-form-group>
                            </b-col>

                        </b-row>
                    </b-form>
                </b-card-text>
            </b-card>

            <b-card title="Employee Leave Summery Search Result">
                <b-card-body>
                    <Datatable  v-bind:fields="columns" :totalList="totalItems" perPage="10" v-bind:items="listItems"  :primaryKeyColumnName="'emp_code'"></Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>
<script>

    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from '../../../Repository/ApiRepository';
    import moment from 'moment';

    export default {
    data() {
        return {
          searchParams: {year:moment().format("YYYY"), type:''},
          listItems:[],
          totalItems:0,
          applicationTypes:[],
          years:[],
          applicationTypes:[],
          columns: [
                {
                      label: 'Employee Code',
                      key: 'emp_code',
                      sortable:true
                },
                {
                    label: 'Employee Name',
                    key: 'emp_name',
                    sortable:true
                },
                {
                    label: 'Leave type',
                    key: 'leave_type',
                },
                {
                    label: 'Leave Year',
                    key: 'leave_from_balance',
                },
                {
                    label: 'Leave Enjoyed',
                    key: 'leave_enjoy',
                },
                {
                    label: 'Leave Remaining',
                    key: 'leave_remaining_balance',
                }
            ],
        };
  },
  mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", { link: "#", label: "Provident Fund" });
    this.$store.commit("setBreadcrumb", { link: "/pf-summary", label: "Loan Application" });
    this.getFormData();
  },
  components: {
      Datatable
  },
  beforeMount(){

  },
  methods: {
    onSubmit: function(e) {
        e.preventDefault();
        this.search();
    },
    getFormData: function () {
        ApiRepository.callApi(ApiRepository.GET_COMMAND, '/leave/leave-summery-form-data').then(res => {
            this.applicationTypes = res.data.leave_types;
            this.years = res.data.leave_years;
        });
    },
    search: function() {
        let params = this.searchParams;
        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/leave/leave-summery-search', params).then(res => {
            this.listItems = res.data.list;
            this.totalItems = res.data.total;
        });
    }
  }
};
</script>
