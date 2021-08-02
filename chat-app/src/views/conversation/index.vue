<template>
    <div class="font-poppins">
        <div class="grid grid-cols-8">
            <!-- START CHAT SIDEBAR -->
            <ConversationSidebar :user="user"></ConversationSidebar>
            <!-- END CHAT SIDEBAR -->

            <div class="col-span-6 bg-hint-of-red h-screen">
                <BlankConversation></BlankConversation>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ConversationSidebar from '@/components/conversation/ConversationSidebar.vue'
import BlankConversation from '@/components/conversation/BlankConversation.vue'

export default {
    name: 'Home',

    components: {
        ConversationSidebar,
        BlankConversation,
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
        }),
    },
}
</script>
