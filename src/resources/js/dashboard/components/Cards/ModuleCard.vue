<template>
    <md-card>
<!--        <b-row>-->
<!--            <b-col striped :sm="pageSize" :md="pageSize" class="my-1">-->
<!--                <b-form-group-->
<!--                    label="Per page"-->
<!--                    label-cols-sm="6"-->
<!--                    label-cols-md="6"-->
<!--                    label-cols-lg="6"-->
<!--                    label-align-sm="left"-->
<!--                    label-size="sm"-->
<!--                    label-for="perPageSelect"-->
<!--                    class="mb-0">-->
<!--                    <b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>-->
<!--                </b-form-group>-->
<!--            </b-col>-->
<!--            <b-col :sm="searchSize" :md="searchSize" class="my-1 ml-auto">-->
<!--                <b-input-group size="sm">-->
<!--                    <b-form-input-->
<!--                        v-model="rawInput"-->
<!--                        type="search"-->
<!--                        label-align-sm="right"-->
<!--                        id="filterInput"-->
<!--                        placeholder="Type to Search"-->
<!--                        :debounce="200"-->
<!--                    ></b-form-input>-->
<!--                    <b-input-group-append>-->
<!--                        <b-button class="data-table-filter" :disabled="!filter" @click="clear()">Clear</b-button>-->
<!--                    </b-input-group-append>-->
<!--                </b-input-group>-->
<!--            </b-col>-->
<!--        </b-row>-->
        <b-row :per-page="perPage"
               :current-page="currentPage"
               :filter="filter">
            <b-col md="4"
                   v-for="(menu, index) in menus.slice(6*(currentPage-1),6*(currentPage))"
                   v-bind:key="menu"
                   :key="index"
                   @filtered="onFiltered">
                <b-card style="max-width: 20rem;"
                        class="mb-2 bg-secondary">
                    <h4 class="card-title">{{ menu.menu_name }}</h4>
                </b-card>
            </b-col>
        </b-row>
        <b-row>
            <b-col sm="12" md="12" class="mt-0">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="rows"
                    :per-page="perPage"
                    align="right"
                    size="sm"
                    class="my-0"
                ></b-pagination>
            </b-col>
        </b-row>
    </md-card>
</template>

<script>
    export default {
        name: "ModuleCard",
        data() {
            return {
                perPage: 6,
                currentPage:1,
                rawInput: null,
                filter: null,
                pageOptions: [5, 10, 15,31],
                pageSize: (this.pageColSize != undefined) ? this.pageColSize : '2',
                searchSize: (this.searchColSize != undefined) ? this.searchColSize : '3',
            };
        },
        watch: {
            rawInput(newVal, oldVal) {
                clearTimeout(this.$_timeout)
                this.$_timeout = setTimeout(() => {
                    this.filter = newVal;
                }, 150) // set this value to your preferred debounce timeout
            }
        },
        computed: {
            menus() {
                return this.$store.getters.menus
            },
            rows(){
                return this.menus.length
            }
        },
        methods: {
            clear() {
                this.filter = ''
                this.rawInput = '';
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            }
        },
        mounted() {
            this.$store.dispatch("getMenues");
        }
    }
</script>

<style scoped>
    .card .card-title {
        color: white;
    }
</style>
