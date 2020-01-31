<template>
    <div>
        <b-row class="mt-3">
            <b-col>
                <b-card >
                    <app-table
                        :items="items"
                        :pagination="pagination"
                        table-classes="table table-responsive-lg"
                        :is-loading="false"
                        :set-page="setPage"
                        :head="tableHead"
                        :sort-action="sortBy"
                        :active-sort="queryStr.sort"
                    ></app-table>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import AppTable from '../../components/Datatable/Table'
    export default {
        components: {
            AppTable,
        },
        data() {
            return {
                items: [],
                pagination: {},
                tableHead: [
                    { name: 'abc', key: 'channel' },
                    { name: 'xyz', key: 'status' },
                    { name: 'xyz', key: 'status' },
                    { name: 'xyz', key: 'status' },
                    { name: 'xyz', key: 'status' },
                ],
                queryStr: {
                    page: {
                        number: 1,
                        size: 5,
                    },
                    sort: null,
                },
            }
        },
        methods: {
            sortBy() {},
            setPage(pageNumber) {
                this.queryStr.page.number = pageNumber;
            },
        }
    }
</script>
