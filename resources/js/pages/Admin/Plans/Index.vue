<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Plus, Edit, Trash2 } from 'lucide-vue-next';

interface Plan {
    id: number;
    name: string;
    description: string | null;
    price: number;
    duration: string;
    features: string[] | null;
    is_active: boolean;
    created_at: string;
}

interface Props {
    plans: Plan[];
}

defineProps<Props>();
</script>

<template>
    <Head title="Plans" />

    <AppSidebarLayout>
        <div class="container mx-auto py-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Plans Management</h1>
                    <p class="text-gray-600 mt-2">Manage your subscription plans and pricing</p>
                </div>
                <Link href="/admin/plans/create">
                    <Button class="flex items-center gap-2">
                        <Plus class="w-4 h-4" />
                        Add New Plan
                    </Button>
                </Link>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <Card v-for="plan in plans" :key="plan.id" class="hover:shadow-lg transition-shadow">
                    <CardHeader>
                        <div class="flex justify-between items-start">
                            <div>
                                <CardTitle class="text-xl">{{ plan.name }}</CardTitle>
                                <CardDescription class="mt-2">{{ plan.description }}</CardDescription>
                            </div>
                            <span
                                :class="[
                                    'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                    plan.is_active
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-gray-100 text-gray-800'
                                ]"
                            >
                                {{ plan.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div class="text-center">
                                <span class="text-3xl font-bold text-gray-900">${{ plan.price }}</span>
                                <span class="text-gray-600 ml-2">/{{ plan.duration }}</span>
                            </div>

                            <div v-if="plan.features && plan.features.length > 0">
                                <h4 class="font-semibold text-gray-900 mb-2">Features:</h4>
                                <ul class="space-y-1">
                                    <li v-for="feature in plan.features" :key="feature" class="text-sm text-gray-600 flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        {{ feature }}
                                    </li>
                                </ul>
                            </div>

                            <div class="flex gap-2 pt-4">
                                <Link :href="`/admin/plans/${plan.id}/edit`">
                                    <Button variant="outline" size="sm" class="flex items-center gap-2">
                                        <Edit class="w-4 h-4" />
                                        Edit
                                    </Button>
                                </Link>
                                <Button variant="outline" size="sm" class="flex items-center gap-2 text-red-600 hover:text-red-700">
                                    <Trash2 class="w-4 h-4" />
                                    Delete
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <div v-if="plans.length === 0" class="text-center py-12">
                <div class="text-gray-500">
                    <h3 class="text-lg font-medium mb-2">No plans found</h3>
                    <p class="mb-4">Get started by creating your first subscription plan.</p>
                    <Link href="/admin/plans/create">
                        <Button class="flex items-center gap-2 mx-auto">
                            <Plus class="w-4 h-4" />
                            Create First Plan
                        </Button>
                    </Link>
                </div>
            </div>
        </div>
    </AppSidebarLayout>
</template>
