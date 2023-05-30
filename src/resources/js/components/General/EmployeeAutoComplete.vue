<template>
    <v-select label="name" :filterable="false" :options="options" @search="onSearch">
        <template slot="no-options">
            type to search GitHub repositories..
        </template>
        <template slot="option" slot-scope="option">
            <div class="d-center">
                <img :src='option.owner.avatar_url'/>
                {{ option.full_name }}
            </div>
        </template>
        <template slot="selected-option" slot-scope="option">
            <div class="selected d-center">
                <img :src='option.owner.avatar_url'/>
                {{ option.full_name }}
            </div>
        </template>
    </v-select>
</template>

<script>
    import Autocomplete from 'vuejs-auto-complete'
    export default {
        props: {
            data: {},
            name: {},
            click: {},
            meta: {},
            classes: {},
        },
        components: {
            Autocomplete
        },
        methods: {
            onSearch(search, loading) {
                loading(true);
                this.search(loading, search, this);
            },
            search: _.debounce((loading, search, vm) => {
                fetch(
                    `https://api.github.com/search/repositories?q=${escape(search)}`
                ).then(res => {
                    res.json().then(json => (vm.options = json.items));
                    loading(false);
                });
            }, 350)
        }
    }
</script>