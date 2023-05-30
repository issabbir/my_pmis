<template>
  <div class="content-wrapper">
        <div class="content-body">
            <b-card>
            <b-row>
                <b-col>
                   <h6>Asst. System Analyst</h6>
                   <p>Total post #10</p>  
                   <br>
                   <p>Permanent Position</p>
                   <br>
                   <p>Salery: 35000 - 60000 (Garde-10)</p>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                   <h6>Job Description</h6>
                        <ul>
                            <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</li>
                            <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</li>
                            <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</li>
                            <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</li>
                            <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</li>
                            <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</li>
                            <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</li>
                        </ul>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                   <h6>Special Instruction</h6>
                   <p>Bank Draft, Quata and other relevent information will go there.</p>
                </b-col>
            </b-row>
            </b-card>
        </div>
  </div>
</template>

<script>
    export default {
        name: "CircularPublication",
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Online Recruitment" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Application Short List" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Publication View" });
            //this.totalRows = this.items.length
        },
    }
</script>

<style scoped>

</style>
