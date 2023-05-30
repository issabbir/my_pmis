<template>
    <div class="main-content">
        <app-notifiction></app-notifiction>
        <Header></Header>
        <BreadCrumb />
        <section>
            <router-view />
        </section>
        <Footer></Footer>
    </div>
</template>
<script>
    import header from './partials/Header';
    import BreadCrumb from "../common/breadcumb";
    import footer from './partials/Footer';
    import AppNotifiction from "../common/Notification";
    export default {
        created() {
            this.baseaccount = this.$route.params.baseaccount;
        },
        data() {
          return {
              "request": 0,
          }
        },
        components : {
            'Header': header,
            'Footer': footer,
             BreadCrumb,
            AppNotifiction
        }
    }
</script>

<style>
    .vs__dropdown-toggle{
        min-height: 38px!important;
    }
</style>
