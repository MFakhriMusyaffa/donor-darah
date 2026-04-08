<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';

// --- Logika Dark/Light Mode ---
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
    <Head title="Sign Up" />

    <div
        class="flex min-h-screen w-full bg-white font-sans transition-colors duration-300 dark:bg-zinc-950"
    >
        <button
            @click="toggleTheme"
            class="absolute top-6 left-6 z-50 rounded-full bg-white/80 p-2.5 text-slate-600 shadow-sm backdrop-blur-sm transition-all duration-200 hover:bg-slate-100 focus:ring-2 focus:ring-red-500 focus:outline-none dark:bg-zinc-800/80 dark:text-slate-300 dark:hover:bg-zinc-700"
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
            class="relative hidden w-1/2 items-center justify-center overflow-hidden bg-gradient-to-br from-red-50 via-rose-50 to-white p-12 lg:flex dark:from-red-950/30 dark:via-rose-900/20 dark:to-zinc-950"
        >
            <div
                class="absolute h-[600px] w-[600px] rounded-full border border-red-200/50 dark:border-red-500/10"
            ></div>
            <div
                class="absolute h-[400px] w-[400px] rounded-full border border-rose-200/50 dark:border-rose-500/10"
            ></div>

            <img
                src="@/assets/images/backgrounds/Register.png"
                alt="Dashboard Preview"
                class="relative z-10 w-full max-w-2xl rounded-xl border border-white/50 object-contain shadow-2xl dark:border-zinc-800"
            />
        </div>

        <div
            class="flex w-full flex-col overflow-y-auto p-8 sm:p-12 lg:w-1/2 lg:px-24 lg:py-12"
        >
            <div class="mx-auto flex h-full w-full max-w-md flex-col">
                <a
                    href="/"
                    class="mb-12 flex w-fit items-center gap-2 text-sm text-slate-500 transition-colors hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        ></path>
                    </svg>
                    Back to the website
                </a>

                <div class="mb-8">
                    <div class="mb-6 flex items-center gap-2.5"></div>
                    <h1
                        class="mb-2 text-3xl font-bold text-slate-900 dark:text-white"
                    >
                        Sign Up to Donor Darah
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Ship Faster and Focus on Growth.
                    </p>
                </div>

                <Form
                    v-bind="store.form()"
                    :reset-on-success="['password', 'password_confirmation']"
                    v-slot="{ errors, processing }"
                    class="flex grow flex-col gap-5"
                >
                    <div class="grid gap-1.5">
                        <Label
                            for="name"
                            class="text-sm font-medium text-slate-700 dark:text-slate-300"
                            >Username<span class="text-red-500">*</span></Label
                        >
                        <Input
                            id="name"
                            type="text"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="name"
                            name="name"
                            placeholder="Enter your username"
                            class="w-full rounded-lg border-slate-300 py-2.5 text-slate-900 shadow-sm focus-visible:ring-red-600 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:focus-visible:ring-red-500"
                        />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="grid gap-1.5">
                        <Label
                            for="email"
                            class="text-sm font-medium text-slate-700 dark:text-slate-300"
                            >Email address<span class="text-red-500"
                                >*</span
                            ></Label
                        >
                        <Input
                            id="email"
                            type="email"
                            required
                            :tabindex="2"
                            autocomplete="email"
                            name="email"
                            placeholder="Enter your email address"
                            class="w-full rounded-lg border-slate-300 py-2.5 text-slate-900 shadow-sm focus-visible:ring-red-600 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:focus-visible:ring-red-500"
                        />
                        <InputError :message="errors.email" />
                    </div>

                    <div class="relative grid gap-1.5">
                        <Label
                            for="password"
                            class="text-sm font-medium text-slate-700 dark:text-slate-300"
                            >Password<span class="text-red-500">*</span></Label
                        >
                        <div class="relative">
                            <Input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                :tabindex="3"
                                autocomplete="new-password"
                                name="password"
                                placeholder="••••••••"
                                class="w-full rounded-lg border-slate-300 py-2.5 pr-10 text-slate-900 shadow-sm focus-visible:ring-red-600 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:focus-visible:ring-red-500"
                            />
                            <div
                                @click="showPassword = !showPassword"
                                class="absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer text-slate-400"
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
                        <InputError :message="errors.password" />
                    </div>

                    <div class="relative grid gap-1.5">
                        <Label
                            for="password_confirmation"
                            class="text-sm font-medium text-slate-700 dark:text-slate-300"
                            >Confirm Password<span class="text-red-500"
                                >*</span
                            ></Label
                        >
                        <div class="relative">
                            <Input
                                id="password_confirmation"
                                :type="
                                    showConfirmPassword ? 'text' : 'password'
                                "
                                required
                                :tabindex="4"
                                autocomplete="new-password"
                                name="password_confirmation"
                                placeholder="••••••••"
                                class="w-full rounded-lg border-slate-300 py-2.5 pr-10 text-slate-900 shadow-sm focus-visible:ring-red-600 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:focus-visible:ring-red-500"
                            />
                            <div
                                @click="
                                    showConfirmPassword = !showConfirmPassword
                                "
                                class="absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer text-slate-400"
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
                        <InputError :message="errors.password_confirmation" />
                    </div>

                    <div class="mt-1 flex items-center space-x-2">
                        <!-- <Checkbox
                            id="terms"
                            required
                            :tabindex="5"
                            class="border-slate-300 data-[state=checked]:bg-red-600 dark:border-zinc-700"
                        />
                        <Label
                            for="terms"
                            class="cursor-pointer text-sm font-normal text-slate-600 dark:text-slate-400"
                        >
                            I agree to
                            <a
                                href="#"
                                class="text-red-600 hover:underline dark:text-red-500"
                                >privacy policy & terms?</a
                            >
                        </Label> -->
                    </div>

                    <Button
                        type="submit"
                        class="mt-2 w-full rounded-lg bg-red-600 py-6 text-base font-medium text-white shadow-sm transition-all duration-200 hover:bg-red-700 active:scale-[0.98]"
                        :tabindex="6"
                        :disabled="processing"
                        data-test="register-user-button"
                    >
                        <Spinner
                            v-if="processing"
                            class="mr-2 h-5 w-5 animate-spin"
                        />
                        <span>Sign Up to Donor Darah</span>
                    </Button>

                    <div
                        class="mt-2 text-center text-sm text-slate-500 dark:text-slate-400"
                    >
                        Already have an account?
                        <TextLink
                            :href="login()"
                            class="font-medium text-red-600 hover:underline dark:text-red-500"
                            :tabindex="7"
                        >
                            Sign in instead
                        </TextLink>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>
