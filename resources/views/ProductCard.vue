<template>
  <div class="card border border-black mx-auto product-card" style="width: 21rem;" v-for="product in products" :key="product.id">
    <img :src="getFirstImageUrl(product)" class="card-img-top" :alt="product.name">
    <div class="card-body product-card-body p-2">
      <b class="card-title">{{ removeSamplePrefix(product.name)  }}</b>
      <br>
      <br>
      <div class="description-text clamp-description"><i class="card-text">{{ product.description }}</i></div>
      <br>
      <span class="card-price">R {{ product.price }}</span>
      <br>
      <br>
      <span>
        <a :href="product.link" class="btn my-btn-2 text-black inline-block mr-1" target="_blank" title="Visit site">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-6 h-6 inline-block icon">
            <path strokeLinecap="round" strokeLinejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
          </svg>
        </a>
      </span>
      <!-- Add Edit and Delete buttons as needed -->
    </div>
  </div>
</template>

<script>
export default {
  props: {
    products: Array // Assuming products is an array of objects with image, name, description, price, and link properties
  },
  methods: {
    getFirstImageUrl(product) {
      if (product.images && product.images.length > 0) {
        return product.images[0].url_standard; // You can use any image URL you prefer
      } else {
        // Provide a placeholder image URL if no images are available
        return 'placeholder_image_url.jpg';
      }
    },
    removeSamplePrefix(name) {
      return name.replace(/^\[Sample\]\s*/i, ''); // Remove "[Sample]" prefix from the product name
    }
  },
  computed: {
    productsWithImages() {
      // Filter out products that don't have images
      return this.products.filter(product => product.images && product.images.length > 0);
    }
  }
}
</script>

<style scoped>
/* Add your CSS styles here */
.card {
  /* Add card styles */
  border: 1px solid black;
  width: 21rem;
}

.card-img-top {
  /* Add image styles */
}

.card-body {
  /* Add card body styles */
}

.card-title {
  /* Add title styles */
}

.card-text {
  /* Add description text styles */
}

.card-price {
  /* Add price styles */
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
