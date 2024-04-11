<template>
  <div>
    <div>
      <h1>Filters:</h1>
      <h1>Search:</h1>
    </div>
    <div v-if="!games || games.length === 0">
      <p>Loading...</p>
    </div>
    <div v-else>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 ">
        <div class="col" v-for="game in games" :key="game.id">
          <div class="card product-card" >
            <div class="relative">
              <a :href="`/gamedetail/${game.id}`">
        <img :src="getCoverImageUrl(game)" class="card-img-top" :alt="game.name">
      
    </a>

              
            
              <div class="prodcard-body py-3">
                <p class="card-title">{{ game.name }}</p>
                <p class="card-title">{{ game.website}} </p>
                <p class="additional-text">[{{ game.released }}]</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    games: {
      type: Array,
      required: true,
    },
  },
  methods: {
    getCoverImageUrl(game) {
      return game.background_image || 'placeholder_image_url.jpg';
    },
  },
  mounted() {
    console.log('games prop:', this.games); 

    if (this.games && this.games.results) {
      console.log('Results:', this.games.results);
    } else {
      console.log('Games or Results is undefined or empty:', this.games);
    }
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
