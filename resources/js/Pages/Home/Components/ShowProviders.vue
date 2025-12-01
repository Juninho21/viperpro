<template>
    <div :key="index" class="game-list flex flex-col mt-5 relative">
        <div class="w-full flex justify-between mb-2">
            <h2 class="text-xl font-bold">{{ $t(provider.name) }}</h2>
            <div class="flex">
                <RouterLink
                    :to="{ name: 'casinosAll', params: { provider: provider.id, category: 'all' } }"
                    class="item-game px-3 py-2 mr-2 rounded">
                    {{ $t('See all') }}
                </RouterLink>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            <CassinoGameCard
                v-for="(game, providerId) in provider.games"
                :key="providerId"
                :index="providerId"
                :title="game.game_name"
                :cover="game.cover"
                :gamecode="game.game_code"
                :type="game.distribution"
                :game="game"
            />
        </div>
    </div>
</template>


<script>
import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";

export default {
    props: ['provider', 'index'],
    components: { CassinoGameCard },
    data() {
        return {
            isLoading: false,
        }
    },
    setup(props) {
        return {};
    },
    computed: {

    },
    mounted() {

    },
    methods: {

    },
    watch: {

    },
};
</script>

<style scoped>

</style>
