<template>
  <div class="rating" style="white-space: nowrap;">
    <template v-for="star in maxStars">
      <img
        :src="getStarIcon(star)"
        alt="star"
        @mouseover="hoverRating(star)"
        @click="setRating(star)"
        class="star"
      />
    </template>
  </div>
</template>

  
  <script>
  export default {
    props: {
      rating: {
        type: Number,
        required: true
      },
      maxRating: {
        type: Number,
        default: 5
      }
    },
    computed: {
      maxStars() {
        return Array.from({ length: this.maxRating }, (_, index) => index + 1);
      }
    },
    methods: {
      hoverRating(star) {
        // Emits the current hovered star as the new rating
        this.$emit("update:rating", star);
      },
      setRating(star) {
        // Emits the clicked star as the final rating
        this.$emit("update:rating", star);
      },
      getStarIcon(star) {
       
        if (star <= this.rating) {
          return "/site-images/generalicons/star-fill.svg";
        } else if (star - 0.5 === this.rating) {
          return "/site-images/generalicons/star-half.svg";
        } else {
          return "/site-images/generalicons/star.svg";
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .rating {
    display: inline-block;
  }
  
  .star {
    width: 24px;
    height: 24px;
    cursor: pointer;
  }
  </style>
  