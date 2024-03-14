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
        <ul class="platform-icons-container">
          <li v-for="platform in filteredPlatforms" :key="platform.platform.id">
            <img :src="getPlatformIconUrl(platform.platform.slug)" :alt="getPlatformName(platform.platform.slug)" class="platform-icon" :title="getPlatformName(platform.platform.slug)" />
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
}
,
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
</style>
