<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Service information
                    <b-link :to='"/pension-app-process"' style="float:right" variant="light" class="button">
                        Back To The List
                    </b-link>
                </b-card-header>
                <b-card-body class="border">
                    <form-wizard @on-complete="onSubmit" title subtitle color="#394C62">
                        <tab-content class="mb-3">
                            <b-form-input
                                v-model="updateIndex"
                                required
                                id="input-update-index"
                                type="text"
                                :style="{'display':'none'}"
                                ></b-form-input>
                            <h4>Service Information of Employee</h4>
                            <hr>
                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Employee Code"
                                        label-for="emp_code"
                                        >
                                        <b-form-input id="emp_code" v-model="formData.emp_code" readonly></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">

                                <b-form-group
                                        label="Name"
                                        label-for="emp_name"
                                        >
                                        <b-form-input id="emp_name" v-model="formData.emp_name" readonly></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Father’s Name"
                                        label-for="fatherName"
                                        >
                                        <b-form-input id="fatherName"  v-model="formData.emp_father_name" readonly></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Nationality"
                                        label-for="nationality"
                                        >
                                        <b-form-input id="nationality" v-model="formData.nationality" readonly></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Designation"
                                        label-for="designation"
                                        >
                                        <b-form-input id="designation" v-model="formData.designation" readonly></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Date of Birth"
                                        label-for="dob"
                                        >
                                        <b-form-input id="dob" v-model="formData.emp_dob" readonly></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Joining date"
                                        label-for="joining_date"
                                        >
                                        <b-form-input id="joining_date" v-model="formData.joining_date" readonly></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Retirement Date"
                                        label-for="retirement_date"
                                        >
                                        <date-picker
                                            v-model="formData.perm_retd_date"
                                            width="100%"
                                            id="retirement_date"
                                            input-class="form-control"
                                            type="date"
                                            lang="en"
                                            format="DD-MM-YYYY"
                                            :input-attr="{ required: true }"
                                        ></date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Allowance & Gratuity Class"
                                        label-for="allowance_and_gratuity_class"
                                        >
                                        <b-form-input id="allowance_and_gratuity_class" v-model="formData.allowance_and_gratuity_class" readonly></b-form-input>
                                    </b-form-group>

                                </b-col>
                            </b-row>
                            <hr>
                            <b-row>
                                <b-col md="8">
                                    <b-form-group
                                        label="Service Period With Discontinuation"
                                        label-for="discontinuous_svc_from_date"
                                    >
                                        <b-row>
                                            <b-col md="6">
                                                <date-picker
                                                    id="discontinuous_svc_from_date"
                                                    v-model="formData.discontinuous_svc_from_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="From Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                            <b-col md="6">
                                                <date-picker
                                                    v-model="formData.discontinuous_svc_to_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="To Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Total Service Duration"
                                        label-for="total_service_duration"
                                    >
                                        <b-form-input id="total_service_duration" v-model="formData.total_service_duration"  readonly ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <hr>
                            <h4>Ineligible Job </h4>
                            <hr>
                            <b-row>
                                <b-col md="6">

                                    <b-form-group
                                        label="Prior employment of before 18 years"
                                        label-for="before_18_from_date"
                                    >
                                        <b-row>
                                            <b-col md="6">
                                                <date-picker
                                                    id="before_18_from_date"
                                                    v-model="formData.before_18_from_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="From Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                            <b-col md="6">
                                                <date-picker
                                                    v-model="formData.before_18_to_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="To Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Extraordinary Leave"
                                        label-for="extraordinary_leave_from_date"
                                    >
                                        <b-row>
                                            <b-col md="6">
                                                <date-picker
                                                    id="extraordinary_leave_from_date"
                                                    v-model="formData.extraordinary_leave_from_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="From Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                            <b-col md="6">
                                                <date-picker
                                                    v-model="formData.extraordinary_leave_to_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="To Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>

                                <b-col md="6">
                                    <b-form-group
                                        label="A temporary dismissal that is not considered a duty / leave"
                                        label-for="temporary_dismissal_from_date"
                                    >
                                        <b-row>
                                            <b-col md="6">
                                                <date-picker
                                                    id="temporary_dismissal_from_date"
                                                    v-model="formData.temporary_dismissal_from_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="From Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                            <b-col md="6">
                                                <date-picker
                                                    v-model="formData.temporary_dismissal_to_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="To Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Period of break in employment"
                                        label-for="break_in_employment_from_date"
                                    >
                                        <b-row>
                                            <b-col md="6">
                                                <date-picker
                                                    id="break_in_employment_from_date"
                                                    v-model="formData.break_in_employment_from_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="From Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                            <b-col md="6">
                                                <date-picker
                                                    v-model="formData.break_in_employment_to_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="To Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>

                                <b-col md="6">
                                    <b-form-group
                                        label="If there is no waiver of the break, then prior to the break"
                                        label-for="prior_to_break_from_date"
                                    >
                                        <b-row>
                                            <b-col md="6">
                                                <date-picker
                                                    id="prior_to_break_from_date"
                                                    v-model="formData.prior_to_break_from_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="From Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                            <b-col md="6">
                                                <date-picker
                                                    v-model="formData.prior_to_break_to_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="To Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Cancelled for resignation"
                                        label-for="cancelled_for_registration_from_date"
                                    >
                                        <b-row>
                                            <b-col md="6">
                                                <date-picker
                                                    id="cancelled_for_registration_from_date"
                                                    v-model="formData.cancelled_for_registration_from_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="From Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                            <b-col md="6">
                                                <date-picker
                                                    id="cancelled_for_registration_to_date"
                                                    v-model="formData.cancelled_for_registration_to_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="To Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>

                                <b-col md="6">
                                    <b-form-group
                                        label="Unauthorized absence"
                                        label-for="unauthorized_absence_from_date"
                                    >
                                        <b-row>
                                            <b-col md="6">
                                                <date-picker
                                                    id="unauthorized_absence_from_date"
                                                    v-model="formData.unauthorized_absence_from_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="From Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                            <b-col md="6">
                                                <date-picker
                                                    v-model="formData.unauthorized_absence_to_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="To Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Total Discontinuous Service Period"
                                        label-for="total_service_period"
                                    >
                                        <b-form-input id="total_service_period" v-model="formData.total_discontinuous_service_period"  readonly ></b-form-input>
                                    </b-form-group>
                                </b-col>

                            </b-row>
                            <hr>
                            <b-row>
                                <b-col offset-md="4" md="4">
                                    <b-form-group
                                        label="Net Service Period"
                                        label-for="net_service_period"
                                    >
                                        <b-form-input id="net_service_period" v-model="formData.net_service_period" readonly></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </tab-content>

                        <tab-content class="mb-3">
                            <b-row>

                                <b-col md="6">
                                    <b-form-group
                                        label="Other Eligible Services"
                                        label-for="other_eligible_services_years"
                                    >
                                        <b-input-group class="mb-2" >
                                            <b-form-input id="other_eligible_services_years" v-model="formData.other_eligible_services_years" placeholder="Years" type="number"></b-form-input>
                                            <b-form-input v-model="formData.other_eligible_services_months" placeholder="Months" type="number"></b-form-input>
                                            <b-form-input v-model="formData.other_eligible_services_days" placeholder="Days" type="number"></b-form-input>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Temporary & Wartime services"
                                        label-for="temporary_wartime_services_from_date"
                                    >
                                        <b-row>
                                            <b-col md="6">
                                                <date-picker
                                                    id="temporary_wartime_services_from_date"
                                                    v-model="formData.temporary_wartime_services_from_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="From Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                            <b-col md="6">
                                                <date-picker
                                                    v-model="formData.temporary_wartime_services_to_date"
                                                    style="float:left"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    placeholder="To Date"
                                                    format="DD-MM-YYYY" ></date-picker>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Remission of Period for Service"
                                        label-for="remission_period_for_service_years"
                                    >
                                        <b-input-group class="mb-2" >
                                            <b-form-input id="remission_period_for_service_years" v-model="formData.remission_period_for_service_years" placeholder="Years" type="number"></b-form-input>
                                            <b-form-input v-model="formData.remission_period_for_service_months" placeholder="Months" type="number"></b-form-input>
                                            <b-form-input v-model="formData.remission_period_for_service_days" placeholder="Days" type="number"></b-form-input>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>

                                <b-col md="6">
                                    <b-form-group
                                        label="Any Other Service Period"
                                        label-for="any_other_service_period_years"
                                        >
                                        <b-input-group class="mb-2" >
                                            <b-form-input id="any_other_service_period_years" v-model="formData.any_other_service_period_years" placeholder="Years" type="number"></b-form-input>
                                            <b-form-input v-model="formData.any_other_service_period_months" placeholder="Months" type="number"></b-form-input>
                                            <b-form-input v-model="formData.any_other_service_period_days" placeholder="Days" type="number"></b-form-input>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Net eligible service period"
                                        label-for="net_eligible_service_period"
                                        >
                                        <b-form-input v-model="formData.net_eligible_service_period" id="net_eligible_service_period"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Pension All. & Gratuity"
                                        label-for="pension_allowance_and_gratuity"
                                        >
