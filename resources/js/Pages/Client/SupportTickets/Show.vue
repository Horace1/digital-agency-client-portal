<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    ticket: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    body: '',
});

const submit = () => {
    form.post(route('client.support-tickets.comments.store', props.ticket.id), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head :title="ticket.subject" />

    <AuthenticatedLayout>
        <template #header>
            <div
                class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between"
            >
                <div>
                    <Link
                        :href="route('client.support-tickets.index')"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                    >
                        Back to Support Tickets
                    </Link>
                    <h2
                        class="mt-2 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
                    >
                        {{ ticket.subject }}
                    </h2>
                    <p
                        v-if="ticket.project_title"
                        class="mt-1 text-sm text-gray-500 dark:text-gray-400"
                    >
                        {{ ticket.project_title }}
                    </p>
                </div>
                <span
                    :class="[
                        ticket.status_badge_classes,
                        'w-fit rounded-full px-3 py-1 text-xs font-medium',
                    ]"
                >
                    {{ ticket.status_label }}
                </span>
            </div>
        </template>

        <div class="py-12">
            <div
                class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-3 lg:px-8"
            >
                <div class="space-y-6 lg:col-span-2">
                    <section
                        class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                        >
                            Description
                        </h3>
                        <p
                            class="mt-3 whitespace-pre-line text-gray-600 dark:text-gray-400"
                        >
                            {{ ticket.description }}
                        </p>
                    </section>

                    <section
                        class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                        >
                            Replies
                        </h3>

                        <div
                            v-if="ticket.comments.length === 0"
                            class="mt-4 rounded-md border border-dashed border-gray-300 bg-gray-50/60 p-5 dark:border-gray-700 dark:bg-gray-900/30"
                        >
                            <h4
                                class="font-semibold text-gray-900 dark:text-gray-100"
                            >
                                No replies yet
                            </h4>
                            <p
                                class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400"
                            >
                                Replies from your agency team will appear here.
                                Add a reply below if you need to share more
                                context or ask for help.
                            </p>
                        </div>

                        <div v-else class="mt-4 space-y-4">
                            <article
                                v-for="comment in ticket.comments"
                                :key="comment.id"
                                class="border-t border-gray-200 pt-4 first:border-t-0 first:pt-0 dark:border-gray-700"
                            >
                                <div
                                    class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between"
                                >
                                    <h4
                                        class="font-semibold text-gray-900 dark:text-gray-100"
                                    >
                                        {{ comment.created_by }}
                                    </h4>
                                    <p
                                        class="text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        {{ comment.created_date }}
                                    </p>
                                </div>
                                <p
                                    class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-600 dark:text-gray-400"
                                >
                                    {{ comment.body }}
                                </p>
                            </article>
                        </div>
                    </section>

                    <section
                        class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                        >
                            Add Reply
                        </h3>
                        <form class="mt-4 space-y-4" @submit.prevent="submit">
                            <div>
                                <textarea
                                    v-model="form.body"
                                    rows="5"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                                    required
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.body"
                                />
                            </div>
                            <div class="flex justify-end">
                                <PrimaryButton :disabled="form.processing">
                                    Post Reply
                                </PrimaryButton>
                            </div>
                        </form>
                    </section>
                </div>

                <aside class="space-y-6">
                    <section
                        class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                        >
                            Ticket Details
                        </h3>
                        <dl class="mt-4 space-y-4 text-sm">
                            <div>
                                <dt
                                    class="font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Status
                                </dt>
                                <dd
                                    class="mt-1"
                                >
                                    <span
                                        :class="[
                                            ticket.status_badge_classes,
                                            'inline-flex rounded-full px-3 py-1 text-xs font-medium',
                                        ]"
                                    >
                                        {{ ticket.status_label }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt
                                    class="font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Priority
                                </dt>
                                <dd
                                    class="mt-1 text-gray-900 dark:text-gray-100"
                                >
                                    {{ ticket.priority_label }}
                                </dd>
                            </div>
                            <div>
                                <dt
                                    class="font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Created
                                </dt>
                                <dd
                                    class="mt-1 text-gray-900 dark:text-gray-100"
                                >
                                    {{ ticket.created_date }}
                                </dd>
                            </div>
                            <div>
                                <dt
                                    class="font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Latest Activity
                                </dt>
                                <dd
                                    class="mt-1 text-gray-900 dark:text-gray-100"
                                >
                                    {{
                                        ticket.latest_activity_date ||
                                        'No replies yet'
                                    }}
                                </dd>
                            </div>
                        </dl>
                    </section>
                </aside>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
