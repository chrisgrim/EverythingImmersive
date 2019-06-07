const state = {
    all:[],
    params:{

    }
}

const mutations = {
    /**
     * Mutate state from actions
     * @param {Object} state
     * @param {Array} events
     * @return void
     */
    index(state,events){
        state.all = events;
    },
    filterEvent(state,e){
        state.params[e.target.name] = e.target.value;
    }
}

const actions = {
    /**
     * Listing all events data from API
     * we will be using async/await
     * @param {Function} commit
     * @return void  
     */
    async index({commit,state}){
        const {params} = state
        axios.get(`/api/events`,{
            params
        }).then(res => {
            commit('index',res.data);
        })
    },
}

export default {
    namespaced:true,
    state,
    mutations,
    actions
}