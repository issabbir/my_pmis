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
                        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="can_update">
                            <b-card :title="header">
                                <b-card-body class="border">
                                    <b-row>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Attachment Types"
                                                label-for="attachment_type_id"
                                                class="requiredField">
                                                <v-select v-model="selectedAttachmentType" :options="attachmentTypeOptions"
                                                          name="attachment_type_id" id="attachment_type_id" label="type"
                                                          class="uppercase"
                                                >
                                                    <template #search="{attributes, events}">
                                                        <input
                                                            class="vs__search"
                                                            v-bind="attributes"
                                                            v-on="events"
                                                        />
                                                    </template>
                                                </v-select>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.attachment_type_id.$error && !$v.formData.attachment_type_id.required}">Attachment type is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="Title"
                                                label-for="title"
                                                class="requiredField"
                                            >
                                                <b-form-input
                                                    class="uppercase"
                                                    v-model="$v.formData.title.$model"
                                                    id="title"
                                                    name="title">
                                                </b-form-input>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.title.$error && !$v.formData.title.required}">Attachment title is required!</div>
                                            </b-form-group>
                                        </b-col>
                                        <b-col sm="6">
                                            <b-form-group class="message requiredField" label="ATTACHMENT" label-for="attachment">
                                                <b-form-file @change="encodeFile"
                                                             id="attachment"
                                                             placeholder="Attachment"
                                                ></b-form-file>
                                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.file_content.$error && !$v.formData.file_content.required}">Attachment is required!</div>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1" >{{submitButton}}</b-button>
                                            <b-button type="reset" class="btn btn-outline-dark">{{cancelButton}}</b-button>
                                        </b-col>
                                    </b-row>
                                </b-card-body>
                            </b-card>
                        </b-form>
                        <b-card title="Attachments">
                            <b-card-body class="border">
                                <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'attachment_id'">
                                    <template v-slot:actions="{ rows }">
                                        <b-link ml="4" class="text-primary" v-if="can_update"
                                                @click="editRow(rows.item)">
                                            <i class="bx bx-edit cursor-pointer"></i>
                                        </b-link>
                                        <b-link class="text-danger" v-if="can_update" v-b-modal="'attachment-remove'" @click="deletedItem = rows.item.attachment_id">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>
                                        <a size="sm" @click="showAttachment(rows.item.file_content)"><i
                                            class="bx bx-download cursor-pointer"></i> </a>
                                    </template>
                                </Datatable>
                                <b-modal :id="'attachment-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                                         @ok="deleteRow()" @hidden="deletedItem = null">
                                    <div class="text-danger">Are you sure you want to delete?</div>
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
    import vSelect from 'vue-select';
    import SideBar from '../partials/sidebar';
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    import {validationMixin} from "vuelidate"
    const {required, requiredIf, maxLength, minLength, maxValue, email} = require("vuelidate/lib/validators");

    export default {
        components: { DatePicker, SideBar, Datatable,vSelect},
        props: ['id'],
        data() {
            return {
                can_update: false,
                submitButton: 'Submit',
                cancelButton: 'Reset',
                header: 'New Attachment',
                deletedItem: null,
                hidenseek: true,
                items: [],
                fields: [
                    {key: 'index', label: 'SL'},
                    {key: 'attachment_type.type', 'label': "Attachment Type", sortable: true},
                    {key: 'title', label:'Title', sortable: true},
                    {key: 'filename', label:"File Name", sortable: true},
                    {key: 'action', class: 'text-center'}
                ],
                totalList: 1,
                currentPage: 1,
                perPage: 5,
                formData: {
                    attachment_id: '',
                    attachment_type_id: '',
                    filename: '',
                    file_content: '',
                    filesystem_yn: 'N',
                    file_path: '',
                    active_yn: 'Y',
                    filesize: '',
                    emp_id: '',
                    title: '',
                    title_bn: '',
                    file_extension: '',
                    emp_code: ''
                },
                selectedAttachmentType: {
                    attachment_type_id: '',
                    title: ''
                },
                attachmentTypeOptions: []
            }
        },
        mixins: [validationMixin],
        validations: {
            formData: {
                attachment_id: {},
                attachment_type_id: {required},
                filename: {},
                file_content: {required},
                filesystem_yn: {required},
                file_path: {},
                active_yn: {required},
                filesize: {},
                emp_id: {required},
                title: {required},
                title_bn: {},
                file_extension: {required},
                emp_code: {required}
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Attachment"});
            this.formData.emp_id = this.id
            this.employee_code()
            this.loadAttachments()
            this.loadAttachmentTypes()
            this.canUpdate()
        },
        watch: {
            'formData.attachment_id': function(val, oldVal){
                if(val){
                    this.submitButton = 'Update'
                    this.cancelButton = 'Cancel'
                    this.header = 'Update Attachment'
                } else {
                    this.submitButton = 'Submit'
                    this.cancelButton = 'Reset'
                    this.header = 'New Attachment'
                }
            },
            selectedAttachmentType: function (val, oldVal) {
                if( val ){
                    this.formData.attachment_type_id = val.attachment_type_id
                } else {
                    this.formData.attachment_type_id = ''
                }
            }
        },
        methods: {
            canUpdate(){
                this.can_update = this.$store.getters.permissions.includes('CAN_UPDATE')
            },
            onSubmit(){
                this.$v.$touch()
                this.$v.formData.$touch()
                if(!this.$v.formData.$invalid){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/admin/attachments`, this.formData).then(result => {
                        if(result.data.status_code == 1){
                            this.$notify({group: 'pmis', text: "Attachment has been inserted successfully!", type: 'success'});
                            this.loadAttachments()
                        } else {
                            this.$notify({group: 'pmis', text: "Something went wrong!", type: 'error'});
                        }

                    });
                }

            },
            editRow(item) {
                this.formData = {
                    attachment_id: item.attachment_id,
                    attachment_type_id: item.attachment_type_id,
                    filename: item.filename,
                    file_content: item.file_content,
                    filesystem_yn: 'N',
                    file_path: item.file_path,
                    active_yn: 'Y',
                    filesize: item.filesize,
                    emp_id: this.id,
                    title: item.title,
                    title_bn: item.title_bn,
                    file_extension: item.file_extension,
                    emp_code: item.emp_code
                }
                this.selectedAttachmentType = {
                    attachment_type_id: item.attachment_type.attachment_type_id,
                    type: item.attachment_type.type
                }
            },
            deleteRow() {
                ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/admin/delete-attachment/${this.deletedItem}`).then(result => {
                    if(result.data.status_code == 1){
                        this.$notify({group: 'pmis', text: "Attachment has been inserted successfully!", type: 'success'});
                        this.loadAttachments()
                    } else {
                        this.$notify({group: 'pmis', text: "Something went wrong!", type: 'error'});
                    }
                });
            },
            onReset(){
                this.formData = {
                    attachment_id: '',
                    attachment_type_id: '',
                    filename: '',
                    file_content: '',
                    filesystem_yn: 'N',
                    file_path: '',
                    active_yn: 'Y',
                    filesize: '',
                    emp_id: this.id,
                    title: '',
                    title_bn: '',
                    file_extension: '',
                    emp_code: this.formData.emp_code
                }
                this.selectedAttachmentType = {
                    attachment_type_id: '',
                    title: ''
                }
                this.$v.$reset()
            },
            loadAttachments(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/employee-attachments/${this.id}`).then(result => {
                    this.items = result.data;
                    this.totalList = result.data.length
                });
            },
            loadAttachmentTypes(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/attachments-types`).then(result => {
                    this.attachmentTypeOptions = result.data;
                });
            },
            employee_code(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/employee-code/${this.id}`).then(result => {
                    this.formData.emp_code = result.data
                });
            },
            showAttachment(data) {
                const win = window.open("","_blank");
                let html = '';
                html += '<html>';
                html += '<body style="margin:0!important">';
                html += '<embed width="100%" height="100%" src="'+data+'"/>';
                html += '</body>';
                html += '</html>';
                setTimeout(() => {
                    win.document.write(html);
                }, 0);
            },
            encodeFile(e) {
                let file_limit = 2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.formData.file_content = reader.result;
                            vm.formData.filename = name;
                            vm.formData.file_extension = type;
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'});
                    }

                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'});
                    return;
                }

            },
        }
    }
</script>


<style>
    .uppercase { text-transform: uppercase; }
</style>
