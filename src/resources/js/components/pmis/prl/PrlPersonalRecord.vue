<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Service information</h4>
                        </div>
                        <b-card-text class="card-content">
                            <div class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <form-wizard title subtitle color="#394C62">
                                        <tab-content title="Form-1" class="mb-3">
                                            <b-form-input
                                                v-model="updateIndex"
                                                required
                                                id="input-update-index"
                                                type="text"
                                                :style="{'display':'none'}"
                                                ></b-form-input>
                                            <p>1.00 Service information of Employees</p>
                                            <b-row>

                                                <b-col lg="8">
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="1.01 Employee Id "
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-select v-model="PrlPersonal.empid"  :options="empList"></b-form-select>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="1.02 Name"
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.name" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="1.03 Father’s Name"
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"  v-model="PrlPersonal.fatName" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="1.04  Nationality"
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.nationality" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="1.05 Designation during Retirement"  
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.desigDuringRtr" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="1.06 Date of Birth "
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.dob" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="1.07 Joining date"
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.joiningDate" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="1.08 Retirement Date "   
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.rtrDate" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="1.09 Class of Allowance & Gratuity"
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.classOfAllowanceGrt" disabled></b-form-input>
                                                    </b-form-group>

                                                </b-col>
                                            </b-row>
                                            <hr>
                                            <p>2.00 Service Book</p>
                                            <p>2.01 Service Period With Discontinuation  </p>
                                            <b-row>
                                                <b-col md="2">
                                                    <label>Form Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.serviceFormDateDiscont"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <label>To Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.serviceToDateDiscont"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group> 
                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                 <b-col md="2">
                                                    <label>Total Year</label>
                                                </b-col>
                                                <b-col md="1">
                                                    <label>Year</label>
                                                </b-col>
                                                <b-col md="1">
                                                    <b-form-group >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.serviceYearDiscont"  disabled placeholder="Year"></b-form-input>
                                                    </b-form-group> 
                                                </b-col>
                                                 <b-col md="1">
                                                    <label>Month</label>
                                                </b-col>
                                                
                                                <b-col md="1">
                                                    <b-form-group >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.serviceMonthDiscont" disabled placeholder="Month"></b-form-input>
                                                    </b-form-group> 
                                                </b-col>
                                                 <b-col md="1">
                                                    <label>Day</label>
                                                </b-col>
                                                <b-col md="1">
                                                    <b-form-group >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.serviceDayDiscont" disabled placeholder="Day"></b-form-input>
                                                    </b-form-group> 
                                                </b-col>
                                            </b-row>
                                               

                                            <p>2.02 Ineligible Job </p>
                                            <b-row> 
                                                <b-col md="6">
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="A. Prior employment of before 18 years "
                                                        label-for="input-1"
                                                        >
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="2">
                                                    <label>Form Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.ineligblFormdate"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group>
                                                </b-col> 
                                                <b-col md="2">
                                                    <label>To Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.ineligblTodate"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group> 
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="6">
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="B. Extraordinary Leave "
                                                        label-for="input-1"
                                                        >
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="2">
                                                    <label>Form Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.extraOrdinaryleaveFrom"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <label>To Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.extraOrdinaryleaveTo"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group> 
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="6">
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="C. A temporary dismissal that is not considered a duty / leave "
                                                        label-for="input-1"
                                                        >
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="2">
                                                    <label>Form Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.tempDismissalFormDate"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <label>To Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.tempDismissalToDate"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group> 
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="6">
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="D. Period of break in employment "
                                                        label-for="input-1"
                                                        >
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="2">
                                                    <label>Form Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.name"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <label>To Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.name"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group> 
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="6">
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="E. If there is no waiver of the break, then prior to the break"
                                                        label-for="input-1"
                                                        >
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="2">
                                                    <label>Form Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.name"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <label>To Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.name"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group> 
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="6">
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="F. Canceled for resignation"
                                                        label-for="input-1"
                                                        >
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="2">
                                                    <label>Form Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.name"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <label>To Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.name"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group> 
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="6">
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="G.Unauthorized absence "
                                                        label-for="input-1"
                                                        >
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row> 
                                                <b-col md="2">
                                                    <label>Form Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.name"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="2">
                                                    <label>To Date</label>
                                                </b-col>
                                                <b-col md="2">
                                                    <b-form-group >
                                                        <date-picker
                                                            v-model="PrlPersonal.name"
                                                            width="100%"
                                                            input-class="form-control"
                                                            type="date"
                                                            lang="en"
                                                            format="YYYY-MM-DD" ></date-picker>
                                                    </b-form-group> 
                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                 <b-col md="2">
                                                    <label>Total Year</label>
                                                </b-col>
                                                <b-col md="1">
                                                    <label>Year</label>
                                                </b-col>
                                                <b-col md="1">
                                                    <b-form-group >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.serviceYearDiscont"  disabled placeholder="Year"></b-form-input>
                                                    </b-form-group> 
                                                </b-col>
                                                 <b-col md="1">
                                                    <label>Month</label>
                                                </b-col>
                                                
                                                <b-col md="1">
                                                    <b-form-group >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.serviceMonthDiscont" disabled placeholder="Month"></b-form-input>
                                                    </b-form-group> 
                                                </b-col>
                                                 <b-col md="1">
                                                    <label>Day</label>
                                                </b-col>
                                                <b-col md="1">
                                                    <b-form-group >
                                                        <b-form-input id="input-horizontal" v-model="PrlPersonal.serviceDayDiscont" disabled placeholder="Day"></b-form-input>
                                                    </b-form-group> 
                                                </b-col>
                                            </b-row>
                                        </tab-content>

                                        <tab-content title="Form-2" class="mb-3">
                                            <b-row>
                                                <b-col lg="8">
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="2.03 Net Service Period (2.01-2.02) "
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"></b-form-input>

                                                    </b-form-group>
                                                    <!--b-form-group
                                                        label-cols-md="4"
                                                        label="2.04) Other Eligible Services (Which are required in necessary cases) "
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" placeholder="Year/Month/Day"></b-form-input>

                                                    </b-form-group-->
                                                    <b-row> 
                                                         <b-col md="4">
                                                            <label>2.04) Other Eligible Services (Which are required in necessary cases) </label>
                                                        </b-col>
                                                        <b-col md="1">
                                                            <label>Year</label>
                                                        </b-col>
                                                        <b-col md="2">
                                                            <b-form-group >
                                                                 <b-form-input id="input-horizontal"></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="1">
                                                            <label>Month</label>
                                                        </b-col>
                                                        <b-col md="2">
                                                            <b-form-group >
                                                                 <b-form-input id="input-horizontal"></b-form-input>
                                                            </b-form-group> 
                                                        </b-col>
                                                        <b-col md="1">
                                                            <label>Day</label>
                                                        </b-col>
                                                        <b-col md="1">
                                                            <b-form-group >
                                                                 <b-form-input id="input-horizontal"></b-form-input>
                                                            </b-form-group> 
                                                        </b-col>
                                                    </b-row>

                                                    <b-row> 
                                                         <b-col md="4">
                                                            <label>KA) Temporary & Wartime services, eligible for getting Pension</label>
                                                        </b-col>
                                                        <b-col md="1">
                                                            <label>Form Date</label>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group >
                                                                <date-picker
                                                                    v-model="PrlPersonal.tempDismissalFormDate"
                                                                    width="100%"
                                                                    input-class="form-control"
                                                                    type="date"
                                                                    lang="en"
                                                                    format="YYYY-MM-DD" ></date-picker>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="1">
                                                            <label>To Date</label>
                                                        </b-col>
                                                        <b-col md="3">
                                                            <b-form-group >
                                                                <date-picker
                                                                    v-model="PrlPersonal.tempDismissalToDate"
                                                                    width="100%"
                                                                    input-class="form-control"
                                                                    type="date"
                                                                    lang="en"
                                                                    format="YYYY-MM-DD" ></date-picker>
                                                            </b-form-group> 
                                                        </b-col>
                                                    </b-row>

                                                    <!--b-form-group
                                                        label-cols-md="4"
                                                        label="KHA) Remission of Period for Service"
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"></b-form-input>
                                                    </b-form-group-->
                                                    <b-row> 
                                                         <b-col md="4">
                                                            <label>KHA) Remission of Period for Service</label>
                                                        </b-col>
                                                        <b-col md="1">
                                                            <label>Year</label>
                                                        </b-col>
                                                        <b-col md="2">
                                                            <b-form-group >
                                                                 <b-form-input id="input-horizontal"></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="1">
                                                            <label>Month</label>
                                                        </b-col>
                                                        <b-col md="2">
                                                            <b-form-group >
                                                                 <b-form-input id="input-horizontal"></b-form-input>
                                                            </b-form-group> 
                                                        </b-col>
                                                        <b-col md="1">
                                                            <label>Day</label>
                                                        </b-col>
                                                        <b-col md="1">
                                                            <b-form-group >
                                                                 <b-form-input id="input-horizontal"></b-form-input>
                                                            </b-form-group> 
                                                        </b-col>
                                                    </b-row>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="GA) Any Other Service Period, eligible for Pension"
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="2.05) Net eligible service period (2.03+2.04) "  
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="3.00) Pension Allowance & Gratuity "
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="3.01) Last monthly receivable salary on Retirement Date (According to ELPC) "
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="3.02) Rate of Pension Allowance"   
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="3.03) Net Pension Allowance "
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="3.04) Half of net Pension"
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="3.05) Exchange rate of first half of total Pension
                                                        (For every 1 Taka)"
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="3.06)  Eligible Lump-sum gratuity "
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"></b-form-input><br/>
                                                         <b-form-input id="input-horizontal" placeholder="In Words" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label=" 3.07) KA) Net monthly pension allowance "
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"></b-form-input><br/>
                                                          <b-form-input id="input-horizontal" placeholder="In Words" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="KHA.1) Exchange rate of allowance’s 2nd half for return of net monthly allowance (In exchange of per taka) "
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="KHA.2) Attainable Lump-sum gratuity in exchange of net monthly pension"
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal"></b-form-input><br/>
                                                          <b-form-input id="input-horizontal" placeholder="In Words" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="3.08) KA) Total allowance"
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" disabled></b-form-input><br/>
                                                          <b-form-input id="input-horizontal" placeholder="In Words" disabled></b-form-input>
                                                    </b-form-group>
                                                    <b-form-group
                                                        label-cols-md="4"
                                                        label="KHA) Total monthly pension "
                                                        label-for="input-horizontal"
                                                        >
                                                        <b-form-input id="input-horizontal" disabled></b-form-input><br/>
                                                          <b-form-input id="input-horizontal" placeholder="In Words" disabled></b-form-input>
                                                        
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                        </tab-content>

                                    </form-wizard>
                                </b-form>
                            </div>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>

        </div>
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import DatePicker from "vue2-datepicker";
    import { FormWizard, TabContent } from "vue-form-wizard";
    import "vue-form-wizard/dist/vue-form-wizard.min.css";

    export default {
        components: {
            FormWizard,
            TabContent,
            Multiselect,
            DatePicker
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {
                link: "#",
                label: "Employee Position"
            });
            this.$store.commit("setBreadcrumb", {link: "#", label: "Department"});
        },
        data() {
            return {
                PrlPersonal: {
                },
                show: true,
                updateIndex: -1,
                submitBtn: "Save"
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

