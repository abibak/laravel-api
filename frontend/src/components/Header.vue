<script setup>
import { inject } from 'vue';
import BaseButton from './Buttons/BaseButton.vue';

const { toggleFormVisible } = inject('task');
</script>

<template>
    <div class="header">
        <div class="header-panel">
            <BaseButton :width="150" :height="40" @click="toggleFormVisible('create', true)">
                Создать задачу
            </BaseButton>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.header {
    margin-bottom: 30px;

    .header-panel {
        display: flex;
    }
}
</style>