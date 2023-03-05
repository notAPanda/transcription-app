<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
    file: Object,
})
</script>
<template>
    <AppLayout title="Files">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                File Transcriptions
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8">
                        <h1 class="text-2xl font-medium text-gray-900">
                            {{ file.name }}.{{ file.extension }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
