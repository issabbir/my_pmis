<template>
  <div class="content-wrapper">
    <div class="content-body ">
      <b-card title="Bill List">
        <b-card-body class="border">
          <Datatable v-bind:fields="fields" v-bind:items="items">
            <template slot="actions" v-bind:row="row">
              <a size="sm" class="text-primary" href=""
                  data-toggle="modal"
                  data-target="#border-less">
                  <i class="bx bx-edit cursor-pointer"></i>
              </a>
              <a size="sm" class="text-primary" href=""
                  data-toggle="modal"
                  data-target="#border-details">
                  <i class="bx bx-show cursor-pointer"></i>
              </a>
            </template>
          </Datatable>
        </b-card-body>
    </b-card>
    </div>
  </div>
</template>

<script>
  import Datatable from '../../layouts/common/datatable';
  export default {
    components: {Datatable},
    mounted() {
      this.$store.commit("setBreadcrumbEmpty");
      this.$store.commit("setBreadcrumb", {link: "#", label: "Payroll"});
      this.$store.commit("setBreadcrumb", {link: "#", label: "Bill Updates"});
    },
    data(){
      return {
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
      }
    },
    methods: {

    }
  }
</script>