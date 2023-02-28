<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { useForm } from '@inertiajs/vue3'
import _ from 'lodash'
import { ref } from 'vue'

defineProps({
    files: Array,
})

const fileUpload = ref(null)

const form = useForm({
    name: null,
    extension: null,
    duration: 0,
})

const getFileMetadata = (file) => {
    form.extension = file.name.split('.').pop()
    form.name = _.replace(file.name, `.${form.extension}`, '')

    const audioObject = new Audio()
    audioObject.src = URL.createObjectURL(file)
    audioObject.addEventListener('loadedmetadata', () => {
        form.duration = Math.ceil(audioObject.duration)
    })
}

const handleFileInput = (event) => {
    let file = _.get(event, 'target.files.0')

    if (!file) return

    fileUpload.value = file

    getFileMetadata(file)
}

const uploadFileToS3 = (url) => {
    axios.put(url, fileUpload.value, {
        onUploadProgress: (progressEvent) => {
            console.log(progressEvent.loaded)
        },
        headers: {
            'Content-Type': fileUpload.value.type,
        },
    })
}

const submit = (event) => {
    axios
        .post(route('files.store'), form.data(), {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        })
        .then(({ data }) => {
            return data.upload_url
        })
        .then(uploadFileToS3)
        .then((response) => {
            console.log('upload completed', response)
        })
}
</script>

<template>
    <AppLayout title="Files">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Files
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8">
                        <h1 class="text-2xl font-medium text-gray-900">
                            Your files:
                        </h1>

                        <div>
                            
                            <div v-for="file in files" class="flex mb-4">
                                <div class="text-sm truncate mr-2">
                                    {{ file.name }}.{{ file.extension }}
                                </div>
                                <div class="text-sm">
                                    {{ Math.floor(file.duration / 60) }}min {{ file.duration % 60 }}sec
                                </div>
                            </div>
                        </div>

                        <form @submit.prevent="submit">
                            <div class="my-8">
                                <span class="sr-only">
                                    Choose profile photo
                                </span>
                                <input
                                    type="file"
                                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"
                                    @input="handleFileInput"
                                />
                                <progress
                                    class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700"
                                    v-if="form.progress"
                                    :value="form.progress.percentage"
                                    max="100"
                                >
                                    {{ form.progress.percentage }}%
                                </progress>
                            </div>

                            <div class="mt-4 text-right">
                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Upload
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
