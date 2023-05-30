<!--template>
    <b-card title="Overtime Approval List">
        <b-card-text>

            <b-table striped hover :items="items"></b-table>

            <Datatable v-bind:fields="tableDataAllowancs.fields" v-bind:items="tableDataAllowancs.items"  v-bind:pageColSize="4" v-bind:searchColSize="5">
                <template v-slot:actions="{ rows }">
                    <b-form-checkbox></b-form-checkbox>
                </template>
                 <template  v-slot:action2="{ rows }" >
                        <b-form-input v-model="approvedOThour"></b-form-input>
              </template>

                <template  v-slot:action4="{ rows }" >
                    <b-form-select v-model="action4" :options="approvedStatusList"></b-form-select>
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
                approvedOThour:'',

                approvedStatusList: [
                    {value: 1, text: 'Approved'},
                    {value: 2, text: 'Reject'}
                ],
                processApprovalList:
                [
                {value: 1, text: 'Approved'},
                 {value: 2, text: 'Reject'}
                 ],
                tableDataAllowancs: {
                    fields: [{key: 'action', label: 'Select'}, {key: 'id', sortable: true}, {key: 'Name', sortable: true}, {key: 'Designation', sortable: true},
                        {key: 'Date', sortable: true}, {key: 'remarks', label: 'Remarks', sortable: true}, {key: 'regOThours', label: 'Registered OT Hours', sortable: true}, {key: 'action2', label: 'Approved OT Hours'}, {key: 'action4', label: 'Registered Aprroval', sortable: true}, {key: 'actOThours', label: 'Actual OT Hours'}, {key: 'action5', label: 'Process Aprroval'}],
                    items: []
                },
            };
        },
        mounted() {
        }
    };
</script>
