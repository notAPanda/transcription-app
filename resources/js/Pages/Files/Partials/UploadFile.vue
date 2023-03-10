<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DialogModal from '@/Components/DialogModal.vue';
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const fileUpload = ref(null)
const showUploadModal = ref(false)

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
            showUploadModal = false
        })
}
</script>
<template>
    <div>
        <div class="text-right">
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                @click.prevent="showUploadModal = true">
                Upload File
            </PrimaryButton>
        </div>

        <DialogModal :show="showUploadModal" @close="showUploadModal = false">
            <template #title>
                Upload File
            </template>
            <template #content>
                <form @submit.prevent="submit">
                    <div class="">
                        <span class="sr-only">
                            Choose profile photo
                        </span>
                        <input type="file"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"
                            @input="handleFileInput" />
                        <progress class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700" v-if="form.progress"
                            :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                    </div>
                </form>
            </template>

            <template #footer>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click.prevent="submit">
                    Upload
                </PrimaryButton>
            </template>


        </DialogModal>
    </div>
</template>