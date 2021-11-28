<template>
    <div class="container">
        <div class="bg-white divide-y divide-gray-200 flex justify-center px-6 py-4">
            <h4><b>Leagues table</b></h4>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team name</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">P</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">W</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">D</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">L</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GD</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PTS</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr class="bg-emerald-200" v-for="standing in data.standings" :key="standing.team_name">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ standing.team_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ standing.played }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ standing.won }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ standing.draw }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ standing.lose }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ standing.goal_drawn }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ standing.points }}</td>
            </tr>
            </tbody>
        </table>
        <hr/>
        <div class="bg-white divide-y divide-gray-200 flex justify-between px-6 py-4">
            <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-3 rounded">
                Previous week
            </button>
            <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-3 rounded">
                Next week
            </button>
        </div>
        <div class="bg-white divide-y divide-gray-200 flex justify-between px-6 py-4 mt-2">
            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Play ALL
            </button>
            <button
                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
                @click="reset"
            >
                Reset
            </button>
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Play current week
            </button>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
import axios from "axios";

export default {
    name: "LeagueTableComponent",
    data() {
        return {}
    },
    async beforeMount() {
        await this.fetchData();
    },
    computed: {
        ...mapGetters({
            data: 'getStandings',
        })
    },
    methods: {
        ...mapActions({
            fetchDataStandings: 'fetchDataStandings'
        }),

        async fetchData() {
            if (this.data.standings.team_name === '') {
                await this.fetchDataStandings();
            }
        },

        async reset() {
            try {
                const response = await axios.get('/reset')

                if (response.status === 200) {
                    await this.fetchDataStandings();
                }
            } catch (e) {
                console.warn(e);
            }
        }
    }
}
</script>

<style scoped>

</style>