<!--                                        <b-input-group   prepend="৳">-->
                                            <b-form-input v-model="formData.pension_allowance_and_gratuity"  id="pension_allowance_and_gratuity"></b-form-input>
<!--                                        </b-input-group>-->
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Last month salary"
                                        label-for="last_month_salary"
                                        >
<!--                                        <b-input-group   prepend="৳">-->
                                            <b-form-input id="last_month_salary" v-model="formData.last_month_salary"  readonly class="text-right"></b-form-input>
<!--                                        </b-input-group>-->
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Rate of Pension Allowance"
                                        label-for="rate_of_pension_allowance"
                                        >
                                        <b-input-group   append="%">
                                            <b-form-input id="rate_of_pension_allowance" v-model="formData.rate_of_pension_allowance" readonly class="text-right"></b-form-input>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Net Pension Allowance "
                                        label-for="net_pension_allowance"
                                        >
<!--                                        <b-input-group  prepend="৳">-->
                                            <b-form-input id="net_pension_allowance" v-model="formData.net_pension_allowance"  readonly class="text-right"></b-form-input>
<!--                                        </b-input-group>-->
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Half of Net Pension"
                                        label-for="half_of_net_pension"
                                        >
<!--                                        <b-input-group   prepend="৳">-->
                                            <b-form-input id="half_of_net_pension" v-model="formData.half_of_net_pension"  readonly class="text-right"></b-form-input>
