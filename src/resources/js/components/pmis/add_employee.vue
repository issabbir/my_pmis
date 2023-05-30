<template>
    <div class="content-body">
        <div id="stacked-pill">
            <div class="col-md-12">
                <div class="card bg-transparent border">
                    <div class="card-content">
                        <div class="card-body pt-1">
                            <div class="pills-stacked">
                                <div class="row">
                                    <div class="col-md-2 col-sm-12 border-right pr-md-0">
                                        <ul class="nav nav-pills flex-column text-center text-md-left">
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center active"
                                                   data-toggle="pill"  aria-expanded="true"><i
                                                    class="bx bx-cog"></i>
                                                    <span> Basic Info</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center"
                                                   data-toggle="pill" aria-expanded="true"><i
                                                    class="bx bx-cog"></i>
                                                    <span> Basic Info</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-10 col-sm-12 border-right pr-md-0">
                                        <b-card title="Card Title">
                                            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                                <div class="col-md-6 p-0">
                                                    <b-form-group
                                                        id="fieldset-1"
                                                        label="Employee Id"

                                                        label-for="empid">
                                                        <b-form-input id="empid" v-model="form.emp_id" placeholder="testing.." disabled trim></b-form-input>
                                                    </b-form-group>
                                                </div>

                                                <b-row>
                                                        <b-col>
                                                            <b-form-group
                                                                label="Title"
                                                                label-for="title"
                                                            >
                                                                <b-form-select v-model="selected" class="">
                                                                    <option :value="null">Please select a Title</option>
                                                                    <option value="1">Mr.</option>
                                                                    <option value="2">Mrs.</option>
                                                                    <option value="3">Col.</option>
                                                                    <option value="4" >Dr.</option>
                                                                </b-form-select>

                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col>
                                                            <b-form-group
                                                                label="First Name"
                                                                label-for="fname"
                                                            >
                                                                <b-form-input
                                                                    id="fname"
                                                                    v-model="form.email"
                                                                    type="text"
                                                                    required
                                                                    placeholder="Enter First Name"
                                                                ></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col>
                                                            <b-form-group
                                                                label="MIDDLE NAME"
                                                                label-for="mname"
                                                            >
                                                                <b-form-input
                                                                    id="mname"
                                                                    v-model="form.email"
                                                                    type="text"
                                                                    required
                                                                    placeholder="Enter Middle Name"
                                                                ></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col>
                                                            <b-form-group
                                                                label="LAST NAME"
                                                                label-for="lname"
                                                            >
                                                                <b-form-input
                                                                    id="lname"
                                                                    v-model="form.email"
                                                                    type="text"
                                                                    required
                                                                    placeholder="Enter Last Name"
                                                                ></b-form-input>
                                                            </b-form-group>
                                                        </b-col>
                                                    </b-row>
                                                <b-row>
                                                    <b-col>
                                                        <b-form-group
                                                            label="Division"
                                                            label-for="division"
                                                        >
                                                            <b-form-select v-model="selected" class="">
                                                                <option :value="null">Please select a Division</option>
                                                                <option value="1">Chairman</option>
                                                                <option value="2">Member (Engineering)</option>
                                                                <option value="3">Member (Harbor and Marine)</option>
                                                                <option value="4" >Member (Admin and Planning)</option>
                                                                <option value="4" >Member (Finance)</option>
                                                                <option value="4" >Chittagong Port Authority</option>
                                                            </b-form-select>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="DEPARTMENT"
                                                            label-for="department"
                                                        >
                                                            <b-form-select v-model="selected" class="">
                                                                <option :value="null">Please select a Department</option>
                                                                <option value="1">Chairman</option>
                                                                <option value="2">Member (Engineering)</option>
                                                                <option value="3">Member (Harbor and Marine)</option>
                                                                <option value="4" >Member (Admin and Planning)</option>
                                                                <option value="4" >Member (Finance)</option>
                                                                <option value="4" >Chittagong Port Authority</option>
                                                            </b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="SECTION"
                                                            label-for="section"
                                                        >
                                                            <b-form-select v-model="selected" class="">
                                                                <option :value="null">Please select a Department</option>
                                                                <option value="1">Chairman</option>
                                                                <option value="2">Member (Engineering)</option>
                                                                <option value="3">Member (Harbor and Marine)</option>
                                                                <option value="4" >Member (Admin and Planning)</option>
                                                                <option value="4" >Member (Finance)</option>
                                                                <option value="4" >Chittagong Port Authority</option>
                                                            </b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="DESIGNATION"
                                                            label-for="designation"
                                                        >
                                                            <b-form-select v-model="selected" class="">
                                                                <option :value="null">Please select a DESIGNATION</option>
                                                                <option value="1">Chairman</option>
                                                                <option value="2">Member (Engineering)</option>
                                                                <option value="3">Member (Harbor and Marine)</option>
                                                                <option value="4" >Member (Admin and Planning)</option>
                                                                <option value="4" >Member (Finance)</option>
                                                                <option value="4" >Chittagong Port Authority</option>
                                                            </b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                                <b-row>
                                                    <b-col>
                                                        <b-form-group
                                                            label="Title:"
                                                            label-for="title"
                                                        >
                                                            <b-form-input
                                                                id="title"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Title"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="Title:"
                                                            label-for="title"
                                                        >
                                                            <b-form-input
                                                                id="title"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Title"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="Title:"
                                                            label-for="title"
                                                        >
                                                            <b-form-input
                                                                id="title"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Title"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group

                                                        >

                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>

                                                <b-row>
                                                    <b-col>
                                                        <b-form-group
                                                            label="Title"
                                                            label-for="title"
                                                        >
                                                            <b-form-select v-model="selected" class="">
                                                                <option :value="null">Please select a Title</option>
                                                                <option value="1">Mr.</option>
                                                                <option value="2">Mrs.</option>
                                                                <option value="3">Col.</option>
                                                                <option value="4" >Dr.</option>
                                                            </b-form-select>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="First Name"
                                                            label-for="fname"
                                                        >
                                                            <b-form-input
                                                                id="fname"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter First Name"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="MIDDLE NAME"
                                                            label-for="mname"
                                                        >
                                                            <b-form-input
                                                                id="mname"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Middle Name"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="LAST NAME"
                                                            label-for="lname"
                                                        >
                                                            <b-form-input
                                                                id="lname"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Last Name"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                                <b-row>
                                                    <b-col>
                                                        <b-form-group
                                                            label="Division"
                                                            label-for="division"
                                                        >
                                                            <b-form-select v-model="selected" class="">
                                                                <option :value="null">Please select a Division</option>
                                                                <option value="1">Chairman</option>
                                                                <option value="2">Member (Engineering)</option>
                                                                <option value="3">Member (Harbor and Marine)</option>
                                                                <option value="4" >Member (Admin and Planning)</option>
                                                                <option value="4" >Member (Finance)</option>
                                                                <option value="4" >Chittagong Port Authority</option>
                                                            </b-form-select>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="DEPARTMENT"
                                                            label-for="department"
                                                        >
                                                            <b-form-select v-model="selected" class="">
                                                                <option :value="null">Please select a Department</option>
                                                                <option value="1">Chairman</option>
                                                                <option value="2">Member (Engineering)</option>
                                                                <option value="3">Member (Harbor and Marine)</option>
                                                                <option value="4" >Member (Admin and Planning)</option>
                                                                <option value="4" >Member (Finance)</option>
                                                                <option value="4" >Chittagong Port Authority</option>
                                                            </b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="SECTION"
                                                            label-for="section"
                                                        >
                                                            <b-form-select v-model="selected" class="">
                                                                <option :value="null">Please select a Department</option>
                                                                <option value="1">Chairman</option>
                                                                <option value="2">Member (Engineering)</option>
                                                                <option value="3">Member (Harbor and Marine)</option>
                                                                <option value="4" >Member (Admin and Planning)</option>
                                                                <option value="4" >Member (Finance)</option>
                                                                <option value="4" >Chittagong Port Authority</option>
                                                            </b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="DESIGNATION"
                                                            label-for="designation"
                                                        >
                                                            <b-form-select v-model="selected" class="">
                                                                <option :value="null">Please select a DESIGNATION</option>
                                                                <option value="1">Chairman</option>
                                                                <option value="2">Member (Engineering)</option>
                                                                <option value="3">Member (Harbor and Marine)</option>
                                                                <option value="4" >Member (Admin and Planning)</option>
                                                                <option value="4" >Member (Finance)</option>
                                                                <option value="4" >Chittagong Port Authority</option>
                                                            </b-form-select>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                                <b-row>
                                                    <b-col>
                                                        <b-form-group
                                                            label="Title:"
                                                            label-for="title"
                                                        >
                                                            <b-form-input
                                                                id="title"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Title"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="Title:"
                                                            label-for="title"
                                                        >
                                                            <b-form-input
                                                                id="title"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Title"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="Title:"
                                                            label-for="title"
                                                        >
                                                            <b-form-input
                                                                id="title"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Title"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>

                                                    <b-col>
                                                        <b-form-group
                                                            label="Title:"
                                                            label-for="title"
                                                        >
                                                            <b-form-input
                                                                id="title"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Title"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                                <b-row>
                                                    <b-col>
                                                        <b-form-group
                                                            label="Title"
                                                            label-for="title"
                                                        >
                                                            <b-form-select v-model="selected" class="">
                                                                <option :value="null">Please select a Title</option>
                                                                <option value="1">Mr.</option>
                                                                <option value="2">Mrs.</option>
                                                                <option value="3">Col.</option>
                                                                <option value="4" >Dr.</option>
                                                            </b-form-select>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="First Name"
                                                            label-for="fname"
                                                        >
                                                            <b-form-input
                                                                id="fname"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter First Name"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="MIDDLE NAME"
                                                            label-for="mname"
                                                        >
                                                            <b-form-input
                                                                id="mname"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Middle Name"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col>
                                                        <b-form-group
                                                            label="LAST NAME"
                                                            label-for="lname"
                                                        >
                                                            <b-form-input
                                                                id="lname"
                                                                v-model="form.email"
                                                                type="text"
                                                                required
                                                                placeholder="Enter Last Name"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>
                                                <b-row >
                                                            <b-col cols="3">
                                                                <b-form-group
                                                                    label="Title:"
                                                                    label-for="title"
                                                                >
                                                                    <b-form-input
                                                                        id="title"
                                                                        v-model="form.email"
                                                                        type="text"
                                                                        required
                                                                        placeholder="Enter Title"
                                                                    ></b-form-input>
                                                                </b-form-group>
                                                            </b-col>
                                                            <b-col cols="3">
                                                                <b-form-group
                                                                    label="Title:"
                                                                    label-for="title"
                                                                >
                                                                    <b-form-input
                                                                        id="title"
                                                                        v-model="form.email"
                                                                        type="text"
                                                                        required
                                                                        placeholder="Enter Title"
                                                                    ></b-form-input>
                                                                </b-form-group>
                                                            </b-col>
                                                </b-row>
                                            </b-form>


                                        </b-card>
                                        <b-card
                                        >
                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                        label="Title"
                                                        label-for="title"
                                                    >
                                                        <b-form-select v-model="selected" class="">
                                                            <option :value="null">Please select a Title</option>
                                                            <option value="1">Mr.</option>
                                                            <option value="2">Mrs.</option>
                                                            <option value="3">Col.</option>
                                                            <option value="4" >Dr.</option>
                                                        </b-form-select>

                                                    </b-form-group>
                                                </b-col>
                                                <b-col>
                                                    <b-form-group
                                                        label="First Name"
                                                        label-for="fname"
                                                    >
                                                        <b-form-input
                                                            id="fname"
                                                            v-model="form.email"
                                                            type="text"
                                                            required
                                                            placeholder="Enter First Name"
                                                        ></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col>
                                                    <b-form-group
                                                        label="MIDDLE NAME"
                                                        label-for="mname"
                                                    >
                                                        <b-form-input
                                                            id="mname"
                                                            v-model="form.email"
                                                            type="text"
                                                            required
                                                            placeholder="Enter Middle Name"
                                                        ></b-form-input>
                                                    </b-form-group>
                                                </b-col>

                                            </b-row>

                                        </b-card>
                                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                                            <b-button type="button" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Save</b-button>
                                            <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">Cancel</b-button>
                                        </div>
                                        <b-button type="submit" variant="primary">Submit</b-button>
                                        <b-button type="reset" variant="danger">Reset</b-button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Add"});
        },
         data() {
            return {
                form: {
                    emp_id:1211
                },
                foods: [{text: 'Select One', value: null}, 'Carrots', 'Beans', 'Tomatoes', 'Corn'],
                show: true
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                alert(JSON.stringify(this.form))
            },
            onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.form.email = '';
                this.form.name = '';
                this.form.food = null;
                this.form.checked = [];
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
            }
        }
    }
</script>

