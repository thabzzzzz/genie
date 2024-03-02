<template>
  <div class="card border border-black mx-auto product-card" style="width: 21rem;" v-for="game in games" :key="game.id">
    <img :src="getCoverImageUrl(game)" class="card-img-top" :alt="game.name">
    <div class="card-body product-card-body p-2">
      <b class="card-title">{{ game.name }}</b>
      <br>
      <br>
      <div class="description-text clamp-description"><i class="card-text">{{ game.summary }}</i></div>
      <br>
      <span class="card-price">Price: N/A</span>
      <br>
      <br>
      <!-- Add any additional buttons or links here -->
    </div>
  </div>
</template>

<script>
export default {
  props: {
    games: Array // Assuming games is an array of objects with name, summary, and cover.url properties
  },
  methods: {
    getCoverImageUrl(game) {
      return game.cover ? `https:${game.cover.url}` : 'placeholder_image_url.jpg';
    }
  }
}
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
  -webkit-line-clamp: 3; /* Number of lines to display */
}

/* Add styles for buttons, icons, etc. */
</style>
