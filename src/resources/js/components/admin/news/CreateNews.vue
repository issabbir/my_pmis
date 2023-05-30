<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card no-body>
                <b-tabs card  v-model="tabIndex">
                    <b-tab active @click="clickOnNewsList">
                        <template #title>
                            <i class='bx bx-list-ul'></i> News List
                        </template>
                        <b-card-body class="border">
                            <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">
                                <template v-slot:actions="{ rows }">
                                    <b-link ml="4" class="text-primary" v-b-modal.approve-modal  title="Click here to approve"
                                            @click="approve(rows.item)" v-if="rows.item.status_key=='NEWS_PENDING' && canHasPermission('ADMIN_CAN_APPROVE_NEWS')">
                                        <i class='bx bx-circle' ></i>
                                    </b-link>
                                    <b-link ml="4" class="text-primary" title="Click here to publish."
                                            v-if="rows.item.status_key=='NEWS_APPROVED' && canHasPermission('ADMIN_CAN_PUBLISH_NEWS')" @click="showModal(rows.item.news_id)" >
                                        <i class='bx bx-send' ></i>
                                    </b-link>
                                    <span v-if="rows.item.status_key=='NEWS_APPROVED'">
                                        <i class='bx bxs-check-circle text-success' :title="'Approved at '+rows.item.updated_at" ></i>
                                    </span>
                                    <span v-if="rows.item.status_key=='NEWS_PUBLISHED'">
                                        <i class='bx bx-send text-success' :title="'Published at '+rows.item.updated_at" ></i>
                                    </span>
                                    <b-link ml="4" class="text-primary" v-if="canHasPermission('ADMIN_CAN_EDIT_NEWS')"
                                            @click="editRow(rows.item)" title="Update">
                                        <i class="bx bx-edit cursor-pointer"></i>
                                    </b-link>
                                    <b-link ml="4" class="text-primary" v-b-modal.detail-modal
                                            @click="modalForm = rows.item" title="View">
                                        <i class="bx bxs-detail cursor-pointer"></i>
                                    </b-link>
                                    <b-link v-if="rows.item.status_key !='NEWS_PUBLISHED'" ml="4" class="text-danger" v-b-modal.delete-modal
                                            @click="delete_id = rows.item.news_id" title="Removed">
                                        <i class="bx bx-trash cursor-pointer"></i>
                                    </b-link>
                                </template>

                            </Datatable>
                        </b-card-body>
                    </b-tab>
                    <b-tab v-if="canHasPermission('ADMIN_ADD_NEWS')" >
                        <template #title>
                            <i class='bx bx-list-plus'></i> {{news_entry}}
                        </template>
                        <b-card-body class="border">
                            <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                                <b-row>
                                    <b-col md="8">
                                        <b-row>
                                            <b-col>
                                                <b-form-group
                                                    id="input-group-2"
                                                    label="Post title (Bengali)"
                                                    label-for="input-2"
                                                    class="required"
                                                    description="THE TITLE WILL BE SHOWN INTO THE NEWS SCROLL ONCE PUBLISHED."
                                                >
                                                    <b-form-input
                                                        id="input-2"
                                                        v-model="form.title_bn"
                                                        type="text"
                                                        required
                                                        placeholder="Enter title"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col>
                                                <b-form-group
                                                    id="input-desc-bn"
                                                    label="Post details (Bengali)"
                                                    label-for="input-desc_bm"
                                                    class="required"
                                                >
                                                    <b-form-textarea
                                                        id="input-desc-bn"
                                                        v-model="form.description_bn"
                                                        placeholder="Enter details..."
                                                        required
                                                        rows="7"
                                                        max-rows="10"
                                                    ></b-form-textarea>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col >
                                                <b-form-group
                                                    id="input-group-1"
                                                    label="Post title"
                                                    label-for="input-1"
                                                    class="required"
                                                    description="THE TITLE WILL BE SHOWN INTO THE NEWS SCROLL ONCE PUBLISHED."
                                                >
                                                    <b-form-input
                                                        id="input-1"
                                                        v-model="form.title"
                                                        type="text"
                                                        required
                                                        placeholder="Enter title"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>

                                        <b-row>
                                            <b-col>
                                                <b-form-group
                                                    id="input-desc"
                                                    label="Post details"
                                                    label-for="input-desc"
                                                    class="required"
                                                >
                                                    <b-form-textarea
                                                        id="input-desc"
                                                        v-model="form.description"
                                                        placeholder="Enter details..."
                                                        rows="7"
                                                        required
                                                        max-rows="10"
                                                    ></b-form-textarea>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                    </b-col>
                                    <b-col md="4">
                                        <b-row>
                                            <b-col>
                                                <b-form-group
                                                    label="Active From"
                                                    label-for="from_date"
                                                    class="required"
                                                >
                                                    <date-picker
                                                        v-model="form.active_from"
                                                        width="100%" input-class="form-control"
                                                        type="date" lang="en"
                                                        required
                                                        :value-type="valueType"
                                                        format="DD-MM-YYYY"  :editable="false"></date-picker>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row :class="{pointerEvents:!form.active_from}">
                                            <b-col>
                                                <b-form-group
                                                    label="Active TO"
                                                    label-for="to_date">
                                                    <date-picker
                                                        v-model="form.active_to"
                                                        width="100%" input-class="form-control"
                                                        type="date" lang="en"
                                                        required
                                                        :value-type="valueType"
                                                        :disabled-date="Boolean(!this.form.active_form)"
                                                        :not-before="notBeforeJoiningDate()"
                                                        format="DD-MM-YYYY"  :editable="false"></date-picker>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <!--                                <b-row>-->
                                        <!--                                    <b-col>-->
                                        <!--                                        <b-form-group-->
                                        <!--                                            label="Status"-->
                                        <!--                                            label-for="to_date">-->
                                        <!--                                            <b-form-select v-model="form.status" :options="news_status"-->
                                        <!--                                              value-field="news_status_id" text-field="status"-->
                                        <!--                                            >-->
                                        <!--                                            </b-form-select>-->
                                        <!--                                        </b-form-group>-->
                                        <!--                                    </b-col>-->
                                        <!--                                </b-row>-->
                                        <b-row>
                                            <b-col>
                                                <b-form-group
                                                    label="Priority Order"
                                                    label-for="sort_order"
                                                >
                                                    <b-form-input type="number" id="sort_order" v-model="form.sort_order"></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col>
                                                <b-form-group   label="ATTACHMENT"
                                                                label-for="document" >
                                                    <div class="custom-file b-form-file">
                                                        <input
                                                            type="file"
                                                            class="custom-file-input"
                                                            @change="getDocument"
                                                            aria-describedby="authentication-document-help-block"
                                                            accept="application/msword,application/pdf,image/png,image/jpg,image/jpeg"
                                                            v-validate.reject="'size:1000'" name="document" />
                                                        <b-form-text id="authentication-document-help-block">
                                                            Document must be PDF,DOCX,Image only. size doesn't exit 1000KB.
                                                        </b-form-text>
                                                        <label data-browse="Browse" class="custom-file-label">{{form.attachment_filename}} </label>
                                                        <span :style="errorMessage">{{ errors.first('document') }}</span>
                                                    </div>
                                                    <div v-if="false">
                                                        <a :href="getAuthenticationDownloaderUrl(basicInfo.emp_id)" target="_blank"> {{form.attachment_filename}} </a>
                                                    </div>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col>
                                                <b-form-group label="ENABLED"  label-for="btn-radios-2">
                                                    <b-form-radio-group
                                                        id="btn-radios-2"
                                                        v-model="form.enabled_yn"
                                                        :options="enabledOptions"
                                                        buttons
                                                        button-variant="outline-primary"
                                                        size="md"
                                                        name="radio-btn-outline"
                                                    ></b-form-radio-group>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row v-for="i in files" :key="i" >
                                            <b-col md="1">
                                                <b-form-group>
                                                    <i class="bx bx-trash mt-1" @click="files.pop(i)"></i>
                                                </b-form-group>
                                            </b-col>
                                            <b-col  md="11">

                                            </b-col>
                                        </b-row>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col class="d-flex justify-content-end">
                                        <b-button type="submit" variant="secondary" class="mr-1" v-if="form.news_id"> <i class='bx bx-save' ></i> Update</b-button>
                                        <div v-else>
                                        <b-button type="submit" variant="secondary" class="mr-1" > <i class='bx bx-save' ></i> Submit</b-button>
                                        <b-button type="reset" variant="danger"> <i class='bx bx-reset' ></i> Reset</b-button>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-form>
                        </b-card-body>
                    </b-tab>
                </b-tabs>
            </b-card>
            <b-modal id="approve-modal" @ok="confirmedApproval"><h6>Do you want to approve the news?</h6></b-modal>
            <b-modal ref="publish" @ok="confirmedPublish"><h6 class="text-warning">Do you want to publish the news?</h6></b-modal>
            <b-modal id="delete-modal" @ok="confirmedDelete"><h6 class="text-danger">Do you want to delete the news?</h6></b-modal>
            <b-modal id="detail-modal" size="xl" title="News Details" hide-footer>
                <b-row>
                    <b-col md="12">
                        <b-form-group
                            label="Title"
                            label-for="title"
                            label-cols-md="2"
                        >
                            <b-form-input :value="modalForm.title" plaintext id="title" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                            label="Title (Bengali)"
                            label-for="title_bn"
                            label-cols-md="2"
                        >
                            <b-form-input :value="modalForm.title_bn" plaintext id="title_bn" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                            label="Description"
                            label-for="description"
                            label-cols-md="2"
                        >
                            <b-form-textarea :value="modalForm.description" plaintext id="description" rows="7" max-rows="10" disabled></b-form-textarea>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                            label="Description (Benglai)"
                            label-for="description_bn"
                            label-cols-md="2"
                        >
                            <b-form-textarea :value="modalForm.description_bn" plaintext id="description_bn" rows="7" max-rows="10" disabled></b-form-textarea>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Active From"
                            label-for="active_from"
                            label-cols-md="4"
                        >
                            <b-form-input :value="modalForm.active_from" plaintext id="active_from" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Active To"
                            label-for="active_to"
                            label-cols-md="4"
                        >
                            <b-form-input :value="modalForm.active_to"  plaintext id="active_to" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Posted At"
                            label-for="created_at"
                            label-cols-md="4"
                        >
                            <b-form-input :value="modalForm.created_at" plaintext id="created_at" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Status"
                            label-for="status"
                            label-cols-md="4"
                        >
                            <b-form-input :value="modalForm.status" plaintext id="status" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-modal>
        </div>
    </div>
