<script setup>
import { useAPI } from '@/composables/useAPI';
import { inject } from 'vue';
import { useRouter } from 'vue-router';
import BaseButton from '@/components/Buttons/BaseButton.vue';

const router = useRouter();
const { destroy } = useAPI();
const { refreshTasks, setSelectedTaskId, toggleFormVisible } = inject('task');

const props = defineProps({
    task: {
        type: Object,
        default: () => ({
            title: '',
            description: '',
            status: ''
        }),
    },
});

async function deleteTask(id) {
    if (!id) {
        return;
    }

    try {
        await destroy('/task/delete', id);
        alert('Задача удалена');
        refreshTasks();
    } catch (e) {
        console.error('Ошибка удаления данных', e);
    }
}

</script>

<template>
    <div class="task">
        <p class="task__title">{{ task.title }}</p>
        <p class="task__description" v-if="task?.fullView">Описание: {{ task.description }}</p>
        <p class="task__status">Статус: {{ task.status_text }}</p>

        <div class="task_controls" v-if="!task?.fullView">
            <BaseButton bgc="none" class="task_controls__item task__view" @click="router.push(`/task/${task.id}`)">
                просмотреть</BaseButton>
            <BaseButton bgc="none" class="task_controls__item task__edit"
                @click="toggleFormVisible('update', true), setSelectedTaskId(task.id)">
                редактировать
            </BaseButton>
            <BaseButton bgc="none" class="task_controls__item task__delete" @click="deleteTask(task.id)">
                удалить
            </BaseButton>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.task {
    margin-bottom: 30px;

    &:last-child {
        margin-bottom: 0;
    }

    &__title {
        font-size: 20px;
        margin-bottom: 5px;
    }

    &__description {
        margin-bottom: 5px;
    }

    .base-button {
        font-size: 14px;
    }

    .task_controls {
        display: flex;
        gap: 10px;
        margin-top: 12px;

        &__item {
            text-decoration: none;
            font-size: 14px;
        }
    }

    &__view,
    &__edit {
        color: #808080;
    }

    &__delete {
        color: rgb(196, 74, 58);
    }

    &__status {
        font-size: 14px;
    }
}
</style>