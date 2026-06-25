<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    tickets: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Support Tickets" />

    <AuthenticatedLayout>
        <template #header>
            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
                >
                    Support Tickets
                </h2>
                <Link
                    :href="route('client.support-tickets.create')"
                    class="inline-flex w-fit items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white"
                >
                    New Ticket
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div
                        v-if="tickets.data.length === 0"
                        class="p-8 text-center sm:p-10"
                    >
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-200"
                        >
                            ST
                        </div>
                        <h3
                            class="mt-4 text-lg font-semibold text-gray-900 dark:text-gray-100"
                        >
                            No support tickets yet
                        </h3>
                        <p
                            class="mx-auto mt-2 max-w-xl text-sm leading-6 text-gray-600 dark:text-gray-400"
                        >
                            When you need help with an active project, open a
                            ticket and the conversation will stay organized
                            here.
                        </p>
                        <Link
                            :href="route('client.support-tickets.create')"
                            class="mt-6 inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white"
                        >
                            Create Ticket
                        </Link>
                    </div>

                    <div v-else class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/40">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                    >
                                        Subject
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                    >
                                        Priority
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                    >
                                        Created
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                    >
                                        Latest Activity
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <tr
                                    v-for="ticket in tickets.data"
                                    :key="ticket.id"
                                >
                                    <td class="px-6 py-4">
                                        <Link
                                            :href="ticket.show_url"
                                            class="font-semibold text-gray-900 hover:text-indigo-700 dark:text-gray-100 dark:hover:text-indigo-300"
                                        >
                                            {{ ticket.subject }}
                                        </Link>
                                        <p
                                            v-if="ticket.project_title"
                                            class="mt-1 text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            {{ ticket.project_title }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            :class="[
                                                ticket.status_badge_classes,
                                                'rounded-full px-3 py-1 text-xs font-medium',
                                            ]"
                                        >
                                            {{ ticket.status_label }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"
                                    >
                                        {{ ticket.priority_label }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"
                                    >
                                        {{ ticket.created_date }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"
                                    >
                                        {{
                                            ticket.latest_activity_date ||
                                            'No replies yet'
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div
                    v-if="tickets.links.length > 3"
                    class="mt-8 flex flex-wrap gap-2"
                >
                    <Link
                        v-for="link in tickets.links"
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
