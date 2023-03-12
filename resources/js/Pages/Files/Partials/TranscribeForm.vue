<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DialogModal from '@/Components/DialogModal.vue';
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'

const props = defineProps({
    file_id: Number,
})

const showUploadModal = ref(false)

const form = useForm({
    language: 'pl',
    file_id: props.file_id,
})

const submit = () => {
    router.post(route('transcriptions.store', form))
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
                    <div class="mb-4">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                            Language
                        </label>
                        <div class="relative">
                            <select
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="grid-state">
                                <option value="pl">Polish</option>
                                <option value="en">English</option>
                                <option value="en-US">English United States</option>
                            </select>
                        </div>
                    </div>

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