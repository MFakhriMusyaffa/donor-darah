<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { update } from '@/routes/password';

const props = defineProps<{
    token: string;
    email: string;
}>();

const inputEmail = ref(props.email);

// --- Logika Dark/Light Mode & Password Toggle ---
const isDark = ref(false);
const showPassword = ref(false);
const showConfirmPassword = ref(false);

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
    <Head title="Reset Password" />

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
                    Reset Password
                </h1>
                <p class="mb-10 text-sm text-slate-500 dark:text-slate-400">
                    Please enter your new password below.
                </p>

                <Form
                    v-bind="update.form()"
                    :transform="(data) => ({ ...data, token, email })"
                    :reset-on-success="['password', 'password_confirmation']"
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
                                v-model="inputEmail"
                                readonly
                                class="w-full cursor-not-allowed rounded-none border-0 border-b-2 border-slate-200 bg-transparent px-0 py-2 text-slate-500 shadow-none dark:border-zinc-800 dark:text-slate-500"
                            />
                            <div
                                class="absolute right-0 bottom-2.5 text-slate-300 dark:text-slate-600"
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
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
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
                            >New Password</Label
                        >
                        <div class="relative mt-2">
                            <Input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                autocomplete="new-password"
                                autofocus
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

                    <div class="relative">
                        <Label
                            for="password_confirmation"
                            class="font-medium text-slate-700 dark:text-slate-300"
                            >Confirm Password</Label
                        >
                        <div class="relative mt-2">
                            <Input
                                id="password_confirmation"
                                :type="
                                    showConfirmPassword ? 'text' : 'password'
                                "
                                name="password_confirmation"
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full rounded-none border-0 border-b-2 border-slate-200 bg-transparent px-0 py-2 font-bold tracking-widest text-slate-900 shadow-none transition-colors focus-visible:border-red-600 focus-visible:ring-0 dark:border-zinc-700 dark:text-white dark:focus-visible:border-red-500"
                            />
                            <div
                                @click="
                                    showConfirmPassword = !showConfirmPassword
                                "
                                class="absolute right-0 bottom-2.5 cursor-pointer text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300"
                            >
                                <svg
                                    v-if="showConfirmPassword"
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
                        <InputError
                            :message="errors.password_confirmation"
                            class="mt-1"
                        />
                    </div>

                    <Button
                        type="submit"
                        class="mt-4 w-full rounded-lg bg-red-600 py-6 text-base text-white transition-all duration-200 hover:bg-red-700"
                        :disabled="processing"
                        data-test="reset-password-button"
                    >
                        <Spinner
                            v-if="processing"
                            class="mr-2 h-5 w-5 animate-spin"
                        />
                        <span>Reset Password</span>
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
