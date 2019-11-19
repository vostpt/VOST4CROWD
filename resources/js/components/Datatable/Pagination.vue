<template>
    <nav :class="paginationClass">
        <ul class="pagination justify-content-end ">
            <li :class="['page-item', { 'disabled': pagination.current_page === 1 }]">
                <a @click.stop.prevent="pageChanged('first')" class="page-link" href="#" tabindex="-1">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">First</span>
                </a>
            </li>
            <li :class="['page-item', { 'disabled': pagination.current_page === 1 }]">
                <a @click.stop.prevent="pageChanged('previous')" class="page-link" href="#" tabindex="-1">
                    <span aria-hidden="true">&lsaquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li v-if="leftHiding" class="page-item disabled">
                <span aria-hiddden="true" class="page-link">&hellip;</span>
            </li>
            <li v-for="n in numbersToShow" v-bind:key="n" :class="['page-item', { 'active': n === pagination.current_page }]">
                <a @click.stop.prevent="pageChanged(n)" class="page-link" href="#">
                    {{ n }}
                    <span class="sr-only">[current]</span>
                </a>
            </li>
            <li v-if="rightHiding" class="page-item disabled">
                <span aria-hiddden="true" class="page-link">&hellip;</span>
            </li>
            <li :class="['page-item', { 'disabled': pagination.current_page === pagination.total_pages }]">
                <a @click.stop.prevent="pageChanged('next')" class="page-link" href="#">
                    <span aria-hidden="true">&rsaquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            <li :class="['page-item', { 'disabled': pagination.current_page === pagination.total_pages }]">
                <a @click.stop.prevent="pageChanged('last')" class="page-link" href="#">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Last</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: 'AppPagination',
        props: {
            pagination:
                {
                    type: Object,
                },
            numberOfLinks: {
                type: Number,
                default: 5,
            },
            paginationClass: {
                type: String,
                default: 'm-t-30',
            },
        },
        computed: {
            numbersToShow() {
                const total = this.pagination.total_pages;
                if (total <= this.numberOfLinks) return total;
                const pages = [];
                const currentPage = this.pagination.current_page;
                const down = Math.floor(this.numberOfLinks / 2);
                let startingNumber = null;
                let endNumber = null;
                startingNumber = currentPage - down;
                endNumber = currentPage + down;
                // if starting is less than one
                if (startingNumber < 1) {
                    startingNumber = 1;
                    endNumber = 1 + (down * 2);
                }
                // if ending is more than total
                if (endNumber > total) {
                    endNumber = total;
                    startingNumber = total - (down * 2);
                }
                for (let i = startingNumber; i <= endNumber; i += 1) {
                    pages.push(i);
                }
                return pages;
            },
            leftHiding() {
                return this.numbersToShow[0] > 1;
            },
            rightHiding() {
                return this.numbersToShow[this.numbersToShow.length - 1] < this.pagination.total_pages;
            },
        },
        methods: {
            pageChanged(pageNumber) {
                let number = 0;
                switch (pageNumber) {
                    case 'first':
                        number = 1;
                        break;
                    case 'last':
                        number = this.pagination.total_pages;
                        break;
                    case 'previous':
                        number = this.pagination.current_page - 1;
                        break;
                    case 'next':
                        number = this.pagination.current_page + 1;
                        break;
                    default:
                        number = pageNumber;
                        break;
                }
                this.$emit('pageChanged', number);
            },
        },
    };
</script>
