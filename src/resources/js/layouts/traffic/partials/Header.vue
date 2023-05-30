<!--template>
     <div class="content-header row">
                    <div class="content-header-left col-12 mb-0 mt-0">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <h5 class="content-header-title float-left pr-1 mb-0"> &nbsp;</h5>
                                <div class="breadcrumb-wrapper col-12">
                                    <ol class="breadcrumb p-0 mb-0">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a></li>
                                        <li class="breadcrumb-item" v-if="isBreadCrubs" v-for="b in breadCrumbs"><a href="#">{{b.label}}</a></li>
                                     </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</template>
<script>
    export default {
        computed: {
            isBreadCrubs: function() {
                this.breadCrumbs = this.$store.state.breadCrumbs;
                //if(this.breadCrumbs.length>0)
                    return true;
            }
        },
        mounted() {
            this.breadCrumbs = this.$store.getters.breadCrumbs;
        },
        data() {
            return {
                "breadCrumbs":""
            }
        }
    }
</script-->
<template>

</template>
<script>
    export default {
        data(){
            return {
            }
        }
    }
</script>
