<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Officer List</h4>
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
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Department</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-select v-model="form.department" :options="department"></b-form-select>
                                                        </b-col>
                                                    </b-row>

                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Job Title</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-select v-model="form.title" :options="title"></b-form-select>
                                                        </b-col>
                                                    </b-row>
                                                </b-col>
                                                <b-col lg="6">
                                                    <b-row>
                                                        <b-col lg="4">
                                                            <label>Section</label>
                                                        </b-col>
                                                        <b-col lg="8" class="form-group">
                                                            <b-form-select v-model="form.section" :options="section"></b-form-select>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row class="mt-3">
                                                        <b-col class="d-flex justify-content-end">
                                                            <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button>&nbsp;
                                                        </b-col>
                                                    </b-row>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>

                                    <!--</fieldset>-->
                                </b-form>
                            </div>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <!--b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Officer List</h4>
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

                            

            <!--</fieldset>
        </b-form>
    </div>
</b-card-text>
</b-card-->
                <b-row>
                    <b-col xl="2" md="6" sm="12">
                        <b-card no-body>
                           <b-img  fluid center  class="w-50" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiOBcnv1xTyyjyIJnuPx6pfkG1ay_7qzdMZdjPAVnBGwTBmInF&s" alt="Image 2"></b-img>
                            <b-card-body class="text-center">
                                <b-card-title >Md. Zafor Alam</b-card-title>
                                <b-card-text class="mb-0"><b>Member</b></b-card-text>
                                <b-card-text class="mb-0">Administration & Planning</b-card-text>
                                <small  class="mb-0"><i class="bx bxs-circle dark font-small-1 mr-50"></i>Administration</small><br> 
                                <small class="text-primary">zafor@gmail.com</small><br>   
                                <small class="text-muted">+8801557258514</small>
                            </b-card-body>
                        </b-card> 
                    </b-col>
                     <b-col xl="2" md="6" sm="12">
                        <b-card no-body>
                           <b-img  fluid center  class="w-50" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiOBcnv1xTyyjyIJnuPx6pfkG1ay_7qzdMZdjPAVnBGwTBmInF&s" alt="Image 2"></b-img>
                            <b-card-body class="text-center">
                                <b-card-title >Md. Zafor Alam</b-card-title>
                                <b-card-text class="mb-0"><b>Member</b></b-card-text>
                                <b-card-text class="mb-0">Administration & Planning</b-card-text>
                                <small  class="mb-0"><i class="bx bxs-circle dark font-small-1 mr-50"></i>Administration</small><br> 
                                <small class="text-primary">zafor@gmail.com</small><br>   
                                <small class="text-muted">+8801557258514</small>
                            </b-card-body>
                        </b-card> 
                    </b-col>
                     <b-col xl="2" md="6" sm="12">
                        <b-card no-body>
                           <b-img  fluid center  class="w-50" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiOBcnv1xTyyjyIJnuPx6pfkG1ay_7qzdMZdjPAVnBGwTBmInF&s" alt="Image 2"></b-img>
                            <b-card-body class="text-center">
                                <b-card-title >Md. Zafor Alam</b-card-title>
                                <b-card-text class="mb-0"><b>Member</b></b-card-text>
                                <b-card-text class="mb-0">Administration & Planning</b-card-text>
                                <small  class="mb-0"><i class="bx bxs-circle dark font-small-1 mr-50"></i>Administration</small><br> 
                                <small class="text-primary">zafor@gmail.com</small><br>   
                                <small class="text-muted">+8801557258514</small>
                            </b-card-body>
                        </b-card> 
                    </b-col>
                     <b-col xl="2" md="6" sm="12">
                        <b-card no-body>
                           <b-img  fluid center  class="w-50" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiOBcnv1xTyyjyIJnuPx6pfkG1ay_7qzdMZdjPAVnBGwTBmInF&s" alt="Image 2"></b-img>
                            <b-card-body class="text-center">
                                <b-card-title >Md. Zafor Alam</b-card-title>
                                <b-card-text class="mb-0"><b>Member</b></b-card-text>
                                <b-card-text class="mb-0">Administration & Planning</b-card-text>
                                <small  class="mb-0"><i class="bx bxs-circle dark font-small-1 mr-50"></i>Administration</small><br> 
                                <small class="text-primary">zafor@gmail.com</small><br>   
                                <small class="text-muted">+8801557258514</small>
                            </b-card-body>
                        </b-card> 
                    </b-col>
                     <b-col xl="2" md="6" sm="12">
                        <b-card no-body>
                           <b-img  fluid center  class="w-50" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiOBcnv1xTyyjyIJnuPx6pfkG1ay_7qzdMZdjPAVnBGwTBmInF&s" alt="Image 2"></b-img>
                            <b-card-body class="text-center">
                                <b-card-title >Md. Zafor Alam</b-card-title>
                                <b-card-text class="mb-0"><b>Member</b></b-card-text>
                                <b-card-text class="mb-0">Administration & Planning</b-card-text>
                                <small  class="mb-0"><i class="bx bxs-circle dark font-small-1 mr-50"></i>Administration</small><br> 
                                <small class="text-primary">zafor@gmail.com</small><br>   
                                <small class="text-muted">+8801557258514</small>
                            </b-card-body>
                        </b-card> 
                    </b-col>
                     <b-col xl="2" md="6" sm="12">
                        <b-card no-body>
                           <b-img  fluid center  class="w-50" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiOBcnv1xTyyjyIJnuPx6pfkG1ay_7qzdMZdjPAVnBGwTBmInF&s" alt="Image 2"></b-img>
                            <b-card-body class="text-center">
                                <b-card-title >Md. Zafor Alam</b-card-title>
                                <b-card-text class="mb-0"><b>Member</b></b-card-text>
                                <b-card-text class="mb-0">Administration & Planning</b-card-text>
                                <small  class="mb-0"><i class="bx bxs-circle dark font-small-1 mr-50"></i>Administration</small><br> 
                                <small class="text-primary">zafor@gmail.com</small><br>   
                                <small class="text-muted">+8801557258514</small>
                            </b-card-body>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {
                link: "#",
                label: "Employee Position"
            });
            this.$store.commit("setBreadcrumb", {link: "#", label: "Department"});
        },
        data() {
            return {
                form: {
                    section: null,
                    department: null, 
                    title: null
                },
               // mainProps: { width: 150, height: 150, class: 'm1' },
                show: true,
                updateIndex: -1,
                submitBtn: "Save",
                department: [
                    {text: "All", value: null},
                    {text: "Administration", value: "Administration"},
                    {text: "Secratariat", value: "Secratariat"}
                ],
                title: [
                    {text: "All", value: null},
                    {text: "Personal Officer", value: "PersonalOfficer"},
                    {text: "Computer Oparator", value: "ComputerOparator"}
                ],
                section: [
                    {text: "All", value: null},
                    {text: "Dummy Data", value: "DummyData"},
                    {text: "Dummy Data", value: "DummyData"}
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
