<template>
    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card title="Circular">
                        <div class="container col-md-9">
                            <form-wizard title subtitle color="#394C62">
                                <!-- tab 1 content -->
                                <tab-content title="Post Information" class="mb-3">
                                    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                        <b-row md="8">
                                            <b-col md="4">
                                                <b-form-group
                                                    id="circular_id"
                                                    label-cols-md="4"
                                                    label="CIRCULAR ID"
                                                    label-for="circularId">
                                                    <b-form-input v-model="jobCircular.id" id="circularId" disabled></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="4">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="4"
                                                    label="Advertisement No"
                                                    label-for="advertismntNo">
                                                    <b-form-select v-model="jobCircular.advertismntNo" :options="oadvertismntNo"></b-form-select>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row md="8">
                                            <b-col md="8">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="2"
                                                    label="Department Name"
                                                    label-for="input-horizontal">
                                                    <b-form-select v-model="jobCircular.departmntName" :options="sdepartmntName"></b-form-select>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row md="8">
                                            <b-col md="8">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="2"
                                                    label="Title"
                                                    label-for="input-horizontal">
                                                    <b-form-select v-model="jobCircular.title" :options="stitle"></b-form-select>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row md="8">
                                            <b-col md="8">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="2"
                                                    label="Concerned Person"
                                                    label-for="concerndPerson">
                                                    <b-form-select v-model="jobCircular.concerndPerson" :options="sconcerndPerson"></b-form-select>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row md="8">
                                            <b-col md="4">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="4"
                                                    label="GARDE"
                                                    label-for="garde">
                                                    <b-form-select v-model="jobCircular.garde" :options="sgarde"></b-form-select>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="4">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="4"
                                                    label="PAY SCALE"
                                                    label-for="payScale">
                                                    <b-form-select v-model="jobCircular.payScale" :options="spaygrade"></b-form-select>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row md="8">
                                            <b-col md="4">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="4"
                                                    label="PUBLISH DATE"
                                                    label-for="pubdate">
                                                    <date-picker v-model="jobCircular.pubdate" width="100%" input-class="form-control" type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="4">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="4"
                                                    label="HOT JOB"
                                                    label-for="input-horizontal">
                                                    <b-form-checkbox
                                                        id="checkbox-1"
                                                        v-model="jobCircular.status"
                                                        name="checkbox-1"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"></b-form-checkbox>
                                                </b-form-group>

                                            </b-col>
                                        </b-row>
                                        <b-row md="8">
                                            <b-col md="4">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="4"
                                                    label="APPLICATION DEADLINE"
                                                    label-for="appDeadline">
                                                    <date-picker v-model="jobCircular.appDeadline" width="100%" input-class="form-control" type="date" lang="en" format="YYYY-MM-DD"></date-picker>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="4">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="4"
                                                    label="MAX AGE"
                                                    label-for="input-horizontal">
                                                    <b-form-input v-model="jobCircular.maxAge" id="input-horizontal"></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row md="8">
                                            <b-col md="4">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="4"
                                                    label="TYPE"
                                                    label-for="input-horizontal">
                                                    <b-form-radio-group id="type" v-model="jobCircular.type" name="type">
                                                        <b-form-radio value="Full">Full</b-form-radio>
                                                        <b-form-radio value="Part">Part</b-form-radio>
                                                    </b-form-radio-group>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="6">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-for="input-horizontal">
                                                    <b-form-radio-group id="type_1" v-model="jobCircular.type1" name="type_1">
                                                        <b-form-radio value="Parmanent">Parmanent</b-form-radio>
                                                        <b-form-radio value="Contractual">Contractual</b-form-radio>
                                                    </b-form-radio-group>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                    </b-form>
                                </tab-content>
                                <tab-content title="Bank Draft" class="mb-5">
                                    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                        <b-row md="8">
                                            <b-col md="4">
                                                <b-form-group
                                                    id="totalPost"
                                                    label-cols-md="4"
                                                    label="TOTAL POST"
                                                    label-for="totalPost">
                                                    <b-form-input v-model="jobCircular.totalPost" id="totalPost"></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row md="8">
                                            <b-col md="8">
                                                <b-form-group
                                                    id="quotalbl"
                                                    label-cols-md="2"
                                                    label="QUOTA"
                                                    label-for="QUOTA">
                                                    <b-form-checkbox
                                                        id="quota"
                                                        v-model="jobCircular.quota"
                                                        name="quota"
                                                        value="accepted"
                                                        unchecked-value="not_accepted">
                                                        <fieldset class="border p-2">
                                                            <legend class="w-auto font-size-small">Quota Allocation</legend>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label>General</label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                              <b-form-input v-model="jobCircular.general" id="general"></b-form-input>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label>Freedom Fighters</label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                             <b-form-input v-model="jobCircular.freedomFighter" id="freedomFighter"></b-form-input>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label>Dependent</label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                             <b-form-input v-model="jobCircular.dependent" id="dependent"></b-form-input>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label>Female</label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <b-form-input v-model="jobCircular.female" id="dependent"></b-form-input>
                                                                         </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </b-form-checkbox>
                                                </b-form-group>

                                            </b-col>
                                        </b-row>
                                        <b-row md="8">
                                            <b-col md="8">
                                                <b-form-group
                                                    id="fieldset-horizontal"
                                                    label-cols-md="2"
                                                    label="BANK DRAFT"
                                                    label-for="BANK DRAFT">
                                                    <b-form-checkbox
                                                        id="bank_draft"
                                                        v-model="jobCircular.bank_draft"
                                                        name="bank_draft"
                                                        value="accepted"
                                                        unchecked-value="not_accepted">
                                                        <b-form-input id="bank_draftAmt"></b-form-input>
                                                    </b-form-checkbox>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row md="8">
                                            <b-col md="8">
                                                <b-form-group
                                                    id="bank_draft_dtls"
                                                    label-cols-md="2"
                                                    label="BANK DRAFT Details"
                                                    label-for="bank_draft_dtls">
                                                    <b-form-textarea
                                                        id="textarea"
                                                        v-model="jobCircular.bankDetails"
                                                        placeholder="Enter something..."
                                                        rows="3"
                                                        max-rows="6"
                                                        ></b-form-textarea>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                        <b-row md="8">
                                            <b-col md="8">
                                                <b-form-group
                                                    id="req_attachment"
                                                    label-cols-md="2"
                                                    label="ATTACHMENT"
                                                    label-for="req_attachment">
                                                    <b-form-checkbox
                                                        id="isReqAttachmnt"
                                                        v-model="jobCircular.isReqAttachmnt"
                                                        name="isReqAttachmnt"
                                                        value="accepted"
                                                        unchecked-value="not_accepted">
                                                        <b-form-textarea
                                                            id="textarea"
                                                            v-model="jobCircular.details"
                                                            placeholder="Enter something..."
                                                            rows="3"
                                                            max-rows="6"
                                                            ></b-form-textarea>
                                                    </b-form-checkbox>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>

                                    </b-form>
                                </tab-content>
                                <tab-content title="Education And Experience" class="mb-5">
                                    <b-row md="8">
                                        <b-col md="8">
                                            <b-form-group
                                                id="minEdulbl"
                                                label-cols-md="2"
                                                label="MINIMUM EDUCATION"
                                                label-for="minEdulbl">

                                                <multiselect v-model="jobCircular.minEdulbl" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="code" :options="minEdulblList" :multiple="true" :taggable="true" @tag="addTag"></multiselect>

                                                <!-- <b-form-select v-model="minEdulbl" :options="minEdulbldata"></b-form-select> -->
                                            </b-form-group>

                                        </b-col>
                                    </b-row>
                                    <b-row md="8">
                                        <b-col md="8">
                                            <b-form-group
                                                id="subject"
                                                label-cols-md="2"
                                                label="subject"
                                                label-for="subject">
                                                <multiselect v-model="jobCircular.subject" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="text" track-by="code" :options="subjectList" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                                             </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row md="8">
                                        <b-col md="4">
                                            <b-form-group
                                                id="experienced"
                                                label-cols-md="4"
                                                label="EXPERIENCED"
                                                label-for="experienced">
                                                <b-form-radio-group id="expreinced" v-model="jobCircular.expreinced" name="expreinced">
                                                    <b-form-radio value="Yes">Yes</b-form-radio>
                                                    <b-form-radio value="No">No</b-form-radio>
                                                </b-form-radio-group>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                id="minLength"
                                                label-cols-md="4"
                                                label="MINIMUM LENGTH"
                                                label-for="minLength">
                                                <b-form-input v-model="jobCircular.minLength" id="minexplength"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row md="8">
                                        <b-col md="8">
                                            <b-form-group
                                                id="areaOfExp"
                                                label-cols-md="2"
                                                label="AREA OF EXPERIENCE"
                                                label-for="areaOfExp">
                                                <b-form-select v-model="jobCircular.areOfExp" :options="areOfExpList"></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </tab-content>
                                <tab-content title="Additional Requirements" class="mb-5">
                                    <b-row md="8">
                                        <b-col md="8">
                                            <b-form-group
                                                id="additionalReq"
                                                label-cols-md="2"
                                                label="Add Additional Requirements"
                                                label-for="additionalReq">
                                                <b-form-textarea
                                                    id="textarea"
                                                    v-model="jobCircular.additionalReq"
                                                    placeholder="Enter something..."
                                                    rows="6"
                                                    max-rows="6"
                                                    ></b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </tab-content>
                            </form-wizard>
                        </div>
                    </b-card>
                </b-col>
            </b-row>

        </div>

    </div>

