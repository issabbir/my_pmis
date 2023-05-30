<template>
    <notifications group="pmis" position="top center" width="500">
        <template slot="body" slot-scope="props">
            <div v-if="props.item.type == 'success'" class="alert alert-dismissible alert-success">
                <h4 class="alert-heading">{{props.item.title}}</h4>
                <button type="button" class="close" data-dismiss="alert" @click="props.close">&times;</button>
                {{props.item.text}}
            </div>
            <div v-else class="alert alert-dismissible alert-danger">
                <h4 class="alert-heading">{{props.item.title}}</h4>
                <button type="button" class="close" data-dismiss="alert" @click="props.close">&times;</button>
                {{props.item.text}}
            </div>
        </template>
    </notifications>
</template>
<script>

    export default {
        mounted() {
        }
    }

</script>
