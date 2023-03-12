<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
    transcription: Object,
})
</script>
<template>
    <AppLayout title="Files">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transcription
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8">
                        {{ transcription.deepgram_response }}
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
