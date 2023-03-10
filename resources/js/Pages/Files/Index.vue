<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import UploadFile from '@/Pages/Files/Partials/UploadFile.vue'
import TranscribeForm from '@/Pages/Files/Partials/TranscribeForm.vue'

import { Link } from '@inertiajs/vue3'
import _ from 'lodash'

defineProps({
    files: Array,
})

const remove = () => {
    console.log('delete')
}
const transcribe = () => {
    console.log('transcribe')
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
                        <UploadFile class="mb-4"></UploadFile>

                        <div>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="text-left">Name</th>
                                        <th class="text-right">Duration</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="file in files">
                                        <td class="hover:text-indigo-700">
                                            <Link :href="route('files.show', file.id)">
                                            {{ file.name }}.{{ file.extension }}
                                            </Link>
                                        </td>
                                        <td class="text-right">
                                            {{ Math.floor(file.duration / 60) }}min {{ file.duration % 60 }}sec
                                        </td>
                                        <td class="flex justify-end">
                                            <TranscribeForm></TranscribeForm>

                                            <Dropdown>
                                                <template #trigger>
                                                    <span class="inline-flex rounded-md">
                                                        <button type="button"
                                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                            <svg class="-mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </template>
                                                <template #content>
                                                    <DropdownLink as="a" href="#" @click.prevent="
                                                        transcribe
                                                    ">
                                                        Transcribe
                                                    </DropdownLink>
                                                    <DropdownLink as="a" href="#" @click.prevent="remove">
                                                        Delete
                                                    </DropdownLink>
                                                </template>
                                            </Dropdown>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
