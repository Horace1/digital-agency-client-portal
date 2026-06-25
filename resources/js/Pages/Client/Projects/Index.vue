<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    projects: {
        type: Object,
        required: true,
    },
});

const statusBadgeClasses = (status) => {
    return (
        {
            completed:
                'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200',
            in_progress:
                'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200',
            on_hold:
                'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
        }[status] ||
        'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
    );
};
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
                    v-if="projects.data.length === 0"
                    class="overflow-hidden bg-white p-8 text-center shadow-sm sm:rounded-lg sm:p-10 dark:bg-gray-800"
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

                <template v-else>
                    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        <article
                            v-for="project in projects.data"
                            :key="project.id"
                            class="flex h-full flex-col overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <h3
                                    class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                                >
                                    {{ project.title }}
                                </h3>
                                <span
                                    :class="[
                                        statusBadgeClasses(project.status),
                                        'shrink-0 rounded-full px-3 py-1 text-xs font-medium',
                                    ]"
                                >
                                    {{ project.status_label }}
                                </span>
                            </div>

                            <div class="mt-6">
                                <div
                                    class="flex items-center justify-between text-sm"
                                >
                                    <span
                                        class="font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Progress
                                    </span>
                                    <span
                                        class="font-semibold text-gray-900 dark:text-gray-100"
                                    >
                                        {{ project.progress_percentage }}%
                                    </span>
                                </div>
                                <div
                                    class="mt-2 h-2 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700"
                                >
                                    <div
                                        class="h-full rounded-full bg-indigo-600 dark:bg-indigo-400"
                                        :style="{
                                            width: `${project.progress_percentage}%`,
                                        }"
                                    />
                                </div>
                            </div>

                            <div class="mt-6 flex grow items-end">
                                <Link
                                    :href="project.show_url"
                                    class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white"
                                >
                                    View Project
                                </Link>
                            </div>
                        </article>
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
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
