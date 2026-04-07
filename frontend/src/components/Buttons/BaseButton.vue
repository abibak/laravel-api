<script setup>
import { computed } from 'vue';

const props = defineProps({
    width: {
        type: [Number, String],
        default: 'auto'
    },
    height: {
        type: [Number, String],
        default: 'auto'
    },
    bgc: {
        type: String,
        default: '#3F72AF'
    }
});

const buttonStyles = computed(() => {
    return {
        width: typeof props.width === 'number' ? `${props.width}px` : props.width,
        height: typeof props.height === 'number' ? `${props.height}px` : props.height,
        background: props.bgc
    };
});

</script>

<template>
    <button class="base-button" :style="buttonStyles">
        <slot></slot>
    </button>
</template>

<style lang="scss" scoped>
.base-button {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    border: none;
    outline: none;
    border-radius: 8px;
    cursor: pointer;
}
</style>