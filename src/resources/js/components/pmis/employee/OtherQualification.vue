<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked" style="padding-top:0px">
                <b-card-title>
                    <b-form-checkbox vertical v-model="hidenseek" name="check-button" switch size="lg"></b-form-checkbox>
                </b-card-title>
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0" :class="{'d-none':!hidenseek}">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0" :class="{'col-md-12':!hidenseek}">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-card title="Other Qualification">
                                <b-row>
                                    <b-col md="4">
                                        <b-form-group
                                            label="Grant/Prize/Award"
                                            label-for="gpa"
                                        >  <b-form-textarea
                                            v-model="OtherQualification.gpa"
                                            id="gpa"
                                            size="sm"
                                            rows="5"
                                            placeholder="Grant/Prize/Award"
                                        ></b-form-textarea>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group
                                            label="IT Literacy"
                                            label-for="it_literacy"
                                        >  <b-form-textarea
                                            id="it_literacy"
                                            v-model="OtherQualification.it_literacy"
                                            size="sm"
                                            rows="5"
                                            placeholder="IT Literacy"
                                        ></b-form-textarea>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group
                                            label="Extra-Curricular Activities"
                                            label-for="extra_cur_act"
                                        >  <b-form-textarea
                                            id="extra_cur_act"
                                            v-model="OtherQualification.extra_cur_act"
                                            size="sm"
                                            rows="5"
                                            placeholder="Extra-Curricular Activities"
                                        ></b-form-textarea>
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <b-row class="mt-2">
                                    <b-col md="12">
                                        <h6>Language Proficiency</h6>
                                        <hr>
                                    </b-col>
                                </b-row>


                                <b-row>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Name"
                                            label-for="lName"
                                        >
                                            <b-form-select v-model="OtherQualification.lName" :options="lName"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Exam Name"
                                            label-for="examName"
                                        >
                                            <b-form-input
                                                placeholder="Exam Name" v-model="OtherQualification.examName">
                                            </b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Grade"
                                            label-for="grade"
                                        >
                                            <b-form-input
                                                placeholder="Grade" v-model="OtherQualification.grade">
                                            </b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="2">
                                        <b-form-group
                                            label="Status"
                                            label-for="status"
                                        >
                                            <b-form-select v-model="OtherQualification.status" :options="status"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <b-row>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Name"
                                            label-for="lName"
                                        >
                                            <b-form-select v-model="OtherQualification.lName" :options="lName"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Exam Name"
                                            label-for="examName"
                                        >
                                            <b-form-input
                                                placeholder="Exam Name" v-model="OtherQualification.examName">
                                            </b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Grade"
                                            label-for="grade"
                                        >
                                            <b-form-input
                                                placeholder="Grade" v-model="OtherQualification.grade">
                                            </b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="2">
                                        <b-form-group
                                            label="Status"
                                            label-for="status"
                                        >
                                            <b-form-select v-model="OtherQualification.status" :options="status"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col  md="1" align-self="center">
                                        <b-button  size="md" type="submit" variant="dark">+</b-button>
                                    </b-col>
                                </b-row>


                                <div class="col-md-12 pr-0 d-flex justify-content-end mt-4">
                                    <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Save</b-button>
                                    <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">Cancel</b-button>
                                </div>
                            </b-card>
                        </b-form>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker'
    import SideBar from "../partials/sidebar";
    export default {
        components: { DatePicker, SideBar},
        props: ['id'],
        data() {
            return {
                hidenseek: true,
                OtherQualification: {
                    gpa: '',
                    it_literacy: '',
                    extra_cur_act: ''
                },
                text: '',
                show:true,

                 lName: [
                    { text: "english", value: "english" },
                    { text: "bangla", value: "Bangla" },
                    { text: "other", value: "other" },
                  ],
                status: [
                    { text: "Week", value: "week" },
                    { text: "Normal", value: "normal" },
                    { text: "Strong", value: "strong" },
                  ],

            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Other Qualification"});
         },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                console.log(JSON.parse(JSON.stringify(this.OtherQualification)));
            },
            onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.OtherQualification.gpa = '';
                this.OtherQualification.it_literacy = '';
                this.form.extra_cur_act = '';
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1
            }
        }
    }
</script>

