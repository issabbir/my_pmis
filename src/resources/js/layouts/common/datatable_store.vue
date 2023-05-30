<template>
    <b-row>
        <b-col>
            <b-row>
                <b-col striped :sm="pageSize" :md="pageSize" class="my-1">
                    <b-form-group
                        label="Per page"
                        label-cols-sm="6"
                        label-cols-md="6"
                        label-cols-lg="6"
                        label-align-sm="left"
                        label-size="sm"
                        label-for="perPageSelect"
                        class="mb-0"
                        >
                        <b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>
                    </b-form-group>
                </b-col>
                <b-col :sm="searchSize" :md="searchSize" class="my-1 ml-auto">
                    <b-input-group size="sm">
                        <b-form-input
                            v-model="rawInput"
                            type="search"
                            label-align-sm="right"
                            id="filterInput"
                            placeholder="Type to Search"
                            :debounce="200"
                            ></b-form-input>
                        <b-input-group-append>
                            <b-button class="data-table-filter" :disabled="!filter" @click="clear()">Clear</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-col>
            </b-row>
            <b-table
                striped
                hover
                show-empty
                small
                :items="items"
                :current-page="currentPage"
                :per-page="perPage"
                :filter="filter"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :sort-direction="sortDirection"
                :fields="fields"
                :primary-key="primaryKeyColumnName"
                :filter-ignored-fields="filterIgnoredFields"
                :filter-included-fields="filterIncludedFields"
                :tbody-tr-class="tbodyTrClass"
                responsive
                @filtered="onFiltered"
                >
                <template v-slot:cell(index)="row" v-if="currentPage <= 1">
                        {{ (row.index + 1) }}
                </template>

                <template v-slot:cell(index)="row" v-else>
                    {{ (perPage * (currentPage-1)) + (row.index + 1) }}
                </template>

                <template v-slot:cell(action)="row" v-bind:row="row">
                      <slot name="actions" :rows="row"></slot>
                </template>
                <template v-slot:cell(action7)="row" v-bind:row="row">
                          <slot name="action7" :rows="row"></slot>
                </template>
                <template v-slot:cell(action2)="row" v-bind:row="row">
                          <slot name="action2" :rows="row"></slot>
                </template>
                <template v-slot:cell(action8)="row" v-bind:row="row">
                          <slot name="action8" :rows="row"></slot>
                </template>
                <template v-slot:cell(action3)="row" v-bind:row="row">
                          <slot name="action3" :rows="row"></slot>
                </template>
                <template v-slot:cell(action4)="row" v-bind:row="row">
                          <slot name="action4" :rows="row"></slot>
                </template>
                <template v-slot:cell(action5)="row" v-bind:row="row">
                          <slot name="action5" :rows="row"></slot>
                </template>
                <template v-slot:cell(action6)="row" v-bind:row="row">
                    <slot name="action6" :rows="row"></slot>
                </template>
                <template v-slot:row-details="row" v-bind:row="row">
                    <slot name="row-details" :rows="row"></slot>
                </template>
                <template v-slot:head(head1)="row" v-bind:row="row">
                    <slot name="head1" :rows="row"></slot>
                </template>
                <template v-slot:cell(head1)="row" v-bind:row="row">
                    <slot name="headCell1" :rows="row"></slot>
                </template>
                <template v-slot:head(head2)="row" v-bind:row="row">
                    <slot name="head2" :rows="row"></slot>
                </template>
                <template v-slot:cell(head2)="row" v-bind:row="row">
                    <slot name="headCell2" :rows="row"></slot>
                </template>
            </b-table>
            <b-row>
                <b-col sm="12" md="12" class="mt-0">
                    <b-pagination
                        v-model="currentPage"
                        :total-rows="totalList"
                        :per-page="perPage"
                        align="right"
                        size="sm"
                        class="my-0"
                        ></b-pagination>
                </b-col>
            </b-row>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        data() {
            return {
                rawInput: null,
                perPage: 10,
                totalRows: 1,
                currentPage: 1,
                pageOptions: [5, 10, 15,50,{
                    value: Number.MAX_SAFE_INTEGER,
                    text: "Show All"
                }],
                sortDesc: false,
                sortDirection: "asc",
                filter: null,
                filterOn: [],
                pageSize: (this.pageColSize != undefined) ? this.pageColSize : '2',
                searchSize: (this.searchColSize != undefined) ? this.searchColSize : '3',
            };
        },
        props: ["totalList","tbodyTrClass","fields", "items", "pageColSize", "searchColSize", "primaryKeyColumnName", "filterIgnoredFields", 'filterIncludedFields','sortBy'],
        mounted() {
            this.totalRows = this.items.length;
            this.$store.commit("setPerPage",this.perPage);
        },
        methods: {
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            },
            clear() {
                this.filter = ''
                this.rawInput = '';
            }
        },
        computed: {},
        created() {
            // Use a non-reactive property to prevent
            // unnecessary re-renders of your component
            this.$_timeout = null;
        },
        beforeDestroy() {
            // Ensure that any pending timeout is cleared on destroy
            clearTimeout(this.$_timeout)
        },
        watch: {
            rawInput(newVal, oldVal) {
                clearTimeout(this.$_timeout)
                this.$_timeout = setTimeout(() => {
                    this.filter = newVal;
                }, 150) // set this value to your preferred debounce timeout
            }
        }
    };
</script>
