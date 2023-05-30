<template>
    <div class="content-body">
        <b-card class="bg-transparent ">
            <b-card-body class="pills-stacked pt-0">
                <b-row>
                    <b-col md="2" sm="12" class="border pr-md-0">
                        <SideBar :empId="id" class="mt-1"></SideBar>
                    </b-col>
                    <b-col md="10" sm="12" class="pr-md-0">
                        <router-view/>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import SideBar from "../pmis/partials/sidebar";
    export default {
        name: "employee",
        components:{SideBar},
        props: ['id'],
    }
</script>

<style scoped>

</style>
