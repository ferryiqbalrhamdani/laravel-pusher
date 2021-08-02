<template>
    <div class="p-8 h-full relative">
        <div class="flex items-center">
            <img class="w-12 h-12 rounded-full" :src="require('@/assets/' + current_user.avatar)" />
            <h2 class="ml-3 font-medium text-gray-800">{{ current_user.name }}</h2>
        </div>

        <div class="h-3/4 flex items-center" v-if="isLoading">
            <vue-loading type="bars" color="#d9544e" :size="{ width: '50px', height: '50px' }"></vue-loading>
        </div>

        <div class="mt-6 w-full h-3/4 overflow-auto scroller" v-else>
            <div v-if="conversation.messages.length > 0">
                <div v-for="message in conversation.messages" :key="message.id">
                    <!-- START YOUR CHAT -->
                    <div class="text-right" v-if="message.user_id == user.id">
                        <div class="bg-primary-default inline-block text-white my-2 p-4 rounded-lg" style="max-width: 56.6%">{{ message.body }}</div>
                    </div>
                    <!-- END YOUR CHAT -->

                    <!-- START OTHERS CHAT -->
                    <div class="text-left" v-else>
                        <div class="bg-white inline-block text-gray-800 my-2 p-4 rounded-lg" style="max-width: 56.6%">{{ message.body }}</div>
                    </div>
                    <!-- END OTHERS CHAT -->
                </div>
            </div>

            <div class="w-full h-full flex items-center justify-center" v-else>
                <div class="flex flex-col items-center">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 stroke-current text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"
                            />
                        </svg>
                    </span>
                    <h1 class="mt-5 text-xl font-medium text-gray-400">Obrolan belum ada, silahkan memulai obrolan</h1>
                </div>
            </div>
        </div>

        <div class="absolute w-full bottom-0 left-0 right-0 p-8">
            <form method="POST" class="flex justify-between items-center space-x-3" @submit.prevent="store">
                <input
                    name="message"
                    class="w-full shadow py-3 px-6 rounded-full bg-white focus:outline-none focus:ring focus:border-blue-200"
                    placeholder="Start typing . . ."
                    type="text"
                    autofocus
                    v-model="message"
                />
                <button type="submit" class="transform rotate-45">
                    <span class="bg-primary-default rounded-full h-12 w-12 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { VueLoading } from 'vue-loading-template'
import { mapGetters } from 'vuex'

export default {
    components: {
        VueLoading,
    },

    data() {
        return {
            current_user: '',
            conversation: '',
            isLoading: true,

            message: '',
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
        }),
    },

    mounted() {
        this.fetchCurrentUser(this.$route.params.id)
        this.fetchConversation(this.$route.params.id)

        window.Echo.channel('message').listen('MessageCreated', (event) => {
            console.log('Event : ', event.message.body)
            this.conversation.messages.push({ body: event.message.body })
        })
    },

    methods: {
        async fetchCurrentUser(id) {
            this.isLoading = true
            let { data } = await axios.get('api/user/' + id)
            this.current_user = data.data
        },
        async fetchConversation(id) {
            let { data } = await axios.get('api/conversation/' + id)
            this.conversation = data.data
            this.isLoading = false
        },

        async store() {
            await axios({
                method: 'post',
                url: `api/conversation/${this.conversation.id}/message`,
                data: {
                    body: this.message,
                },
                headers: {
                    'X-Socket-Id': window.Echo.socketId(),
                },
            })
            this.message = ''

            this.fetchConversation(this.$route.params.id)
        },
    },

    watch: {
        '$route.params.id'(newId) {
            this.fetchCurrentUser(newId)
            this.fetchConversation(newId)
        },
    },
}
</script>
