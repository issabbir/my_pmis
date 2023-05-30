<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked" style="padding-top:0px;">
                <b-card-title>
                    <b-form-checkbox vertical v-model="hidenseek" name="check-button" switch size="lg">
                    </b-form-checkbox>
                </b-card-title>
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0" :class="{'d-none':!hidenseek}">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0" :class="{'col-md-12':!hidenseek}">
                        <b-card title="accommodation" v-if="show && can_update">
                            <b-card-body class="border">
                                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                                    <b-row>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Building Type"
                                                label-for="building_type"
                                                class="requiredField"
                                            >
                                                <v-select v-model="buildingType" :options="buildingTypes"
                                                          name="building_type_id" id="building_type_id" label="text"
                                                          v-validate="'required'"
                                                          class="uppercase">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span :style="errorMessage">{{ errors.first('building_type_id') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="no of tap"
                                                label-for="no_of_tap"
                                            >
                                                <b-form-input
                                                    id="no_of_tap"
                                                    v-model="accommodation.no_of_tap"
                                                    type="text"
                                                    placeholder="Enter no of tap"
                                                    name="no_of_tap"
                                                ></b-form-input>
                                                <span :style="errorMessage">{{ errors.first('no_of_tap') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="no of burner"
                                                label-for="no_of_burner"
                                            >
                                                <b-form-select
                                                    v-model="accommodation.no_of_burner"
                                                    :options="burnerTypes"
                                                    name="no_of_burner" >
                                                </b-form-select>
                                                <span :style="errorMessage">{{ errors.first('no_of_burner') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="House take over date"
                                                label-for="take_over_date"
                                                class="requiredField"
                                            >
                                                <date-picker
                                                    width="100%"
                                                    v-model="accommodation.take_over_date"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    :input-attr="{required: 'true'}"
                                                    @change="accommodation.hand_over_date = ''"
                                                    name="take_over_date"
                                                    v-validate="'required'"
                                                    id="take_over_date">
                                                </date-picker>
                                            </b-form-group>
                                            <span :style="errorMessage">{{ errors.first('take_over_date') }}</span>
                                        </b-col>
                                        <b-col md="4" :style="{'pointer-events':accommodation.take_over_date?'':'none'}">
                                            <b-form-group
                                                label="House hand over date"
                                                label-for="hand_over_date">
                                                <date-picker
                                                    width="100%"
                                                    v-model="accommodation.hand_over_date"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="valueType"
                                                    :editable="false"
                                                    :not-before="accommodation.take_over_date"
                                                    id="hand_over_date">
                                                </date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col>
                                            <b-form-group
                                                label="Active Status"
                                                label-for="active_yn"
                                            >
                                                <b-form-radio-group
                                                    id="active_yn"
                                                    v-model="accommodation.active_yn"
                                                    :options="activeStatusOptions"
                                                    name="active_yn"
                                                ></b-form-radio-group>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1" :disabled="keepDisable">{{submitBtn}}</b-button>
                                            <b-button type="reset" class="btn btn-outline-dark" :disabled="keepDisable">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </b-card-body>
                        </b-card>
                        <b-card title="Accommodation Information">
                            <b-card-body class="border">
                                <Datatable v-bind:fields="fields" v-bind:items="items">
                                    <template v-slot:actions="{ rows }">
                                        <!--<b-link ml="4" class="text-primary"
                                                @click="editRow(rows.item)">
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>-->
                                        <!--<b-link class="text-danger" v-b-modal="'accommodation-remove'" @click="deletedItem = rows.item">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>-->
                                    </template>
                                </Datatable>
                                <b-modal :id="'accommodation-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                                         @ok="deleteRow()" @hidden="deletedItem = null">
                                    <div>Are you sure you want to delete?</div>
                                </b-modal>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker'
    import SideBar from "../partials/sidebar";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';

    export default {
        props: ['id'],
        components: {DatePicker, SideBar, Datatable, vSelect, vcss},
        data() {
            return {
                can_update: false,
                hidenseek: true,
                valueType: this.dateFormatter(),
                buildingType:{'text':'', 'value':''},
                deletedItem: null,
                keepDisable: false,
                errorMessage: {color: 'red'},
                accommodation:{
                    building_type_id: '',
                    no_of_tap: '',
                    no_of_burner: '',
                    take_over_date: '',
                    hand_over_date: '',
                    active_yn: 'Y'
                },
                activeStatusOptions: [
                    { text: 'Yes', value: 'Y' },
                    { text: 'No', value: 'N' }
                ],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                updateIndex:-1,
                show:true,
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'building_type_name',label:'Building Type', sortable: true},
                    {key: 'no_of_tap', sortable: true},
                    {
                        key: 'no_of_burner',
                        formatter: value=>{
                            if(value == 1){
                                return 'Single Burner';
                            }else if(value == 2){
                                return 'Double Burner';
                            }
                        } ,
                        sortable: true
                    },
                    {
                        key: 'take_over_date',
                        label: 'House Take Over Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true
                    },
                    {
                        key: 'hand_over_date',
                        label: 'House Hand Over Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true
                    },
                    {
                        key: 'active_yn',
                        label: 'Active',
                        formatter: value=>{
                            if(value == 'Y'){
                                return 'Yes';
                            }else if(value == 'N'){
                                return 'No';
                            }
                        } ,
                        sortable: true
                    }
                ],
                items: [],
                submitBtn: 'Save',
                buildingTypes:[],
                burnerTypes: [{text: 'Single Burner', value: '1'},{text: 'Double Burner', value: '2'}]

            }
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Accommodation"});
            this.accommodation.emp_id = this.id;
            this.onReset()
            this.canUpdate()
        },

        watch: {
            can_update: function(val, oldVal){
                if(val){
                    this.fields.push({key: 'action', class: 'text-center'})
                }
            },
            buildingType:function (val, oldVal) {
                if(val !== null) {
                    this.accommodation.building_type_id = val;
                } else {
                    this.accommodation.building_type_id = '';
                }
            }
        },
        methods: {
            canUpdate(){
                this.can_update = this.$store.getters.permissions.includes('CAN_UPDATE')
            },
            dateFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null;
                    }
                }
            },
            hasEmpId: function() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            onSubmit() {
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.keepDisable = true;
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/accommodations", this.accommodation).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.onReset();
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                            } else{
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                            }
                            this.loadData();
                            this.keepDisable = false;
                        });
                    }
                });
            },
            loadData: function() {
                if(this.hasEmpId()) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/accommodations/specific/${this.id}`).then(res => {
                        this.buildingTypes = res.data.building;
                        this.items = res.data.data;
                        if(res.data.data.length > 0){
                            this.show = false;
                        }
                    });
                }

            },
            onReset() {
                this.loadData();
                // Reset our form values
                this.submitBtn = 'Save';
                this.updateIndex = -1;
                this.deletedItem = null;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.accommodation.house_allotement_id = '';
                    this.accommodation.building_type_id = '';
                    this.accommodation.no_of_burner = '';
                    this.accommodation.no_of_tap = '';
                    this.show = true
                })
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1
            },
            editRow(data) {
                    this.show = true;
                    this.submitBtn = 'Update';
                    this.accommodation = data;
                    this.buildingType = {text: data.building_type_name, value: data.building_type_id}
            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/pmis/employee/accommodations/${this.deletedItem.house_allotement_id}`).then(result => {
                        if (result.data.o_status_code == 1) {
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                        } else{
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                        }
                        this.deletedItem = null;
                        this.onReset();
                        this.loadData();
                    }).catch(err => {
                        this.deletedItem = null;
                        console.log(err);
                    });
                }
            }
        }
    }
</script>
