<template>
    <button class="sympl-thead-button" @click="sortAction(name)">
        <i class="fa" :class="currentClass"></i>
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                required: true,
            },
            sorting: {
                type: String,
                required: true,
            },
            sortAction: {
                type: Function,
                default: () => {},
            },
        },
        computed: {
            currentClass() {
                const result = [];
                if (this.name === this.sorting) {
                    result.push('fa-long-arrow-alt-up');
                } else if (this.sorting === `-${this.name}`) {
                    result.push('fa-long-arrow-alt-down');
                } else {
                    result.push('fa-exchange-alt fa-rotate-90 text-muted');
                }
                return result;
            },
        },
    };
</script>

<style>
</style>