<!--                                        </b-input-group>-->
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Exchange rate of first half of total Pension (For every 1 Taka)"
                                        label-for="exchange_rate_1st_half"
                                        >
                                        <b-input-group  append="%">
                                            <b-form-input id="exchange_rate_1st_half" v-model="formData.exchange_rate_1st_half" readonly class="text-right"></b-form-input>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Exchange rate of allowance’s 2nd half (For every 1 Taka) "
                                        label-for="exchange_rate_2nd_half"
                                    >
                                        <b-input-group  append="%">
                                            <b-form-input id="exchange_rate_2nd_half" v-model="formData.exchange_rate_2nd_half"  readonly class="text-right"></b-form-input>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="12">
                                    <b-form-group
                                        label="Eligible Lump-sum gratuity "
                                        label-for="eligible_lump_sum_gratuity"
                                        >
                                        <b-row>
                                            <b-col md="3">
<!--                                                <b-input-group  prepend="৳">-->
                                                    <b-form-input id="eligible_lump_sum_gratuity" v-model="formData.eligible_lump_sum_gratuity"  readonly class="text-right"></b-form-input>
<!--                                                </b-input-group>-->
                                            </b-col>
                                            <b-col md="9">
                                                <b-form-input  placeholder="In Words" readonly ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="12">
                                    <b-form-group
                                        label="Net monthly pension allowance"
                                        label-for="net_monthly_pension_allowance"
                                        >
                                        <b-row>
                                            <b-col md="3">
<!--                                                <b-input-group  prepend="৳">-->
                                                    <b-form-input id="net_monthly_pension_allowance" v-model="formData.net_monthly_pension_allowance"  readonly class="text-right"></b-form-input>
<!--                                                </b-input-group>-->
                                            </b-col>
                                            <b-col md="9">
                                                <b-form-input  placeholder="In Words" readonly ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>

                                <b-col md="12">
                                    <b-form-group
                                        label="Attainable Lump-sum gratuity in exchange of net monthly pension"
                                        label-for="attainable_lump_sum_gratuity"
                                        >
                                        <b-row>
                                            <b-col md="3">
<!--                                                <b-input-group  prepend="৳">-->
                                                    <b-form-input id="attainable_lump_sum_gratuity" v-model="formData.attainable_lump_sum_gratuity"  readonly class="text-right"></b-form-input>
