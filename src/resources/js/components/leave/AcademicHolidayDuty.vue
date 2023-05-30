<template>
  <div class="content-body">
    <b-card>
      <b-card-body class="border" >
        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
          <b-row>
            <b-col md="4" :style="is_update == true ? 'pointer-events:none' : ''">
              <b-form-group
                label="Employee"
                label-for="employee"
                class="requiredField">
                <v-select
                  v-model="selectedEmployee"
                  :options="employeeOptions"
                  name="employee"
                  id="employee"
                  label="option_name"
                  class="uppercase">
                  <template #search="{attributes, events}">
                    <input
                      class="vs__search"
                      v-bind="attributes"
                      v-on="events"
                    />
                  </template>
                </v-select>
                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.emp_id.$error && !$v.formData.emp_id.required}">Employee is required!</div>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label="Start Date" label-for="startDate" class="requiredField">
                <date-picker
                  v-model="$v.formData.duty_start_date.$model"
                  type="date"
                  lang="en"
                  format="DD-MM-YYYY"
                  :editable="false"
                  :value-type="valueType"
                  @change="formData.duty_end_date = ''"
                  width="100%"
                  input-class="form-control"
                  id="startDate"
                ></date-picker>
                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.duty_start_date.$error && !$v.formData.duty_start_date.required}">Start date is required!</div>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label="End Date" label-for="endDate" class="requiredField">
                <date-picker
                  v-model="$v.formData.duty_end_date.$model"
                  type="date"
                  lang="en"
                  format="DD-MM-YYYY"
                  :editable="false"
                  :not-before="formData.duty_start_date"
                  :value-type="valueType"
                  width="100%"
                  input-class="form-control"
                  id="endDate"
                ></date-picker>
                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.duty_end_date.$error && !$v.formData.duty_end_date.required}">End date is required!</div>
              </b-form-group>
            </b-col>
            <b-col md="12">
              <b-form-group label="Remarks" label-for="remarks">
                <b-form-textarea
                  id="remarks"
                  rows="3"
                  v-model.trim="$v.formData.remarks.$model"

                ></b-form-textarea>
              </b-form-group>
            </b-col>
            <b-col md="12">
              <b-form-group label="Office Order" label-for="attachment" class="message">
                <b-form-file
                  @change="encodeFile"
                  id="attachment"
                  placeholder="Office Order"
                ></b-form-file>
              </b-form-group>
            </b-col>

          </b-row>
          <b-row>
            <b-col class="d-flex justify-content-end">
              <b-button type="submit" variant="primary" class="mr-1" >{{submitBtn}}</b-button>
              <b-button type="reset" >Cancel</b-button>
            </b-col>
          </b-row>
        </b-form>
      </b-card-body>
    </b-card>
    <b-card title="Academic Holiday Duty">
      <b-card-body class="border">
        <Datatable :fields="fields" :items="items" :totalList="totalList" :perPage="perPage" :filter-ignored-fields="['office_order']">
          <template v-slot:actions="{ rows }">
            <b-link class="text-success" v-if="rows.item.office_order" @click="showAttachment(rows.item.office_order)"><i class="bx bx-download cursor-pointer"></i></b-link>
            <b-link class="text-primary" v-if="hasPermission('CAN_UPDATE_ACADEMIC_HOLIDAY_DUTY') && rows.item.approve_yn == 'N'" @click="editRow(rows.item)"><i class="bx bx-edit cursor-pointer"></i></b-link>
            <b-link class="text-danger" v-if="hasPermission('CAN_DELETE_ACADEMIC_HOLIDAY_DUTY') && rows.item.approve_yn == 'N'" @click="openDeleteModal(rows.item)"><i class="bx bx-trash cursor-pointer"></i></b-link>
            <b-link class="text-success" v-if="hasPermission('CAN_APPROVE_ACADEMIC_HOLIDAY_DUTY') && rows.item.approve_yn == 'N'" @click="openApprovalModal(rows.item)"><i class="bx bx-cog cursor-pointer"></i></b-link>
            <i v-if="rows.item.approve_yn == 'Y'" class="bx bx-check-square text-primary"></i>
          </template>
        </Datatable>
        <b-modal
          id="remove"
          ref="remove"
          :centered="true"
          title="Delete Alert"
          size="sm"
          buttonSize="sm"
          okTitle="YES"
          cancelTitle="NO"
          footerClass="p-2"
          :hideHeaderClose="false"
          @ok="deleteRow()"
          @close="onReset()"
          @hidden="onReset()">
          <div class="text-danger text-center">Are you sure you want to delete?</div>
        </b-modal>
        <b-modal
          id="approve"
          ref="approve"
          :centered="true"
          title="Approve Alert"
          size="sm"
          buttonSize="sm"
          okTitle="YES"
          cancelTitle="NO"
          footerClass="p-2"
          :hideHeaderClose="false"
          @ok="approve()"
          @close="onReset()"
          @hidden="onReset()">
          <div class="text-danger text-center">Are you sure you want to approve?</div>
        </b-modal>
      </b-card-body>
    </b-card>
  </div>
