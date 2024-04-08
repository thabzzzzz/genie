<template>
  <div class="rating" style="white-space: nowrap;">
    <template v-for="star in maxStars" :key="star">
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
    data() {
    return {
      hoveredRating: null
    };
  },
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
  // Update internal state for hovering, don't emit yet
  this.hoveredRating = star;
},
setRating(star) {
  // Emit the clicked star as the final rating
  this.$emit("update:rating", star);
  // Update hovered state to match clicked state
  this.hoveredRating = star;
},
getStarIcon(star) {
  const rating = this.hoveredRating || this.rating; // Use hoveredRating if available, otherwise use rating

  if (rating <= star) {
    return "/site-images/generalicons/star-fill.svg";
  } else if (star - 0.5 === rating) {
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
  