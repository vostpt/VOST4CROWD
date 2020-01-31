<template>
    <tbody style="font-size:13px;">
    <template v-for="(item, index) in items">
        <tr :key="item.id" @click="rowClick(item.id)" :class="rowClass">
            <slot name="row" :item="item" :index="index"></slot>
        </tr>
        <tr :key="`second-${item.id}`" v-if="showSecondRow">
            <slot name="second-row" :item="item" :index="index"></slot>
        </tr>
    </template>
    </tbody>
</template>

<script>
    export default {
        props: {
            items: {
                type: Array,
                default: () => [],
            },
            showSecondRow: {
                type: Boolean,
                default: false,
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
    };
</script>
