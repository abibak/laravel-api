<script setup>
import { computed, inject, reactive } from 'vue';
import BaseButton from '../Buttons/BaseButton.vue';
import { STATUS_LIST } from '@/utils/constants';
import { useAPI } from '@/composables/useAPI';

const { loading, post } = useAPI();
const { refreshTasks, toggleFormVisible } = inject('task');

const form = reactive({
    title: '',
    description: '',
    status: ''
});

const isLoading = computed(() => {
    return (loading.value) ? 'Создание...' : 'Создать';
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
        await post('/task/create', form);

        toggleFormVisible('create', false);
        refreshTasks();
    } catch (e) {
        console.alert('Ошибка отправки данных');
    }
}
</script>

<template>
    <form class="form-create-task" @submit.prevent>
        <p class="form-title">Создание задачи</p>
        <p v-if="loading"></p>

        <div class="form-create-task__field">
            <label for="title">Заголовок</label>
            <input type="text" name="title" id="title" v-model="form.title">
        </div>

        <div class="form-create-task__field">
            <label for="description">Описание</label>
            <textarea name="description" id="description" v-model="form.description"></textarea>
        </div>

        <div class="form-create-task__field">
            <label for="status">Статус</label>
            <select name="status" id="status" v-model="form.status">
                <option v-for="(value, key) in STATUS_LIST" :value="key">{{ value }}</option>
            </select>
        </div>

        <div class="form-create-buttons">
            <BaseButton :width="150" :height="40" @click="submitForm">{{ isLoading }}</BaseButton>
            <BaseButton :width="150" :height="40" bgc="#C44A3A" @click="toggleFormVisible('create', false)">Отмена
            </BaseButton>
        </div>

    </form>
</template>

<style lang="scss" scoped>
.form-create-task {
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

    .form-create-buttons {
        display: flex;
        gap: 10px;
    }
}
</style>