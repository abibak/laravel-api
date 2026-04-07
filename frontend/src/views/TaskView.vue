<script setup>
import { useRoute } from 'vue-router';
import { useAPI } from '@/composables/useAPI';
import { onMounted, computed } from 'vue';
import TaskItem from '@/components/Task/TaskItem.vue';

const route = useRoute();
const { data, loading, get } = useAPI();

const taskId = route.params.id;

onMounted(async () => {
    await get('task/get', taskId);
});

const task = computed(() => {
    return Object.assign(data.value?.data ?? {}, {
        fullView: true,
    });
});
</script>

<template>
    <div class="task-view">
        <TaskItem v-if="!loading" :task="task"></TaskItem>
    </div>
</template>

<style lang="scss" scoped></style>