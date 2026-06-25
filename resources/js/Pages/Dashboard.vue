<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    summaryCards: {
        type: Array,
        default: () => [],
    },
    recentActivity: {
        type: Array,
        default: () => [],
    },
    quickActions: {
        type: Array,
        default: () => [],
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
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <section
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div
                        class="flex flex-col gap-6 p-6 lg:flex-row lg:items-center lg:justify-between"
                    >
                        <div>
                            <h3
                                class="text-2xl font-semibold text-gray-900 dark:text-gray-100"
                            >
                                Account Overview
                            </h3>

                            <p
                                class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400"
                            >
                                Track active work, support conversations,
                                shared files, and recent updates from your
                                agency team.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <Link
                                v-for="action in quickActions"
                                :key="action.label"
                                :href="action.href"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                            >
                                {{ action.label }}
                            </Link>
                        </div>
                    </div>
                </section>

                <section class="mt-6 grid gap-6 sm:grid-cols-2 xl:grid-cols-5">
                    <article
                        v-for="card in summaryCards"
                        :key="card.label"
                        class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <p
                            class="text-sm font-medium text-gray-500 dark:text-gray-400"
                        >
                            {{ card.label }}
                        </p>
                        <p
                            class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100"
                        >
                            {{ card.value }}
                        </p>
                        <p
                            class="mt-2 text-sm leading-5 text-gray-600 dark:text-gray-400"
                        >
                            {{ card.description }}
                        </p>
                    </article>
                </section>

                <section
                    class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div
                        class="border-b border-gray-200 px-6 py-4 dark:border-gray-700"
                    >
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                        >
                            Recent Activity
                        </h3>
                    </div>

                    <div
                        v-if="recentActivity.length === 0"
                        class="p-8 text-center sm:p-10"
                    >
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-200"
                        >
                            RA
                        </div>
                        <h4
                            class="mt-4 text-lg font-semibold text-gray-900 dark:text-gray-100"
                        >
                            No recent activity yet
                        </h4>
                        <p
                            class="mx-auto mt-2 max-w-xl text-sm leading-6 text-gray-600 dark:text-gray-400"
                        >
                            Published project updates, uploaded files, and
                            support ticket replies will appear here as your
                            account becomes active.
                        </p>
                    </div>

                    <div
                        v-else
                        class="divide-y divide-gray-200 dark:divide-gray-700"
                    >
                        <article
                            v-for="item in recentActivity"
                            :key="`${item.type}-${item.title}-${item.date}`"
                            class="flex flex-col gap-3 p-6 sm:flex-row sm:items-start sm:justify-between"
                        >
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span
                                        class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-700 dark:bg-gray-700 dark:text-gray-200"
                                    >
                                        {{ item.type }}
                                    </span>
                                    <p
                                        v-if="item.date"
                                        class="text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        {{ item.date }}
                                    </p>
                                </div>

                                <h4
                                    class="mt-2 font-semibold text-gray-900 dark:text-gray-100"
                                >
                                    {{ item.title }}
                                </h4>
                                <p
                                    v-if="item.context"
                                    class="mt-1 text-sm text-gray-600 dark:text-gray-400"
                                >
                                    {{ item.context }}
                                </p>
                            </div>

                            <Link
                                :href="item.href"
                                class="inline-flex w-fit shrink-0 items-center rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white"
                            >
                                View
                            </Link>
                        </article>
                    </div>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
