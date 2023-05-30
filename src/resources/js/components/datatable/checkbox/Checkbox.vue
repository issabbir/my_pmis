<template>
    <b-form-checkbox size="lg" @click="click(data)"></b-form-checkbox>
</template>
<script>
    export default {
        props: {
            data: {},
            name: {},
            click: {},
            meta: {},
            classes: {},
        }
    }
</script>