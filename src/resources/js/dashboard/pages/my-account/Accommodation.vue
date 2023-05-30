<template>
  <div class="content-body">
    <b-card title="Accommodation">
      <b-card-body class="border">
        <Datatable :fields="fields" :items="items" :totalList="totalList" :perPage="perPage"></Datatable>
      </b-card-body>
    </b-card>
  </div>
</template>

<script>

    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    import moment from "moment";

    export default {
        name: "Accommodation",
        components: { Datatable},
        data() {
            return {
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'colony_name', label:"Residential Area", sortable: true},
                    {key: 'house_type', label:"House Type", sortable: true},
                    {key: 'building_name', 'label': "Building Name", sortable: true},
                    {key: 'building_no', 'label': "Building Number", sortable: true},
                    {key: 'building_road_no', 'label': "Road Number", sortable: true},
                    {key: 'flat_name', label:'Flat Name', sortable: true},
                    {key: 'dormitory_booked_seat', label:'Seat Number', sortable: true},
                    {key: 'floor_number', label:"Floor", sortable: true},
                    {key: 'double_gas_yn', label:"Gas Burner", sortable: true},
                    {
                        key: 'take_over_date',
                        label:"Take Over Date",
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true
                    },
                    /*{key: 'house_name', 'label': "House Name", sortable: true},
                    {key: 'house_size', label:"House Size", sortable: true},

                    {key: 'colony_address', label:"Colony Address", sortable: true}*/
                ],
                items: [],
                totalList: 1,
                perPage: 1,
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "My Account"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Accommodation"});
            this.loadData();
        },
        methods: {
            loadData: function() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/accommodation`).then(res => {
                    this.items = res.data;
                    this.totalList = res.data.length;
                });
            }
        }
    }
</script>


<style>
</style>
