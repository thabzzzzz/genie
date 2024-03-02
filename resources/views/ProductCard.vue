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
      <a :href="game.url" class="btn my-btn-2 text-black inline-block mr-1" target="_blank" title="Visit site">
        Visit Game
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    games: Array
  },
  methods: {
    getCoverImageUrl(game) {
  if (!game.cover || !game.cover.url) return 'placeholder_image_url.jpg';
  const coverUrl = game.cover.url;
  const modifiedUrl = coverUrl.replace('/t_thumb/', '/t_cover_big/');
  return `https:${modifiedUrl}`;
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
