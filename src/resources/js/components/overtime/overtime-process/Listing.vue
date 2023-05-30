<template>
    <b-card title="Overtime Process List">
        <b-card-text>
            <!--b-table striped hover :items="items"></b-table-->

            <Datatable v-bind:fields="tableDataAllowancs.fields" v-bind:items="tableDataAllowancs.items"  v-bind:pageColSize="4" v-bind:searchColSize="5">
                <template v-slot:actions="{ rows }">
                    <b-form-checkbox></b-form-checkbox>
                </template>
                <template  v-slot:action5="{ rows }" >
                    <b-form-select id="shift" v-model="shift" :options="e_shift"></b-form-select>
                </template>
                <template  v-slot:actionFromDate="{ rows }" >
                    <date-picker  input-class="form-control" v-model="date"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                </template>
                <template  v-slot:actionToDate="{ rows }" >
                    <date-picker   input-class="form-control" v-model="to_date"  type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                </template>
                 <template  v-slot:action2="{ rows }" >
                        <b-form-input v-model="OtAppHourDay"></b-form-input>
              </template>
                <template  v-slot:action3="{ rows }" >
                    <b-form-input v-model="workHours"></b-form-input>
                </template>
                <template  v-slot:action4="{ rows }" >
                    <b-form-input readonly v-model="overTimeHours"></b-form-input>
                </template>


            </Datatable>
             <b-col class="d-flex justify-content-end ">
                        <b-button type="submit" class="btn btn-dark shadow mt-1  mb-1">Submit</b-button> &nbsp;
                    </b-col>

        </b-card-text>
    </b-card>
</template>

<!--script>
export default {
  data() {
    return {
        items: [
                { ID: 40, Name: 'Mr Waker Khan', DESIGNATION: "Sr. Computer operator", 'Approved OT(Hhh)': "2", "Actual OT(Hhh)":3},
            { ID: 41, Name: 'Mr Waker Khan', DESIGNATION: "Sr. Computer operator", 'Approved OT(Hhh)': "2", "Actual OT(Hhh)":3},
         ]
    };
  },
  mounted() {
  }
};
</script-->


<script>
import DatePicker from 'vue2-datepicker';
import Datatable from '../../../layouts/common/datatable';


export default {
         components: {
            Datatable,DatePicker
        },


  data() {
    return {
        //overtimeprocess = '',
        date:new Date(),
        to_date:new Date(),
        position: '',
        shift:null,
        workHours:null,
        OtAppHourDay:null,
        overTimeHours:null,
        e_shift: [{ text: 'Select One', value: null }, 'shift-1', 'shift-2'],
         tableDataAllowancs: {
                    fields: [
                        {key:'action', label:'Select'},{key:'id', label:'ID' ,sortable:true},
                        {key:'action5', label:'Shift', sortable:true},
                        {key:'actionFromDate', label:'From',sortable:true},
                        {key:'actionToDate',label:'To', sortable:true},{key:'action2', label:'OT Approve Hours/Days'},
                        {key:'action3', label:'Work Hours'},{key:'action4', label:'Over Time Hours'}
                        ],

                    items: [
                         { "actions": "","id": 40,"actionFromDate":"14/10/2019","actionToDate":"10/12/2019", },

                    ]
                },
    };
  },
  mounted() {
  }
};
</script>
