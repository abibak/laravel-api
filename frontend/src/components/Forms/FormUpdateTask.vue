<script setup>
import { computed, inject, reactive } from 'vue';
import { STATUS_LIST } from '@/utils/constants';
import { useAPI } from '@/composables/useAPI';
import BaseButton from '../Buttons/BaseButton.vue';

const { loading, put } = useAPI();
const { refreshTasks, toggleFormVisible } = inject('task');

const props = defineProps({
    task: {
        type: Object,
        default: () => { }
    }
});

const form = reactive({
    title: props.task?.title,
    description: props.task?.description,
    status: props.task?.status
});

const isLoading = computed(() => {
    return (loading.value) ? 'Обновление...' : 'Обновить';
});

async function submitForm() {
    const isSubmit = Object.values(form).some(val => val.trim() === '');

    if (isSubmit) {
        alert('Не все поля заполнены');
        return;
    }

    if (loading.value) {
        return;
    }

    try {
        await put('/task/update', form, props.task.id);

        toggleFormVisible('update', false);
        refreshTasks();
    } catch (e) {
        alert('Ошибка отправки данных');
    }
}
</script>

<template>
    <form class="form-update-task" @submit.prevent>
        <p class="form-title">Обновление задачи</p>
        <p v-if="loading"></p>

        <div class="form-update-task__field">
            <label for="title">Заголовок</label>
            <input type="text" name="title" id="title" v-model="form.title">
        </div>

        <div class="form-update-task__field">
            <label for="description">Описание</label>
            <textarea name="description" id="description" v-model="form.description"></textarea>
        </div>

        <div class="form-update-task__field">
            <label for="status">Статус</label>
            <select name="status" id="status" v-model="form.status">
                <option v-for="(value, key) in STATUS_LIST" :value="key">{{ value }}</option>
            </select>
        </div>

        <div class="form-update-buttons">
            <BaseButton :width="150" :height="40" @click="submitForm">{{ isLoading }}</BaseButton>
            <BaseButton :width="150" :height="40" bgc="#C44A3A" @click="toggleFormVisible('update', false)">Отмена</BaseButton>
        </div>

    </form>
</template>

<style lang="scss" scoped>
.form-update-task {
    display: flex;
    flex-direction: column;
    width: 50%;
    padding: 15px;
    border-radius: 8px;
    background: #EEEEEE;
    box-shadow: 3px 3px 10px 2px #474747;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);

    .form-title {
        font-size: 28px;
        margin-bottom: 14px;
    }

    &__field {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;

        label {
            margin-bottom: 8px;
        }

        input,
        textarea,
        select {
            max-width: 100%;
            min-width: 100%;
            border-radius: 4px;
            outline: none;
            border: 1px solid #3F72AF;
            padding: 5px 10px;
        }

        textarea {
            min-height: 150px;
        }
    }

    .form-update-buttons {
        display: flex;
        gap: 10px;
    }
}
</style>