<template>
    <button :class="classes" @click="click(data)" title="Update">
        <span>
            <i class="bx bx-edit cursor-pointer"></i><!--{{ name }}-->
        </span>
    </button>
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