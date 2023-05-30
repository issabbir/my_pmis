<template>
        <!-- BEGIN: Content-->

         <div class="content-wrapper">
                <div class="content-body">

                    <b-card >
                        <b-form  @submit="onSubmit" @reset="onReset">
                            <b-row>
                                <b-col md="6" offset-md="3" >
                                    <h5 >Product Settings </h5>
                                    <b-row mb="1">
                                        <b-col>
                                            <b-form-group
                                                label="Product Name"
                                                label-for="productName"
                                            >
                                                <b-form-input
                                                    id="productName"
                                                    v-model="productSetting.productName"
                                                    type="text"
                                                    required
                                                    placeholder=" Enter Product Name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col >
                                            <b-form-group
                                                label="Product Price"
                                                label-for="productPrice"
                                            >
                                                <b-form-input
                                                    id="companyName"
                                                    v-model="productSetting.productPrice"
                                                    type="text"
                                                    required
                                                    placeholder="Enter Product Price "
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col >
                                            <b-form-group
                                                label="Product Category"
                                                label-for="productCategory "
                                            >
                                                <b-form-select v-model="productSetting.productCategory" :options="e_product"></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col >
                                            <b-form-group
                                                label="Description"
                                                label-for="description"
                                            >
                                                <b-form-textarea
                                                    id="description"
                                                    size="sm"
                                                    placeholder="Description"
                                                ></b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </b-col>

                            </b-row>
                            <b-row class="d-flex justify-content-center">
                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-2 mt-2">Save</b-button>
                                <b-button type="reset" class="btn btn-outline-dark mr-1 mb-2 mt-2">Cancel</b-button>
                            </b-row>
                        </b-form>

                    </b-card>
                    <b-card class="card">
                        <b-row>
                            <b-col>
                                <b-card title="Product Settings">
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
                                                class="mb-0">
                                                <b-form-select
                                                    v-model="perPage"
                                                    id="perPageSelect"
                                                    size="sm"
                                                    :options="pageOptions"></b-form-select>
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
                                    <b-table striped hover show-empty
                                             small
                                             stacked="md"
                                             :items="items"
                                             :fields="fields"
                                             :current-page="currentPage"
                                             :per-page="perPage"
                                             :filter="filter"
                                             :filterIncludedFields="filterOn"
                                             :sort-by.sync="sortBy"
                                             :sort-desc.sync="sortDesc"
                                             :sort-direction="sortDirection"
                                             @filtered="onFiltered">

                                        <template v-slot:cell(action)="row">
                                            <a size="sm"  class="text-primary" data-toggle="modal" href="#" data-target="#border-less"><i class="bx bx-edit cursor-pointer"></i> </a>
                                            <a target="_self" href="#" class="text-primary"><i class="bx bx-show  cursor-pointer"></i></a>

                                        </template>

                                    </b-table>
                                    <b-col sm="12" md="12" class="my-1">
                                        <b-pagination
                                            v-model="currentPage"
                                            :total-rows="totalRows"
                                            :per-page="perPage"
                                            align="right"
                                            size="sm"
                                            class="my-0"></b-pagination>
                                    </b-col>
                                </b-card>
                            </b-col>
                        </b-row>
                    </b-card>
                </div>
            </div>

        <!-- END: Content-->

</template>

<script>
    import DatePicker from 'vue2-datepicker'
    // import marine from '../../json/incident.json';


    export default {
        components: { DatePicker,

        },
        data(){
            return {

         productSetting: {
             productName: '',
             description: '',
             productPrice: '',
             productCategory: null,

         },
                e_product:[
                    { value: null, text: 'Select One' },
                    { value: '1', text: 'Chart' },
                    { value: '2', text: 'Map' },

                ],
                show: true,
                fields: [{key: 'ProductId', label: 'Product Id', sortable: true, sortDirection: 'desc'},
                    {key: 'ProductName', label: 'Product Name', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'ProductCategory', label: 'Product Category', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'ProductPrice', label: 'Product Price', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'ProductDescription', label: 'Product Description', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'CreatedDate', label: 'Created Date', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'action'],
                items: [
                    {ProductId: '00012', ProductName: 'Survey Chart', ProductCategory: 'Chart', ProductPrice: '$20', ProductDescription: 'sdf sdfdf',
                        CreatedDate: '10/01/2019',  action: ''},
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
            this.$store.commit("setBreadcrumb", { link: "#", label: "Hydrography" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Product Settings" });
            this.totalRows = this.items.length

        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if (JSON.parse(localStorage.getItem('marine.incident'))) {
                    this.incidents = JSON.parse(localStorage.getItem('marine.incident'));
                    this.marine.incident.incidentID = parseInt(this.incidents[this.incidents.length - 1].incidentID) + 1;
                }
                this.incidents.push(this.marine.incident);
                localStorage.setItem('marine.incident', JSON.stringify(this.incidents));
                this.items = this.incidents;
                this.totalRows = this.items.length;
                this.marine.incident = {};
            },
            onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.form.incidentID = '';
                this.form.description = '';
                this.form.category = null;
                this.form.location = null;
                this.form.shipname = null;
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
            },
            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`;
                this.infoModal.content = JSON.stringify(item, null, 2);
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            resetInfoModal() {
                this.infoModal.title = '';
                this.infoModal.content = ''
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1
            }
        }

    }
</script>
