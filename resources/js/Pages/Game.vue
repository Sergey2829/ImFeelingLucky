<template>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-lg justify-center bg-white shadow-xl rounded-xl p-6">
            <h1 class="text-xl text-gray-800 font-semibold text-center mb-6">Filing Lucky Game</h1>

            <div class="mb-7">
                <button
                    v-if="!uniqueLink.id"
                    @click="generateLink"
                    class="w-full rounded bg-blue-500 hover:bg-blue-600 justify-center font-medium py-3 px-4 mb-2"
                >
                     Generate unique link for the new game
                </button>
                <div v-if="uniqueLink.id" class="flex items-center justify-center mb-1">
                    <a :href="uniqueLink.url"  class="text-blue-500 underline">
                        Your new temporary game link
                    </a>
                </div>
                <button v-if="uniqueLink.id"
                    @click="deactivateLink"
                    class="w-full rounded bg-red-500  hover:bg-red-600 justify-center font-medium py-3 px-4 mb-2"
                >
                    Deactivate the link
                </button>

                <button
                    @click="handleImFeelingLucky"
                    class="w-full rounded bg-sky-600 text-stone-200  hover:bg-sky-700 justify-center font-medium py-3 px-4 mb-2"
                >
                    Imfeelinglucky
                </button>
                <div v-if="luckyResult" class="mt-3 p-4 bg-gray-100 rounded-xl shadow-md">
                    <p class="text-gray-800"><strong>Your number:</strong> {{ luckyResult.number }}</p>
                    <p class="text-gray-800"><strong>Your result:</strong>
                        <span :class="luckyResult.win ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold'">
                        {{ luckyResult.win ? ' Win' : ' Lost' }}
                        </span>
                    </p>
                    <p class="text-gray-800"><strong>Your win amount:</strong> {{luckyResult.amount }}</p>
                </div>

                <button
                    @click="showHistory"
                    class="w-full rounded bg-green-300 text-slate-50  hover:bg-green-500 justify-center font-medium py-3 px-4"
                >
                    History
                </button>
                <div v-if="visibleHistory" class="mt-1">
                    <table v-if="history.length" class="w-full border-collapse">
                        <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="p-2 border border-gray-300">#</th>
                            <th class="p-2 border border-gray-300">Number</th>
                            <th class="p-2 border border-gray-300">Result</th>
                            <th class="p-2 border border-gray-300">Win Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(game, index) in history" :key="index" class="text-gray-800 text-center bg-white odd:bg-gray-50">
                            <td class="p-2 border border-gray-300">{{ index + 1 }}</td>
                            <td class="p-2 border border-gray-300">{{ game.number }}</td>
                            <td class="p-2 border border-gray-300">
                    <span :class="game.win ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold'">
                        {{ game.win ? 'Win' : 'Lost' }}
                    </span>
                            </td>
                            <td class="p-2 border border-gray-300 font-medium">
                                {{ game.amount }}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <p v-else class="text-base text-center text-gray-700">
                        Let's start playing to get your win history.
                    </p>
                </div>
            </div>


        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: {
        userId: String,
        history: []
    },
    data() {
        return {
            uniqueLink: {
                id: null,
                url: null
            },
            luckyResult: null,
            visibleHistory: false,
        };
    },
    methods: {
        async generateLink() {
            try {
                const response = await axios.get('link', {
                    params: {user_id: this.$props.userId}
                });

                this.uniqueLink.url = response.data.link.url;
                this.uniqueLink.id = response.data.link.id;
            } catch (error) {
                console.error("Error generating link:", error);
            }
        },
        deactivateLink() {
            if (!this.uniqueLink.id) {
                return false
            }
            try {
                 axios.delete('link', {
                    params: {id: this.uniqueLink.id}
                });

            } catch (error) {
                console.error("Error deactivate link:", error);
            }
            this.uniqueLink.id = this.uniqueLink.url = null;
        },
        async handleImFeelingLucky() {
            try {
                const response = await axios.post('game', {
                    user_id: this.$props.userId
                });
                this.luckyResult = response.data;

                // Add to history
                this.$props.history.unshift(this.luckyResult);
                if (this.$props.history.length > 3) {
                    this.$props.history.pop();
                }
            } catch (error) {
                console.error("Error fetching lucky result:", error);
            }
        },
        showHistory() {
             this.visibleHistory = !this.visibleHistory
        },
    },
};
</script>

<style scoped>
button:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
}
</style>
