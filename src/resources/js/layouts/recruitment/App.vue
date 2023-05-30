<template>
    <div class="main-content">
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
    export default {
        data() {
          return {
              "request": 0,
          }
        },
        components : {
            'Header': header,
            'Footer': footer,
             BreadCrumb
        }
    }
</script>
