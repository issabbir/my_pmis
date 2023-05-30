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
            { ID: 40, LeaveType: 'Sick Leave', StartDate: "01/01/2019", EndDate: "01/01/2019", Duration: "3", Remaining: "9", 'Application Status': "Approved"},
            { ID: 41, LeaveType: 'Sick Leave', StartDate: "01/01/2019", EndDate: "01/01/2019", Duration: "3", Remaining: "9", 'Application Status': "Approved"},
          ]
    };
  },
  mounted() {
  }
};
</script>
