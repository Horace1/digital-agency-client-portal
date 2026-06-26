<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    projects: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="My Projects" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                My Projects
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div
                        v-if="projects.data.length === 0"
                        class="p-8 text-center sm:p-10"
                    >
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-200"
                        >
                            PR
                        </div>
                        <h3
                            class="mt-4 text-lg font-semibold text-gray-900 dark:text-gray-100"
                        >
                            No assigned projects yet
                        </h3>
                        <p
                            class="mx-auto mt-2 max-w-xl text-sm leading-6 text-gray-600 dark:text-gray-400"
                        >
                            Projects assigned to your client account will appear
                            here with their current status, progress, files, and
                            updates.
                        </p>
                    </div>

                    <div v-else class="overflow-x-auto">
                        <table
                            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                        >
                            <thead class="bg-gray-50 dark:bg-gray-900/40">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                    >
                                        Project
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                    >
                                        Progress
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                    >
                                        Last Update
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                    >
                                        Due Date
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="divide-y divide-gray-200 dark:divide-gray-700"
                            >
                                <tr
                                    v-for="project in projects.data"
                                    :key="project.id"
                                >
                                    <td class="px-6 py-4">
                                        <div
                                            class="font-bold text-gray-900 dark:text-gray-100"
                                        >
                                            {{ project.title }}
                                        </div>
                                        <div
                                            v-if="project.description"
                                            class="mt-1 line-clamp-1 text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            {{ project.description }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            :class="[
                                                project.status_badge_classes,
                                                'inline-flex rounded-full px-3 py-1 text-xs font-medium',
                                            ]"
                                        >
                                            {{ project.status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-2 w-full max-w-[100px] overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700"
                                            >
                                                <div
                                                    class="h-full rounded-full bg-indigo-600 dark:bg-indigo-400"
                                                    :style="{
                                                        width: `${project.progress_percentage}%`,
                                                    }"
                                                />
                                            </div>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-gray-100"
                                            >
                                                {{
                                                    project.progress_percentage
                                                }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"
                                    >
                                        {{
                                            project.last_update ||
                                            'No updates yet'
                                        }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span
                                            v-if="project.due_date"
                                            :class="[
                                                project.is_overdue
                                                    ? 'font-medium text-red-600 dark:text-red-400'
                                                    : 'text-gray-700 dark:text-gray-300',
                                            ]"
                                        >
                                            {{ project.due_date }}
                                        </span>
                                        <span
                                            v-else
                                            class="text-gray-500 dark:text-gray-400"
                                        >
                                            No due date
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <Link
                                            :href="project.show_url"
                                            class="inline-flex items-center rounded-md bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white"
                                        >
                                            View
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div
                    v-if="projects.links.length > 3"
                    class="mt-8 flex flex-wrap gap-2"
                >
                    <Link
                        v-for="link in projects.links"
                        :key="`${link.label}-${link.url}`"
                        :href="link.url || '#'"
                        preserve-scroll
                        :class="[
                            'rounded-md px-3 py-2 text-sm font-medium',
                            link.active
                                ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900'
                                : 'bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700',
                            !link.url && 'pointer-events-none opacity-50',
                        ]"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
