<template>
    <b-card title="Overtime Register">
        <b-card-text>
            <b-table striped hover :items="items"></b-table>
        </b-card-text>
    </b-card>
</template>

<script>
export default {
  data() {
    return {
        items: [
            { ID: 40, EmployeeName: 'Mr Waker Khan', EmployeeID: "Sr. Computer operator", 'Level Type': "2", "Start Date":'12/06/2019', "End Date":"12/20/2019", "Date Of Recived":"30/06/2019"},
            { ID: 41, EmployeeName: 'Mr Waker Khan', EmployeeID: "Sr. Computer operator", 'Level Type': "2", "Start Date":'12/06/2019', "End Date":"12/20/2019", "Date Of Recived":"30/06/2019"},
          ]
    };
  },
  mounted() {
  }
};
</script>
