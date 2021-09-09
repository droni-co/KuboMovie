<template>
  <v-card class="mx-auto my-12" v-if="movie.name">
    <template slot="progress">
      <v-progress-linear
        color="deep-purple"
        height="10"
        indeterminate
      ></v-progress-linear>
    </template>
    <v-alert border="top" color="red lighten-2" dark v-for="(error, key) in errors" :key="key">
      {{ error[0] }}
    </v-alert>
    <div class="embed-responsive embed-responsive-16by9">
      <iframe class="embed-responsive-item" :src="'https://www.youtube.com/embed/'+getYtId(movie.trailer)+'?rel=0'" allowfullscreen></iframe>
    </div>
    <v-card-title>{{ movie.name }}</v-card-title>
    <v-card-text>
      
      <v-sheet height="210" width="180" class="float-end pt-5 m-3" :style="'background-image:url('+getCover()+'); background-size: cover;'">
      </v-sheet>
      Duration: {{ movie.duration }}mins<br>

      {{ movie.description }}
      <div class="clearfix"></div>
    </v-card-text>

    <v-divider class="mx-4"></v-divider>

    <v-card-text>
      <template v-for="category in movie.categories">
        <router-link :to="'/categories/'+category.id" :key="category.id">
          <v-chip class="me-2">
            <v-icon v-text="category.icon"></v-icon> 
            {{ category.name }}
          </v-chip>
        </router-link>
      </template>
    </v-card-text>
  </v-card>
</template>

<script>
  export default {
    props: ['movie', 'loading', 'errors'],
    data: () => ({
      coverUrl: ''
    }),
    mounted() {
    },
    methods: {
      getYtId(url='') {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        var match = url.match(regExp);
        return (match&&match[7].length==11)? match[7] : false;
      },
      getCover() {
        return this.movie.id ? '/storage/'+this.movie.cover : this.movie.tempCover;
      }
    }
  }
</script>
