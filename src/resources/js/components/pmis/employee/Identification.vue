<template>
    <div class="content-body">
        <b-card class="bg-transparent">
            <b-card-body class="pills-stacked  pt-0">
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <!--<b-col md="10" sm="12" class="border-right pr-md-0">
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                            <b-row class="justify-content-md-center">
                                <b-col md="2" class="text-center">
                                    <h4 class="text-center">Picture</h4>
                                    <b-card class="m-0">
                                        <b-card-text>
                                            <img id="profilepic" src="../../../../images/portrait/small/avatar.png"  class="img-fluid" alt="...">
                                        </b-card-text>
                                    </b-card>
                                    <b-form-file v-model="identification.uploadprofilepic" class="mt-3" id="uploadprofilepic" plain hidden></b-form-file>
                                    <label style="width:100%" tabindex="0" for="uploadprofilepic" class="btn btn-primary ">Upload</label>
                                </b-col>
                                <b-col md="2" class="text-center">
                                    <h4 class="text-center">Retina</h4>
                                    <b-card class="m-0">
                                        <b-card-text>
                                            <img id="file" src="../../../../images/portrait/small/retina.png"  class="img-fluid" alt="...">
                                        </b-card-text>
                                    </b-card>
                                    <b-form-file v-model="identification.uploadretina" class="mt-3" id="uploadretina" plain hidden></b-form-file>
                                    <label style="width:100%" tabindex="0" for="uploadretina" class="btn btn-primary ">Upload</label>
                                </b-col>
                                <b-col md="2" class="text-center">
                                    <h4 class="text-center">Signature</h4>
                                    <b-card class="m-0">
                                        <b-card-text>
                                            <img id="signature" src="../../../../images/portrait/small/signature.png"  class="img-fluid" alt="...">
                                        </b-card-text>
                                    </b-card>
                                    <b-form-file v-model="identification.uploadsignature" class="mt-3" plain hidden id="uploadsignature"></b-form-file>
                                    <label style="width:100%" tabindex="0" for="uploadsignature" class="btn btn-primary ">Upload</label>
                                </b-col>
                            </b-row>
                            <b-row class="justify-content-md-center">
                                <b-col md="12" class="mt-1 mb-2 border-bottom">
                                    <h4>Biometric</h4>
                                </b-col>
                                <b-col md="2" class="text-center">
                                    <b-card class="m-0">
                                        <b-card-text>
                                            <img  src="../../../../images/portrait/small/Fingerprint.png"  class="img-fluid" alt="...">
                                        </b-card-text>
                                    </b-card>
                                    <label style="width:100%" tabindex="0" for="Fingerprint1" class="btn btn-primary ">R Thumb</label>
                                </b-col>
                                <b-col md="2" class="text-center">
                                    <b-card class="m-0">
                                        <b-card-text>
                                            <img  src="../../../../images/portrait/small/Fingerprint.png"  class="img-fluid" alt="...">
                                        </b-card-text>
                                    </b-card>
                                    <label style="width:100%" tabindex="0" for="Fingerprint2" class="btn btn-primary ">R Fore</label>
                                </b-col>
                                <b-col md="2" class="text-center">
                                    <b-card class="m-0">
                                        <b-card-text>
                                            <img  src="../../../../images/portrait/small/Fingerprint.png"  class="img-fluid" alt="...">
                                        </b-card-text>
                                    </b-card>
                                    <label style="width:100%" tabindex="0" for="Fingerprint3" class="btn btn-primary ">L Thumb</label>
                                </b-col>
                                <b-col md="2" class="text-center">
                                    <b-card class="m-0">
                                        <b-card-text>
                                            <img  src="../../../../images/portrait/small/Fingerprint.png"  class="img-fluid" alt="...">
                                        </b-card-text>
                                    </b-card>
                                    <label style="width:100%" tabindex="0" for="Fingerprint4" class="btn btn-primary ">L Fore</label>
                                </b-col>
                            </b-row>
                            <div class="col-md-11 pr-0 d-flex justify-content-center mt-2">
                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Save</b-button>
                                <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">Cancel</b-button>
                            </div>

                        </b-form>
                    </b-col>-->
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    import SideBar from "../partials/sidebar";
    import employee from '../../../json/employee.json'; //data edit
    // json.forEach(x => { console.log(x.emp_id, x.lastname); });

    export default {
        components: { DatePicker, SideBar},
        props: ['id'],
        data() {
            return {
                identification:{
                    uploadprofilepic:'',
                    uploadretina:'',
                    uploadsignature:'',
                },
                show: true
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Identification"});
         },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                console.log(JSON.stringify(this.identification))
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

