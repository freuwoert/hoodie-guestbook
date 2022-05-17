<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Login" />

    <div class="container">
        <div class="limiter">
            <BreezeValidationErrors class="mb-4" />
        
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>
        
            <form @submit.prevent="submit">
                <mui-input no-border type="email" label="Email" required autocomplete="username" v-model="form.email"/>
                <mui-input no-border type="password" label="Password" required autocomplete="current-password" v-model="form.password"/>
        
                <mui-toggle class="remember" no-border v-model="form.remember" append-label="Remember me"/>
        
                <mui-button type="submit" icon-left="login" label="Login" :loading="form.processing"/>
            </form>
        </div>
    </div>

</template>

<style lang="sass" scoped>
    .container
        width: 100%
        height: 100vh
        display: flex
        justify-content: center
        align-items: center

    .limiter
        flex: 1
        
        form
            display: flex
            flex-direction: column
            gap: 1rem

            --mui-background: var(--color-background-secondary)

            .remember
                background: var(--color-background-secondary)
                justify-content: flex-start
</style>