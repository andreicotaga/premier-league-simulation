import axios from "axios";

export default {
    async fetchDataStandings({dispatch, getters, commit}) {
        let fetchStandingsPromise = dispatch('fetchStandings');
        commit('STANDING', await fetchStandingsPromise.then(response => response))
    },

    async fetchStandings() {
        try {
            const response = await axios.get('/standings')

            if (response.status !== 200) {
                throw new Error(response.status);
            }

            return response.data.data;
        } catch (e) {
            console.warn(e);
        }
    }
}
