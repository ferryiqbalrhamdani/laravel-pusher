<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8 font-poppins">
        <div class="max-w-md w-full space-y-8 border p-8 rounded-md shadow-md bg-white">
            <div>
                <img class="mx-auto h-16 w-auto" src="@/assets/logo.png" alt="Workflow" />
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Login</h2>
            </div>
            <form action="#" class="mt-8 space-y-6" method="POST" @submit.prevent="store()">
                <div class="rounded-md shadow-sm space-y-3">
                    <div>
                        <label for="email-address" class="sr-only">Email address</label>
                        <input
                            id="email-address"
                            name="email"
                            type="email"
                            autocomplete="email"
                            class="
                                appearance-none
                                relative
                                block
                                w-full
                                px-3
                                py-2
                                border border-gray-300
                                placeholder-gray-500
                                text-gray-900
                                focus:outline-none focus:ring-primary-default focus:border-primary-default focus:z-10
                                rounded-md
                            "
                            placeholder="Email address"
                            required
                            v-model="form.email"
                        />
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            class="
                                appearance-none
                                relative
                                block
                                w-full
                                px-3
                                py-2
                                border border-gray-300
                                placeholder-gray-500
                                text-gray-900
                                focus:outline-none focus:ring-primary-default focus:border-primary-default focus:z-10
                                rounded-md
                            "
                            placeholder="Password"
                            required
                            v-model="form.password"
                        />
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="
                            group
                            relative
                            w-full
                            flex
                            justify-center
                            py-2
                            px-4
                            border border-transparent
                            text-lg
                            font-semibold
                            rounded-md
                            text-white
                            bg-primary-default
                            hover:bg-blue-800
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                        "
                    >
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
        }
    },

    methods: {
        ...mapActions({
            login: 'auth/login',
        }),
        async store() {
            await this.login(this.form)
            this.$router.push('/')
        },
    },
}
</script>
