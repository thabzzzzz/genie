<template>
  <div>
    <div v-if="!wishlistGameIds || wishlistGameIds.length === 0">
      <p>Loading...</p>
    </div>
    <div v-else>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div class="col" v-for="gameId in wishlistGameIds" :key="gameId">
          <div class="card product-card">
            <div class="relative">
              <a :href="`/gamedetail/${gameId}`">
                <img v-if="gameNames[gameId] && gameNames[gameId].image" :src="gameNames[gameId].image" alt="Game cover" />
              </a>
              <!-- image here -->
              <div class="card-buttons">
                <a href="{{ route('item.edit',['item'=>$item]) }}" class="my-btn-2" title="Bookmark">
                  <img src="site-images/cardicons/bookmark-plus-fill.svg" alt="">
                </a>
              </div>
              <div class="prodcard-body py-3">
             
                <!-- Display the game name once it's fetched -->
          
               

                <div class="prodcard-body py-3">
                  <p class="card-title" v-if="gameNames[gameId]">{{ gameNames[gameId].name }}</p>
               
                  <p class="additional-text" v-if="gameNames[gameId]">{{ gameNames[gameId].releasedDate }}</p>
                  <p v-else>Loading game ...</p>
              </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
  props: {
    wishlistGameIds: {
      type: Array,
      required: true,
    },
  },
  setup(props) {
    const gameNames = ref({}); // Use ref for reactive property

    const fetchGameNames = async () => {
      try {
        for (const gameId of props.wishlistGameIds) {
          const name = await getGameName(gameId);
          // Use Vue.set or directly set the property
          gameNames.value[gameId] = name;
        }
      } catch (error) {
        console.error('Error fetching game names:', error);
      }
    };

    const getGameName = async (gameId) => {
  try {
    console.log('Fetching game name for game ID:', gameId);
    const response = await fetch(`https://api.rawg.io/api/games/${gameId}?key=36e199df12d14562ad36f3befadf81d5`);
    const data = await response.json();
    console.log('Game name fetched:', data.name);

    // Extract and format release date (unchanged)
    const releaseDate = new Date(data.released);
    const formattedDate = releaseDate.toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });

    const imageUrl = data.background_image || data.background_image_large; // Use fallback

    return {
      name: data.name,
      releasedDate: formattedDate,
      image: imageUrl,
    };
  } catch (error) {
    console.error('Error fetching game name:', error);
    return 'Error fetching game name';
  }
};

    onMounted(() => {
      fetchGameNames();
    });

    return {
      gameNames,
    };
  },
};
</script>

<style scoped>


.clamp-description {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  -webkit-line-clamp: 3; 
}



.card {
  background-color: #f9f9f9;
  border: 1px solid black;
  margin: 1px; 
  overflow: hidden;
  transition: transform 0.3s;
  display: flex; /* Add display:flex to make sure the card content is vertically centered */
}

.card-body {
  flex: 1; /* Add flex: 1 to make sure the card body takes up the remaining space */
  padding: 1rem;
}

.card-title {
  font-size: 13px;
  margin-bottom: 0.5rem;
}

.card-text {
  font-size: 1rem;
  color: #555;
}

.card-price {
  font-size: 1.25rem;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

.card-buttons {
  display: flex;
  justify-content: space-between;
}






.prodcard-body{
  padding-left: 10px;
}

.prodcard-body {
  display: flex; 
  justify-content: space-between;
  align-items: center; 
}

.card-title {
  margin: 0; 
}


.card-buttons {
  display: flex;
  justify-content: space-between;
  opacity: 0; /* Initially hidden */
  transition: opacity 0.3s ease;
}

.card:hover .card-buttons {
  opacity: 1; /* Show buttons on hover */
}



</style>
