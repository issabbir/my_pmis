<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-row >
                <b-col>
                    <b-card class="card">
                        <div class="card-header">
                            <h4 class="card-title">Leave Type Info</h4>
                        </div>
                        <div class="card-content">
                            <b-card-text class="card-body mb-2">
                                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                    <!--<fieldset class="border p-2">-->
                                        <!--<legend class="w-auto">Thana Setup</legend>-->
                                        <b-row >
                                            <b-col>
                                                <b-row class="row">
                                                    <b-col lg="6">
                                                        <b-row >
                                                            <b-col lg="4">
                                                                <label>Leave Code</label>
                                                            </b-col>
                                                            <b-col lg="8" class="form-group">
                                                                <b-form-input  required  type="text" placeholder="Leave Code" value="123"></b-form-input>
                                                            </b-col>
                                                        </b-row>

                                                        <b-row>
                                                            <b-col lg="4">
                                                                <label>Leave Description</label>
                                                            </b-col>
                                                            <b-col lg="8" class="form-group">
                                                                <b-form-input  required  type="text" placeholder="Leave Description"></b-form-input>

                                                            </b-col>
                                                        </b-row>

                                                    </b-col>
                                                    <b-col lg="6" >
                                                        <b-row >
                                                            <b-col lg="4">
                                                                <label>Leave Type</label>
                                                            </b-col>
                                                            <b-col lg="8" class="form-group">
                                                                <b-form-input  required  type="text" placeholder="Leave Type"></b-form-input>
                                                            </b-col>
                                                        </b-row>



                                                        <b-row >
                                                            <b-col lg="4">
                                                                <label>Leave Day</label>
                                                            </b-col>
                                                            <b-col lg="8" class="form-group">
                                                                <b-form-input   required  type="text" placeholder="Leave Day"></b-form-input>

                                                            </b-col>
                                                        </b-row>
                                                    </b-col>
                                                </b-row>

                                                <b-row class="row">
                                                    <b-col lg="6">
                                                        <b-row>
                                                            <b-col lg="4"><label class="d-block">Applicable Employee Type</label></b-col>
                                                            <b-col lg="8">
                                                                <b-form-group>
                                                                    <b-form-radio-group v-model="emptype"
                                                                            :options="emptype_options"
                                                                            name="radio-options"
                                                                    ></b-form-radio-group>
                                                                </b-form-group>
                                                            </b-col>
                                                        </b-row>
                                                    </b-col>
                                                    <b-col lg="6" >
                                                        <b-row>
                                                            <b-col lg="4"><label class="d-block">Applicable Gender</label></b-col>
                                                            <b-col lg="8">
                                                                <b-form-group>
                                                                    <b-form-radio-group v-model="gender"
                                                                            :options="gender_options"
                                                                            name="radio-options"
                                                                    ></b-form-radio-group>
                                                                </b-form-group>
                                                            </b-col>
                                                        </b-row>
                                                    </b-col>
                                                </b-row>


                                            </b-col>
                                        </b-row>

                                        <b-row>
                                            <b-col class="mt-2 d-flex justify-content-end">
                                                <b-button lg="6" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                                <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                            </b-col>
                                        </b-row>
                                    <!--</fieldset>-->
                                    <!-- </fieldset>-->
                                </b-form>
                            </b-card-text>
                        </div>
                    </b-card>
                </b-col>
            </b-row>



            <!-- Zero configuration table -->
            <section id="basic-datatable">
                <b-row >
                    <b-col >
                        <b-card class="card">
                            <div class="card-content">
                                <b-card-text class="card-body">
                                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" >
                                        <template v-slot:actions="{ rows }">
                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item.id, rows.item.id)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                            <b-link class="text-danger" @click="deleteRow(rows.item.id, rows.item.id)">
                                                <i class="bx bx-trash cursor-pointer"></i>
                                            </b-link>
                                        </template>
                                    </Datatable>
                                </b-card-text>
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
    import Datatable from '../../../layouts/common/datatable';
    export default {
        components: {
            Datatable
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Leave Setup"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Leave Type" });
        },
        data() {
            return {
                gender:'Male',
                emptype: 'All',
                form: {
                    id: '',
                    division_name: null,
                    district_name: null,
                    description: '',
                },
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                tableData: {
                    fields: [{key:'Code', sortable:true}, {key:'Leave Type', sortable:true}, {key:'Leave Description', sortable:true},{key: 'Leave Days', sortable:true},{key: 'Employee Type', sortable:true},{key: 'Applicable Gender', sortable:true}, 'Action'],
                    items:[
                        {
                            "Code": 1,
                            "Leave Type": "Leave Average Pay",
                            "Leave Description": "Lap",
                            "Leave Days": "",
                            "Employee Type": "Officer",
                            "Applicable Gender": "Male",
                            "Action": ""
                        },
                        {
                            "Code": 2,
                            "Leave Type": "Leave Average Pay",
                            "Leave Description": "Lap",
                            "Leave Days": "",
                            "Employee Type": "Officer",
                            "Applicable Gender": "Male",
                            "Action": ""
                        },
                        {
                            "Code": 3,
                            "Leave Type": "Leave Average Pay",
                            "Leave Description": "Lap",
                            "Leave Days": "",
                            "Employee Type": "Officer",
                            "Applicable Gender": "Male",
                            "Action": ""
                        }
                    ]
                },
                gender_options: [
                    { value: 'Male', text: 'Male' },
                    { value: 'Female', text: 'Female' },
                    { value: 'Other', text: 'Other' },
                ],
                emptype_options: [
                    { value: 'All', text: 'All' },
                    { value: 'Officer', text: 'Officer' },
                    { value: 'Staff', text: 'Staff' },
                ],


            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if(this.updateIndex > -1){ //update
                    this.tableData.items[this.updateIndex].id = this.form.id;

                }else{ //new data add
                    this.tableData.items.push({
                        id: this.form.id,
                        division_name: this.form.division_name,
                        description: this.form.description,
                    });
                }
                this.onReset(evt);
            },
            onReset(evt) {
                evt.preventDefault();
                this.id =  '';
                this.designation= '';
                this.division_name= null;


                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });

            },
            editRow(i) {
                this.submitBtn = 'Update';
                this.updateIndex = i;
                let data = this.tableData.items[i];
                console.log(data);

            },
            deleteRow(i) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            }

        }
    }
</script>

