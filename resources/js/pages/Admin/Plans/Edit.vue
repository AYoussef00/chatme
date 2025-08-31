<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft, Save, Plus, X } from 'lucide-vue-next';
import { ref } from 'vue';

interface Plan {
    id: number;
    name: string;
    description: string | null;
    price: number;
    duration: string;
    features: string[] | null;
    is_active: boolean;
}

interface Props {
    plan: Plan;
}

const props = defineProps<Props>();

// Form data
const form = useForm({
    name: props.plan.name,
    description: props.plan.description || '',
    price: props.plan.price,
    duration: props.plan.duration,
    features: props.plan.features || [],
    is_active: props.plan.is_active
});

// New feature input
const newFeature = ref('');

// Add feature
const addFeature = () => {
    if (newFeature.value.trim()) {
        form.features.push(newFeature.value.trim());
        newFeature.value = '';
    }
};

// Remove feature
const removeFeature = (index: number) => {
    form.features.splice(index, 1);
};

// Submit form
const submit = () => {
    form.put(`/admin/plans/${props.plan.id}`);
};
</script>

<template>
    <Head title="Edit Plan" />

    <AppSidebarLayout>
        <div class="container mx-auto py-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <Link href="/admin/plans" class="text-gray-600 hover:text-gray-900">
                        <ArrowLeft class="w-5 h-5" />
                    </Link>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Edit Plan</h1>
                        <p class="text-gray-600 mt-2">Update your subscription plan details</p>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle>Plan Information</CardTitle>
                    <CardDescription>Update the plan details below</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Plan Name *
                            </label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter plan name"
                            />
                            <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea
                                id="description"
                                v-model="form.description"
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter plan description"
                            ></textarea>
                            <div v-if="form.errors.description" class="text-red-600 text-sm mt-1">
                                {{ form.errors.description }}
                            </div>
                        </div>

                        <!-- Price and Duration -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Price *
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                                                    <input
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    step="1"
                                    min="0"
                                    required
                                    class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="0"
                                />
                                </div>
                                <div v-if="form.errors.price" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.price }}
                                </div>
                            </div>

                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                                    Duration *
                                </label>
                                <select
                                    id="duration"
                                    v-model="form.duration"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    <option value="">Select duration</option>
                                    <option value="month">Per Month</option>
                                    <option value="year">Per Year</option>
                                    <option value="one-time">One Time</option>
                                    <option value="lifetime">Lifetime</option>
                                </select>
                                <div v-if="form.errors.duration" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.duration }}
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Features
                            </label>
                            <div class="space-y-3">
                                <!-- Existing Features -->
                                <div v-for="(feature, index) in form.features" :key="index" class="flex items-center space-x-2">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    <span class="flex-1 text-sm text-gray-700">{{ feature }}</span>
                                    <Button
                                        type="button"
                                        variant="ghost"
                                        size="sm"
                                        @click="removeFeature(index)"
                                        class="text-red-600 hover:text-red-700 hover:bg-red-50"
                                    >
                                        <X class="w-4 h-4" />
                                    </Button>
                                </div>

                                <!-- Add New Feature -->
                                <div class="flex space-x-2">
                                    <input
                                        v-model="newFeature"
                                        type="text"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Add a new feature"
                                        @keypress.enter="addFeature"
                                    />
                                    <Button
                                        type="button"
                                        @click="addFeature"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                        <Plus class="w-4 h-4" />
                                    </Button>
                                </div>
                            </div>
                            <div v-if="form.errors.features" class="text-red-600 text-sm mt-1">
                                {{ form.errors.features }}
                            </div>
                        </div>

                        <!-- Active Status -->
                        <div>
                            <label class="flex items-center space-x-2">
                                <input
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                />
                                <span class="text-sm font-medium text-gray-700">Active Plan</span>
                            </label>
                            <div v-if="form.errors.is_active" class="text-red-600 text-sm mt-1">
                                {{ form.errors.is_active }}
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex space-x-3 pt-4">
                            <Button
                                type="submit"
                                :disabled="form.processing"
                                class="flex items-center space-x-2 bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <Save class="w-4 h-4" />
                                <span v-if="form.processing">Updating...</span>
                                <span v-else>Update Plan</span>
                            </Button>
                            <Link href="/admin/plans">
                                <Button
                                    type="button"
                                    variant="outline"
                                    class="border-gray-300 text-gray-700 hover:bg-gray-50"
                                >
                                    Cancel
                                </Button>
                            </Link>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppSidebarLayout>
</template>
