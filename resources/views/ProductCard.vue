<template>
  <div>
    <div v-if="!games || games.length === 0">
      
      <p>Loading...</p>
    </div>
    <div v-else>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-10">
        <div v-for="game in games" :key="game.id" class="card border border-texttheme mx-auto product-card" style="width: 21rem;">
          <img :src="getCoverImageUrl(game)" class="card-img-top" :alt="game.name">
          <div class="card-body product-card-body p-2">
            <b class="card-title">{{ game.name }}</b>
            <br>
            <span v-for="(platform, index) in game.platforms" :key="index">{{ platform.platform.name }}</span>
            <br>
            <br>
            <div class="description-text clamp-description"><i class="card-text">{{ game.summary }}</i></div>
            <br>
            <span class="card-price">Price: N/A</span>
            <br>
            <a :href="game.url" class="btn my-btn-2 text-black inline-block mr-1" target="_blank" title="Visit site">
              Visit Game
            </a>
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
.card {
  border: 1px solid black;
  width: 21rem;
}

.clamp-description {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  -webkit-line-clamp: 3; 
}


</style>
