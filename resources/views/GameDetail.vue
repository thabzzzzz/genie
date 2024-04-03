<template>
  <div>
    <h1 class="text-center gamename">{{ gameDetail.name }}</h1>
    <div class="flex">
      <div class="w-1/2 border-r col1">
        <img :src="gameDetail.background_image" :alt="gameDetail.name" class="gamedetailimg" />
      </div>
      <div class="w-1/2 col2 flex-grow  min-w-0">
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

        <div class="p-6">
          <p>Actions /</p>
          <br>
          <button class="my-btn-2" @click="test">
            <span class="btn-content">
              <img src="/site-images/generalicons/bookmark-plus-fill.svg" alt="" class="mr-2"> 
              Add to Wishlist
            </span>
          </button>
          <br>
          <br>
          <button class="my-btn-2">
            <span class="btn-content">
              <img src="/site-images/generalicons/collection-fill.svg" alt="" class="mr-2"> 
              Add to Library
            </span>
          </button>
          <br>
          <br>
          <button class="my-btn-2" @click="logMessage1">
      <span class="btn-content">
        Log Message 1
      </span>
    </button>
          Rate:
          <Rating :rating="userRating" @update:rating="updateRating" />
        </div>
      </div>
    </div>
    <carousel :items-to-show="1.5">
    <slide v-for="slide in 10" :key="slide">
      {{ slide }}
    </slide>

    <template #addons>
      <navigation />
      <pagination />
    </template>
  </carousel>
  </div>
</template>

<script>
import Rating from "./Rating.vue";
import axios from 'axios';
import { useToast } from "vue-toastification";
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'



export default {
  components: {
    Rating,
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
      userRating: 0, // Initial user rating
    };
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
        "ubuntu": "windows.svg" 
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
        "ubuntu": "Ubuntu"
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
  

    logMessage1() {
      console.log('message1');
      alert('message1');
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

</style>
