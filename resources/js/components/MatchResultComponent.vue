<template>
    <div class="ml-2">
        <div class="bg-white divide-y divide-gray-200 flex justify-center px-6 py-4">
            <h4>
                <b>Match results</b>
            </h4>
        </div>
        <div class="grid grid-cols-1">
            <div
                class="bg-white px-6 py-3"
                v-for="(p, index) in paginated" :key="index"
            >
                <b>{{ p[0] ? p[0].week_name + ' Week Match Results' : '' }}</b>
                <div class="grid grid-cols-3" v-for="(value, index) in p" :key="index">
                    <div class="px-5 py-3">
                        {{ value.home_team }}
                    </div>
                    <div class="px-5 py-3">
                        {{ value.home_team_goal }} - {{ value.away_team_goal }}
                    </div>
                    <div class="px-5 py-3">
                        {{ value.away_team }}
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white divide-y divide-gray-200 flex justify-between px-6 py-4">
            <button @click="prev" :disabled="current === 1" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-3 rounded">
                Previous week
            </button>
            <button @click="next" :disabled="disabledNext" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-3 rounded">
                Next week
            </button>
        </div>

        <div class="mt-2">
            <prediction-component></prediction-component>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import _ from "lodash";

export default {
    name: "MatchResultComponent",
    async beforeMount() {
        await this.fetchData();
    },
    data() {
        return {
            current: 1,
            pageSize: 1,
            disabledNext: false,
        }
    },
    computed: {
        ...mapGetters({
            data: 'getFixtures',
        }),

        indexStart() {
            return (this.current - 1) * this.pageSize;
        },

        indexEnd() {
            return this.indexStart + this.pageSize;
        },

        paginated() {
            return _.toArray(this.data).slice(this.indexStart, this.indexEnd);
        }
    },
    methods: {
        ...mapActions({
            fetchDataFixtures: 'fetchDataFixtures'
        }),

        async fetchData() {
            if (this.data.id === 0) {
                await this.fetchDataFixtures();
            }
        },

        prev() {
            this.current--;
            this.disabledNext = this.current === _.toArray(this.data).length;
            this.$bus.$emit('week-id', {weekId: this.current});
        },

        next() {
            this.current++;
            this.disabledNext = this.current === _.toArray(this.data).length;
            this.$bus.$emit('week-id', {weekId: this.current});
        }

    }
}
</script>

<style scoped>

</style>
