<template>
  <div class="flex">
    <div class="w-1/2 border-r col1">
      <img :src="gameDetail.background_image" :alt="gameDetail.name" class="gamedetailimg" />
    </div>
    <div class="w-1/2 col2 flex-grow p-6 min-w-0">
      <p>Details /</p>
      <br>
      <p>{{ gameDetail.name }}</p>
      <br>
      <div class="desc"> 
        <div v-html="gameDetail.description"></div> 
      </div>
      <br>
      <div class="platforms">
        <h3>Platforms:</h3>
        <ul>
          <li v-for="platform in gameDetail.platforms" :key="platform.platform.id">
            <img :src="getPlatformIconUrl(platform.platform.slug)" alt="Platform Icon" class="platform-icon" />
            {{ platform.platform.name }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    gameDetail: {
      type: Object,
      required: true
    }
  },
  methods: {
  getPlatformIconUrl(slug) {
    // Define mappings between slugs and icon filenames
    const platformIcons = {
      "android": "android.svg",
      "ios": "ios.svg",
      "playstation": "playstation.svg",
      "playstation3": "ps-3.svg",
      "playstation4": "ps4.svg",
      "ps4": "ps4.svg",
      "xbox": "xbox.svg",
      "xbox360": "xbox.svg",
      "xbox-one": "xbox.svg",
      "pc": "windows.svg",
      "linux": "windows.svg",
      "macos": "windows.svg"
      // Add more mappings as needed
    };

    // Construct the relative path to the icons folder
    const iconsFolder = '/site-images/platforms/';
    
    // Check if the slug exists in the platformIcons mapping
    if (slug in platformIcons) {
      // Construct the URL for the platform icon
      return iconsFolder + platformIcons[slug];
    } else {
      // If no matching slug is found, return a default icon or handle it as needed
      return iconsFolder + 'default-icon.svg';
    }
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
}

.platform-icon{
  width: 40px;
  height: 40px;
}
</style>
