import { mapState, mapMutations, mapGetters } from 'vuex';

export default {
    computed: {
        ...mapState('users', {
            loggedInUser: 'user'
        }),
        ...mapGetters('users', [
            'isLoggedIn', 'isGuest'
        ]),
    },
    methods: {
        ...mapMutations('users', [
            'setUserEmail'
        ]),
    }
};