<template>
    <div>
        <loading :active.sync="backgroundProcess" :loader="loader" :color="color"
             :can-cancel="true"
             :on-cancel="onCancel"
             :is-full-page="fullPage"></loading>
    </div>
</template>
<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import {mapState} from 'vuex';
export default {
    name:'background',
    components: {
        Loading
    },
    computed: {
        ...mapState(['backgroundProcess'])
    },
    mounted() {
    },
    data() {
        return {
            fullPage:true,
            loader:'bars',
            color:'#00E7F7'
        }
    },
    methods: {
        onCancel() {
            console.log('User cancelled the loader.')
        }
    }
}

</script>