</template>

<script>
    import DatePicker from "vue2-datepicker"
    import Datatable from "../../layouts/common/datatable"
    import vSelect from "vue-select"
    import ApiRepository from "../../Repository/ApiRepository"
    import moment from 'moment'
    const {required} = require("vuelidate/lib/validators")

    export default {
        name: "AcademicHolidayDuty",
        components: {DatePicker, Datatable, vSelect},
        data() {
            return {
                is_update: false,
                selectedEmployee: {
                    emp_id: '',
                    emp_code: '',
                    option_name: ''
                },
                employeeOptions: [],
                formData: {
                    emp_id: '',
                    emp_code: '',
                    duty_start_date: '',
                    duty_end_date: '',
                    office_order: '',
                    remarks: ''
                },
                submitBtn: 'Save',
                fields: [
                    {key: 'index', label: 'SL', class: 'widthTen'},
                    {key: 'emp_code', label: 'Employee Code', sortable: true, class: 'widthTen'},
                    {key: 'employee.emp_name', label: 'Employee Name', sortable: true, class: 'widthThirty'},
                    {
                        key: 'duty_start_date',
                        label: 'Start Date',
                        sortable: true,
                        class: 'widthTwenty',
                        formatter : value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY')
                            }
                        }
                    },
                    {
                        key: 'duty_end_date',
                        label: 'End Date',
                        sortable: true,
                        class: 'widthTwenty',
                        formatter : value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY')
                            }
                        }
                    },
                    {key: 'total_count', label: 'Total Day', sortable: true, class: 'widthThirty'},
                    {key: 'action', label: 'Actions', class: 'text-right widthTen'}
                ],
                items: [],
                totalList: 1,
                currentPage: 1,
                perPage: 5,
                deletedItem: {
                    emp_id: '',
                    emp_code: '',
                    duty_start_date: '',
                    duty_end_date: ''
                },
                valueType: this.dateFormatter(),
            }
        },
        validations: {
            formData: {
                emp_id: {required},
                emp_code: {required},
                duty_start_date: {required},
                duty_end_date: {required},
                office_order: '',
                remarks: ''
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty")
            this.$store.commit("setBreadcrumb", {link: "#", label: "Leave System"})
            this.$store.commit("setBreadcrumb", {link: "#", label: "Academic Holiday Duty"})
            this.loadTeachers()
            this.loadData()

        },
        watch: {
            selectedEmployee(val,oldVal) {
                if(val.emp_id) {
                    this.formData.emp_id = val.emp_id
                    this.formData.emp_code = val.emp_code
                } else {
                    this.formData.emp_id = ''
                    this.formData.emp_code = ''
                }
            }
        },
        methods: {
            openDeleteModal(item){
                this.deletedItem = {
                    emp_id: item.emp_id,
                    emp_code: item.emp_code,
                    duty_start_date: item.duty_start_date,
                    duty_end_date: item.duty_end_date
                }
                this.$refs['remove'].show()
            },
            openApprovalModal(item){
                this.formData = {
                    emp_id: item.emp_id,
                    emp_code: item.emp_code,
                    duty_start_date: item.duty_start_date,
                    duty_end_date: item.duty_end_date
                }
                this.$refs['approve'].show()
            },
            onSubmit() {
                this.$v.$touch()
                this.$v.formData.$touch()
                if (!this.$v.formData.$invalid){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/admin/leave-setup/academic-holiday-duty", this.formData).then(res => {
                        if (res.data) {
                            this.onReset()
                            if (res.data.message){
                                this.$notify({ group: 'pmis', text: res.data.message, type:'error' })
                            }else{
                                this.$notify({ group: 'pmis', text: 'Duty submitted successfully', type:'success' })
                            }

                        } else{
                            this.$notify({ group: 'pmis', text: 'Duty submission failed', type:'error' })
                        }
                        this.loadData()
                    })
                }
            },
            loadTeachers(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/leave-setup/all-teachers`).then(res => {
                    this.employeeOptions = res.data
                })
            },
            approve() {
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/leave-setup/academic-holiday-duty`, this.formData).then(res => {
                    if (res.data) {
                        this.onReset()
                        this.$notify({ group: 'pmis', text: 'Duty Approved', type:'success' })
                    } else{
                        this.$notify({ group: 'pmis', text: 'Duty approval failed', type:'error' })
                    }
                    this.loadData()
                })
            },
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/leave-setup/academic-holiday-duty`).then(res => {
                    this.items = res.data
                    this.totalList = res.data.length
                })
            },
            onReset() {
                this.submitBtn = 'Save'
                this.is_update = false
                this.$nextTick(() => {
                    this.formData = {
                        emp_id: '',
                        emp_code: '',
                        duty_start_date: '',
                        duty_end_date: '',
                        office_order: '',
                        remarks: ''
                    }
                    this.selectedEmployee = {
                        emp_id: '',
                        emp_code: '',
                        option_name: ''
                    }
                    this.deletedItem = {
                        emp_id: '',
                        emp_code: '',
                        duty_start_date: '',
                        duty_end_date: ''
                    }
                    this.$v.$reset()
                })
            },
            editRow(item) {
                this.submitBtn = 'Update'
                this.is_update = true
                this.formData = {
                    emp_id: '',
                    emp_code: '',
                    duty_start_date: item.duty_start_date,
                    duty_end_date: item.duty_end_date,
                    office_order: item.office_order,
                    remarks: item.remarks
                }

                this.selectedEmployee = {
                    emp_id: item.employee.emp_id,
                    emp_code: item.employee.emp_code,
                    option_name: item.employee.option_name
                }
            },
            deleteRow() {
                if (this.deletedItem.emp_id) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/leave-setup/academic-holiday-duty/${this.deletedItem.emp_id}/${this.deletedItem.emp_code}/${this.deletedItem.duty_start_date}/${this.deletedItem.duty_end_date}`).then( result => {
                        if (result.data) {
                            this.$notify({ group: 'pmis', text: 'Delete operation successful', type:'success' })
                        } else{
                            this.$notify({ group: 'pmis', text: 'Delete operation failed', type:'error' })
                        }
                        this.onReset()
                        this.loadData()
                    }).catch(err => {
                        this.onReset()
                        console.log(err)
                    })
                }
            },
            dateFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null
                    }
                }
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess
                return this.$store.getters.permissions.includes(key)
            },
            encodeFile(e) {
                let file_limit = 2000000
                let vm = this
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                        let file = e.target.files[0]
                        let reader = new FileReader()
                        reader.readAsDataURL(file)
                        reader.onload = (file)=>{
                            vm.formData.office_order = reader.result
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'})
                    }
                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'})
                    return
                }
            },
            showAttachment(data) {
                const win = window.open("","_blank")
                let html = ''
                html += '<html>'
                html += '<body style="margin:0!important">'
                html += '<embed width="100%" height="100%" src="'+data+'"/>'
                html += '</body>'
                html += '</html>'
                setTimeout(() => {
                    win.document.write(html)
                }, 0)
            }
        }
    }
</script>

<style scoped>
  .widthForty {
    width: 40% !important
  }

  .widthThirty {
    width: 30% !important
  }

  .widthTwenty {
    width: 20% !important
  }
  .widthTen {
    width: 10% !important
  }
</style>
