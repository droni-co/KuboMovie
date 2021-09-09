<template>
  <v-container>
    <v-row>
      <template>
        <v-col class="mt-2" cols="12">
          <strong>Category {{ category.name }}</strong>
        </v-col>

        <v-col v-for="movie in movies" :key="movie.id" cols="6" md="2">
          <router-link :to="'/movie/'+movie.id">
            <v-img :src="'/storage/'+movie.cover"></v-img>
            <h5 class="pt-2 pb-0 mb-0">{{ movie.name }}</h5>
            <small>{{ movie.duration }} mins</small>
          </router-link>
        </v-col>
      </template>
    </v-row>
  </v-container>
</template>

<script>
  export default {
    data: () => ({
      category: {},
      movies: []
    }),
    mounted() {
      this.getCategory();
    },
    methods: {
      getCategory() {
        axios.get('/api/categories/'+this.$route.params.id).then(res=>{
          this.category = res.data;
          this.getMovies(this.category.id);
        })
      },
      getMovies(category_id) {
        axios.get('/api/movies?category_id='+category_id).then(res=>{
          this.movies = res.data;
        })
      }
    },
    watch:{
      $route (to, from){
        this.getCategory();
      }
    } 
  }
</script>
