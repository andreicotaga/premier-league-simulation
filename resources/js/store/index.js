import Vue from 'vue';
import Vuex from 'vuex';

import StandingModule from './modules/standings';
import FixtureModule from './modules/fixtures';
import PredictionModule from './modules/prediction';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        standing: StandingModule,
        fixtures: FixtureModule,
        prediction: PredictionModule,
    }
});
