<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    tasks: Array,
    message: String,
});

const form = useForm({
    title: "",
    description: "",
    status: "todo",
    priority: "medium",
    due_date: "",
});

const tasksCreated = () => {
    form.post(route("tasks.store"), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>
<template>
    <AppLayout>
        <Head title="Tasks" />
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                v-if="message"
                class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded"
            >
                {{ message }}
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-2xl font-bold mb-4">Create New Task</h2>

                <form @submit.prevent="tasksCreated">
                    <div class="mb-4">
                        <label class="block">Title</label>
                        <input
                            v-model="form.title"
                            type="text"
                            class="border rounded w-full"
                        />
                        <div v-if="form.errors.title" class="text-red-500">
                            {{ form.errors.title }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block">Description</label>
                        <textarea
                            v-model="form.description"
                            class="border rounded w-full"
                        ></textarea>
                        <div
                            v-if="form.errors.description"
                            class="text-red-500"
                        >
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block">Status</label>
                        <select
                            v-model="form.status"
                            class="border rounded w-full"
                        >
                            <option value="todo">Todo</option>
                            <option value="in-progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block">Priority</label>
                        <select
                            v-model="form.priority"
                            class="border rounded w-full"
                        >
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block">Due Date</label>
                        <input
                            v-model="form.due_date"
                            type="date"
                            class="border rounded w-full "
                        />
                    </div>
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                    >
                        Save
                    </button>
                </form>
            </div>

            <!-- <div class="mt-10 bg-white p-6 rounded-lg shadow">
                <h2 class="text-2xl font-bold mb-4">Your Tasks</h2>

                <div
                    v-if="tasks && tasks.length > 0"
                    v-for="task in tasks"
                    :key="task.id"
                    :task="task"
                    class="border-b py-4"
                >
                    <div class="flex justify-between">
                        <div>
                            <h3 class="text-xl font-semibold">
                                {{ task.title }}
                            </h3>
                            <p>{{ task.description }}</p>
                            <p class="text-sm text-gray-600">
                                Priority: {{ task.priority }} | Status:
                                {{ task.status }} | Due: {{ task.due_date }}
                            </p>
                        </div>
                    </div>
                </div>
                <div v-else class="text-gray-500">No tasks available.</div>
            </div> -->
        </div>
    </AppLayout>
</template>
