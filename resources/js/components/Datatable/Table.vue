<template>
    <div>
<!--        <vue-element-loading :active="isLoading" />-->
        <div class="row" v-if="showTop">
            <div class="col-xl col-lg-5 m-b-10">
                <slot name="headerTitle" />
            </div>
            <div class="col-xl col-lg-7">
                <div class="form" v-if="showPerPage">
                    <div class="form-group float-right m-b-10" style="width:86px;" >
<!--                        <v-select-->
<!--                            :options="perPageOptions"-->
<!--                            :value="perPage"-->
<!--                            :on-change="changedPerPage"-->
<!--                            :searchable="false"-->
<!--                            :clearable="false"-->
<!--                        ></v-select>-->
                    </div>
                </div>
                <app-pagination
                    class="m-l-5"
                    v-if="paginationTop && pagination.total >0"
                    @pageChanged="setPage"
                    :pagination="pagination"
                    pagination-class=""
                />
            </div>
        </div>
        <div class="table-responsive-lg">
            <table :class="tableClasses">
                <slot name="header">
                    <thead style="font-size:14px;">
                    <tr>
                        <th
                            v-for="(item, index) in head"
                            v-bind:key="index"
                            :class="item.classes"
                        >
                            <span style="display:flex;">
                                <app-sort-button
                                    v-if="item.sortable"
                                    :name="item.key"
                                    :sorting="activeSort"
                                    :sort-action="sortAction"
                                >
                                    {{ item.name }}
                                </app-sort-button>
                                <template v-else>
                                    <div v-if="item.raw" v-html="item.name"></div>
                                    <div v-else>{{ headerName(item) }}</div>
                                </template>
                            </span>
                        </th>
                    </tr>
                    </thead>
                </slot>
                <template v-if="items.length > 0">
                    <tbody style="font-size:13px;">
                        <template v-for="(item, index) in items">
                            <tr :key="item.id" @click="rowClick(item.id)" :class="rowClass">
                                <slot name="row" :item="item" :index="index"></slot>
                            </tr>
                            <tr :key="`second-${item.id}`" v-if="secondRow">
                                <slot name="second-row" :item="item" :index="index"></slot>
                            </tr>
                        </template>
                    </tbody>
                </template>
                <template v-else>
                    <tbody>
                    <tr><td :colspan="head.length" class="text-center">No records found.</td></tr>
                    </tbody>
                </template>
            </table>
        </div>
        <app-pagination
            v-if="showPaginationDown"
            @pageChanged="setPage"
            :pagination="pagination"
        />
    </div>
</template>

<script>
    //import VueElementLoading from 'vue-element-loading';
    import AppPagination from './Pagination.vue';
    import AppSortButton from './SortButton.vue';
    export default {
        name: 'AppTable',
        components: {
            //VueElementLoading,
            AppPagination,
            AppSortButton,
        },
        props: {
            activeSort: {
                type: String,
            },
            changedPerPage: {
                type: Function,
                default: () => {},
            },
            head: {
                type: Array,
                required: true,
            },
            headerTitle: {
                type: Boolean,
                default: false,
            },
            isLoading: {
                type: Boolean,
                default: false,
            },
            items: {
                type: Array,
                default: () => [],
            },
            pagination: {
                type: Object,
                default: () => ({
                    total: 0,
                }),
            },
            paginationTop: {
                type: Boolean,
                default: false,
            },
            perPage: {
                type: Number,
                default: 30,
            },
            perPageOptions: {
                type: Array,
                default: () => [10, 20, 30, 50, 100],
            },
            secondRow: {
                type: Boolean,
                default: false,
            },
            setPage: {
                type: Function,
            },
            showPerPage: {
                type: Boolean,
                default: false,
            },
            sortAction: {
                type: Function,
                default: () => {},
            },
            tableClasses: {
                type: String,
                default: 'table',
            },
            rowClick: {
                type: Function,
                default: () => {},
            },
            rowClass: {
                type: String,
                default: '',
            },
        },
        computed: {
            showTop() {
                return this.showPerPage || this.showPaginationTop || this.headerTitle;
            },
            showPaginationTop() {
                return this.paginationTop && this.pagination.total > 0;
            },
            showPaginationDown() {
                return this.pagination.total > 0;
            },
        },
        methods: {
            headerName(item) {
                return (typeof item === 'object' ? item.name : item);
            },
        },
    };
</script>
