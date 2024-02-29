<template>
  <div>
    <div class="card border border-black mx-auto product-card" style="width: 21rem;" v-for="product in products" :key="product.id">
      <img :src="product.image" class="card-img-top" :alt="product.name">
      <div class="card-body product-card-body">
        <h5 class="card-title">{{ product.name }}</h5>
        <p class="card-text">{{ product.description }}</p>
        <span class="card-price">Price: {{ product.price }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['products']
}
</script>
