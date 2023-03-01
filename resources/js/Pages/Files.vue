<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
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

const logMe = () => {
    console.log('hello')
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
                            <div
                                v-for="file in files"
                                class="flex justify-between mb-4"
                            >
                                <div class="text-sm truncate mr-2">
                                    {{ file.name }}.{{ file.extension }}
                                </div>
                                <div class="text-sm">
                                    {{ Math.floor(file.duration / 60) }}min
                                    {{ file.duration % 60 }}sec
                                </div>
                                <div class="relative">
                                    <Dropdown>
                                        <template #trigger>
                                            <span
                                                class="inline-flex rounded-md"
                                            >
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
                                                >
                                                    <svg
                                                        class="ml-2 -mr-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <DropdownLink
                                                as="a"
                                                href="#"
                                                @click.prevent="logMe"
                                            >
                                                Delete
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
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
