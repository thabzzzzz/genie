<template>
  <div>
    <h1 class="text-center gamename">{{ gameDetail.name }}</h1>
    <div class="flex">
      <div class="w-3/2 border-r col1">
        <img :src="gameDetail.background_image" :alt="gameDetail.name" class="gamedetailimg" />
      </div>
      <div class="w-1/4 col2 flex-grow  min-w-0">
        <div class="details p-6">
          <p>Details /</p>
          <br>
          <p>{{ gameDetail.name }}</p>
          <br>
          <div class="desc " :style="{ maxHeight: descriptionMaxHeight }"> 
            <div v-html="gameDetail.description"></div> 
          </div>
          <br>
          <div class="platforms">
            <h3>Platforms:</h3>
            <ul class="platform-icons-container">
              <li v-for="platform in filteredPlatforms" :key="platform.platform.id">
                <img :src="getPlatformIconUrl(platform.platform.slug)" :alt="getPlatformName(platform.platform.slug)" class="platform-icon" :title="getPlatformName(platform.platform.slug)" />
              </li>
            </ul>
          </div>
        </div>
        <hr class="dashed-line">

        <div class="p-6 pt-2">
          <p >Actions /</p>
          <br>
          <button class="my-btn-2" @click="test">
            <span class="btn-content">
              <img src="/site-images/generalicons/bookmark-plus-fill.svg" alt="" class="mr-2"> 
              Add to Collection
            </span>
          </button>
          <br>
          <br>
        
          
        
          Rate:
         

         <div class="rating-select">
      <label for="rating">Select Rating:</label>
      <select id="rating" class="ml-2" v-model="selectedRating">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
    </div>
    <br>
          
    <!-- Submit Button -->
    <button class="my-btn-2 " @click="submitRating">
      Submit Rating
    </button>

          <br>
          <br>

          <p>Genie rating: 
  <span class="average-rating">
    {{ averageRating !== null ? averageRating : "This game hasn't been rated yet" }}
  </span>
</p>

          


        </div>
      </div>
    </div>
    <div>

      <div class="second-section">
        <h1 class="text-center gamename">Screenshots</h1>
      </div>
     
      <carousel :items-to-show="1.5">
      <!-- Loop through images from API response and generate slides -->
      <slide v-for="(image, index) in gameImages" :key="index">
        <!-- Use image URLs as src attribute -->
        <img :src="image.image" :alt="'Screenshot ' + (index + 1)" />
      </slide>

      <!-- Navigation and Pagination components -->
      <template #addons>
        <navigation />
        <pagination />
      </template>
    </carousel>
    </div>
    
  </div>
</template>

<script>

import axios from 'axios';
import { useToast } from "vue-toastification";
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'



