<script setup>
import TaskItem from './TaskItem.vue';

const props = defineProps({
    tasks: {
        type: Array,
        default: () => []
    }
});

</script>

<template>
    <div class="task-list">
        <TaskItem v-for="task in props.tasks" :task="task"></TaskItem>
    </div>
</template>

<style lang="scss" scoped>
.task {
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}
</style>