</template>

<script>
import Vue from 'vue';
import vSelect from 'vue-select';
import vcss from 'vue-select/dist/vue-select.css';
import moment from 'moment';
import DatePicker from "vue2-datepicker";
import Datatable from '../../../layouts/common/datatable';
import ApiRepository from "../../../Repository/ApiRepository";
import Multiselect from 'vue-multiselect';


export default {
  components: {DatePicker,Datatable,Vue,vSelect,vcss,Multiselect},
    props: ['id'],
  mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", { link: "#", label: "Administration" });
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "System Admin"
    });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Post A News" });
    this.allNews();
  },
  data() {
      return {
          items:[],
          news_entry: 'News Entry',
          delete_id:'',
          approve_id:'',
          publish_id:'',
          tabIndex: 0,
          title: 'Post A News',
          form: {
              enabled_yn: 'Y',
              active_from: new Date(Date.now()),
          },
          modalForm:{},
          show: true,
          valueType:this.dateFormatter(),
          disabledDates: {
              to: new Date(Date.now() - 8640000)
          },
          totalList:0,
          perPage:25,
          files : 0,
          news_status: [{"news_status_id": null}],
          enabledOptions: [
              { text: 'YES', value: 'Y' },
              { text: 'NO', value: 'N' },
          ],
          errorMessage: {color: 'red'},
          tableData: {
              fields: [
                  {key:'sort_order', label:'Priority Order', sortable:true, class:'text-center col-width-sort'},
                  {key:'title_bn', label:'title (BN)', sortable:true, class:'text-left col-width-title'},
                  {key:'active_from', class:'col-width-other',
                      formatter: value => {
                          if(value) {
                              return moment(value).format('DD-MM-YYYY');
                          }
                      },
                      label:'Active From', sortable:true},
                  {key:'active_to',
                      formatter: value => {
                          if(value) {
                              return moment(value).format('DD-MM-YYYY');
                          }
                      },
                      label:'Active To', sortable:true, class:'col-width-other'},
                  {key:'created_at', label:'Posted At', sortable:true, class:'text-left col-width-other',
                      formatter: value => {
                          if(value) {
                              return moment(value).format('DD-MM-YYYY HH:MM');
                          }
                      }
                  },
                  {key:'status', label:'status', sortable:true, class:'text-left col-width-other'},
                  {key:'enabled_yn', label:'ENABLED', sortable:true, class:'text-center col-width-sort', formatter: value => {
                        if (value && value.toUpperCase() == 'Y') {
                            return "YES"
                        }
                       else {
                            return "NO"
                       }
                      }},
                  {key:'action', label:'Action',class:'text-left col-width-other'},
              ],
              items:[]
          },
      };
  },
  methods: {
      onSubmit() {
          this.form.active_from =  moment(this.form.active_from).format('YYYY-MM-DD');
          if (!this.form.news_id) {
              ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/post/news', this.form).then(result => {
                  if (result.data.params.o_status_code != 1)
                      this.$notify({group: 'pmis', text: result.data.params.o_status_message, type: 'error'});
                  else {
                      this.$notify({group: 'pmis', text: result.data.params.o_status_message, type: 'success'});
                      this.tableData.items = result.data.news;
                      this.totalList = result.data.news.length;
                      this.tabIndex = 0
                      this.form = {}
                  }
              });
          }
          else {
              ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/post/news/${this.form.news_id}`, this.form).then(result => {
                  if (result.data.params.o_status_code != 1)
                      this.$notify({group: 'pmis', text: result.data.params.o_status_message, type: 'error'});
                  else {
                      this.$notify({group: 'pmis', text: result.data.params.o_status_message, type: 'success'});
                      this.tableData.items = result.data.news;
                      this.totalList = result.data.news.length;
                      this.tabIndex = 0
                      this.form = {}
                  }
              });
          }
      },
      clickOnNewsList(){
          this.form = {}
          this.news_entry = 'News Entry'
      },
      editRow(item){
          this.tabIndex = 1
          this.form = item
          this.news_entry = 'News Update'
      },
      approve(item){
          this.approve_id=item.news_id
      },
      showModal(id) {
          this.$refs['publish'].show()
          this.publish_id = id
      },
      delete(item){
          this.delete_id=item.news_id;
          console.log(item);
      },
      confirmedApproval() {
          ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/post/approved/news/${this.approve_id}`).then(result => {
              if (result.data.params.o_status_code != 1)
                this.$notify({group: 'pmis', text: result.data.params.o_status_message, type: 'error'});
              else {
                  this.$notify({group: 'pmis', text: result.data.params.o_status_message, type: 'success'});
                  this.tableData.items = result.data.news;
                  this.totalList = result.data.news.length;
              }
          });
      },
      confirmedPublish(){
          ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/admin/post/published/news/${this.publish_id}`).then(result => {
              if (result.data.params.o_status_code != 1)
              this.$notify({group: 'pmis', text: result.data.params.o_status_message, type: 'error'});
          else {
                  this.$notify({group: 'pmis', text: result.data.params.o_status_message, type: 'success'});
                  this.tableData.items = result.data.news;
                  this.totalList = result.data.news.length;
              }
          });
      },
      confirmedDelete(){
          ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/admin/post/news/${this.delete_id}`).then(result => {
              if (result.data.params.o_status_code != 1)
                  this.$notify({group: 'pmis', text: result.data.params.o_status_message, type: 'error'});
              else {
                  this.$notify({group: 'pmis', text: result.data.params.o_status_message, type: 'success'});
                  this.tableData.items = result.data.news;
                  this.totalList = result.data.news.length;
              }
          });
      },
      onReset() {
          // Reset our form values
          this.form.title = ''
          this.form.description = ''
          // Trick to reset/clear native browser form validation state
          this.show = false
          this.$nextTick(() => {
              this.show = true
          })
      },
      notBeforeJoiningDate() {
          if(this.form.active_from) {
              return this.form.active_from
          }
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
      allNews(){
          ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/post/news').then(result => {
              this.tableData.items = result.data.news.map(option => {
                  if(option.enabled_yn==='N'){
                      let newPropsObj = {
                          _rowVariant:'danger'
                      };
                      return Object.assign(option, newPropsObj);
                  }else{
                      let newPropsObj = {
                          _rowVariant:''
                      };
                      return Object.assign(option, newPropsObj);
                  }
              });
              this.totalList = result.data.news.length;
              this.news_status =  result.data.status;
          });
      },
      getDocument(event) {
          let currObj = this;
          let input = event.target;
          let reader = new FileReader();
          if (input.files && input.files[0]) {
              this.$validator.validate('document', currObj.form.attachment).then(function() {
                  reader.onload = (e) => {
                      if(!currObj.errors.has('document')) {
                          currObj.form.attachment = e.target.result;
                      }
                  }
              }).catch(err => {
                  console.log('file error');
              });
              reader.readAsDataURL(input.files[0]);
              this.form.attachment_filename = input.files[0].name;
              this.form.attachment_type = input.files[0].name.split('.').pop();
          }
      },
      canHasPermission: function(key) {

           if (this.$store.getters.hasGrantAccess)
             return this.$store.getters.hasGrantAccess;

           let permissions = this.$store.getters.permissions;
           for (let p in permissions) {
               if (key == permissions[p]) {
                   return true;
               }
           }
          return false;
      }
  }
};
</script>
<style>
  .datatatbleBtn button:not(:disabled) {
    cursor: pointer;
    border: 0;
  }
  .nav.nav-tabs {
      margin-bottom: 0rem;
      border-bottom-color: #EDEDED;
  }
  .card-footer, .card-header {
      padding: 0.8rem 1.7rem 0.4rem 1.7rem;
  }
  .card-body {
      padding: 0.7rem;
  }
  .pointerEvents{
      pointer-events: none;
  }
  .col-width-sort {
      width:5%
  }
    .col-width-other {
        width:12%
    }
  .col-width-title {
      width:30%
  }
  .form-group.required > label:after {
      content: "*" !important;
      color: red;
  }
</style>
