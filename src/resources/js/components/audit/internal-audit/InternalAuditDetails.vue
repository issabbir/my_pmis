<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Internal Audit</h4>
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
                    <b-col>
                      <b-row>
                        <b-col lg="6">
                          <!-- Audit No -->
                          <b-row>
                            <b-col lg="4">
                              <label>Audit No</label>
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

                          <!-- Some Text -->
                          <b-row>
                            <b-col lg="4">
                              <label>Some Text</label>
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
                    <b>Internal Audit Details</b>
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

                      <b-row>
                        <b-col>
                          <b-row>
                            <b-col lg="4">
                              <!-- Audit Date -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Audit Date</label>
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

                              <!-- Audit No -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Audit No</label>
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

                              <!-- Audit Department -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Audit Department</label>
                                </b-col>
                                <b-col lg="8" class="form-group">
                                  <multiselect
                                    v-model="form.AuditDepartment"
                                    :options="AuditDepartmentList"
                                    label="text"
                                    track-by="name"
                                    :show-labels="false"
                                  ></multiselect>
                                </b-col>
                              </b-row>
                            </b-col>

                            <b-col lg="8">
                              <!-- Audit Title -->
                              <b-row>
                                <b-col lg="2">
                                  <label>Audit Title</label>
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

                              <!-- Audit Referance -->
                              <b-row>
                                <b-col lg="2">
                                  <label>Audit Referance</label>
                                </b-col>
                                <b-col lg="10" class="form-group">
                                  <b-form-input
                                    v-model="form.AuditReferance"
                                    required
                                    id="input-id"
                                    type="text"
                                    placeholder="Audit Referance"
                                  ></b-form-input>
                                </b-col>
                              </b-row>
                            </b-col>
                          </b-row>
                        </b-col>
                      </b-row>

                      <fieldset class="border p-2">
                        <legend class="w-auto" style="font-size:small">
                          <b>Audit Team (Optional)</b>
                        </legend>

                        <b-card-text class="card-body">
                          <div class="table-responsive">
                            <b-table
                              bordered
                              striped
                              hover
                              show-empty
                              small
                              :items="tableData.items"
                              :current-page="currentPage"
                              er-page="perPage"
                              :filter="filter"
                              ort-by.sync="sortBy"
                              ort-desc.sync="sortDesc"
                              ort-direction="sortDirection"
                              :fields="tableData.fields"
                              responsive
                            ></b-table>
                          </div>
                        </b-card-text>
                      </fieldset>
                      <br />

                      <b-row>
                        <b-col>
                          <b-row>
                            <b-col lg="6">
                              <!-- Audit Status -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Audit Status</label>
                                </b-col>
                                <b-col lg="8" class="form-group">
                                  <multiselect
                                    v-model="form.AuditStatus"
                                    :options="AuditStatusList"
                                    label="text"
                                    track-by="name"
                                    :show-labels="false"
                                  ></multiselect>
                                </b-col>
                              </b-row>

                              <!-- Audit Assesment Category -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Audit Assesment Category</label>
                                </b-col>
                                <b-col class="col-md-8 form-group">
                                  <multiselect
                                    v-model="form.AuditAssesmentCategory"
                                    :options="AuditAssesmentCategoryList"
                                    label="text"
                                    track-by="name"
                                    :show-labels="false"
                                  ></multiselect>
                                </b-col>
                              </b-row>
                            </b-col>

                            <b-col lg="6">
                              <!-- Audit Date -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Completion</label>
                                </b-col>
                                <b-col lg="8" class="form-group">
                                  <multiselect
                                    v-model="form.Completion"
                                    :options="CompletionList"
                                    label="text"
                                    track-by="name"
                                    :show-labels="false"
                                  ></multiselect>
                                </b-col>
                              </b-row>

                              <!-- Completion Date -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Completion Date</label>
                                </b-col>
                                <b-col lg="8" class="form-group">
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
                          </b-row>
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
                          <br />
                          <h5>Deciplinary Action</h5>
                          <br />
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
                    <b>Internal Audit Details</b>
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

                      <b-row>
                        <b-col>
                          <b-row>
                            <b-col lg="4">
                              <!-- Audit Date -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Audit Date</label>
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

                              <!-- Audit No -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Audit No</label>
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

                              <!-- Audit Department -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Audit Department</label>
                                </b-col>
                                <b-col lg="8" class="form-group">
                                  <multiselect
                                    v-model="form.AuditDepartment"
                                    :options="AuditDepartmentList"
                                    label="text"
                                    track-by="name"
                                    :show-labels="false"
                                  ></multiselect>
                                </b-col>
                              </b-row>
                            </b-col>

                            <b-col lg="8">
                              <!-- Audit Title -->
                              <b-row>
                                <b-col lg="2">
                                  <label>Audit Title</label>
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

                              <!-- Audit Referance -->
                              <b-row>
                                <b-col lg="2">
                                  <label>Audit Referance</label>
                                </b-col>
                                <b-col lg="10" class="form-group">
                                  <b-form-input
                                    v-model="form.AuditReferance"
                                    required
                                    id="input-id"
                                    type="text"
                                    placeholder="Audit Referance"
                                  ></b-form-input>
                                </b-col>
                              </b-row>
                            </b-col>
                          </b-row>
                        </b-col>
                      </b-row>

                      <fieldset class="border p-2">
                        <legend class="w-auto" style="font-size:small">
                          <b>Audit Team (Optional)</b>
                        </legend>

                        <b-card-text class="card-body">
                          <div class="table-responsive">
                            <b-table
                              bordered
                              striped
                              hover
                              show-empty
                              small
                              :items="tableData.items"
                              :current-page="currentPage"
                              er-page="perPage"
                              :filter="filter"
                              ort-by.sync="sortBy"
                              ort-desc.sync="sortDesc"
                              ort-direction="sortDirection"
                              :fields="tableData.fields"
                              responsive
                            ></b-table>
                          </div>
                        </b-card-text>
                      </fieldset>
                      <br />

                      <b-row>
                        <b-col>
                          <b-row>
                            <b-col lg="6">
                              <!-- Audit Status -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Audit Status</label>
                                </b-col>
                                <b-col lg="8" class="form-group">
                                  <multiselect
                                    v-model="form.AuditStatus"
                                    :options="AuditStatusList"
                                    label="text"
                                    track-by="name"
                                    :show-labels="false"
                                  ></multiselect>
                                </b-col>
                              </b-row>

                              <!-- Audit Assesment Category -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Audit Assesment Category</label>
                                </b-col>
                                <b-col class="col-md-8 form-group">
                                  <multiselect
                                    v-model="form.AuditAssesmentCategory"
                                    :options="AuditAssesmentCategoryList"
                                    label="text"
                                    track-by="name"
                                    :show-labels="false"
                                  ></multiselect>
                                </b-col>
                              </b-row>
                            </b-col>

                            <b-col lg="6">
                              <!-- Audit Date -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Completion</label>
                                </b-col>
                                <b-col lg="8" class="form-group">
                                  <multiselect
                                    v-model="form.Completion"
                                    :options="CompletionList"
                                    label="text"
                                    track-by="name"
                                    :show-labels="false"
                                  ></multiselect>
                                </b-col>
                              </b-row>

                              <!-- Completion Date -->
                              <b-row>
                                <b-col lg="4">
                                  <label>Completion Date</label>
                                </b-col>
                                <b-col lg="8" class="form-group">
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
                          </b-row>
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
                          <br />
                          <h5>Deciplinary Action</h5>
                          <br />
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
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Accounts & Finance"
    });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Fixed Asset" });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Asset Addition" });
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
          { key: "EmployeeName", label: "Employee Name", sortable: true },
          { key: "Designation", label: "Designation", sortable: true },
          { key: "Department", label: "Department", sortable: true }
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

      StatusActionList: [
        { value: "ShowCause", text: "Show Cause" },
        { value: "Suspended", text: "Suspended" }
      ],

      StatusProcessList: [
        { value: "Corrected", text: "Corrected" },
        { value: "CorrectioninProcess", text: "Correction in Process" }
      ],

      AuditStatusList: [
        { value: "HalfWay", text: "Half Way" },
        { value: "EndingWay", text: "Ending Way" }
      ],
      CompletionList: [
        { value: "tenp", text: "10%" },
        { value: "fiftyp", text: "50%" }
      ],
      AuditAssesmentCategoryList: [
        { value: "Good", text: "Good" },
        { value: "Satisfactory", text: "Satisfactory" },
        { value: "LimitedModarate", text: "Limited/Modarate" },
        { value: "Weak", text: "Weak" }
      ],
      AuditDepartmentList: [
        { value: "CentralStore", text: "Central Store" },
        { value: "Machanical", text: "Machanical" }
      ],
      StatusList: [
        { value: "Open", text: "Open" },
        { value: "Close", text: "Close" }
      ],
      ConcernDepertmentList: [
        { value: "FinanceandAccounts", text: "Finance & Accounts" },
        { value: "CentralStore", text: "Central Store" }
      ],
      AuditNoList: [
        { value: "IT8228", text: "IT8228" },
        { value: "FA083", text: "FA083" }
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
