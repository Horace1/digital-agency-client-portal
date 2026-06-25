<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    projectsCount: {
        type: Number,
        default: 0,
    },
    supportTicketsCount: {
        type: Number,
        default: 0,
    },
    projectUpdatesCount: {
        type: Number,
        default: 0,
    },
    filesCount: {
        type: Number,
        default: 0,
    },
});
</script>

<template>
    <Head title="Client Portal" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Client Portal
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6">
                        <h3
                            class="text-2xl font-semibold text-gray-900 dark:text-gray-100"
                        >
                            Welcome back!
                        </h3>

                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            View your projects, updates and support tickets.
                        </p>
                    </div>
                </div>

                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Projects
                        </p>
                        <p
                            class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100"
                        >
                            {{ projectsCount }}
                        </p>
                    </div>

                    <div
                        class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Support Tickets
                        </p>
                        <p
                            class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100"
                        >
                            {{ supportTicketsCount }}
                        </p>
                    </div>

                    <div
                        class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Project Updates
                        </p>
                        <p
                            class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100"
                        >
                            {{ projectUpdatesCount }}
                        </p>
                    </div>

                    <div
                        class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Files
                        </p>
                        <p
                            class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100"
                        >
                            {{ filesCount }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
