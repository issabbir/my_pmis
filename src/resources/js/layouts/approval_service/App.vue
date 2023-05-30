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
    import AppNotifiction from "../common/Notification";
    import footer from './partials/Footer';

    export default {
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
            AppNotifiction
        }
    }
</script>

