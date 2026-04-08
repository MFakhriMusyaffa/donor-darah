<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Form, Head, usePage } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import {
    saveRememberedEmail,
    getRememberedEmail,
    clearRememberedEmail,
} from '@/lib/rememberMe';

const page = usePage();

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();

// --- Logika Dark/Light Mode ---
const isDark = ref(false);
const showPassword = ref(false);
const isRemember = ref(false);
const emailInput = ref('');

const toggleTheme = () => {
    isDark.value = !isDark.value;
    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

/**
 * Detect user role based on authenticated user or redirect path
 */
const detectUserRole = (): 'admin' | 'user' => {
    // Try to get from current user props
    const user = page.props.auth?.user;
    if (user?.role === 'admin') {
        return 'admin';
    }

    // Fallback: check from localStorage after login
    const storedRole = localStorage.getItem('user_role');
    if (storedRole === 'admin') {
        return 'admin';
    }

    return 'user';
};

/**
 * Handle form submission - save or clear email cookie with role-based duration
 * ✅ Email ONLY (not password)
 * ✅ Validated before save
 * ✅ Role-based duration (Admin: 1 day, User: 7 days)
 * ✅ Auto-deleted if checkbox unchecked
 */
const handleFormSubmit = () => {
    const email = emailInput.value?.trim();

    if (isRemember.value && email) {
        // Detect role for duration
        const role = detectUserRole();

        // Save email to cookie with role-based duration
        // After redirect, middleware should set localStorage user_role
        setTimeout(() => {
            const finalRole = detectUserRole();
            saveRememberedEmail(email, finalRole);
        }, 500);
    } else {
        // Clear if checkbox unchecked or email empty
        clearRememberedEmail();
    }
};

onMounted(() => {
    // Cek preferensi user sebelumnya atau sistem OS
    if (
        localStorage.theme === 'dark' ||
        (!('theme' in localStorage) &&
            window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        isDark.value = true;
        document.documentElement.classList.add('dark');
    } else {
        isDark.value = false;
        document.documentElement.classList.remove('dark');
    }

    // Load remembered email from cookie (role-based retention)
    // ✅ Email validated when reading from cookie
    // ✅ Invalid emails auto-deleted
    const rememberedEmail = getRememberedEmail();
    if (rememberedEmail) {
        emailInput.value = rememberedEmail;
        isRemember.value = true;
    }
});
// ------------------------------
</script>

<template>
    <Head title="Sign In" />

    <div
        class="relative flex min-h-screen w-full bg-white transition-colors duration-300 dark:bg-zinc-950"
    >
        <button
            @click="toggleTheme"
            class="absolute top-6 left-6 z-50 rounded-full bg-slate-100 p-2.5 text-slate-600 transition-all duration-200 hover:bg-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none dark:bg-zinc-800 dark:text-slate-300 dark:hover:bg-zinc-700"
            aria-label="Toggle Dark Mode"
        >
            <svg
                v-if="!isDark"
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                ></path>
            </svg>
            <svg
                v-else
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
                ></path>
            </svg>
        </button>

        <div
            class="flex w-full items-center justify-center p-8 sm:p-12 lg:w-1/2 lg:p-24"
        >
            <div class="w-full max-w-md">
                <h1
                    class="mb-2 text-4xl font-extrabold text-slate-900 dark:text-white"
                >
                    Sign in
                </h1>
                <p class="mb-10 text-sm text-slate-500 dark:text-slate-400">
                    Don't have an account
                    <TextLink
                        v-if="canRegister"
                        :href="register()"
                        class="ml-1 font-medium text-red-600 hover:underline dark:text-red-500"
                    >
                        Register here
                    </TextLink>
                </p>

                <div
                    v-if="status"
                    class="mb-6 rounded-lg bg-emerald-50 p-4 text-sm font-medium text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400"
                >
                    {{ status }}
                </div>

                <Form
                    v-bind="store.form()"
                    :reset-on-success="['password']"
                    v-slot="{ errors, processing }"
                    class="flex flex-col gap-6"
                    @submit="handleFormSubmit"
                >
                    <div class="relative">
                        <Label
                            for="email"
                            class="font-medium text-slate-700 dark:text-slate-300"
                            >Email</Label
                        >
                        <div class="relative mt-2">
                            <Input
                                id="email"
                                v-model="emailInput"
                                type="email"
                                name="email"
                                required
                                autofocus
                                :tabindex="1"
                                autocomplete="email"
                                placeholder="Enter email"
                                class="w-full rounded-none border-0 border-b-2 border-slate-200 bg-transparent px-0 py-2 text-slate-900 shadow-none transition-colors focus-visible:border-red-600 focus-visible:ring-0 dark:border-zinc-700 dark:text-white dark:focus-visible:border-red-500"
                            />
                            <div
                                class="absolute right-0 bottom-2.5 text-slate-400 dark:text-slate-500"
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                        <InputError :message="errors.email" class="mt-1" />
                    </div>

                    <div class="relative">
                        <Label
                            for="password"
                            class="font-medium text-slate-700 dark:text-slate-300"
                            >Password</Label
                        >
                        <div class="relative mt-2">
                            <Input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                required
                                :tabindex="2"
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full rounded-none border-0 border-b-2 border-slate-200 bg-transparent px-0 py-2 font-bold tracking-widest text-slate-900 shadow-none transition-colors focus-visible:border-red-600 focus-visible:ring-0 dark:border-zinc-700 dark:text-white dark:focus-visible:border-red-500"
                            />

                            <div
                                @click="showPassword = !showPassword"
                                class="absolute right-0 bottom-2.5 cursor-pointer text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300"
                            >
                                <svg
                                    v-if="showPassword"
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    ></path>
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    ></path>
                                </svg>
                                <svg
                                    v-else
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                        <InputError :message="errors.password" class="mt-1" />
                    </div>

                    <div class="mt-2 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <input
                                type="hidden"
                                name="remember"
                                :value="isRemember ? 'on' : ''"
                            />

                            <Checkbox
                                id="remember"
                                :checked="isRemember"
                                @update:checked="isRemember = $event"
                                :tabindex="3"
                                class="border-slate-300 data-[state=checked]:bg-red-600 dark:border-zinc-700"
                            />
                            <Label
                                for="remember"
                                class="cursor-pointer text-sm font-normal text-slate-600 dark:text-slate-400"
                                @click="isRemember = !isRemember"
                            >
                                Remember me
                            </Label>
                        </div>
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-sm font-medium text-red-600 hover:underline dark:text-red-500"
                            :tabindex="5"
                        >
                            Forgot Password?
                        </TextLink>
                    </div>

                    <Button
                        type="submit"
                        class="mt-2 w-full rounded-lg bg-red-600 py-6 text-base text-white transition-all duration-200 hover:bg-red-700"
                        :tabindex="4"
                        :disabled="processing"
                    >
                        <Spinner
                            v-if="processing"
                            class="mr-2 h-5 w-5 animate-spin"
                        />
                        <span>Sign in</span>
                    </Button>
                </Form>
            </div>
        </div>

        <div class="hidden w-1/2 p-4 lg:flex">
            <div
                class="relative flex h-full w-full items-center justify-center overflow-hidden rounded-3xl bg-slate-100 transition-colors duration-300 dark:bg-red-200"
            >
                <img
                    src="@/assets/images/backgrounds/Login.png"
                    alt="Illustration"
                    class="relative z-10 max-h-[80%] max-w-[80%] object-contain"
                />
            </div>
        </div>
    </div>
</template>
