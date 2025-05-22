<script setup>
import { Link, router } from "@inertiajs/vue3";

defineProps({
    tasks: Array,
});

function deleteTask(id) {
    if (confirm("Are you sure you want to delete this task?")) {
        router.delete(route("tasks.destroy", id));
    }
}
</script>

<template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"
                >
                    <div v-if="tasks && tasks.length > 0">
                        <div
                            v-for="task in tasks"
                            :key="task.id"
                            class="border-b py-4 last:border-b-0"
                        >
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold">
                                        {{ task.title }}
                                    </h3>
                                    <p class="mt-1">{{ task.description }}</p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Priority:
                                        <span
                                            :class="{
                                                'text-red-600':
                                                    task.priority === 'high',
                                                'text-yellow-600':
                                                    task.priority === 'medium',
                                                'text-green-600':
                                                    task.priority === 'low',
                                            }"
                                            >{{ task.priority }}</span
                                        >
                                        | Status:
                                        <span
                                            :class="{
                                                'text-blue-600':
                                                    task.status === 'todo',
                                                'text-yellow-600':
                                                    task.status ===
                                                    'in-progress',
                                                'text-green-600':
                                                    task.status === 'done',
                                            }"
                                            >{{ task.status }}</span
                                        >
                                        <span
                                            v-if="task.formatted_due_date"
                                            class="font-bold"
                                        >
                                            | Due: {{ task.formatted_due_date }}
                                        </span>
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <!-- Always show edit button for debugging -->
                                    <Link
                                        :href="route('tasks.edit', task.id)"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm"
                                    >
                                        Edit
                                    </Link>
                                    <!-- Always show delete button for debugging -->
                                    <button
                                        @click="deleteTask(task.id)"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                    >
                                        Delete
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-gray-500 text-center py-8">
                        No tasks available. Click "Create Task" to add your
                        first task!
                    </div>
                </div>
            </div>
        </div>
</template>