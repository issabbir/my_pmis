<template>
<div class="row">
    <div class="col-md-12 contentHeader">
        <noticeBar />
        <ol class="breadcrumb p-2 mb-0">
            <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item" v-for="b in breadCrumbs"><a href="#">{{b.label}}</a></li>
        </ol>
    </div>
    <div class="emptyheight"></div>
 </div>
</template>
<script>

import noticeBar from "./noticeBar"
import {mapState} from 'vuex';

export default {
    components: {
        noticeBar,
    },
    computed: {
        ...mapState(['breadCrumbs'])
    },
    mounted() {
    },
    data() {
        return {
        }
    }
}
</script>
