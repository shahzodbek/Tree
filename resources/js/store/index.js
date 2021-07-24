import Vue from 'vue'
import Vuex from 'vuex'
import state from './state'
import mutations from './mutations.js'
import actions from './actions.js'

Vue.use(Vuex)

export default new Vuex.Store({
    mutations: mutations,
    actions: actions,
    state: state
})