<!--                                                </b-input-group>-->
                                            </b-col>
                                            <b-col md="9">
                                                <b-form-input  placeholder="In Words" readonly ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="12">
                                    <b-form-group
                                        label="Total allowance"
                                        label-for="total_allowance"
                                        >
                                        <b-row>
                                            <b-col md="3">
<!--                                                <b-input-group  prepend="৳">-->
                                                    <b-form-input id="total_allowance" v-model="formData.total_allowance"  readonly class="text-right"></b-form-input>
<!--                                                </b-input-group>-->
                                            </b-col>
                                            <b-col md="9">
                                                <b-form-input  placeholder="In Words" readonly ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                                <b-col md="12">
                                    <b-form-group
                                        label="Total monthly pension"
                                        label-for="total_monthly_pension"
                                        >
                                        <b-row>
                                            <b-col md="3">
<!--                                                <b-input-group  prepend="৳">-->
                                                    <b-form-input id="total_monthly_pension" v-model="formData.total_monthly_pension"  readonly class="text-right"></b-form-input>
<!--                                                </b-input-group>-->
                                            </b-col>
                                            <b-col md="9">
                                                <b-form-input  placeholder="In Words" readonly ></b-form-input>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </tab-content>

                    </form-wizard>
                </b-card-body>
            </b-card>


        </div>
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import { FormWizard, TabContent } from "vue-form-wizard";
    import "vue-form-wizard/dist/vue-form-wizard.min.css";
    import DatePicker from 'vue2-datepicker';
    import BFormDatepicker from 'bootstrap-vue'
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from '../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';

    export default {
        components: {FormWizard, TabContent, Multiselect, DatePicker, vSelect, vcss},
        props: ['emp_id'],
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Service Record"});
            this.employeeData();
            console.log(this.emp_id)
        },
        data() {
            return {
                formData: {
                    application_id:null,
                    emp_id:null,
                    emp_name:null,
                    emp_father_name:null,
                    nationality:null,
                    designation_id:null,
                    designation:null,
                    emp_dob:null,
                    joining_date:null,
                    perm_retd_date:null,
                    allowance_and_gratuity_class:null,
                    discontinuous_svc_from_date:null,
                    discontinuous_svc_to_date:null,
                    total_service_duration:null,
                    before_18_from_date:null,
                    before_18_to_date:null,
                    extraordinary_leave_from_date:null,
                    extraordinary_leave_to_date:null,
                    temporary_dismissal_from_date:null,
                    temporary_dismissal_to_date:null,
                    break_in_employment_from_date:null,
                    break_in_employment_to_date:null,
                    prior_to_break_from_date:null,
                    prior_to_break_to_date:null,
                    cancelled_for_registration_from_date:null,
                    cancelled_for_registration_to_date:null,
                    unauthorized_absence_from_date:null,
                    unauthorized_absence_to_date:null,
                    total_discontinuous_service_period:null,

                    other_eligible_services_years:null,
                    other_eligible_services_months:null,
                    other_eligible_services_days:null,
                    temporary_wartime_services_from_date:null,
                    temporary_wartime_services_to_date:null,
                    remission_period_for_service_years:null,
                    remission_period_for_service_months:null,
                    remission_period_for_service_days:null,
                    any_other_service_period_years:null,
                    any_other_service_period_months:null,
                    any_other_service_period_days:null,
                    net_eligible_service_period:null,
                    pension_allowance_and_gratuity:null,
                    last_month_salary:null,
                    rate_of_pension_allowance:null,
                    net_pension_allowance:null,
                    half_of_net_pension:null,
                    exchange_rate_1st_half:null,
                    exchange_rate_2nd_half:null,
                    eligible_lump_sum_gratuity:null,
                    net_monthly_pension_allowance:null,
                    attainable_lump_sum_gratuity:null,
                    total_allowance:null,
                    total_monthly_pension:null
                },
                show: true,
                updateIndex: -1,
            };
        },
        methods: {
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/store-service-record`, this.formData).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onReset();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset() {
                this.$nextTick(() => {
                    this.formData={};
                    this.show = true;
                });
            },
            employeeData(){
                if (this.emp_id>0){
                    let id = this.emp_id;
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/get-service-record?emp_id=${id}`).then(res => {
                        this.formData=res.data[0];
                    });
                }

            }



        }
    };
</script>

