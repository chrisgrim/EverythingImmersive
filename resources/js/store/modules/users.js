import _ from 'lodash';

export default {
    namespaced: true,
    state: {
        user: ! _.isEmpty(window.user) ? window.user : null,
    },
    mutations: {
        // sample mutation
        setUserEmail(state, newValue) {
            state.user.email = newValue;
        }
    },
    actions: {

    },
    getters: {
        isLoggedIn: (state) => {
            return _.has(state.user, 'id') ? true : false;
        },
        isGuest: (state, getters) => {
            return (! getters.isLoggedIn) ? true : false;
        },
    }
};
