<template>
  <div>
    <h1 class="text-center gamename">{{ gameDetail.name }}</h1>
    <div class="game-detail-container">
      <!-- Column 1: Image -->
      <div class="col1">
        <img :src="gameDetail.background_image" :alt="gameDetail.name" class="gamedetailimg" />
      </div>
      <!-- Column 2: Details -->
      <div class="col2">
        <div class="details p-6">
          <p>Details /</p>
          <p>{{ gameDetail.name }}</p>
          <div class="desc" :style="{ maxHeight: descriptionMaxHeight }"> 
            <div v-html="gameDetail.description"></div> 
          </div>
          <br>
          <div class="platforms">
            <h3 >Platforms:</h3>
            <br>
            <ul class="platform-icons-container">
              <li v-for="platform in filteredPlatforms" :key="platform.platform.id">
                <img :src="getPlatformIconUrl(platform.platform.slug)" :alt="getPlatformName(platform.platform.slug)" class="platform-icon" :title="getPlatformName(platform.platform.slug)" />
              </li>
            </ul>
          </div>
          <hr class="dashed-line">
          <div class=" pt-2">
            <p>Actions /</p>
            <button class="my-btn-2" @click="test">
              <span class="btn-content">
                <img src="/site-images/generalicons/bookmark-plus-fill.svg" alt="" class="mr-2"> 
                Add to Collection
              </span>
            </button>
            <br><br>
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
            <button class="my-btn-2" @click="submitRating">
              Submit Rating
            </button>
            <br><br>
            <p>Genie rating: <span style="font-family: 'opensans', sans-serif;">{{ averageRating }}</span></p>
          </div>
        </div>
      </div>
    </div>
    <div class="second-section">
      <h1 class="text-center gamename">Screenshots</h1>
      <carousel :items-to-show="1.5">
        <!-- lop through images from API response and generate slides -->
        <slide v-for="(image, index) in gameImages" :key="index">
        
          <img :src="image.image" :alt="'Screenshot ' + (index + 1)" />
        </slide>
      
        <template #addons>
          <navigation />
          <pagination />
        </template>
      </carousel>
    </div>
    <div class="second-section reviewssecion" >
      <h1 class="text-center gamename">Reviews</h1>
      <form @submit.prevent="submitReview">
        <textarea id="freeform" name="freeform" rows="4" cols="100" v-model="reviewText" placeholder=" Write your review here..."></textarea>
        <br>
        <button type="submit" class="my-btn-2">
          Submit Review
        </button>
      </form>
      
      <br>
      <!-- reviews from db here -->

      <div v-if="reviews.length">
        <div v-for="review in reviews" :key="review.id" class="review-item">
          <h3>{{ review.user.name }} (Rating: {{ review.rating }})</h3>
          <p>{{ review.review }}</p>
        </div>
      </div>
      <div v-else>
        <p>No reviews yet. Be the first to review!</p>
      </div>
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
      // for game description paragraph
      descriptionMaxHeight: 'calc(1.2em * 10)', 
      // initial rating is 1 by default
      selectedRating: 1,
      // used for the screenshots carousel
      gameImages: [],
      // initially set to null incase the game has no rating from the site database
      averageRating: null ,
      reviewText: '',
      reviews: [],
    };
  },
  created() {
    
    this.fetchGameImages();
    this.fetchAverageRating();
    this.fetchReviews();
  },
  computed: {
    filteredPlatforms() {
      return this.gameDetail.platforms.filter(platform => platform.platform.slug !== "macos" && platform.platform.slug !== "linux");
    }
  },
  methods: 
  // fetch platforms from api and associate them with their icons
  {
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

    // take the current rating from the rating dropdown and set it as the new rating
    updateRating(newRating) {
      this.userRating = newRating;
    },  

    // add game to table using its id, display a toast if successful or failed 
    test() {
      const toast = useToast();
      
      
      axios.post('/test', {
      gameId: this.gameDetail.id, 
    })
      .then(response => {
       
        console.log(response.data);
        const toastMessage = response.data;
        toast(toastMessage);
           })
      .catch(error => {
        
        console.error('Error:', error);
      });
    },
  
    // fetch the screenshots from api to be used in the screenshots carousel
    fetchGameImages() {
      axios.get(`https://api.rawg.io/api/games/${this.gameDetail.id}/screenshots?key=36e199df12d14562ad36f3befadf81d5`)
        .then(response => {
         
          this.gameImages = response.data.results;
        })
        .catch(error => {
          console.error('Error fetching game images:', error);
        });
    },

    // logic for rating submission
    submitRating() {
  if (!this.selectedRating) {
 
    const toast = useToast();
    toast.error('Please select a rating');
    return;
  }

  
  axios.post('/submitrating', {
    gameId: this.gameDetail.id,
    rating: this.selectedRating
  })
  .then(response => {
    
    console.log(response.data);
    const toast = useToast();
    toast.success('Rating submitted successfully');
    
   
    this.fetchAverageRating();
    this.fetchReviews(); 
  })
  .catch(error => {

    console.error('Error submitting rating:', error);
    const toast = useToast();
    toast.error('Failed to submit rating');
  });
},


// fetch the average rating from the database for the specific game via its id
fetchAverageRating() {
  axios.get(`/average-rating/${this.gameDetail.id}`)
    .then(response => {
      this.averageRating = response.data.averageRating !== null ?
        parseFloat(response.data.averageRating).toFixed(1) :
        'Game hasn\'t been rated yet';
    })
    .catch(error => {
      console.error('Error fetching average rating:', error);
    });
},
submitReview(){
  const toast = useToast();
      if (this.reviewText.trim() === '') {
        toast.error('Please write a review');
        return;
      }

      axios
        .post('/submitreview', {
          gameId: this.gameDetail.id,
          review: this.reviewText,
        })
        .then((response) => {
          console.log(response.data);
          toast.success('Review submitted successfully');
          this.reviewText = ''; 
          this.fetchReviews(); 
        })
        .catch((error) => {
          console.error('Error submitting review:', error);
          toast.error('Failed to submit review');
        });
},
fetchReviews() {
      axios
        .get(`/game/${this.gameDetail.id}/reviews`)
        .then((response) => {
          this.reviews = response.data;
          
        })
        .catch((error) => {
          console.error('Error fetching reviews:', error);
        });
    },

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
  width: 100%; 
  max-width: 660px; 
  overflow: hidden;
  line-height: 1.2em; 
  display: -webkit-box;
  -webkit-line-clamp: 10; 
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

}

.my-btn-2 .btn-content {
  display: flex;
  align-items: center;
}

.dashed-line {
  border: 0;
  border-top: 1px dashed black;
  margin: 20px 0;
}

.rating {
    display: inline-flex; 
  }

  .second-section{
    padding-top: 1.25rem;
    border-bottom: solid black 1px;
  }

  .game-detail-container {
    display: grid;
    grid-template-columns: 1fr;
    grid-template-areas: "col1" "col2";
  }

  @media (min-width: 768px) {
    .game-detail-container {
      grid-template-columns: 2fr 1fr; 
      grid-template-areas: "col1 col2";
    }
  }

  .col1 {
    grid-area: col1;
  }

  .col2 {
    grid-area: col2;
  }


  

</style>
