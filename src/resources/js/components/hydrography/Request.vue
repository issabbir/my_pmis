<template>
  <div class="content-wrapper">
    <div class="content-body">
      <form-wizard title subtitle color="green">
        <tab-content title="Request Form">
          <fieldset>
            <div class="row">
              <div class="col-12">
                <h6 class="py-50">Basic Details</h6>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>FIRST Name</label>
                  <input type="text" class="form-control" placeholder="Enter Your First name" />
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" class="form-control" placeholder="Enter Your Last name" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="col-md-">
                  <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" class="form-control" placeholder="Enter Your Company Name" />
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Degination</label>
                  <input type="text" class="form-control" placeholder="Enter Your Degination" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" placeholder="Enter Your Email" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>password</label>
                  <input type="password" class="form-control" placeholder="Enter Your Password" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Confirm password</label>
                  <input
                    type="password"
                    class="form-control"
                    placeholder="Enter Your Confirm Password"
                  />
                </div>
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-12">
                <h6 class="py-50">Contact Details</h6>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Address Line 1</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Enter Your House no./ Flate no."
                  />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>address line 2</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Enter Your Society name / Area name"
                  />
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>city</label>
                  <input type="text" class="form-control" placeholder="Enter Your Ciy" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>State</label>
                  <input type="text" class="form-control" placeholder="Enter Your State" />
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Age</label>
                  <input type="text" class="form-control" placeholder="Enter Your Current Age" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Phone</label>
                  <input type="number" class="form-control" placeholder="+12345675" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="d-block">Gender</label>
                  <ul class="list-unstyled mt-1">
                    <li class="d-inline-block">
                      <fieldset>
                        <div class="radio radio-primary">
                          <input type="radio" name="gender" id="male" aria-invalid="false" />
                          <label for="male">M</label>
                        </div>
                      </fieldset>
                    </li>
                    <li class="d-inline-block">
                      <fieldset>
                        <div class="radio radio-primary ml-1">
                          <input type="radio" name="gender" id="female" aria-invalid="false" />
                          <label for="female">F</label>
                        </div>
                      </fieldset>
                    </li>
                    <li class="d-inline-block">
                      <fieldset>
                        <div class="radio radio-primary ml-1">
                          <input type="radio" name="gender" id="others" aria-invalid="false" />
                          <label for="others">Other</label>
                        </div>
                      </fieldset>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-12">
                <h6 class="py-50">Products Details</h6>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Select Product</label>
                  <select class="form-control" name="product_name" id="product_name">
                    <option>Chart</option>
                    <option>Map</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Product QTY</label>
                  <input type="number" class="form-control" name="qty" placeholder="QTY" />
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Format</label>
                  <select class="form-control" name="format" id="format">
                    <option>Row File</option>
                    <option>Text File</option>
                    <option>CSV</option>
                    <option>PDF</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Expected Delivery Date</label>
                  <fieldset class="form-group position-relative has-icon-right">
                    <input
                      type="date"
                      class="form-control"
                      value
                      placeholder="Select Date"
                      name="date"
                      id="edate"
                    />
                    <div class="form-control-position">
                      <i class="bx bx-calendar-check"></i>
                    </div>
                  </fieldset>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <h6 class="py-50">Customer Note</h6>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Note</label>
                  <textarea class="form-control" name="note" id cols="30" rows="5"></textarea>
                </div>
              </div>
            </div>
          </fieldset>
        </tab-content>
        <tab-content title="Approval">
          <fieldset>
            <div class="row">
              <div class="col-12">
                <h6 class="py-50">Wait For Approval</h6>
              </div>
              <div class="col-12"></div>
              <div class="col-sm-12">
                <div class="table-responsive mb-2">
                  <!-- table start -->
                  <table id="table-marketing-campaigns" class="table mb-0">
                    <thead>
                      <tr>
                        <th>Products</th>
                        <th>Qty</th>
                        <th>Formate</th>
                        <th>Expected Date</th>
                        <th>status</th>
                        <th>action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-bold-600">
                          <img
                            class="rounded-circle mr-1"
                            src="../../../images/cards/2.png"
                            alt="card"
                          />Chart
                        </td>
                        <td>2</td>
                        <td class="text-bold-600">
                          <i class="bx bx-trending-up text-success align-middle mr-50"></i>
                          <span>CSV File</span>
                        </td>
                        <td class="text-bold-600">5th January 2020</td>
                        <td class="text-warning">Pending</td>
                        <td>
                          <div class="dropdown">
                            <span
                              class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                              data-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false"
                              role="menu"
                            ></span>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" href="#">
                                <i class="bx bx-edit-alt mr-1"></i> edit
                              </a>
                              <a class="dropdown-item" href="#">
                                <i class="bx bx-trash mr-1"></i> delete
                              </a>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- table ends -->
                </div>
              </div>
            </div>
          </fieldset>
        </tab-content>
        <tab-content title="Payment">
          <fieldset>
            <!-- User Detals Widget Starts -->
            <div class="col-lg-12 col-xl-10 user-details-card">
              <div class="card widget-user-details">
                <div class="card-header">
                  <div class="card-title-details d-flex align-items-center">
                    <div class="avatar bg-rgba-primary p-25 mr-2 ml-0">
                      <img
                        class="img-fluid"
                        src="../../../images/profile/user-uploads/social-2.jpg"
                        alt="img placeholder"
                        height="70"
                        width="70"
                      />
                    </div>
                    <div>
                      <h5>Chart</h5>
                      <div class="card-subtitle">Awesome App for Project Management</div>
                    </div>
                  </div>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td class="pb-0 pl-0">
                              <strong>Order Number</strong>
                            </td>
                            <td class="pb-0 pl-0">
                              <strong>Order Date</strong>
                            </td>
                            <td class="pb-0">
                              <strong>Qty</strong>
                            </td>
                            <td class="pb-0">
                              <strong>Price</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="pl-0">00014652</td>
                            <td class="pl-0">
                              <div class="badge badge-light-danger text-bold-500 py-50">06 May 2019</div>
                            </td>
                            <td>2</td>
                            <td>$76,810</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="card-footer border-top text-right">
                  <div class="justify-content-end">
                    <button type="button" class="btn btn-primary glow justify-content-end">Payment</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- User Detals Widget Ends -->
          </fieldset>
        </tab-content>
        <tab-content title="Delivery">
          <fieldset>
            <!-- User Detals Widget Starts -->
            <div class="col-lg-6 col-xl-6 offset-3 user-details-card mt-2">
              <div class="card" style="height: 179.5px; zoom: 1;">
                <div class="card-content">
                  <div class="card-body">
                    <div class="form-group">
                      <h5>Chart Survey</h5>
                      <p>File Size 1.5MB</p>
                      <button
                        class="btn btn-lg btn-block font-medium-1 btn-light-danger mb-1 block-multiple-msgs text-nowrap"
                      >File Download</button>

                      <div
                        class="multiple-msgs"
                        style="padding: 15px 0px; display: none; cursor: default;"
                      >
                        <div class="semibold">
                          <span class="icon-thumbs-o-up text-left"></span>&nbsp; Success
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- User Detals Widget Ends -->
          </fieldset>
        </tab-content>
      </form-wizard>
    </div>
  </div>
</template>

<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
export default {
  data() {
    return {
      name: ""
    };
  },
  mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", { link: "#", label: "Hydrography" });
    this.$store.commit("setBreadcrumb", { link: "#", label: "Request" });
  },
  components: {
    FormWizard,
    TabContent
  }
};
</script>
