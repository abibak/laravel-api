<script setup>
import { computed, provide, reactive, ref, onMounted } from 'vue';
import { useAPI } from './composables/useAPI';

const { data, get } = useAPI();

const taskForms = reactive({
    create: false,
    update: false
});

const taskSelectedId = ref(null);

onMounted(async () => {    
    await get('/task/get');
});

const tasks = computed(() => {
    return data.value?.data ?? [];
});

function toggleFormVisible(form, value) {
    taskForms[form] = value;
}

function setSelectedTaskId(id) {
    taskSelectedId.value = id;
}

async function refreshTasks() {
    await get('/task/get');
}

provide('task', {
    taskForms,
    tasks,
    taskSelectedId,
    toggleFormVisible,
    setSelectedTaskId,
    refreshTasks
});
</script>

<template>
    <div class="wrapper">
        <div class="main-title">
            <h1 class="main-title__text">Task list</h1>
        </div>

        <router-view></router-view>
    </div>
</template>

<style lang="scss" scoped>
.wrapper {
    width: 100%;
    height: 100%;
    padding: 40px;

    .main-title {
        max-width: 50%;
        border-bottom: 1px solid #ccc;
        margin-bottom: 15px;

        &__text {
            font-size: 28px;
            margin-bottom: 5px;
        }
    }
}
</style>
