<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <b-row>
                                <b-col md="2">
                                    <h4 class="card-title">Pilotage Navigation</h4>
                                </b-col>
                            </b-row>
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
                                        <b-col lg="4">
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Pilotage Navigation</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-select v-model="selected">
                                                        <option
                                                            v-for="option in options"
                                                            v-bind:value="option.id"
                                                            v-bind:key="option.value"
                                                            >{{option.value}}</option>
                                                    </b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col lg="4">
                                            <b-row>
                                                <b-col lg="4">
                                                    <label>Registration/ROT No</label>
                                                </b-col>
                                                <b-col lg="8" class="form-group">
                                                    <b-form-input
                                                        v-model="form.ROTNO"
                                                        required
                                                        id="input-id"
                                                        type="text"
                                                        placeholder="Registration/ROT No"
                                                        ></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col lg="4">
                                            <b-row class="d-flex justify-content-start">
                                                <b-button lg="6" size="md" variant="dark" type="submit">Search</b-button>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <hr>
                                    <b-row>
                                        <b-col>
                                            <b-row>
                                                <b-col lg="4">
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Registration/ROT No</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input
                                                                v-model="form.RegistrationNo"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Registration/ROT No"
                                                                ></b-form-input>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Registration Date</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <date-picker
                                                                v-model="form.RegistrationDate"
                                                                width="100%"
                                                                input-class="form-control"
                                                                type="date"
                                                                lang="en"
                                                                format="YYYY-MM-DD"
                                                                ></date-picker>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Agent Type</label>
                                                        </b-col>
                                                        <div class="col-md-8 form-group">
                                                            <b-form-input
                                                                v-model="form.AgentType"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Agent Type"
                                                                ></b-form-input>
                                                        </div>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Vessel Name</label>
                                                        </b-col>
                                                        <div class="col-md-8 form-group">
                                                            <b-form-input
                                                                v-model="form.VesselName"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Vessel Name"
                                                                ></b-form-input>
                                                        </div>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>M Vessel Name</label>
                                                        </b-col>
                                                        <div class="col-md-8 form-group">
                                                            <b-form-input
                                                                v-model="form.MVesselName"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="M Vessel Name"
                                                                ></b-form-input>
                                                        </div>
                                                    </b-row>
                                                </b-col>
                                                <b-col lg="4">
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Entry Date</label>
                                                        </b-col>
                                                        <div class="col-md-8 form-group">
                                                            <date-picker
                                                                v-model="form.EntryDate"
                                                                width="100%"
                                                                input-class="form-control"
                                                                type="date"
                                                                lang="en"
                                                                format="YYYY-MM-DD"
                                                                ></date-picker>
                                                        </div>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Master Name</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input
                                                                v-model="form.MasterName"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Master Name"
                                                                ></b-form-input>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Vessel Types</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input
                                                                v-model="form.VesselTypes"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Vessel Types"
                                                                ></b-form-input>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>GRT</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input
                                                                v-model="form.GRT"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="GRT"
                                                                ></b-form-input>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Status</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-select v-model="form.status":options="statusList"></b-form-select>
                                                        </b-col>
                                                    </b-row>
                                                </b-col>
                                                <b-col lg="4">
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Deck Cargo</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input
                                                                v-model="form.DeckCargo"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Deck Cargo"
                                                                ></b-form-input>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Exchange Rate ($)</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input
                                                                v-model="form.ExchangeRate"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Exchange Rate"
                                                                ></b-form-input>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Last Port</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input
                                                                v-model="form.LastPort"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Last Port"
                                                                ></b-form-input>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Next Port</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-input
                                                                v-model="form.NextPort"
                                                                required
                                                                id="input-id"
                                                                type="text"
                                                                placeholder="Next Port"
                                                                ></b-form-input>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row class="mt-2 d-flex justify-content-end">
                                                        <b-button lg="6" size="md" variant="dark" type="submit">Save</b-button>
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
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-content">
                            <b-card-text class="card-body">
                                <div>
                                    <div v-if="selected === 1">
                                        <b-row>
                                            <b-col>
                                                <b-card class="card">
                                                    <h3>Inward</h3>
                                                    <hr />
                                                    <b-row>
                                                        <b-col class="col-md-6 col-12">
                                                            <br />
                                                            <br />
                                                            <fieldset class="border p-2">
                                                                <legend class="w-auto">Details</legend>
                                                                <b-col lg="12">
                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Pilot Name</label>
                                                                        </b-col>
                                                                        <b-col class="col-md-10 form-group">
                                                                            <b-form-input
                                                                                v-model="form.PilotName"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Pilot Name"
                                                                                ></b-form-input>
                                                                        </b-col>
                                                                    </b-row>

                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Bearth Date</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <date-picker
                                                                                v-model="form.BearthDate"
                                                                                width="100%"
                                                                                input-class="form-control"
                                                                                type="date"
                                                                                lang="en"
                                                                                format="YYYY-MM-DD"
                                                                                ></date-picker>
                                                                        </div>

                                                                        <b-col lg="2">
                                                                            <label>Add Pilot</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <b-form-input
                                                                                v-model="form.AddPilot"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Add Pilot"
                                                                                ></b-form-input>
                                                                        </div>
                                                                    </b-row>

                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Bearth Time From</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <date-picker
                                                                                v-model="form.BearthTimeFrom"
                                                                                width="100%"
                                                                                input-class="form-control"
                                                                                type="time"
                                                                                lang="en"
                                                                                format="hh-mm-ss"
                                                                                placeholder="Select Time"
                                                                                ></date-picker>
                                                                        </div>
                                                                        <b-col lg="2">
                                                                            <label>Time To</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <date-picker
                                                                                v-model="form.TimeTo"
                                                                                width="100%"
                                                                                input-class="form-control"
                                                                                type="time"
                                                                                lang="en"
                                                                                format="hh-mm-ss"
                                                                                placeholder="Select Time"
                                                                                ></date-picker>
                                                                        </div>
                                                                    </b-row>

                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Bearth From</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <date-picker
                                                                                v-model="form.BearthFrom"
                                                                                width="100%"
                                                                                input-class="form-control"
                                                                                type="date"
                                                                                lang="en"
                                                                                format="YYYY-MM-DD"
                                                                                ></date-picker>
                                                                        </div>
                                                                        <b-col lg="2">
                                                                            <label>Bearth To</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <date-picker
                                                                                v-model="form.BearthTo"
                                                                                width="100%"
                                                                                input-class="form-control"
                                                                                type="date"
                                                                                lang="en"
                                                                                format="YYYY-MM-DD"
                                                                                ></date-picker>
                                                                        </div>
                                                                    </b-row>

                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Port Deus Status</label>
                                                                        </b-col>
                                                                        <div class="col-md-10 form-group">
                                                                            <b-form-input
                                                                                v-model="form.PortDeusStatus"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Port Deus Status"
                                                                                ></b-form-input>
                                                                        </div>
                                                                    </b-row>

                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Additional Port Status</label>
                                                                        </b-col>
                                                                        <b-col class="col-md-10 form-group">
                                                                            <b-form-input
                                                                                v-model="form.AdditionalPortStatus"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Additional Port Status"
                                                                                ></b-form-input>
                                                                        </b-col>
                                                                    </b-row>
                                                                </b-col>
                                                            </fieldset>
                                                        </b-col>

                                                        <b-col class="col-md-6 col-12">
                                                            <!-- Mooring Info -->

                                                            <fieldset class="border p-2">
                                                                <legend class="w-auto">Mooring Info</legend>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Number of Fixed Moor</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.NumberofFixedMoor"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Number of Fixed Moor"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Number Of Swing Moor</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.NumberOfSwingMoor"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Number Of Swing Moor"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>
                                                            </fieldset>

                                                            <!-- Tug Info -->
                                                            <fieldset class="border p-2">
                                                                <legend class="w-auto">Tug Info</legend>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Tug in out (Additional)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.Additional"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Tug in out (Additional)"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Tug in out (Time)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <date-picker
                                                                            v-model="form.TuginoutTime"
                                                                            width="100%"
                                                                            input-class="form-control"
                                                                            type="time"
                                                                            lang="en"
                                                                            placeholder="Select Time"
                                                                            format="hh-mm-ss"
                                                                            ></date-picker>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Tug in out (Cancel)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.TuginoutCan"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Tug in out (Cancel)"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Default Tug out (Cancel)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.DefaultTugoutCan"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Default Tug out (Cancel)"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>
                                                            </fieldset>
                                                        </b-col>
                                                    </b-row>
                                                </b-card>
                                            </b-col>
                                        </b-row>
                                    </div>
                                    <div v-if="selected === 2">
                                        <b-row>
                                            <b-col>
                                                <b-card class="card">
                                                    <h3>Outward</h3>
                                                    <hr />
                                                    <b-row>
                                                        <b-col class="col-md-6 col-12">
                                                            <fieldset class="border p-2">
                                                                <legend class="w-auto">Details</legend>
                                                                <b-col lg="12">
                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Pilot Name</label>
                                                                        </b-col>
                                                                        <b-col lg="10" class="form-group">
                                                                            <b-form-input
                                                                                v-model="form.PilotName2"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Pilot Name"
                                                                                ></b-form-input>
                                                                        </b-col>
                                                                    </b-row>

                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Depurture Date</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <date-picker
                                                                                v-model="form.DepurtureDate"
                                                                                width="100%"
                                                                                input-class="form-control"
                                                                                type="date"
                                                                                lang="en"
                                                                                format="YYYY-MM-DD"
                                                                                ></date-picker>
                                                                        </div>

                                                                        <b-col lg="2">
                                                                            <label>Add Pilot</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <b-form-input
                                                                                v-model="form.AddPilot2"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Add Pilot"
                                                                                ></b-form-input>
                                                                        </div>
                                                                    </b-row>

                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Depurture Time From</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <date-picker
                                                                                v-model="form.DepurtureTimeFrom"
                                                                                width="100%"
                                                                                input-class="form-control"
                                                                                type="time"
                                                                                lang="en"
                                                                                placeholder="Select Time"
                                                                                format="hh-mm-ss"
                                                                                ></date-picker>
                                                                        </div>

                                                                        <b-col lg="2">
                                                                            <label>Time To</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <date-picker
                                                                                v-model="form.DepurtureTimeTo"
                                                                                width="100%"
                                                                                input-class="form-control"
                                                                                type="time"
                                                                                lang="en"
                                                                                placeholder="Select Time"
                                                                                format="hh-mm-ss"
                                                                                ></date-picker>
                                                                        </div>
                                                                    </b-row>

                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Shifting From</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <b-form-input
                                                                                v-model="form.ShiftingFrom"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Shifting From"
                                                                                ></b-form-input>
                                                                        </div>

                                                                        <b-col lg="2">
                                                                            <label>Shifting To</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <b-form-input
                                                                                v-model="form.ShiftingTo"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Shifting To"
                                                                                ></b-form-input>
                                                                        </div>
                                                                    </b-row>
                                                                </b-col>
                                                            </fieldset>
                                                        </b-col>

                                                        <b-col class="col-md-6 col-12">
                                                            <!-- Tug Info -->
                                                            <fieldset class="border p-2">
                                                                <legend class="w-auto">Tug Info</legend>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Tug in out (Additional)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.TuginoutAdditional2"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Tug in out (Additional)"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Tug in out (Time)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.TuginoutTime2"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Tug in out (Time)"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Tug in out (Cancel)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.TuginoutCan2"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Tug in out (Cancel)"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Default Tug out (Cancel)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.DefaultTugoutCan2"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Default Tug out (Cancel)"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>
                                                            </fieldset>
                                                        </b-col>
                                                    </b-row>
                                                </b-card>
                                            </b-col>
                                        </b-row>
                                    </div>
                                    <div v-if="selected === 3">
                                        <b-row>
                                            <b-col>
                                                <b-card class="card">
                                                    <h3>Shifting</h3>
                                                    <hr />
                                                    <b-row>
                                                        <b-col class="col-md-6 col-12">
                                                            <br />
                                                            <br />
                                                            <br />
                                                            <fieldset class="border p-2">
                                                                <legend class="w-auto">Details</legend>
                                                                <b-col lg="12">
                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Pilot Name</label>
                                                                        </b-col>
                                                                        <b-col lg="10" class="form-group">
                                                                            <b-form-input
                                                                                v-model="form.PilotName3"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Pilot Name"
                                                                                ></b-form-input>
                                                                        </b-col>
                                                                    </b-row>

                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Shifting Date</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <date-picker
                                                                                v-model="form.ShiftingDate"
                                                                                width="100%"
                                                                                input-class="form-control"
                                                                                type="date"
                                                                                lang="en"
                                                                                format="YYYY-MM-DD"
                                                                                ></date-picker>
                                                                        </div>

                                                                        <b-col lg="2">
                                                                            <label>Add Pilot</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <b-form-input
                                                                                v-model="form.AddPilot3"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Add Pilot"
                                                                                ></b-form-input>
                                                                        </div>
                                                                    </b-row>

                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Shifting Time From</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <date-picker
                                                                                v-model="form.ShiftingTimeFrom"
                                                                                width="100%"
                                                                                input-class="form-control"
                                                                                type="time"
                                                                                lang="en"
                                                                                placeholder="Select Time"
                                                                                format="hh-mm-ss"
                                                                                ></date-picker>
                                                                        </div>

                                                                        <b-col lg="2">
                                                                            <label>Time To</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <date-picker
                                                                                v-model="form.ShiftingTimeTo"
                                                                                width="100%"
                                                                                input-class="form-control"
                                                                                type="time"
                                                                                lang="en"
                                                                                placeholder="Select Time"
                                                                                format="hh-mm-ss"
                                                                                ></date-picker>
                                                                        </div>
                                                                    </b-row>

                                                                    <b-row>
                                                                        <b-col lg="2">
                                                                            <label>Shifting From</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <b-form-input
                                                                                v-model="form.DepurtureFrom3"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Shifting From"
                                                                                ></b-form-input>
                                                                        </div>

                                                                        <b-col lg="2">
                                                                            <label>Shifting To</label>
                                                                        </b-col>
                                                                        <div class="col-md-4 form-group">
                                                                            <b-form-input
                                                                                v-model="form.DepurtureTo3"
                                                                                required
                                                                                id="input-id"
                                                                                type="text"
                                                                                placeholder="Shifting To"
                                                                                ></b-form-input>
                                                                        </div>
                                                                    </b-row>
                                                                </b-col>
                                                            </fieldset>
                                                        </b-col>

                                                        <b-col class="col-md-6 col-12">
                                                            <!-- Mooring Info -->

                                                            <fieldset class="border p-2">
                                                                <legend class="w-auto">Mooring Info</legend>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Number of Fixed Moor</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.NumberofFixedMoor"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Number of Fixed Moor"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Number Of Swing Moor</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.NumberOfSwingMoor"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Number Of Swing Moor"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>
                                                            </fieldset>
                                                            <!-- Tug Info -->
                                                            <fieldset class="border p-2">
                                                                <legend class="w-auto">Tug Info</legend>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Tug in out (Additional)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.TuginoutAdditional"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Tug in out (Additional)"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Tug in out (Time)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.TuginoutTime"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Tug in out (Time)"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Tug in out (Cancel)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.TuginoutCan"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Tug in out (Cancel)"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>

                                                                <b-row>
                                                                    <b-col lg="3">
                                                                        <label>Default Tug out (Cancel)</label>
                                                                    </b-col>
                                                                    <b-col lg="9" class="form-group">
                                                                        <b-form-input
                                                                            v-model="form.DefaultTugoutCan"
                                                                            required
                                                                            id="input-id"
                                                                            type="text"
                                                                            placeholder="Default Tug out (Cancel)"
                                                                            ></b-form-input>
                                                                    </b-col>
                                                                </b-row>
                                                            </fieldset>
                                                        </b-col>
                                                    </b-row>
                                                </b-card>
                                            </b-col>
                                        </b-row>
                                    </div>
                                </div>
                            </b-card-text>
                        </div>
                    </b-card>
                </b-col>
            </b-row>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Bill Receivable"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Vessel Service"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pilotage Navigation"});

        },
        data() {
            return {
                form: {
                    employee_id: "",
                    department_name: "",
                    designation: "",
                    bankname: null,
                    bankbr: null,
                    accname: null,
                    accno: null,
                    financial_code: null,
                    shift: null
                },
                options: [
                    {id: 1, value: "Inward"},
                    {id: 2, value: "Outward"},
                    {id: 3, value: "Shifting"}
                ],
                selected: null,
                show: true,
                updateIndex: -1,
                submitBtn: "Save",

                examCenter: [
                    "SL",
                    "BillNo",
                    "BillDate",
                    "NameofVessle",
                    "NaturalAccounts",
                    "BillAmount",
                    "Remarks",
                    "Action"
                ],
                education: [
                    {
                        SL: "",
                        BillNo: "",
                        BillDate: "",
                        NameofVessle: "",
                        NaturalAccounts: "",
                        BillAmount: "",
                        Remarks: "",
                        Action: ""
                    }
                ],
                tableData: {
                    fields: [
                        {key: "line", label: "Line"},
                        {key: "Bank_Name", label: "Bank Name"},
                        {key: "Branch_Name", label: "Branch Name"},
                        {key: "STD_Account_Name", label: "STD Account Name"},
                        {key: "STD_Account", label: "STD Account"},
                        {key: "Opening_Date", label: "Opening Date"},
                        {key: "STD_Tenor", label: "STD Tenor"},
                        {key: "STD_Amount", label: "STD Amount"},
                        {key: "STD_Rate", label: "STD Rate"},
                        {key: "Interest", label: "Interest"},
                        {key: "Total_Amount", label: "Total Amount"},
                        {key: "Status", label: "Status"},
                        {key: "Action", label: "Action"}
                    ],
                    items: [
                        {
                            line: 1,
                            Bank_Name: "Pubali Bank",
                            Branch_Name: "Agrabad",
                            STD_Account_Name: "CPA-FDR",
                            STD_Account: 1240,
                            Opening_Date: "30-Dec-2019",
                            STD_Tenor: "1 Year",
                            STD_Amount: "01-Jan-2019",
                            STD_Rate: "31-Dec-2019",
                            Interest: 100000,
                            Total_Amount: "8%",
                            Status: "Open"
                        }
                    ]
                },
                accnolist: [
                    {value: null, text: "Please select"},
                    {value: "011091003", text: "011091003"},
                    {value: "011091004", text: "011091004"},
                    {value: "011091005", text: "011091005"},
                    {value: "011091006", text: "011091006"}
                ],
                partycodelist: [
                    {value: null, text: "Please select"},
                    {value: "011091003", text: "011091003"},
                    {value: "011091004", text: "011091004"},
                    {value: "011091005", text: "011091005"},
                    {value: "011091006", text: "011091006"}
                ],
                partynamelist: [
                    {value: null, text: "Please select"},
                    {value: "ABC Company", text: "ABC Company"},
                    {value: "XYZ Pvt. Ltd.", text: "XYZ Pvt. Ltd."}
                ],
                approvalstatus: [
                    {value: null, text: "Please select"},
                    {value: "Approved", text: "Approved"},
                    {value: "Not Approved", text: "Not Approved"}
                ],
                bankNameList: [
                    {value: null, text: "Please select"},
                    {value: "NRBC Bank", text: "NRBC Bank"},
                    {value: "Pubali Bank", text: "Pubali Bank"},
                    {value: "Standered Chartered Bank", text: "Standered Chartered Bank"},
                    {value: "United Commarcial Bank", text: "United Commarcial Bank"},
                    {value: "Eastern Bank", text: "Eastern Bank"}
                ],
                bankbrNameList: [
                    {value: null, text: "Please select"},
                    {value: "Agrabad", text: "Agrabad"},
                    {value: "Sadar", text: "Sadar"},
                    {value: "Port", text: "Port"}
                ],
                financial_code_options: [
                    {value: null, text: "Please select"},
                    {value: 97040, text: "97040"},
                    {value: 97041, text: "97041"},
                    {value: 97042, text: "97042"},
                    {value: 97043, text: "97043"},
                    {value: 97044, text: "97044"},
                    {value: 97045, text: "97045"},
                    {value: 97046, text: "97046"},
                    {value: 90720, text: "90720"},
                    {value: 90631, text: "90631"},
                    {value: 90730, text: "90730"},
                    {value: 90810, text: "90810"},
                    {value: 90490, text: "90490"}
                ],
                shift_options: [
                    {value: null, text: "Please select"},
                    {value: "1", text: "1"},
                    {value: "2", text: "2"},
                    {value: "3", text: "3"},
                    {value: "4", text: "4"},
                    {value: "5", text: "5"},
                    {value: "6", text: "6"},
                    {value: "7", text: "7"}
                ],
                statusList: [
                            {value: 1, text: 'Incomplete'},
                            {value: '2', text: 'Complete'},
                            {value: '4', text: 'Approved'},
                            {value: '4', text: 'In Process'},
                            {value: '4', text: 'Reject'}
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
