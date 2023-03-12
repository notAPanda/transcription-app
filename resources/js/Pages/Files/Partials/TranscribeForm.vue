<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DialogModal from '@/Components/DialogModal.vue';
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const showUploadModal = ref(false)

const form = useForm({
    name: null,
    extension: null,
    duration: 0,
})

const submit = (event) => {
    axios
        .post(route('files.store'), form.data(), {
        })
        .then(({ data }) => {
            return data.upload_url
        })
        .then(uploadFileToS3)
        .then((response) => {
            showUploadModal.value = false
        })
}
</script>
<template>
    <div>
        <div class="text-right">
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                @click.prevent="showUploadModal = true">
                Transcribe
            </PrimaryButton>
        </div>

        <DialogModal :show="showUploadModal" @close="showUploadModal = false">
            <template #title>
                Transcription settings
            </template>
            <template #content>
                <form @submit.prevent="submit">
                    
                </form>
            </template>

            <template #footer>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click.prevent="submit">
                    Submit
                </PrimaryButton>
            </template>


        </DialogModal>
    </div>
</template>