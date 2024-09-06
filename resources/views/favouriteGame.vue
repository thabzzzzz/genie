<template>
    <div class="favouriteGameBox">
        <h3>within vue test</h3>
        <p v-if="showcaseGameId">Game ID: {{ showcaseGameId }}</p>
        <p v-else>No game selected</p>
    </div>
</template>

<script setup>

const props = defineProps({
  showcaseGameId: {
    type: [Number, String], // Adjust type based on your data
    required: false, // Make it optional if needed
  },
});


</script>

<style scoped>
.favouriteGameBox{
    border: black solid 2px;
    margin-top:5em ;
    padding: 2em;
}

</style>