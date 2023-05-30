<template>
  <div class="content-wrapper">
        <div class="content-body">
<b-row>
                        <b-col>
                            <b-card title="Job List">
                                <b-row>
                                <b-col sm="2" md="2" class="my-1">
                                    <b-form-group
                                    label="Per page"
                                    label-cols-sm="6"
                                    label-cols-md="6"
                                    label-cols-lg="6"
                                    label-align-sm="left"
                                    label-size="sm"
                                    label-for="perPageSelect"
                                    class="mb-0"
                                    >
                                    <b-form-select
                                        v-model="perPage"
                                        id="perPageSelect"
                                        size="sm"
                                        :options="pageOptions"
                                    ></b-form-select>
                                    </b-form-group>
                                 </b-col>
                                <b-col sm="3" md="3" class="my-1 ml-auto">
                                    <b-input-group size="sm">
                                        <b-form-input
                                        v-model="filter"
                                        type="search"
                                        label-align-sm="right"
                                        id="filterInput"
                                        placeholder="Type to Search"
                                        ></b-form-input>
                                        <b-input-group-append>
                                        <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                                        </b-input-group-append>
                                    </b-input-group>
                                  </b-col>
                                  </b-row>
                                 <b-table striped hover show-empty :items="items" :current-page="currentPage" :per-page="perPage" :filter="filter" :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc" :sort-direction="sortDirection" :fields="fields" responsive="sm">
                                <template v-slot:cell(action)="row">
                                        <b-button size="sm"  class="mr-2"> View </b-button>
                                </template>
                                </b-table>
                                <b-col sm="12" md="12" class="my-1">
                                    <b-pagination
                                    v-model="currentPage"
                                    :total-rows="totalRows"
                                    :per-page="perPage"
                                    align="right"
                                    size="sm"
                                    class="my-0"
                                    ></b-pagination>
                                </b-col>
                            </b-card>
                        </b-col>

                    </b-row>
        </div>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker'
    export default {
        components: { DatePicker },
        data(){
           return {
                fields: [
                            {key: 'jobTitle', sortable: true},
                            {key: 'AdvID', sortable: true},
                            {key: 'NoOfPost', sortable: true},
                            {key: 'Views', sortable: true},
                            {key: 'Application', sortable: true},
                            {key: 'status', sortable: true},
                            {key: 'expires', sortable: true},
                            'action'
                       ],
                items: [
                        {isActive: true,  SL:'1', jobTitle: 'Senior Programmer', AdvID: '06/2009', NoOfPost: '10', Views: '35', Application: '5',  status: 'Not Reviewed', expires: '20/11/2009' },
                        {isActive: true,  SL:'2', jobTitle: 'Jonior Operator', AdvID: '06/2009', NoOfPost: '5', Views: '135', Application: '35',  status: 'Not Reviewed', expires: '20/11/2009' },
                        {isActive: true,  SL:'3', jobTitle: 'Grreer', AdvID: '06/2009', NoOfPost: '15', Views: '35', Application: '65',  status: 'Not Reviewed', expires: '20/11/2009' },
                        {isActive: true,  SL:'4', jobTitle: 'Asst. System Analyst', AdvID: '06/2009', NoOfPost: '20', Views: '55', Application: '15',  status: 'Not Reviewed', expires: '20/11/2009' },
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
                }
              }
         },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Online Recruitment" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Application Short List" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Publication List" });
            this.totalRows = this.items.length
        },
         methods: {

             },
              actionBtn(item, index, button) {
                this.infoModal.title = `Row index: ${index}`
                this.infoModal.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }

    }

</script>


<style scoped>

</style>
