import Vue from 'vue';
import Vuex from 'vuex';

import StandingModule from './modules/standings';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        standing: StandingModule
    }
});
