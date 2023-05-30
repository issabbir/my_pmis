<template>
    <div>
        <!--h1>division page sdf sadfsdfsdfsd</h1-->
    <div class="content-wrapper">
                <div class="content-body">
            <b-row>
                <b-col>
                    <b-card>
                        <b-form @submit="onSubmit" @reset="onReset" v-if="show" class="form form-vertical col-md-8 offset-md-2">
                            <b-row class="d-flex justify-content-center mt-3">
                                <b-col class="col-md-6 col-12">
                                    <fieldset class="border p-2">
                                            <legend class="w-auto ">Login</legend>
                                               <b-row class="my-1">
                                                    <b-col sm="12">
                                                        <b-form-group id="input-group-2" label="MOBILE NUMBER:" label-for="mobileNumber">
                                                            <b-form-input
                                                            id="mobileNumber"
                                                            v-model="form.mobileNumber"
                                                            required
                                                            placeholder="Mobile Number"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col> <b-col sm="12">
                                                        <b-form-group id="input-group-3" label="PASSWORD:" label-for="password">
                                                           <b-form-input
                                                            id="password"
                                                            v-model="form.password"
                                                            required
                                                            placeholder="Password"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>

                                                </b-row>
                                    </fieldset>
                                 </b-col>
                            </b-row>
                            <b-row class="d-flex justify-content-center mt-3">
                                    <b-button type="submit"  class="btn btn-dark shadow mr-1 mb-1">Submit</b-button> &nbsp;
                                    <b-button type="reset" class="btn btn-outline-dark  mb-1">Clear</b-button>
                           </b-row>
                        </b-form>
                    </b-card>
                </b-col>
            </b-row>


        </div>


    </div>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker'
    export default {
        components: { DatePicker },
        data(){
           return {
                datetime: new Date(),
                form: {
                fullName: '',
                mobileNumber: '',
                },
                show: true,
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                infoModal: {
                id: 'info-modal',
                title: '',
                content: ''
                }
              }
         },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Online Recruitment" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Application Short List" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Login" });
            this.totalRows = this.items.length
        },
         methods: {
              onSubmit(evt) {
                evt.preventDefault()
                console.log(JSON.stringify(this.form))
                },
                onReset(evt) {
                    evt.preventDefault()
                    // Reset our form values
                    this.form.fullName = ''
                    this.form.mobileNumber = ''
                    // Trick to reset/clear native browser form validation state
                    this.show = false
                    this.$nextTick(() => {
                    this.show = true
                    })
             },
              info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`
                this.infoModal.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            resetInfoModal() {
                this.infoModal.title = ''
                this.infoModal.content = ''
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
      }

    }

</script>


<style scoped>

</style>
