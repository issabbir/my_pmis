<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Governmet Audit</h4>
                        </div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-input
                                        v-model="updateIndex"
                                        required
                                        id="input-update-index"
                                        type="text"
                                        :style="{'display':'none'}"
                                    ></b-form-input>

                                    <b-row>
                                        <b-col lg="2">
                                            <label>Issue No</label>
                                        </b-col>
                                        <b-col lg="4" class="form-group">
                                            <multiselect
                                                v-model="form.AuditNo"
                                                :options="AuditNoList"
                                                placeholder="Select one"
                                                label="text"
                                                track-by="name"
                                                :show-labels="false"
                                            ></multiselect>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col>
                                            <b-row>
                                                <b-col lg="6">
                                                    <!-- Audit Type -->
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Audit Type</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <multiselect
                                                                v-model="form.AuditNo"
                                                                :options="AuditNoList"
                                                                placeholder="Select one"
                                                                label="text"
                                                                track-by="name"
                                                                :show-labels="false"
                                                            ></multiselect>
                                                        </b-col>
                                                    </b-row>

                                                    <!-- Issue Name -->
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Issue Name</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input
                                                                v-model="form.SomeText"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Some Text"
                                                            ></b-form-input>
                                                        </b-col>
                                                    </b-row>

                                                    <!-- Date From -->
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Date From</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <date-picker
                                                                v-model="form.DateFrom"
                                                                width="100%"
                                                                input-class="form-control"
                                                                type="date"
                                                                lang="en"
                                                                format="YYYY-MM-DD"
                                                            ></date-picker>
                                                        </b-col>
                                                    </b-row>

                                                    <!-- Add Button -->
                                                    <b-row>
                                                        <b-col class="mt-2 d-flex justify-content-left">
                                                            <b-button
                                                                lg="6"
                                                                size="md"
                                                                class="btn-outline-dark"
                                                                type="reset"
                                                                v-on:click="isHiddenn = !isHiddenn"
                                                            >
                                                                <i class="bx bx-plus-circle cursor-pointer"></i> Add New
                                                            </b-button>
                                                        </b-col>
                                                    </b-row>
                                                </b-col>

                                                <b-col lg="6">
                                                    <!-- Concern Depertment -->
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Concern Depertment</label>
                                                        </b-col>
                                                        <div class="col-md-8 form-group">
                                                            <multiselect
                                                                v-model="form.ConcernDepertment"
                                                                :options="ConcernDepertmentList"
                                                                :custom-label="nameWithLang"
                                                                label="text"
                                                                track-by="name"
                                                                :show-labels="false"
                                                            ></multiselect>
                                                        </div>
                                                    </b-row>

                                                    <!-- Status -->
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Status</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <multiselect
                                                                v-model="form.Status"
                                                                :options="StatusList"
                                                                label="text"
                                                                track-by="name"
                                                                :show-labels="false"
                                                            ></multiselect>
                                                        </b-col>
                                                    </b-row>

                                                    <!-- Date To -->
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Date To</label>
                                                        </b-col>
                                                        <b-col class="col-md-8 form-group">
                                                            <date-picker
                                                                v-model="form.DateTo"
                                                                width="100%"
                                                                input-class="form-control"
                                                                type="date"
                                                                lang="en"
                                                                format="YYYY-MM-DD"
                                                            ></date-picker>
                                                        </b-col>
                                                    </b-row>

                                                    <!-- Search Button -->
                                                    <b-row>
                                                        <b-col class="mt-2 d-flex justify-content-end">
                                                            <b-button
                                                                lg="6"
                                                                size="md"
                                                                class="btn-outline-dark"
                                                                type="reset"
                                                                v-on:click="isHidden = !isHidden"
                                                            >
                                                                <i class="bx bx-search cursor-pointer"></i> Search
                                                            </b-button>
                                                        </b-col>
                                                    </b-row>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </div>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <!-- Zero configuration table -->
            <section id="basic-datatable" v-if="isHidden">
                <b-row>
                    <b-col>
                        <b-card class="card">
                            <div class="card-content">
                                <fieldset class="border p-2">
                                    <legend class="w-auto" style="font-size:small">
                                        <b>Government Audit Details</b>
                                    </legend>
                                    <div class="card-body mb-2">
                                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                            <b-form-input
                                                v-model="updateIndex"
                                                required
                                                id="input-update-index"
                                                type="text"
                                                :style="{'display':'none'}"
                                            ></b-form-input>

                                            <!-- Audit Details -->
                                            <b-row>
                                                <b-col>
                                                    <b-row>
                                                        <b-col lg="6">
                                                            <!-- Issue Date -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>&Issue Date</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <date-picker
                                                                        v-model="form.datetime1"
                                                                        width="100%"
                                                                        input-class="form-control"
                                                                        type="date"
                                                                        lang="en"
                                                                        format="YYYY-MM-DD"
                                                                    ></date-picker>
                                                                </b-col>
                                                            </b-row>

                                                            <!-- Issue Id -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Issue Id</label>
                                                                </b-col>
                                                                <b-col class="col-md-8 form-group">
                                                                    <b-form-input
                                                                        v-model="form.AuditNo"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Audit No"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>

                                                        <b-col lg="6">
                                                            <!-- Issue Name -->
                                                            <b-row>
                                                                <b-col lg="2">
                                                                    <label>Issue Name</label>
                                                                </b-col>
                                                                <b-col lg="10" class="form-group">
                                                                    <b-form-input
                                                                        v-model="form.AuditTitle"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Audit Title"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>

                                                            <!-- Department -->
                                                            <b-row>
                                                                <b-col lg="2">
                                                                    <label>Department</label>
                                                                </b-col>
                                                                <b-col lg="10" class="form-group">
                                                                    <b-form-input
                                                                        v-model="form.AuditReferance"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Department"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                    </b-row>
                                                </b-col>
                                            </b-row>


                                            <!-- Subject -->
                                            <b-row>
                                                <b-col lg="2">
                                                    <label>Subject</label>
                                                </b-col>
                                                <b-col lg="10" class="form-group">
                                                    <b-form-input
                                                        v-model="form.AuditReferance"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="Subject..."
                                                    ></b-form-input>
                                                </b-col>
                                            </b-row>
                                            <!-- description -->
                                            <b-row>
                                                <b-col lg="2">
                                                    <label>Long Description</label>
                                                </b-col>
                                                <b-col lg="10" class="form-group">
                                                    <b-form-textarea
                                                        id="textarea1"
                                                        v-model="text"
                                                        placeholder="Long Description..."
                                                        rows="3"
                                                        max-rows="12"
                                                    ></b-form-textarea>
                                                </b-col>
                                            </b-row>
                                            <!--Current Status -->
                                            <b-row>
                                                <b-col lg="2">
                                                    <label>Current Status</label>
                                                </b-col>
                                                <b-col lg="3" class="form-group">
                                                    <multiselect
                                                        v-model="form.CurrentStatus"
                                                        :options="CurrentStatusList"
                                                        label="text"
                                                        track-by="name"
                                                        :show-labels="false"
                                                    ></multiselect>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>

                                                    <b-row>
                                                        <b-col lg="12">
                                                            <b-row>
                                                                <b-col lg="2">
                                                                    <label>Findings</label>
                                                                </b-col>
                                                                <b-col lg="10" class="form-group">
                                                                    <b-form-textarea
                                                                        id="textarea1"
                                                                        v-model="text"
                                                                        placeholder="Findings..."
                                                                        rows="5"
                                                                        max-rows="12"
                                                                    ></b-form-textarea>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                    </b-row>
                                                    <br/>
                                                    <h5>Deciplinary Action</h5>
                                                    <br/>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <!-- Legal Action -->
                                                            <b-row>
                                                                <b-col lg="1" class="form-group">
                                                                    <b-form-checkbox
                                                                        id="checkbox-1"
                                                                        v-model="status"
                                                                        name="checkbox-1"
                                                                        value="accepted"
                                                                        unchecked-value="not_accepted"
                                                                    ></b-form-checkbox>
                                                                </b-col>
                                                                <b-col lg="8">
                                                                    <label>Legal Action</label>
                                                                </b-col>
                                                            </b-row>

                                                            <!-- Correction Process -->
                                                            <b-row>
                                                                <b-col lg="1" class="form-group">
                                                                    <b-form-checkbox
                                                                        id="checkbox-2"
                                                                        v-model="status"
                                                                        name="checkbox-2"
                                                                        value="accepted"
                                                                        unchecked-value="not_accepted"
                                                                    ></b-form-checkbox>
                                                                </b-col>
                                                                <b-col lg="8">
                                                                    <label>Correction Process</label>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>

                                                        <b-col lg="4">
                                                            <!-- Action Type -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Action Type</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <b-form-input
                                                                        v-model="form.ActionType"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Action Type"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>

                                                            <!-- Correction -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Correction</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <b-form-input
                                                                        v-model="form.Correction"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Correction"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>

                                                        <b-col lg="4">
                                                            <!-- Status(action) -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Status</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <multiselect
                                                                        v-model="form.StatusAction"
                                                                        :options="StatusActionList"
                                                                        label="text"
                                                                        track-by="name"
                                                                        :show-labels="false"
                                                                    ></multiselect>
                                                                </b-col>
                                                            </b-row>

                                                            <!-- Status(process) -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Status</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <multiselect
                                                                        v-model="form.StatusProcess"
                                                                        :options="StatusProcessList"
                                                                        label="text"
                                                                        track-by="name"
                                                                        :show-labels="false"
                                                                    ></multiselect>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                    </b-row>
                                                </b-col>
                                            </b-row>
                                        </b-form>
                                    </div>
                                </fieldset>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>
            </section>
            <!--/ Zero configuration table -->

            <!-- Zero configuration table -->
            <section id="basic-datatable" v-if="isHiddenn">
                <b-row>
                    <b-col>
                        <b-card class="card">
                            <div class="card-content">
                                <fieldset class="border p-2">
                                    <legend class="w-auto" style="font-size:small">
                                        <b>Government Audit Details</b>
                                    </legend>
                                    <div class="card-body mb-2">
                                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                            <b-form-input
                                                v-model="updateIndex"
                                                required
                                                id="input-update-index"
                                                type="text"
                                                :style="{'display':'none'}"
                                            ></b-form-input>

                                            <!-- Audit Details -->
                                            <b-row>
                                                <b-col>
                                                    <b-row>
                                                        <b-col lg="6">
                                                            <!-- Issue Date -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>&Issue Date</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <date-picker
                                                                        v-model="form.datetime1"
                                                                        width="100%"
                                                                        input-class="form-control"
                                                                        type="date"
                                                                        lang="en"
                                                                        format="YYYY-MM-DD"
                                                                    ></date-picker>
                                                                </b-col>
                                                            </b-row>

                                                            <!-- Issue Id -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Issue Id</label>
                                                                </b-col>
                                                                <b-col class="col-md-8 form-group">
                                                                    <b-form-input
                                                                        v-model="form.AuditNo"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Audit No"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>

                                                        <b-col lg="6">
                                                            <!-- Issue Name -->
                                                            <b-row>
                                                                <b-col lg="2">
                                                                    <label>Issue Name</label>
                                                                </b-col>
                                                                <b-col lg="10" class="form-group">
                                                                    <b-form-input
                                                                        v-model="form.AuditTitle"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Audit Title"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>

                                                            <!-- Department -->
                                                            <b-row>
                                                                <b-col lg="2">
                                                                    <label>Department</label>
                                                                </b-col>
                                                                <b-col lg="10" class="form-group">
                                                                    <b-form-input
                                                                        v-model="form.AuditReferance"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Department"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                    </b-row>
                                                </b-col>
                                            </b-row>


                                            <!-- Subject -->
                                            <b-row>
                                                <b-col lg="2">
                                                    <label>Subject</label>
                                                </b-col>
                                                <b-col lg="10" class="form-group">
                                                    <b-form-input
                                                        v-model="form.AuditReferance"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="Subject..."
                                                    ></b-form-input>
                                                </b-col>
                                            </b-row>
                                            <!-- description -->
                                            <b-row>
                                                <b-col lg="2">
                                                    <label>Long Description</label>
                                                </b-col>
                                                <b-col lg="10" class="form-group">
                                                    <b-form-textarea
                                                        id="textarea1"
                                                        v-model="text"
                                                        placeholder="Long Description..."
                                                        rows="3"
                                                        max-rows="12"
                                                    ></b-form-textarea>
                                                </b-col>
                                            </b-row>
                                            <!--Current Status -->
                                            <b-row>
                                                <b-col lg="2">
                                                    <label>Current Status</label>
                                                </b-col>
                                                <b-col lg="3" class="form-group">
                                                    <multiselect
                                                        v-model="form.CurrentStatus"
                                                        :options="CurrentStatusList"
                                                        label="text"
                                                        track-by="name"
                                                        :show-labels="false"
                                                    ></multiselect>
                                                </b-col>
                                            </b-row>

                                            <br/>
                                            <h5>Assignment Details</h5>
                                            <br/>
                                            <b-row>
                                                <b-col>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <!-- Assign -->
                                                            <b-row>
                                                                <b-col lg="6">
                                                                    <label>Assign</label>
                                                                </b-col>
                                                                <b-col lg="6" class="form-group">
                                                                    <b-form-checkbox
                                                                        id="checkbox-1"
                                                                        v-model="Assign"
                                                                        name="checkbox-1"
                                                                        value="Assign"
                                                                        unchecked-value="not_assign"
                                                                    ></b-form-checkbox>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>

                                                        <b-col lg="4">
                                                            <!-- Assignment Date -->
                                                            <b-row>
                                                                <b-col lg="6">
                                                                    <label>Assignment Date</label>
                                                                </b-col>
                                                                <b-col lg="6" class="form-group">
                                                                    <date-picker
                                                                        v-model="form.CompletionDate"
                                                                        width="100%"
                                                                        input-class="form-control"
                                                                        type="date"
                                                                        lang="en"
                                                                        format="YYYY-MM-DD"
                                                                    ></date-picker>
                                                                </b-col>
                                                            </b-row>

                                                        </b-col>
                                                        <b-col lg="4">
                                                            <!-- Attachment -->
                                                            <b-row>
                                                                <b-col lg="3">
                                                                    <label>Attachment</label>
                                                                </b-col>
                                                                <b-col lg="9" class="form-group">
                                                                    <b-form-group label-for="file-default"
                                                                                  label-cols-sm="2">
                                                                        <b-form-file
                                                                            v-model="file"
                                                                            :state="Boolean(file)"
                                                                            placeholder="Choose a file here..."
                                                                            drop-placeholder="Drop file here..."
                                                                        ></b-form-file>
                                                                    </b-form-group>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row>
                                                        <b-col lg="12">
                                                            <b-row>
                                                                <b-col lg="2">
                                                                    <label>Assignment Note</label>
                                                                </b-col>
                                                                <b-col lg="10" class="form-group">
                                                                    <b-form-textarea
                                                                        id="textarea1"
                                                                        v-model="text"
                                                                        placeholder="Assignment Notes..."
                                                                        rows="5"
                                                                        max-rows="12"
                                                                    ></b-form-textarea>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                    </b-row>
                                                    <!--People assign Button -->
                                                    <b-row>
                                                        <b-col class="mt-2 d-flex justify-content-end">
                                                            <b-button
                                                                lg="6"
                                                                size="md"
                                                                class="btn-outline-dark"
                                                                type="reset">People Assign
                                                            </b-button>&nbsp;
                                                            <b-button
                                                                lg="6" size="md"
                                                                class="btn-outline-dark"
                                                                type="reset">Approved & Forward
                                                            </b-button>
                                                        </b-col>
                                                    </b-row>

                                                    <br/>
                                                    <h5>Replay Details</h5>
                                                    <br/>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <!-- Replay -->
                                                            <b-row>
                                                                <b-col lg="6">
                                                                    <label>Replay</label>
                                                                </b-col>
                                                                <b-col lg="6" class="form-group">
                                                                    <b-form-checkbox
                                                                        id="checkbox-1"
                                                                        v-model="Replay"
                                                                        name="checkbox-1"
                                                                        value="Assign"
                                                                        unchecked-value="not_assign"
                                                                    ></b-form-checkbox>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>

                                                        <b-col lg="4">
                                                            <!-- Assignment Date -->
                                                            <b-row>
                                                                <b-col lg="6">
                                                                    <label>Assignment Date</label>
                                                                </b-col>
                                                                <b-col lg="6" class="form-group">
                                                                    <date-picker
                                                                        v-model="form.CompletionDate"
                                                                        width="100%"
                                                                        input-class="form-control"
                                                                        type="date"
                                                                        lang="en"
                                                                        format="YYYY-MM-DD"
                                                                    ></date-picker>
                                                                </b-col>
                                                            </b-row>

                                                        </b-col>
                                                        <b-col lg="4">
                                                            <!-- Attachment -->
                                                            <b-row>
                                                                <b-col lg="3">
                                                                    <label>Attachment</label>
                                                                </b-col>
                                                                <b-col lg="9" class="form-group">
                                                                    <b-form-group label-for="file-default"
                                                                                  label-cols-sm="2">
                                                                        <b-form-file
                                                                            v-model="file"
                                                                            :state="Boolean(file)"
                                                                            placeholder="Choose a file here..."
                                                                            drop-placeholder="Drop file here..."
                                                                        ></b-form-file>
                                                                    </b-form-group>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row>
                                                        <b-col lg="12">
                                                            <b-row>
                                                                <b-col lg="2">
                                                                    <label>Replay Note</label>
                                                                </b-col>
                                                                <b-col lg="10" class="form-group">
                                                                    <b-form-textarea
                                                                        id="textarea1"
                                                                        v-model="text"
                                                                        placeholder="Replay Notes..."
                                                                        rows="5"
                                                                        max-rows="12"
                                                                    ></b-form-textarea>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                        <b-col lg="12">
                                                            <b-row>
                                                                <b-col lg="2">
                                                                    <label>Replay By</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <b-form-input
                                                                        v-model="form.ActionType"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Action Type"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <!-- Legal Action -->
                                                            <b-row>
                                                                <b-col lg="1" class="form-group">
                                                                    <b-form-checkbox
                                                                        id="checkbox-1"
                                                                        v-model="status"
                                                                        name="checkbox-1"
                                                                        value="accepted"
                                                                        unchecked-value="not_accepted"
                                                                    ></b-form-checkbox>
                                                                </b-col>
                                                                <b-col lg="8">
                                                                    <label>Replay to Ministry</label>
                                                                </b-col>
                                                            </b-row>

                                                            <!-- Correction Process -->
                                                            <b-row>
                                                                <b-col lg="1" class="form-group">
                                                                    <b-form-checkbox
                                                                        id="checkbox-2"
                                                                        v-model="status"
                                                                        name="checkbox-2"
                                                                        value="accepted"
                                                                        unchecked-value="not_accepted"
                                                                    ></b-form-checkbox>
                                                                </b-col>
                                                                <b-col lg="8">
                                                                    <label>Call Bilateral</label>
                                                                </b-col>
                                                            </b-row>
                                                            <b-row>
                                                                <b-col lg="1" class="form-group">
                                                                    <b-form-checkbox
                                                                        id="checkbox-2"
                                                                        v-model="status"
                                                                        name="checkbox-2"
                                                                        value="accepted"
                                                                        unchecked-value="not_accepted"
                                                                    ></b-form-checkbox>
                                                                </b-col>
                                                                <b-col lg="8">
                                                                    <label>Triparti</label>
                                                                </b-col>
                                                            </b-row>
                                                            <b-row>
                                                                <b-col lg="1" class="form-group">
                                                                    <b-form-checkbox
                                                                        id="checkbox-2"
                                                                        v-model="status"
                                                                        name="checkbox-2"
                                                                        value="accepted"
                                                                        unchecked-value="not_accepted"
                                                                    ></b-form-checkbox>
                                                                </b-col>
                                                                <b-col lg="8">
                                                                    <label>Draft Para</label>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>

                                                        <b-col lg="4">
                                                            <!-- Action Type -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Date</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <b-form-input
                                                                        v-model="form.ActionType"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Action Type"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>

                                                            <!-- Correction -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Date</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <b-form-input
                                                                        v-model="form.Correction"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Correction"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Date</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <b-form-input
                                                                        v-model="form.Correction"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Correction"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Date</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <b-form-input
                                                                        v-model="form.Correction"
                                                                        required
                                                                        id="input-id"
                                                                        type="text"
                                                                        placeholder="Correction"
                                                                    ></b-form-input>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>

                                                        <b-col lg="4">
                                                            <!-- Status(action) -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Status</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <multiselect
                                                                        v-model="form.StatusAction"
                                                                        :options="StatusActionList"
                                                                        label="text"
                                                                        track-by="name"
                                                                        :show-labels="false"
                                                                    ></multiselect>
                                                                </b-col>
                                                            </b-row>

                                                            <!-- Status(process) -->
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Status</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <multiselect
                                                                        v-model="form.StatusProcess"
                                                                        :options="StatusProcessList"
                                                                        label="text"
                                                                        track-by="name"
                                                                        :show-labels="false"
                                                                    ></multiselect>
                                                                </b-col>
                                                            </b-row>
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Status</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <multiselect
                                                                        v-model="form.StatusAction"
                                                                        :options="StatusActionList"
                                                                        label="text"
                                                                        track-by="name"
                                                                        :show-labels="false"
                                                                    ></multiselect>
                                                                </b-col>
                                                            </b-row>
                                                            <b-row>
                                                                <b-col lg="4">
                                                                    <label>Status</label>
                                                                </b-col>
                                                                <b-col lg="8" class="form-group">
                                                                    <multiselect size="sm"
                                                                                 v-model="form.StatusAction"
                                                                                 :options="StatusActionList"
                                                                                 label="text"
                                                                                 track-by="name"
                                                                                 :show-labels="false"
                                                                    ></multiselect>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                        <b-col lg="12">
                                                            <b-row>
                                                                <b-col lg="2">
                                                                    <label>Action Summary</label>
                                                                </b-col>
                                                                <b-col lg="10" class="form-group">
                                                                    <b-form-textarea
                                                                        id="textarea1"
                                                                        v-model="text"
                                                                        placeholder="Action Summary..."
                                                                        rows="5"
                                                                        max-rows="12"
                                                                    ></b-form-textarea>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                        <b-col lg="12">
                                                            <b-row>
                                                                <b-col lg="2">
                                                                    <label>Completion Note</label>
                                                                </b-col>
                                                                <b-col lg="10" class="form-group">
                                                                    <b-form-textarea
                                                                        id="textarea1"
                                                                        v-model="text"
                                                                        placeholder="Action Summary..."
                                                                        rows="2"
                                                                        max-rows="12"
                                                                    ></b-form-textarea>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                        <b-col lg="12">
                                                            <b-row>
                                                                <b-col lg="2">
                                                                    <label>Attachment</label>
                                                                </b-col>
                                                                <b-col lg="9" class="form-group">
                                                                    <b-form-group label-for="file-default"
                                                                                  label-cols-sm="2">
                                                                        <b-form-file
                                                                            v-model="file"
                                                                            :state="Boolean(file)"
                                                                            placeholder="Choose a file here..."
                                                                            drop-placeholder="Drop file here..."
                                                                        ></b-form-file>
                                                                    </b-form-group>
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                    </b-row>
                                                </b-col>
                                            </b-row>
                                        </b-form>
                                    </div>
                                </fieldset>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>
            </section>
            <!--/ Zero configuration table -->
        </div>
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import DatePicker from "vue2-datepicker";

    export default {
        components: {
            Multiselect,
            DatePicker
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Audit"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Government Audit"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Audit Details"});
        },
        data() {
            return {
                form: {
                    employee_id: "",
                    department_name: "",
                    designation: "",
                    Status: null,
                    bankbr: null,
                    accname: null,
                    accno: null,
                    financial_code: null,
                    shift: null
                },
                show: true,
                updateIndex: -1,
                submitBtn: "Save",

                tableData: {
                    fields: [
                        {key: "EmployeeName", label: "Employee Name", sortable: true},
                        {key: "Designation", label: "Designation", sortable: true},
                        {key: "Department", label: "Department", sortable: true}
                    ],
                    items: [
                        {
                            EmployeeName: "Mr. Aminul Islam",
                            Designation: "Officer",
                            Department: "Internal Audit"
                        },
                        {
                            EmployeeName: "Mr. Kazi Arif Uddin",
                            Designation: "Sr. Officer",
                            Department: "Central Store"
                        }
                    ]
                },

                CurrentStatusList: [
                    {value: "DraftPara", text: "Draft Para"},
                    {value: "BilateralMitting", text: "Bilateral Mitting"},
                    {value: "AdvanceMeeting", text: "Advance Meeting"}
                ],

                StatusActionList: [
                    {value: "ShowCause", text: "Show Cause"},
                    {value: "Suspended", text: "Suspended"}
                ],

                StatusProcessList: [
                    {value: "Corrected", text: "Corrected"},
                    {value: "CorrectioninProcess", text: "Correction in Process"}
                ],

                AuditStatusList: [
                    {value: "HalfWay", text: "Half Way"},
                    {value: "EndingWay", text: "Ending Way"}
                ],
                CompletionList: [
                    {value: "tenp", text: "10%"},
                    {value: "fiftyp", text: "50%"}
                ],
                AuditAssesmentCategoryList: [
                    {value: "Good", text: "Good"},
                    {value: "Satisfactory", text: "Satisfactory"},
                    {value: "LimitedModarate", text: "Limited/Modarate"},
                    {value: "Weak", text: "Weak"}
                ],
                AuditDepartmentList: [
                    {value: "CentralStore", text: "Central Store"},
                    {value: "Machanical", text: "Machanical"}
                ],
                StatusList: [
                    {value: "Open", text: "Open"},
                    {value: "Close", text: "Close"}
                ],
                ConcernDepertmentList: [
                    {value: "FinanceandAccounts", text: "Finance & Accounts"},
                    {value: "CentralStore", text: "Central Store"}
                ],
                AuditNoList: [
                    {value: "IT8228", text: "IT8228"},
                    {value: "FA083", text: "FA083"}
                ]
            };
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if (this.updateIndex > -1) {
                    //update
                    this.tableData.items[
                        this.updateIndex
                        ].employee_id = this.form.employee_id;
                    this.tableData.items[
                        this.updateIndex
                        ].department_name = this.form.department_name;
                    this.tableData.items[
                        this.updateIndex
                        ].designation = this.form.designation;
                    this.tableData.items[
                        this.updateIndex
                        ].division_name = this.form.division_name;
                    this.tableData.items[
                        this.updateIndex
                        ].financial_code = this.form.financial_code;
                    this.tableData.items[this.updateIndex].shift = this.form.shift;
                } else {
                    //new data add
                    this.tableData.items.push({
                        employee_id: this.form.employee_id,
                        department_name: this.form.department_name,
                        designation: this.form.designation,
                        division_name: this.form.division_name,
                        financial_code: this.form.financial_code,
                        shift: this.form.shift
                    });
                }
                this.onReset(evt);
            },
            onReset(evt) {
                evt.preventDefault();
                this.employee_id = "";
                this.department_name = "";
                this.designation = "";
                this.division_name = null;
                this.financial_code = null;
                this.shift = null;

                this.updateIndex = -1;
                this.submitBtn = "Save";
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            editRow(i, code) {
                this.submitBtn = "Update";
                this.updateIndex = i;
                let data = this.tableData.items[i];

                console.log(data);

                this.form.employee_id = data.employee_id;
                this.form.department_name = data.department_name;
                this.form.designation = data.designation;
                this.form.division_name = data.division_name;
                this.form.financial_code = data.financial_code;
                this.form.shift = data.shift;

                console.log(this.form);
            },
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            }
        }
    };
</script>
