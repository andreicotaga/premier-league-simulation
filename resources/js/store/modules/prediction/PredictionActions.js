import axios from "axios";

export default {
    async fetchDataPrediction({dispatch, getters, commit}) {
        let fetchPredictionPromise = dispatch('fetchPrediction');

        await Promise.resolve(fetchPredictionPromise);
        let value = await fetchPredictionPromise.then(response => response);

        commit('PREDICTION', value)
    },

    async fetchPrediction() {
        try {
            const response = await axios.get('/prediction')

            if (response.status !== 200) {
                throw new Error(response.status);
            }

            return response.data.data;
        } catch (e) {
            console.warn(e);
        }
    }
}
