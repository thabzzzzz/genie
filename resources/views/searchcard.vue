<template>
    <div class="searchpage">
      <div>
       
       
        <input type="text" v-model="searchTerm"   @keyup.enter="searchGames"  style="border: 1px solid black;"/>
        <button @click="searchGames" class="my-btn-2 ">Search</button>
      </div>
      <div v-if="isLoading">
        <p>Searching...</p>
      </div>
      <div v-else-if="!games.length">  <p class="text-center">no games loaded so far...</p>
      </div>
      <div v-else-if="!filteredGames.length && searchTerm">
        <p>No games found for "{{ searchTerm }}".</p>
      </div>
      <div v-else>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 ">
          <div class="col" v-for="game in filteredGames" :key="game.id">
            <div class="card product-card">
              <div class="relative">
                <img 
  :src="getCoverImageUrl(game)" 
  class="card-img-top" 
  :alt="game.name" 
  @click="viewGameDetails(game.id)"
  style="cursor: pointer;"
>

                <div class="prodcard-body py-3">
                  <p class="card-title">{{ game.name }}</p>
                  <p class="card-title">{{ game.website }} </p>
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
      // Consider using a default prop value (e.g., `games: []`) if applicable
    },
    data() {
      return {
        games: [],
        searchTerm: '',
        isLoading: false, // Flag for loading state
      };
    },
    methods: {
      getCoverImageUrl(game) {
        return game.background_image || 'placeholder_image_url.jpg';
      },
      async searchGames() {
        if (!this.searchTerm) return;

  const storedSearchTerm = localStorage.getItem('searchTerm');
  if (storedSearchTerm) {
    this.searchTerm = storedSearchTerm; // Restore the search term
  }
  
        const apiKey = '36e199df12d14562ad36f3befadf81d5'; // Replace with your actual RAWG API key
        const baseUrl = 'https://api.rawg.io/api/games';
  
        try {
          this.isLoading = true;
          const response = await fetch(
            `${baseUrl}?key=${apiKey}&search=${this.searchTerm}`
          );
          const data = await response.json();
          this.games = data.results || []; // Handle potential undefined results
        } catch (error) {
          console.error('Error fetching games:', error);
          // Handle errors (e.g., display an error message to the user)
        } finally {
          this.isLoading = false;
        }
      },
      viewGameDetails(gameId) {
  const scrollPosition = window.scrollY;
  localStorage.setItem('scrollPosition', scrollPosition);
  console.log('Setting scrollPosition:', scrollPosition); // Log scroll position

  // Open game details in a new tab
  window.open(`/gamedetail/${gameId}`, '_blank');
},
    },
    computed: {
      filteredGames() {
        if (!this.searchTerm) return this.games;
  
        const searchTermLower = this.searchTerm.toLowerCase();
        return this.games.filter((game) =>
          game.name.toLowerCase().includes(searchTermLower)
        );
      },
    },
    created() {
  const storedSearchTerm = localStorage.getItem('searchTerm');
  const storedScrollPosition = localStorage.getItem('scrollPosition');

  if (storedSearchTerm) {
    this.searchTerm = storedSearchTerm;
    console.log('Restoring searchTerm:', storedSearchTerm); // Log restored search term
    this.searchGames();
  }

  if (storedScrollPosition) {
    window.scrollTo(0, storedScrollPosition);
    console.log('Restoring scrollPosition:', storedScrollPosition); // Log restored scroll position
  }
}

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
  