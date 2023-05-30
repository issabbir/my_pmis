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
                    <b-col v-if="families.length > 0 && nominees != null" md="10" sm="12" class="pr-md-0" :class="{'col-md-12':!hidenseek}">
                        <b-tabs>
                            <b-tab title="PENSION" active>
                                <pension-nominee :id="id" used_by="pmis" :families="families" @submitted="loadData" :nominees="nominees"></pension-nominee>
                            </b-tab>
                            <b-tab title="BNF">
                                <bnf-nominee :id="id" used_by="pmis" :families="families" @submitted="loadData" :nominees="nominees"></bnf-nominee>
                            </b-tab>
                            <b-tab title="GPF">
                                <gpf-nominee :id="id" used_by="pmis" :families="families" @submitted="loadData" :nominees="nominees"></gpf-nominee>
                            </b-tab>
                        </b-tabs>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import BNFNominee from "./BNFNominee";
    import GPFNominee from "./GPFNominee";
    import PensionNominee from "./PensionNominee";
    import SideBar from "../partials/sidebar";
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {
            'bnf-nominee':BNFNominee,
            'gpf-nominee':GPFNominee,
            'pension-nominee':PensionNominee,
            SideBar
        },
        props: ['id'],
        data() {
            return {
                hidenseek: true,
                families: [],
                nominees: null
            }
        },
        watch: {

        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Nominee"});
            this.loadFamilies()
            this.loadData()
        },
        methods: {
            loadFamilies(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/families/specific/${this.id}`).then(res => {
                    this.families = res.data.data

                });
            },
            loadData: function() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominees/specific/${this.id}`).then(res => {
                    this.nominees = res.data
                });
            }
        }
    }
</script>

<style>
    .file-upload-form, .image-preview {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        padding: 20px;
    }
    img.preview {
        width: 200px;
        background-color: white;
        border: 1px solid #DDD;
        padding: 5px;
    }
    #nomineepic, #nomineedoc{
        height: 180px !important;
        width: 100%;
    }
</style>
