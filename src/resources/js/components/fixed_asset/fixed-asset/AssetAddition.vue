<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Asset Addition</h4>
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
                        <b-col lg="4">
                          <!-- Asset Code -->
                          <b-row>
                            <b-col lg="4">
                              <label>Asset Code</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.AssetCode"
                                :options="AssetCodeList"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Asset Type -->
                          <b-row>
                            <b-col lg="4">
                              <label>Asset Type</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.AssetType"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Asset Type"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Asset Description -->
                          <b-row>
                            <b-col lg="4">
                              <label>Asset Description</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.AssetDescription"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Asset Description"
                              ></b-form-input>
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
                                <i class="bx bx-plus-circle cursor-pointer"></i> Add
                              </b-button>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="4">
                          <!-- Asset Depertment -->
                          <b-row>
                            <b-col lg="4">
                              <label>Asset Depertment</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <multiselect
                                v-model="form.AssetDepertment"
                                :options="AssetDepertmentlist"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </div>
                          </b-row>

                          <!-- Group Name -->
                          <b-row>
                            <b-col lg="4">
                              <label>Group Name</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.GroupName"
                                :options="GroupNamelist"
                                :custom-label="nameWithLang"
                                placeholder="Select one"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Category -->
                          <b-row>
                            <b-col lg="4">
                              <label>Category</label>
                            </b-col>
                            <b-col class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.Category"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Category"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="4">
                          <!-- PO Number -->
                          <b-row>
                            <b-col lg="4">
                              <label>PO Number</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.PONumber"
                                required
                                id="input-id"
                                type="text"
                                placeholder="PO Number"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Party Code -->
                          <b-row>
                            <b-col lg="4">
                              <label>Party Code</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.PartyCode"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Party Code"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Party Name -->
                          <b-row>
                            <b-col lg="4">
                              <label>Party Name</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <b-form-input
                                v-model="form.PartyName"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Party Name"
                              ></b-form-input>
                            </div>
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
                              >Search</b-button>&nbsp;
                              <b-button lg="6" size="md" class="btn-outline-dark" type="reset">Clear</b-button>
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
                            <!-- Asset Code -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Code</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <multiselect
                                  v-model="form.AssetCodeBdy"
                                  :options="AssetCodeList"
                                  :custom-label="nameWithLang"
                                  placeholder="Select one"
                                  label="text"
                                  track-by="name"
                                ></multiselect>
                              </b-col>
                            </b-row>

                            <!-- Asset Type -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Type</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.AssetTypeBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Asset Type"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Asset Description -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Description</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.AssetDescriptionBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Asset Description"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Asset Depertment -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Depertment</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <multiselect
                                  v-model="form.AssetDepertmentBdy"
                                  :options="AssetDepertmentlist"
                                  :custom-label="nameWithLang"
                                  placeholder="Select one"
                                  label="text"
                                  track-by="name"
                                ></multiselect>
                              </b-col>
                            </b-row>

                            <!-- Asset Location -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Location</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.AssetLocation"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Asset Location"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>

                          <b-col lg="4">
                            <!-- Group -->
                            <b-row>
                              <b-col lg="4">
                                <label>Group</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.Group"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Group"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Category -->
                            <b-row>
                              <b-col lg="4">
                                <label>Category</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.CategoryBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Category"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- PO Number -->
                            <b-row>
                              <b-col lg="4">
                                <label>PO Number</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.PONumberBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="PO Number"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Party Code -->
                            <b-row>
                              <b-col lg="4">
                                <label>Party Code</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.PartyCodeBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Party Code"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Party Name -->
                            <b-row>
                              <b-col lg="4">
                                <label>Party Name</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.PartyNameBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Party Name"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>

                          <b-col lg="4">
                            <!-- Qua -->
                            <b-row>
                              <b-col lg="4">
                                <label>Qua</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.Qua"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Qua"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Serial Number -->
                            <b-row>
                              <b-col lg="4">
                                <label>Serial Number</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.SerialNumber"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Serial Number"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Methods -->
                            <b-row>
                              <b-col lg="4">
                                <label>Methods</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.Methods"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Methods"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Prorate Date -->
                            <b-row>
                              <b-col lg="4">
                                <label>Prorate Date</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <date-picker
                                  v-model="form.dateProrate"
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
                      </b-col>
                    </b-row>

                    <!--</fieldset>-->
                  </b-form>
                </div>

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
                    >
                      <template v-slot:cell(action)="row">
                        <b-link
                          ml="4"
                          class="text-primary"
                          @click="editRow(row.index, row.item.id)"
                        >
                          <i class="bx bx-edit cursor-pointer"></i>
                        </b-link>

                        <b-link class="text-danger" @click="deleteRow(row.index, row.item.id)">
                          <i class="bx bx-trash cursor-pointer"></i>
                        </b-link>
                      </template>
                    </b-table>
                  </div>
                </b-card-text>
                <div class="mt-2 d-flex justify-content-end">
                  <b-button lg="6" size="md" variant="dark" type="submit">Edit</b-button>&nbsp;
                </div>
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
                            <!-- Asset Code -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Code</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <multiselect
                                  v-model="form.AssetCodeBdy"
                                  :options="AssetCodeList"
                                  :custom-label="nameWithLang"
                                  placeholder="Select one"
                                  label="text"
                                  track-by="name"
                                ></multiselect>
                              </b-col>
                            </b-row>

                            <!-- Asset Type -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Type</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.AssetTypeBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Asset Type"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Asset Description -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Description</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.AssetDescriptionBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Asset Description"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Asset Depertment -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Depertment</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <multiselect
                                  v-model="form.AssetDepertmentBdy"
                                  :options="AssetDepertmentlist"
                                  :custom-label="nameWithLang"
                                  placeholder="Select one"
                                  label="text"
                                  track-by="name"
                                ></multiselect>
                              </b-col>
                            </b-row>

                            <!-- Asset Location -->
                            <b-row>
                              <b-col lg="4">
                                <label>Asset Location</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.AssetLocation"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Asset Location"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>

                          <b-col lg="4">
                            <!-- Group -->
                            <b-row>
                              <b-col lg="4">
                                <label>Group</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.Group"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Group"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Category -->
                            <b-row>
                              <b-col lg="4">
                                <label>Category</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.CategoryBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Category"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- PO Number -->
                            <b-row>
                              <b-col lg="4">
                                <label>PO Number</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.PONumberBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="PO Number"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Party Code -->
                            <b-row>
                              <b-col lg="4">
                                <label>Party Code</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.PartyCodeBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Party Code"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Party Name -->
                            <b-row>
                              <b-col lg="4">
                                <label>Party Name</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.PartyNameBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Party Name"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>

                          <b-col lg="4">
                            <!-- Qua -->
                            <b-row>
                              <b-col lg="4">
                                <label>Qua</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.Qua"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Qua"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Serial Number -->
                            <b-row>
                              <b-col lg="4">
                                <label>Serial Number</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.SerialNumber"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Serial Number"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Methods -->
                            <b-row>
                              <b-col lg="4">
                                <label>Methods</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.Methods"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Methods"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Prorate Date -->
                            <b-row>
                              <b-col lg="4">
                                <label>Prorate Date</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <date-picker
                                  v-model="form.dateProrate"
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
                      </b-col>
                    </b-row>

                    <!--</fieldset>-->
                  </b-form>
                </div>

                <b-card-text class="card-body">
                  <div class="table-responsive">
                    <b-table
                      bordered
                      striped
                      hover
                      show-empty
                      small
                      :items="fieldItems"
                      :current-page="currentPage"
                      er-page="perPage"
                      :filter="filter"
                      ort-by.sync="sortBy"
                      ort-desc.sync="sortDesc"
                      ort-direction="sortDirection"
                      :fields="tableFields"
                      responsive
                    >
                      <template v-slot:cell(SL)="row">
                        <b-form-input id="tableFields" v-model="form.SL" placeholder="SL"></b-form-input>
                      </template>
                      <template v-slot:cell(DateinService)="row">
                        <date-picker
                          v-model="form.datetimein"
                          width="100%"
                          input-class="form-control"
                          type="date"
                          lang="en"
                          format="YYYY-MM-DD"
                        ></date-picker>
                      </template>
                      <template v-slot:cell(LifeYear)="row">
                        <b-form-input
                          id="tableFields"
                          v-model="form.Number"
                          placeholder="Life Year"
                        ></b-form-input>
                      </template>
                      <template v-slot:cell(Month)="row">
                        <b-form-input id="tableFields" v-model="form.Number" placeholder="Month"></b-form-input>
                      </template>
                      <template v-slot:cell(Cost)="row">
                        <b-form-input id="tableFields" v-model="form.Number" placeholder="Cost"></b-form-input>
                      </template>
                      <template v-slot:cell(ExpanceAmount)="row">
                        <b-form-input
                          id="tableFields"
                          v-model="form.Number"
                          placeholder="Expance Amount"
                        ></b-form-input>
                      </template>
                      <template v-slot:cell(Quantity)="row">
                        <b-form-input id="tableFields" v-model="form.Number" placeholder="Quantity"></b-form-input>
                      </template>
                      <template v-slot:cell(Remarks)="row">
                        <b-form-input id="tableFields" v-model="form.Number" placeholder="Remarks"></b-form-input>
                      </template>
                      <template v-slot:cell(action)="row">
                        <b-button size="sm" class="mr-2">Add</b-button>
                      </template>
                    </b-table>
                  </div>
                </b-card-text>
                <div class="mt-2 d-flex justify-content-end">
                  <b-button lg="6" size="md" variant="dark" type="submit">Save</b-button>&nbsp;
                </div>
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
      this.$store.commit("setBreadcrumb", {link: "#", label: "Accounts & Finance"});
      this.$store.commit("setBreadcrumb", {link: "#", label: "Fixed Asset"});
      this.$store.commit("setBreadcrumb", {link: "#", label: "Asset Addition"});
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
          { key: "SL", label: "SL", sortable: true },
          { key: "DateinService", label: "Date in Service", sortable: true },
          { key: "LifeYear", label: "Life Year", sortable: true },
          { key: "Month", label: "Month", sortable: true },
          { key: "Cost", label: "Cost", sortable: true },
          { key: "ExpenseAccount", label: "Expense Account", sortable: true },
          { key: "Quantity", label: "Quantity", sortable: true },
          { key: "Remarks", label: "Remarks", sortable: true },
          "Action"
        ],
        items: [
          {
            SL: 1,
            DateinService: "1-Jan-2019",
            LifeYear: 4,
            Month: "29-Aug-2019",
            Cost: 5000,
            ExpenseAccount: "222.49448(LOV)",
            Quantity: 1,
            Remarks: "-"
          }
        ]
      },

      tableFields: [
        { key: "DateinService", label: "Date in Service", sortable: true },
        { key: "LifeYear", label: "Life Year", sortable: true },
        { key: "Month", label: "Month", sortable: true },
        { key: "Cost", label: "Cost", sortable: true },
        { key: "ExpanceAmount", label: "Expance Amount", sortable: true },
        { key: "Quantity", label: "Quantity", sortable: true },
        { key: "Remarks", label: "Remarks", sortable: true },
        "Action"
      ],
      fieldItems: [
        {
          SL: "",
          DateinService: "",
          LifeYear: "",
          Month: "",
          Cost: "",
          ExpanceAmount: "",
          Quantity: "",
          Remarks: "",
          Action: ""
        }
      ],
      AssetCodeList: [
        { value: null, text: "Please select" },
        { value: "011091003", text: "011091003" },
        { value: "011091004", text: "011091004" },
        { value: "011091005", text: "011091005" },
        { value: "011091006", text: "011091006" }
      ],
      GroupNamelist: [
        { value: null, text: "Please select" },
        { value: "Land", text: "Land" },
        { value: "ElectricInstallation", text: "Electric Installation" }
      ],
      AssetDepertmentlist: [
        { value: null, text: "Please select" },
        { value: "CivilEngineeringDept", text: "Civil Engineering Dept." },
        { value: "MachanicalDept", text: "Machanical Dept." }
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
