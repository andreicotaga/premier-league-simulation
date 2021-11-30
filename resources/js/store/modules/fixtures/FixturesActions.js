import axios from "axios";

export default {
    async fetchDataFixtures({dispatch, getters, commit}) {
        let fetchFixturesPromise = dispatch('fetchFixtures');

        await Promise.resolve(fetchFixturesPromise);
        let value = await fetchFixturesPromise.then(response => response.fixtures);

        commit('FIXTURE', value)
    },

    async fetchFixtures() {
        try {
            const response = await axios.get('/fixtures')

            if (response.status !== 200) {
                throw new Error(response.status);
            }

            return response.data.data;
        } catch (e) {
            console.warn(e);
        }
    }
}
