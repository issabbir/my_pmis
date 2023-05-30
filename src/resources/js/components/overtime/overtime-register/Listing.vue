<template>
    <b-card title="Overtime Register List">
        <b-card-text>

            <!--b-table striped hover :items="items"></b-table-->

            <Datatable v-bind:fields="tableDataAllowancs.fields" v-bind:items="tableDataAllowancs.items"  v-bind:pageColSize="4" v-bind:searchColSize="5">
                <template v-slot:actions="{ rows }">
                    <b-form-checkbox></b-form-checkbox>
                </template>

                 <template  v-slot:action2="{ rows }" >
                        <b-form-input v-model="position"></b-form-input>
              </template>
                  <template  v-slot:action3="{ rows }" >
                        <b-form-input v-model="remarks"></b-form-input>
              </template>

            </Datatable>

            <b-row class="mt-3">
                    <b-col class="d-flex justify-content-end ">
                        <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Submit</b-button> &nbsp;
                        <b-button type="reset" class="btn btn-outline-dark  mb-1">Cancel</b-button>
                    </b-col>
            </b-row>
        </b-card-text>
    </b-card>
</template>

<script>
import Datatable from '../../../layouts/common/datatable';
export default {
         components: {
            Datatable
        },

  data() {
    return {

         tableDataAllowancs: {
                    fields: [{key:'action', label:'Select'},
                    {key:'id', sortable:true}, {key:'Name', sortable:true},
                    {key:'Designation', sortable:true}, {key:'From_Date', sortable:true},
                    {key:'action2', label:'Ot Hours'},
                    {key:'action3', label:'Remarks',sortable:true},
                    {key:'status', label:'Status',sortable:true}],

                    items: [
                        { "actions": "",
                        "id": 40,"Name": 'Mr Karim',
                        "Designation": "Sr. Computer operator",
                        "From_Date": "03/10/2018","position": "",
                        "remarks":"",
                        "status": "" },
                         { "actions": "","id": 41,"Name": 'Mr Rahim',"Designation": "Sr. Computer operator","From_Date": "03/10/2018","position": "","remarks":"","status": "Approved" },
                    ]
                },
    };
  },
  mounted() {
  }
};
</script>