</template>

<script>
    import DatePicker from 'vue2-datepicker';
    import { FormWizard, TabContent } from "vue-form-wizard";
    import "vue-form-wizard/dist/vue-form-wizard.min.css";
    import Multiselect from 'vue-multiselect';

    // register globally
//   Vue.component('multiselect', Multiselect)

    export default {
         components: {
            FormWizard,
            DatePicker,
            TabContent,
            Multiselect
        },
        data() {
            return {
                jobCircular: {
                    id: '',
                    advertismntNo: '',
                    departmntName: '',
                    title: null,
                    concerndPerson: null,
                    garde: null,
                    payScale: null,
                    pubdate: '',
                    status: '',
                    appDeadline: '',
                    maxAge: '',
                    type: null,
                    type1: '',
                    totalPost: '',
                    quota: '',
                    general: '',
                    freedomFighter: '',
                    dependent: '',
                    female: '',
                    bank_draft: '',
                    bankDetails: '',
                    isReqAttachmnt: '',
                    minEdulbl: null,
                    subject: null,
                    expreinced: '',
                    minLength: '',
                    areOfExp: null,
                    additionalReq: '',
                },
                selected: null,
                oadvertismntNo: [
                    {value: null, text: '07/2009'}
                ],
                selected: null,
                sdepartmntName: [
                    {value: null, text: 'Select'}, {value: 1, text: 'Computer Center'}, {value: 2, text: 'Administration'}
                ],
                 stitle: [
                    {value: null, text: 'Select'}, {value: 1, text: 'Assistant System Analyst'}, {value: 2, text: 'Senior Computer Operator'}
                ],
               subjectList: [
                    {value: null, text: 'Select'}, {value: 1, text: 'Assistant System Analyst'}, {value: 2, text: 'Senior Computer Operator'}
                ],
               areOfExpList: [
                    {value: null, text: 'Select'}, {value: 1, text: 'Dhaka'}, {value: 2, text: 'Barisal'}
                ],
                selected: null,
                sconcerndPerson: [
                    {value: null, text: 'Select'}, {value: 1, text: 'Waker Khan'}
                ],
                spaygrade: [
                    {value: null, text: 'Select'}, {value: 1, text: '01'}, {value: 2, text: '02'}
                ],
                 minEdulblListData: [
                        { name: 'Javascript', code: 'js' }
                    ],
                minEdulblList: [
                    { name: 'Vue.js', code: 'vu' },
                    { name: 'Javascript', code: 'js' },
                    { name: 'Open Source', code: 'os' }
                ],
                sgarde: [
                    {value: null, text: 'Select'}
                ],
                minEdulbldata: [
                     'Bsc(Engr)','Bsc(Hons)'
                ],
                show: true
            }
        },
        methods: {
            formSubmitted() {
                alert("Form submitted!");
            },
            onSubmit(evt) {
                evt.preventDefault()
                alert(JSON.stringify(this.form))
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.email = ''
                this.form.name = ''
                this.form.food = null
                this.form.checked = []
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            },
            addTag (newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.minEdulblList.push(tag)
            this.minEdulblListData.push(tag)
        }
        },

    }

</script>
