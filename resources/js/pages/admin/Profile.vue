<script setup lang="ts">
import { Form, Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '@/components/AdminLayout.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

type Props = {
    mustVerifyEmail: boolean;
    status?: string;
};

withDefaults(defineProps<Props>(), {
    mustVerifyEmail: false,
});

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <AdminLayout title="Profile Admin">
        <Head title="Admin Profile" />

        <div class="space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Admin Profile</h1>
                <p class="text-gray-600 mt-2">Manage your admin account settings</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Profile Information</h2>

                <Form
                    method="PATCH"
                    action="/settings/profile"
                    class="space-y-6"
                    @submit.prevent="$page.props.auth.user"
                >
                    <div>
                        <Label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</Label>
                        <Input
                            id="name"
                            type="text"
                            name="name"
                            :default-value="user.name"
                            required
                            variant="gray"
                            class="w-full px-3 py-2 rounded-md text-gray-900"
                        />
                    </div>

                    <div>
                        <Label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</Label>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            :default-value="user.email"
                            required
                            variant="gray"
                            class="w-full px-3 py-2 rounded-md text-gray-900"
                        />
                    </div>

                    <div class="flex gap-2">
                        <Button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white"
                        >
                            Save Changes
                        </Button>
                    </div>
                </Form>
            </div>
        </div>
    </AdminLayout>
</template>
