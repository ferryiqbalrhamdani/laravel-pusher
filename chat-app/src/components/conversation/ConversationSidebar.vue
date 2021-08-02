<template>
    <div class="col-span-2 border-r border-gray-200">
        <div class="p-8 h-screen overflow-auto scroller">
            <div class="flex justify-center">
                <div class="relative">
                    <img class="rounded-full object-cover h-24 w-24" :src="require('@/assets/' + user.avatar)" />
                    <span class="absolute right-2 bottom-0 border-2 border-white w-4 h-4 bg-green-500 rounded-full"></span>
                </div>
            </div>
            <div class="text-center mt-4">
                <h1 class="text-lg font-medium text-gray-800">{{ user.name }}</h1>
            </div>
            <hr class="my-4" />
            <h2 class="font-medium text-gray-700 mb-6 text-center">Chats</h2>
            <div v-for="people in users" :key="people.id">
                <div class="mb-8" v-if="user.id != people.id">
                    <router-link
                        :to="{
                            name: 'conversation.show',
                            params: { id: people.id },
                        }"
                        class="flex justify-center items-center"
                    >
                        <img class="rounded-full object-cover h-14 w-14" :src="require('@/assets/' + people.avatar)" />
                        <div class="ml-3 lg:flex justify-between items-center w-full hidden lg:visible">
                            <div class="space-y-1">
                                <h3 class="font-medium text-gray-800">{{ people.name }}</h3>
                                <p class="text-sm text-gray-400">Lorem ipsum dolo...</p>
                            </div>
                            <p class="text-sm text-gray-400">03:00</p>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    props: ['user'],

    data() {
        return {
            users: [],
        }
    },

    mounted() {
        this.fetchUsers()
    },

    methods: {
        async fetchUsers() {
            let { data } = await axios.get('api/user')
            this.users = data.data
        },
    },
}
</script>

<style>
.scroller {
    overflow-y: scroll;
    scrollbar-width: thin;
}

.router-link-exact-active {
    background-color: rgba(243, 244, 246, 1);
    border-radius: 5%;
}
</style>
