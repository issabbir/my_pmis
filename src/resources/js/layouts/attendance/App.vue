<template>
    <div class="container-fluid">
    <BackgroundProcess></BackgroundProcess>
        <div class="main-content">
            <app-notification></app-notification>
            <Header></Header>
            <BreadCrumb />
            <section>
                <router-view />
            </section>
            <Footer></Footer>
        </div>
    </div>
</template>
<script>
    import header from './partials/Header';
    import BreadCrumb from "../common/breadcumb";
    import BackgroundProcess from "../common/BackgroundProcess";
    import AppNotification from "../common/Notification";
    import footer from './partials/Footer';

    export default {
        created() {
        },
        data() {
          return {
              "request": 0,
              fullPage: true,
          }
        },
        methods: {
        },
        components : {
            'Header': header,
            'Footer': footer,
             BreadCrumb,
            AppNotification,
            BackgroundProcess
        }
    }
</script>
<style>
    .vs__dropdown-toggle{
        min-height: 38px!important;
    }
</style>