export default {
  components: {
   
    Carousel,
    Slide,
    Pagination,
    Navigation,
  },
  props: {
    gameDetail: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      descriptionMaxHeight: 'calc(1.2em * 10)', // Set the maximum height based on 10 lines
      selectedRating: 1,
      gameImages: [],
      averageRating: null 
    };
  },
  created() {
    // Fetch images from API when component is created
    this.fetchGameImages();
    this.fetchAverageRating();
  },
  computed: {
    filteredPlatforms() {
      return this.gameDetail.platforms.filter(platform => platform.platform.slug !== "macos" && platform.platform.slug !== "linux");
    }
  },
  methods: {
    getPlatformIconUrl(slug) {
      const genericPlatformIcons = {
        "android": "mobile.svg",
        "ios": "mobile.svg",
        "playstation": "playstation.svg",
        "xbox": "xbox.svg",
        "pc": "windows.svg",
        "ubuntu": "windows.svg",
        "nintendo-switch": "nintendo-switch.svg",
        "ps-vita": "vita.svg",
      };
      const iconsFolder = '/site-images/platforms/';
      if (slug in genericPlatformIcons) {
        return iconsFolder + genericPlatformIcons[slug];
      } else {
        if (slug.includes("playstation")) {
          return iconsFolder + genericPlatformIcons["playstation"];
        } else if (slug.includes("xbox")) {
          return iconsFolder + genericPlatformIcons["xbox"];
        } else {
          return iconsFolder + 'default-icon.svg';
        }
      }
    },
    getPlatformName(slug) {
      const platformNames = {
        "android": "Mobile",
        "ios": "Mobile",
        "playstation": "Playstation",
        "xbox": "Xbox",
        "pc": "PC",
        "ubuntu": "Ubuntu",
        "nintendo-switch":"Switch",
        "ps-vita":"Vita"
      };
      if (slug in platformNames) {
        return platformNames[slug];
      } else {
        return slug;
      }
    },
    updateRating(newRating) {
      this.userRating = newRating;
    },  

    test() {
      const toast = useToast();
      
      // Send a POST request to your controller endpoint
      axios.post('/test', {
      gameId: this.gameDetail.id, // Assuming you have gameDetail.id accessible
    })
      .then(response => {
        // Handle successful addition to wishlist (e.g., display a message)
        console.log(response.data);
        const toastMessage = response.data;
        toast(toastMessage);
           })
      .catch(error => {
        // Handle errors
        console.error('Error:', error);
      });
    },
  

    fetchGameImages() {
      axios.get(`https://api.rawg.io/api/games/${this.gameDetail.id}/screenshots?key=36e199df12d14562ad36f3befadf81d5`)
        .then(response => {
          // Extract image URLs from API response
          this.gameImages = response.data.results;
        })
        .catch(error => {
          console.error('Error fetching game images:', error);
        });
    },
    submitRating() {
  if (!this.selectedRating) {
    // Handle case when no rating is selected
    // For example, display an error message
    const toast = useToast();
    toast.error('Please select a rating');
    return;
  }

  // Send the selected rating to the server-side endpoint
  axios.post('/submitrating', {
    gameId: this.gameDetail.id,
    rating: this.selectedRating
  })
  .then(response => {
    // Handle successful rating submission
    console.log(response.data);
    const toast = useToast();
    toast.success('Rating submitted successfully');
    
    // Refetch the average rating
    this.fetchAverageRating();
  })
  .catch(error => {
    // Handle errors
    console.error('Error submitting rating:', error);
    const toast = useToast();
    toast.error('Failed to submit rating');
  });
},


   fetchAverageRating() {
  axios.get(`/average-rating/${this.gameDetail.id}`)
    .then(response => {
      // Round the rating to one decimal before assigning
      this.averageRating = parseFloat(response.data.averageRating).toFixed(1);
    })
    .catch(error => {
      console.error('Error fetching average rating:', error);
    });
}

  }

};
</script>

<style scoped>
.gamedetailimg{
  width:1400px;
}
.col1,.col2{
  border: solid 1px black;
}
.col2 {
  border-left: none;
}
.desc{
  width: 460px;
  overflow: hidden;
  line-height: 1.2em; /* Adjust according to your font size */
  display: -webkit-box;
  -webkit-line-clamp: 10; /* Limit to 10 lines */
  -webkit-box-orient: vertical;
}
.platform-icons-container {
  display: flex;
  flex-wrap: wrap; 
}
.platforms {
  width: 100%;
}
.platform-icon{
  width: 20px;
  height: 20px;
  margin-right: 10px; 
}
.gamename{
  margin-bottom: 20px;
}

.my-btn-2 {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  /* Add other button styling as needed */
}

.my-btn-2 .btn-content {
  display: flex;
  align-items: center;
}

.dashed-line {
  border: 0;
  border-top: 1px dashed black;
  margin: 20px 0; /* Adjust margin as needed */
}

.rating {
    display: inline-flex; /* Set the Rating component to display inline */
  }

  .second-section{
    padding-top: 1.25rem;
    border-bottom: solid black 1px;
  }

  

</style>
