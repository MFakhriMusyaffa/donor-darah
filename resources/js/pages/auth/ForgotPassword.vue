<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { email } from '@/routes/password';

defineProps<{
    status?: string;
}>();

// --- Logika Dark/Light Mode ---
const isDark = ref(false);

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

onMounted(() => {
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
});
// ------------------------------
</script>

<template>
    <Head title="Forgot Password" />

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
                    Forgot Password
                </h1>
                <p class="mb-10 text-sm text-slate-500 dark:text-slate-400">
                    Enter your email to receive a password reset link.
                </p>

                <div
                    v-if="status"
                    class="mb-6 rounded-lg bg-emerald-50 p-4 text-sm font-medium text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400"
                >
                    {{ status }}
                </div>

                <Form
                    v-bind="email.form()"
                    v-slot="{ errors, processing }"
                    class="flex flex-col gap-6"
                >
                    <div class="relative">
                        <Label
                            for="email"
                            class="font-medium text-slate-700 dark:text-slate-300"
                            >Email address</Label
                        >
                        <div class="relative mt-2">
                            <Input
                                id="email"
                                type="email"
                                name="email"
                                required
                                autofocus
                                autocomplete="off"
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

                    <Button
                        type="submit"
                        class="mt-4 w-full rounded-lg bg-red-600 py-6 text-base text-white transition-all duration-200 hover:bg-red-700"
                        :disabled="processing"
                        data-test="email-password-reset-link-button"
                    >
                        <Spinner
                            v-if="processing"
                            class="mr-2 h-5 w-5 animate-spin"
                        />
                        <span>Email password reset link</span>
                    </Button>

                    <div
                        class="mt-2 text-center text-sm text-slate-500 dark:text-slate-400"
                    >
                        Or, return to
                        <TextLink
                            :href="login()"
                            class="font-medium text-red-600 hover:underline dark:text-red-500"
                        >
                            log in
                        </TextLink>
                    </div>
                </Form>
            </div>
        </div>

        <div class="hidden w-1/2 p-4 lg:flex">
            <div
                class="relative flex h-full w-full items-center justify-center overflow-hidden rounded-[2rem] bg-slate-100 transition-colors duration-300 dark:bg-red-200"
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
