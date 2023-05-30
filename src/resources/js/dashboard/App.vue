<template>
    <div class="container-fluid">
        <BackgroundProcess></BackgroundProcess>
        <div class="main-content">
            <app-notifiction></app-notifiction>
            <Header></Header>
            <BreadCrumb/>
            <section>
                <router-view/>
            </section>
            <Footer></Footer>
        </div>
    </div>
</template>

<script>

import header from "../layouts/main_dashboard/partials/Header";
import footer from "../layouts/main_dashboard/partials/Footer";
import BreadCrumb from "../layouts/common/breadcumb";
import AppNotifiction from "../layouts/common/Notification";
import BackgroundProcess from "../layouts/common/BackgroundProcess";

export default {
    components: {
        'Header': header,
        'Footer': footer,
        BreadCrumb,
        AppNotifiction,
        BackgroundProcess
    },
    created() {

    },
    data() {
        return {
            "request": 0,
            fullPage: true,
        }
    },
    methods: {
        showLoading: function () {
            this.loader = this.$loading.show({
                // Optional parameters
                container: this.fullPage ? null : this.$refs.formContainer,
                canCancel: true,
                onCancel: this.onCancel,
                loader: 'dots'
            });
        },
        hideLoading: function () {
            this.loader.hide();
        }
    },
};
</script>
<style>
    .vs__dropdown-toggle{
        min-height: 38px!important;
    }
    .form-control, .form-group .form-control {
        background-color: white!important;
    }
    .show {
        visibility: visible!important;
    }
    .header-navbar .navbar-container ul.nav li.dropdown-user .dropdown-menu-right {
        top: 6rem;
    }
    .breadcrumb .breadcrumb-item a {
        color: #596F88!important;
    }
</style>
