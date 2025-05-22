<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    task: Object,
    message: String,
});

const form = useForm({
    title: props.task.title || "",
    description: props.task.description || "",
    status: props.task.status || "todo",
    priority: props.task.priority || "medium",
    due_date: props.task.due_date || "",
});

const updateTask = () => {
    form.put(route("tasks.update", props.task.id), {
        onSuccess: () => {
           
        },
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Edit Task" />
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                v-if="message"
                class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded"
            >
                {{ message }}
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Edit Task</h2>
                    <Link
                        :href="route('tasks')"
                        class="text-gray-600 hover:text-gray-800"
                    >
                        ← Back to Tasks
                    </Link>
                </div>

                <form @submit.prevent="updateTask">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input
                            v-model="form.title"
                            type="text"
                            class="border border-gray-300 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            :class="{ 'border-red-500': form.errors.title }"
                        />
                        <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">
                            {{ form.errors.title }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea
                            v-model="form.description"
                            rows="4"
                            class="border border-gray-300 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            :class="{ 'border-red-500': form.errors.description }"
                        ></textarea>
                        <div
                            v-if="form.errors.description"
                            class="text-red-500 text-sm mt-1"
                        >
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select
                                v-model="form.status"
                                class="border border-gray-300 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="todo">Todo</option>
                                <option value="in-progress">In Progress</option>
                                <option value="done">Done</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                            <select
                                v-model="form.priority"
                                class="border border-gray-300 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
                            <input
                                v-model="form.due_date"
                                type="date"
                                class="border border-gray-300 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <Link
                            :href="route('tasks')"
                            class="px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                        >
                            Cancel
                        </Link>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50"
                        >
                            {{ form.processing ? 'Updating...' : 'Update Task' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>