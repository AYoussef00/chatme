<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { ArrowLeft, Plus, X } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    description: '',
    price: '',
    duration: 'monthly',
    features: [''],
    is_active: true,
});

const addFeature = () => {
    form.features.push('');
};

const removeFeature = (index: number) => {
    form.features.splice(index, 1);
};

const updateFeature = (index: number, value: string) => {
    form.features[index] = value;
};

const submit = () => {
    form.post('/admin/plans');
};
</script>

<template>
    <Head title="Create New Plan" />

    <AppSidebarLayout>
        <div class="container mx-auto py-6">
            <div class="mb-6">
                <Link href="/admin/plans" class="flex items-center text-gray-600 hover:text-gray-900 mb-4">
                    <ArrowLeft class="w-4 h-4 mr-2" />
                    Back to Plans
                </Link>
                <h1 class="text-3xl font-bold text-gray-900">Create New Plan</h1>
                <p class="text-gray-600 mt-2">Add a new subscription plan to your system</p>
            </div>

            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle>Plan Information</CardTitle>
                    <CardDescription>Fill in the details for your new subscription plan</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label for="name">Plan Name *</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    placeholder="e.g., Basic Plan, Pro Plan"
                                />
                                <p v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</p>
                            </div>

                            <div class="space-y-2">
                                <Label for="price">Price *</Label>
                                <Input
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    placeholder="0.00"
                                />
                                <p v-if="form.errors.price" class="text-sm text-red-600">{{ form.errors.price }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <Label for="duration">Duration *</Label>
                            <select
                                v-model="form.duration"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus:ring-2 focus:ring-ring focus:ring-offset-2"
                            >
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                                <option value="weekly">Weekly</option>
                                <option value="daily">Daily</option>
                            </select>
                            <p v-if="form.errors.duration" class="text-sm text-red-600">{{ form.errors.duration }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="description">Description</Label>
                            <textarea
                                id="description"
                                v-model="form.description"
                                placeholder="Describe what this plan offers..."
                                rows="3"
                                class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus:ring-2 focus:ring-ring focus:ring-offset-2"
                            />
                            <p v-if="form.errors.description" class="text-sm text-red-600">{{ form.errors.description }}</p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <Label>Features</Label>
                                <Button type="button" variant="outline" size="sm" @click="addFeature">
                                    <Plus class="w-4 h-4 mr-2" />
                                    Add Feature
                                </Button>
                            </div>

                            <div class="space-y-3">
                                <div v-for="(feature, index) in form.features" :key="index" class="flex gap-2">
                                    <Input
                                        v-model="form.features[index]"
                                        placeholder="Enter feature description..."
                                        @input="updateFeature(index, $event.target.value)"
                                    />
                                    <Button
                                        v-if="form.features.length > 1"
                                        type="button"
                                        variant="outline"
                                        size="sm"
                                        @click="removeFeature(index)"
                                    >
                                        <X class="w-4 h-4" />
                                    </Button>
                                </div>
                            </div>
                            <p v-if="form.errors.features" class="text-sm text-red-600">{{ form.errors.features }}</p>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input
                                id="is_active"
                                v-model="form.is_active"
                                type="checkbox"
                                class="h-4 w-4 rounded border border-input"
                            />
                            <Label for="is_active">Active Plan</Label>
                        </div>

                        <div class="flex gap-4 pt-4">
                            <Button type="submit" :disabled="form.processing" class="flex-1">
                                {{ form.processing ? 'Creating...' : 'Create Plan' }}
                            </Button>
                            <Link href="/admin/plans">
                                <Button type="button" variant="outline" class="flex-1">
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
