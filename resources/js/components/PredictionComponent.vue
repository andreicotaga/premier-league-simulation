<template>
    <div v-if="data">
        <div class="bg-white divide-y divide-gray-200 flex justify-center px-6 py-4">
            <h4>
                <b>Prediction</b>
            </h4>
        </div>
        <div
            class="bg-white"
            v-for="(score, key) in data" :key="key"
        >
            <div class="grid grid-cols-2">
                <div class="px-2 py-2">
                    {{ key }}
                </div>
                <div class="px-2 py-2">
                    <b>{{ score + '%' }}</b>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "PredictionComponent",
    data() {
        return {}
    },
    async beforeMount() {
        await this.fetchData();
    },
    computed: {
        ...mapGetters({
            data: 'getPrediction',
        })
    },
    methods: {
        ...mapActions({
            fetchDataPrediction: 'fetchDataPrediction',
        }),

        async fetchData() {
            //if (this.data.standings.team_name === '') {
                await this.fetchDataPrediction();
            //}

            console.log(this.data);
        },
    }
}
</script>

<style scoped>

</style>
