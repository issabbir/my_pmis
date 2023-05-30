<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
        <b-card title="Teacher's Holiday Setup">
          <b-card-body class="border">
            <b-row>
              <b-col md="12">
                <b-form-group
                  label="Holiday" label-for="holiday" class="requiredField">
                  <b-form-input
                    v-model.trim="$v.formData.holiday.$model"
                    class="uppercase"
                    name="holiday">
                  </b-form-input>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.holiday.$error && !$v.formData.holiday.required}">Holiday is required!</div>
                </b-form-group>
              </b-col>
              <b-col md="12">
                <b-form-group
                  label="ছুটির দিন"
                  label-for="holiday_bng">
                  <b-form-input
                    v-model="$v.formData.holiday_bng.$model"
                    class="uppercase"
                    name="holiday_bng">
                  </b-form-input>
                </b-form-group>
              </b-col>

              <b-col md="6">
                <b-form-group
                  label="Date From"
                  class="requiredField"
                  label-for="date_from">
                  <date-picker
                    v-model="$v.formData.date_from.$model"
                    width="100%"
                    input-class="form-control"
                    type="date" lang="en"
                    format="DD-MM-YYYY"
                    @input="formData.date_to = null"
                    :value-type="valueType"
                    :editable="false"
                    name="date_from">
                  </date-picker>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.date_from.$error && !$v.formData.date_from.required}">Date from is required!</div>
                </b-form-group>
              </b-col>

              <b-col md="6">
                <b-form-group
                  label="Date To"
                  class="requiredField"
                  label-for="date_to">
                  <date-picker
                    v-model="$v.formData.date_to.$model"
                    width="100%"
                    input-class="form-control"
                    type="date" lang="en"
                    format="DD-MM-YYYY"
                    :value-type="valueType"
                    :editable="false"
                    :not-before="notBefore(formData.date_from)"
                    name="date_to">
                  </date-picker>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.date_to.$error && !$v.formData.date_to.required}">Date to is required!</div>
                </b-form-group>
              </b-col>
              <b-col md="12">
                <b-form-group
                  label="Description" label-for="description" class="requiredField">
                  <b-form-textarea
                    v-model.trim="$v.formData.description.$model"
                    class="uppercase"
                    rows="2"
                    name="description">
                  </b-form-textarea>
                  <div :class="{'invalid-feedback':true ,'d-block':$v.formData.description.$error && !$v.formData.description.required}">Description is required!</div>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col>
                <b-form-group v-slot="{ ariaDescribedby }">
                  <b-form-radio-group
                    id="active_yn"
                    v-model="$v.formData.active_yn.$model"
                    :options="options"
                    :aria-describedby="ariaDescribedby"
                    name="active_yn"
                  ></b-form-radio-group>
                </b-form-group>

              </b-col>
              <b-col class="d-flex justify-content-end">
                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1">{{submitBtn}}</b-button>&nbsp;
                <b-button type="reset" class="btn btn-outline-dark" >Cancel</b-button>
              </b-col>
            </b-row>
          </b-card-body>
        </b-card>
      </b-form>
      <b-card title="Teacher's Holiday List">
        <b-card-body class="border">
          <Datatable :fields="fields" :items="items" :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'holiday_id'">
            <template v-slot:actions="{ rows }">
              <b-link ml="4" class="text-primary" @click="editRow(rows.item)"><i class="bx bx-edit cursor-pointer"></i></b-link>
              <b-link class="text-danger" v-b-modal="'formData-remove'" @click="delete_holiday_id = rows.item.holiday_id"><i class="bx bx-trash cursor-pointer"></i></b-link>
            </template>
          </Datatable>
          <b-modal :id="'formData-remove'" :centered="true" title="Please Confirm" size="sm"
                   buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"
                   :hideHeaderClose="false"
                   @ok="deleteRow(delete_holiday_id)" @hidden="delete_holiday_id = null">
            <div>Are you sure you want to delete?</div>
          </b-modal>
        </b-card-body>
      </b-card>
    </div>
  </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker'
    import vSelect from 'vue-select';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    const {required, requiredIf, maxLength, minLength, email, maxValue, decimal} = require("vuelidate/lib/validators");
    export default {
        name: "TeachersHolidaySetup",
        components: {DatePicker, Datatable, vSelect},
        data() {
            return {
                options: [
                    { text: 'Active', value: 'Y' },
                    { text: 'Inactive', value: 'N' }
                ],
                valueType: this.dateFormatter(),
                delete_holiday_id: null,
                formData: {
                    holiday_id: null,
                    holiday: null,
                    holiday_bng: null,
                    date_from: null,
                    date_to: null,
                    description: null,
                    active_yn: 'Y',
                    insert_by: ''
                },
                submitBtn: 'Save',
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'holiday', label: 'Holiday', sortable: true},
                    {key: 'holiday_bng', label: 'ছুটির দিন', sortable: true},
                    {
                        key: 'date_from',
                        label: 'Date From',
                        sortable: true,
                        filterByFormatted: true,
                        sortByFormatted: true,
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }
                    },
                    {
                        key: 'date_to',
                        label: 'Date To',
                        sortable: true,
                        filterByFormatted: true,
                        sortByFormatted: true,
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }
                    },
                   {key: 'total_count', label: 'Total Day', sortable: true},
                    {
                        key: 'active_yn',
                        label: 'Active',
                        formatter: value => {
                            if (value == 'Y') {
                                return 'Active'
                            }else {
                                return 'Inactive'
                            }
                        },
                        class: 'text-center'
                    },
                    {key: 'action', class: 'text-center'}
                ],
                items: [],
                totalList: 1,
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
        validations: {
            formData: {
                holiday_id: {},
                holiday: {required},
                holiday_bng: {},
                date_from: {required},
                date_to: {required},
                description: {required},
                active_yn: {required},
                insert_by: {}
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Leave System"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Teacher's Holiday"});
            this.formData.emp_id = this.id;
            this.loadData();
        },
        watch: {

        },
        created() {

        },
        methods: {

            dateFormatter: function () {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null;
                    }
                }
            },
            notBefore(date) {
                if(date)
                  return moment(date).format("YYYY-MM-DD");
                else
                    return moment(new Date()).format("YYYY-MM-DD");
            },

            onSubmit() {
                this.$v.$touch();
                this.$v.formData.$touch();
                if (!this.$v.formData.$invalid){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/leave-setup/teachers-holiday-setup", this.formData).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.loadData()
                            this.onReset();
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                        } else {
                            this.$notify({group: 'pmis', text: res.data.message, type: 'error'})
                        }
                    })
                }

            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/leave-setup/teachers-holiday-setup`).then(res => {
                    this.items = res.data.holiday
                    this.totalList = res.data.holiday.length
                });
            },


            onReset() {
                this.submitBtn = 'Save';
                this.$nextTick(() => {
                    this.formData = {
                        holiday_id: null,
                        holiday: null,
                        holiday_bng: null,
                        date_from: null,
                        date_to: null,
                        description: null,
                        active_yn: 'Y',
                        insert_by: ''
                    }
                    this.$v.$reset()
                })
            },

            editRow(item) {
                this.submitBtn = 'Update'
                this.formData =  {
                    holiday_id: item.holiday_id,
                    holiday: item.holiday,
                    holiday_bng: item.holiday_bng,
                    date_from: item.date_from,
                    date_to: item.date_to,
                    description: item.description,
                    active_yn: item.active_yn,
                    insert_by: item.insert_by,
                }
            },

            deleteRow(id) {
                ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/admin/leave-setup/teachers-holiday-setup/${id}`).then(res => {
                    if (res.data == 1) {
                        this.$notify({group: 'pmis', text: 'Holiday deleted successfully', type: 'success'});
                    } else {
                        this.$notify({group: 'pmis', text: 'Sorry, holiday deletion is unsuccessful', type: 'error'});
                    }
                    this.loadData();
                    this.onReset();
                })
            }
        }
    }
</script>

<style scoped>

</style>
