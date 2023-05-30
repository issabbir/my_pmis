<template>
  <div class="content-wrapper">
    <div class="content-body">
      <b-row>
        <b-col>
          <b-card class="card">
            <div class="card-header">
              <h4 class="card-title">Enter Budget Amount</h4>
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
                          <!-- Budget Year -->
                          <b-row>
                            <b-col lg="4">
                              <label>Budget Year</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.BudgetYear"
                                :options="BudgetYearList"
                                label="text"
                                track-by="name"
                                :show-labels="false"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Department Name -->
                          <b-row>
                            <b-col lg="4">
                              <label>Department Name</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.DepartmentName"
                                :options="DepartmentNameList"
                                :show-labels="false"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>

                          <!-- Budget Types -->
                          <b-row>
                            <b-col lg="4">
                              <label>Budget Types</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.BudgetTypes"
                                :options="BudgetTypesList"
                                :show-labels="false"
                                label="text"
                                track-by="name"
                              ></multiselect>
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
                          <!-- Natural Accounts -->
                          <b-row>
                            <b-col lg="4">
                              <label>Natural Accounts</label>
                            </b-col>
                            <div class="col-md-8 form-group">
                              <multiselect
                                v-model="form.NaturalAccounts"
                                :options="NaturalAccountslist"
                                :show-labels="false"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </div>
                          </b-row>

                          <!-- Account Description -->
                          <b-row>
                            <b-col lg="4">
                              <label>Account Description</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <multiselect
                                v-model="form.AccountDescription"
                                :options="AccountDescriptionlist"
                                :show-labels="false"
                                label="text"
                                track-by="name"
                              ></multiselect>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="4">
                          <!-- Budget Month From -->
                          <b-row>
                            <b-col lg="4">
                              <label>Budget Month From</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.BudgetMonthFrom"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Budget Month From"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <!-- Budget Month To -->
                          <b-row>
                            <b-col lg="4">
                              <label>Budget Month To</label>
                            </b-col>
                            <b-col lg="8" class="form-group">
                              <b-form-input
                                v-model="form.BudgetMonthTo"
                                required
                                id="input-id"
                                type="text"
                                placeholder="Budget Month To"
                              ></b-form-input>
                            </b-col>
                          </b-row>

                          <br />
                          <br />
                          <br />

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
                                <i class="bx bx-search cursor-pointer"></i>Search
                              </b-button>&nbsp;
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
                            <!-- Budget Year -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Year</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <multiselect
                                  v-model="form.BudgetYearbdy"
                                  :options="BudgetYearList"
                                  :custom-label="nameWithLang"
                                  placeholder="Select one"
                                  label="text"
                                  track-by="name"
                                  :show-labels="false"
                                ></multiselect>
                              </b-col>
                            </b-row>

                            <!-- Budget Year -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Year (dept)</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <multiselect
                                  v-model="form.DepartmentNamebdy1"
                                  :options="DepartmentNameList"
                                  :show-labels="false"
                                  label="text"
                                  track-by="name"
                                ></multiselect>
                              </b-col>
                            </b-row>

                            <!-- Budget Description -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Description</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.BudgetDescription"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Budget Description"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Revised Amount -->
                            <b-row>
                              <b-col lg="4">
                                <label>Revised Amount</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.RevisedAmountsearch"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Revised Amount"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>

                          <b-col lg="4">
                            <!-- Natural Account -->
                            <b-row>
                              <b-col lg="4">
                                <label>Natural Account</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.NaturalAccountBdysearch"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Natural Account"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Account Description -->
                            <b-row>
                              <b-col lg="4">
                                <label>Account Description</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.AccountDescriptionBdysearch"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Account Description"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Budget Amount -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Amount</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.BudgetAmountsearch"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Budget Amount"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Remarks -->
                            <b-row>
                              <b-col lg="4">
                                <label>Remarks</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.Remarks"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Remarks"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>

                          <b-col lg="4">
                            <!-- Budget Types -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Types</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <multiselect
                                  v-model="form.BudgetTypesbdy"
                                  :options="BudgetTypesList"
                                  :show-labels="false"
                                  label="text"
                                  track-by="name"
                                ></multiselect>
                              </b-col>
                            </b-row>

                            <!-- Budget Month -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Month</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.BudgetMonthsearch"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Budget Month"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Total Amount -->
                            <b-row>
                              <b-col lg="4">
                                <label>Total Amount</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.TotalAmountsearch"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Total Amount"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>
                        </b-row>
                      </b-col>
                    </b-row>
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
                <div class="card-body pt-0 mx-50">
                  <hr />
                  <div class="row">
                    <div class="col-4 col-sm-6 mt-75"></div>
                    <div class="col-8 col-sm-6 d-flex justify-content-end mt-75">
                      <div class="invoice-subtotal">
                        <div class="invoice-calc d-flex justify-content-between">
                          <span class="invoice-title">
                            <b>Amount:</b>&emsp;&emsp;&emsp;&emsp;&emsp;
                          </span>
                          <span class="invoice-value">
                            <b>20,03459</b>
                          </span>
                        </div>
                        <div class="invoice-calc d-flex justify-content-between">
                          <span class="invoice-title">
                            <b>Revised Amount:</b>&emsp;&emsp;&emsp;&emsp;&emsp;
                          </span>
                          <span class="invoice-value">
                            <b>10,3459</b>
                          </span>
                        </div>
                        <div class="invoice-calc d-flex justify-content-between">
                          <span class="invoice-title">
                            <b>Total Amount:</b>&emsp;&emsp;&emsp;&emsp;&emsp;
                          </span>
                          <span class="invoice-value">
                            <b>2,106,918</b>
                          </span>
                        </div>
                        <hr />

                        <div class="invoice-calc d-flex justify-content-between">
                          <b-button
                            variant="dark"
                            class="btn btn-primary btn-block subtotal-preview-btn"
                          >Edit</b-button>
                        </div>
                      </div>
                    </div>
                  </div>
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
                            <!-- Budget Year -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Year</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <multiselect
                                  v-model="form.BudgetYearbdy2"
                                  :options="BudgetYearList"
                                  label="text"
                                  track-by="name"
                                  :show-labels="false"
                                ></multiselect>
                              </b-col>
                            </b-row>

                            <!-- Budget Year -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Year (dept)</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <multiselect
                                  v-model="form.DepartmentNamebdy2"
                                  :options="DepartmentNameList"
                                  :show-labels="false"
                                  label="text"
                                  track-by="name"
                                ></multiselect>
                              </b-col>
                            </b-row>

                            <!-- Budget Description -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Description</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.BudgetDescription"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Budget Description"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Revised Amount -->
                            <b-row>
                              <b-col lg="4">
                                <label>Revised Amount</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.RevisedAmount"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Revised Amount"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>

                          <b-col lg="4">
                            <!-- Natural Account -->
                            <b-row>
                              <b-col lg="4">
                                <label>Natural Account</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.NaturalAccountBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Natural Account"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Account Description -->
                            <b-row>
                              <b-col lg="4">
                                <label>Account Description</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.AccountDescriptionBdy"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Account Description"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Budget Amount -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Amount</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.BudgetAmount"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Budget Amount"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Remarks -->
                            <b-row>
                              <b-col lg="4">
                                <label>Remarks</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.Remarks"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Remarks"
                                ></b-form-input>
                              </b-col>
                            </b-row>
                          </b-col>

                          <b-col lg="4">
                            <!-- Budget Types -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Types</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <multiselect
                                  v-model="form.BudgetTypesbdy2"
                                  :options="BudgetTypesList"
                                  :show-labels="false"
                                  label="text"
                                  track-by="name"
                                ></multiselect>
                              </b-col>
                            </b-row>

                            <!-- Budget Month -->
                            <b-row>
                              <b-col lg="4">
                                <label>Budget Month</label>
                              </b-col>
                              <b-col class="col-md-8 form-group">
                                <b-form-input
                                  v-model="form.BudgetMonth"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Budget Month"
                                ></b-form-input>
                              </b-col>
                            </b-row>

                            <!-- Total Amount -->
                            <b-row>
                              <b-col lg="4">
                                <label>Total Amount</label>
                              </b-col>
                              <b-col lg="8" class="form-group">
                                <b-form-input
                                  v-model="form.TotalAmount"
                                  required
                                  id="input-id"
                                  type="text"
                                  placeholder="Total Amount"
                                ></b-form-input>
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
                      <template v-slot:cell(BudgetYear)="row">
                        <b-form-input
                          id="tableFields"
                          v-model="form.BudgetYear"
                          placeholder="Budget Year "
                        ></b-form-input>
                      </template>
                      <template v-slot:cell(DepartmentName)="row">
                        <b-form-input
                          id="tableFields"
                          v-model="form.DepartmentName"
                          placeholder="Department Name"
                        ></b-form-input>
                      </template>
                      <template v-slot:cell(Month)="row">
                        <b-form-input id="tableFields" v-model="form.Number" placeholder="Month"></b-form-input>
                      </template>
                      <template v-slot:cell(NaturalAccount)="row">
                        <b-form-input
                          id="tableFields"
                          v-model="form.NaturalAccount"
                          placeholder="Natural Account"
                        ></b-form-input>
                      </template>
                      <template v-slot:cell(Amount)="row">
                        <b-form-input id="tableFields" v-model="form.Amount" placeholder="Amount"></b-form-input>
                      </template>
                      <template v-slot:cell(RevisedAmount)="row">
                        <b-form-input
                          id="tableFields"
                          v-model="form.RevisedAmounttable"
                          placeholder="Revised Amount"
                        ></b-form-input>
                      </template>
                      <template v-slot:cell(TotalAmount)="row">
                        <b-form-input
                          id="tableFields"
                          v-model="form.TotalAmounttable"
                          placeholder="Total Amount"
                        ></b-form-input>
                      </template>
                      <template v-slot:cell(Remarks)="row">
                        <b-form-input id="tableFields" v-model="form.Remarks" placeholder="Remarks"></b-form-input>
                      </template>
                      <template v-slot:cell(action)="row">
                        <b-button size="sm" class="mr-2">Add</b-button>
                      </template>
                    </b-table>
                  </div>
                </b-card-text>
                <div class="mt-2 d-flex justify-content-end">
                  <b-button lg="6" size="md" variant="dark" type="submit">Save</b-button>
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
    this.$store.commit("setBreadcrumb", { link: "#", label: "Administration" });
    this.$store.commit("setBreadcrumb", {
      link: "#",
      label: "Employee Position"
    });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Department" });
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
          { key: "BudgetYear", label: "Budget Year", sortable: true },
          { key: "DepartmentName", label: "Department Name", sortable: true },
          { key: "Month", label: "Month", sortable: true },
          { key: "NaturalAccount", label: "Natural Account", sortable: true },
          { key: "Amount", label: "Amount", sortable: true },
          { key: "RevisedAmount", label: "Revised Amount", sortable: true },
          { key: "TotalAmount", label: "Total Amount", sortable: true },
          { key: "Remarks", label: "Remarks", sortable: true },
          "Action"
        ],
        items: [
          {
            SL: "1",
            BudgetYear: "2019-2020",
            DepartmentName: "Electric",
            Month: "??",
            NaturalAccount: "222.49448(LOV)",
            Amount: "20,03459",
            RevisedAmount: "10,3459",
            TotalAmount: "2,106,918",
            Remarks: "",
            Action: ""
          }
        ]
      },

      tableFields: [
        { key: "BudgetYear", label: "Budget Year", sortable: true },
        { key: "DepartmentName", label: "Department Name", sortable: true },
        { key: "Month", label: "Month", sortable: true },
        { key: "NaturalAccount", label: "Natural Account", sortable: true },
        { key: "Amount", label: "Amount", sortable: true },
        { key: "RevisedAmount", label: "Revised Amount", sortable: true },
        { key: "TotalAmount", label: "Total Amount", sortable: true },
        { key: "Remarks", label: "Remarks", sortable: true },
        "Action"
      ],
      fieldItems: [
        {
          BudgetYear: "",
          DepartmentName: "",
          LifeYear: "",
          Month: "",
          NaturalAccount: "",
          Amount: "",
          RevisedAmount: "",
          TotalAmount: "",
          Remarks: "",
          Action: ""
        }
      ],
      BudgetYearList: [
        { value: "1819", text: "2018-2019 (Revised)" },
        { value: "1819", text: "2018-2019" },
        { value: "1920", text: "2019-2020" }
      ],
      NaturalAccountslist: [
        { value: "StoresAndSpares", text: "Stores And Spares" },
        { value: "FixedAsset", text: "Fixed Asset" }
      ],
      AccountDescriptionlist: [
        { value: "1232", text: "1232" },
        { value: "2455", text: "2455" }
      ],
      BudgetTypesList: [
        { value: "Capital", text: "Capital" },
        { value: "Revenue", text: "Revenue" }
      ],
      DepartmentNameList: [
        { value: "Mechanical", text: "Mechanical" },
        { value: "Civil", text: "Civil" },
        { value: "Electrical", text: "Electrical" },
        { value: "CentralStore", text: "Central Store" },
        { value: "Traffic", text: "Traffic" },
        { value: "Merine", text: "Merine" },
        { value: "Hydrography", text: "Hydrography" },
        { value: "Administration", text: "Administration" },
        { value: "Medical", text: "Medical" },
        { value: "Planning", text: "Planning" },
        { value: "FinanceandAccounting", text: "Finance & Accounting" },
        { value: "AuditandInspaction", text: "Audit & Inspaction" }
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
