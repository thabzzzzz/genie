<template>
    <div class="favouriteGameBox">
        <div v-if="showcaseGameId">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-200 p-4">
                    <h4>{{ favouriteGameName }}</h4>
                </div>
                <div class="bg-gray-200 p-4">
                    <img :src="gameImageUrl" alt="Favourite Game" v-if="gameImageUrl" class="fav-game-img" />
                </div>
            </div>
        </div>
        <p v-else>No game selected</p>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    showcaseGameId: {
        type: [Number, String],
        required: false,
    },
    imageUrl: {
        type: String,
        required: true,
    },
});

const favouriteGameName = ref('');
const gameImageUrl = ref(props.imageUrl);

onMounted(async () => {
    if (!props.showcaseGameId) {
        return;
    }

    try {
        // Fetch the favourite game details (name, image) from the backend
        const response = await axios.get(`/api/favourite-game/${props.showcaseGameId}`);
        favouriteGameName.value = response.data.favourite_game;
        gameImageUrl.value = response.data.favgame_image || props.imageUrl;

        // If no game name or image, make API call to RAWG
        if (!favouriteGameName.value || !gameImageUrl.value) {
            const rawgData = await fetchFromRawgAPI(props.showcaseGameId);
            favouriteGameName.value = rawgData.name;
            gameImageUrl.value = rawgData.imageUrl;

            // Save the fetched data to the user's table via a backend call
            await axios.post('/api/save-favourite-game', {
                showcaseGameId: props.showcaseGameId,
                name: rawgData.name,
                imageUrl: rawgData.imageUrl,
            });
        }
    } catch (error) {
        console.error('Error fetching or saving the favourite game:', error);
    }
});

async function fetchFromRawgAPI(gameId) {
    // Example API call to RAWG to fetch game details
    const rawgApiKey = 'YOUR_RAWG_API_KEY';
    const response = await axios.get(`https://api.rawg.io/api/games/${gameId}?key=36e199df12d14562ad36f3befadf81d5`);
    const gameData = response.data;

    return {
        name: gameData.name,
        imageUrl: gameData.background_image,
    };
}
</script>


<style scoped>
.favouriteGameBox {
    border: black solid 2px;
    margin-top: 2em;
    padding: 2em;
}

.fav-game-img {
    width: 100%;
    height: auto;
    object-fit: cover;
}
</style>
