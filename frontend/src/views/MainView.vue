<script setup>
import { inject, computed } from 'vue';
import FormCreateTask from '@/components/Forms/FormCreateTask.vue';
import FormUpdateTask from '@/components/Forms/FormUpdateTask.vue';
import TaskList from '@/components/Task/TaskList.vue';
import Header from '@/components/Header.vue';

const { taskForms, tasks, taskSelectedId } = inject('task');

const isTaskList = computed(() => {
    return tasks.value.length > 0;
});

const getTask = computed(() => {
    return tasks.value.filter(task => task.id === taskSelectedId.value)[0] ?? {};
});

</script>

<template>
    <div class="main-view">
        <Header></Header>

        <TaskList v-if="isTaskList" :tasks="tasks"></TaskList>
        <FormCreateTask v-if="taskForms.create"></FormCreateTask>
        <FormUpdateTask v-if="taskForms.update" :task="getTask"></FormUpdateTask>
    </div>
</template>

<style lang="scss" scoped></style>