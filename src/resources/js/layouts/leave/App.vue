<template>
    <div class="container-fluid">
        <BackgroundProcess></BackgroundProcess>
        <div class="main-content">
            <app-notifiction></app-notifiction>
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
    import AppNotifiction from "../common/Notification";
    import footer from './partials/Footer';
    import BackgroundProcess from "../common/BackgroundProcess";

    export default {
        created() {
            // axios.interceptors.request.use((config) => {
            //     this.showLoading();
            //     return config;
            // }, (error) => {
            //     this.hideLoading();
            //     return Promise.reject(error);
            // });
            //
            // axios.interceptors.response.use((response) => {
            //     this.hideLoading();
            //     return response;
            // }, (error) => {
            //     if (error.response.status === 419 || error.response.status === 401) {
            //         //Todo: do something if authorized
            //     }
            //     this.hideLoading();
            //     return Promise.reject(error);
            // });
        },
        data() {
          return {
              "request": 0,
              fullPage: true,
          }
        },
        methods: {
            showLoading: function() {
                this.loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                    loader: 'dots'
                });
            },
            hideLoading: function() {
                this.loader.hide();
            }
        },
        components : {
            'Header': header,
            'Footer': footer,
             BreadCrumb,
            AppNotifiction,
            BackgroundProcess
        }
    }
</script>

<style>
    .vs__dropdown-toggle{
        min-height: 38px!important;
    }
</style>
