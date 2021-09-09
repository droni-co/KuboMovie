<template>
  <v-container>
    <v-row>
      <v-col class="mt-2" cols="12">
        <strong>Recently watched</strong>
      </v-col>
      <v-col cols="6" md="2">
        <router-link to="/movie/create">
          <v-sheet height="210" class="text-center pt-5">
            <v-icon class="align-center">mdi-plus</v-icon><br>
            Add new
          </v-sheet>
        </router-link>
      </v-col>
      <v-col v-for="recent in recently" :key="recent.id" cols="6" md="2">
        <router-link :to="'/movie/'+recent.id">
          <v-img :src="'/storage/'+recent.cover"></v-img>
          <h5 class="pt-2 pb-0 mb-0">{{ recent.name }}</h5>
          <small>{{ recent.duration }} mins</small>
        </router-link>
      </v-col>
    </v-row>
    <v-row>
      <v-col class="mt-2" cols="12">
        <strong>All movies</strong>
      </v-col>
      <v-col v-for="movie in movies" :key="movie.id" cols="6" md="2">
        <router-link :to="'/movie/'+movie.id">
          <v-img :src="'/storage/'+movie.cover"></v-img>
          <h5 class="pt-2 pb-0 mb-0">{{ movie.name }}</h5>
          <small>{{ movie.duration }} mins</small>
        </router-link>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  export default {
    data: () => ({
      movies: [],
      recently: []
    }),
    mounted() {
      this.getMovies();
      this.getRecently();
    },
    methods: {
      getMovies() {
        axios.get('/api/movies').then(res=>{
          this.movies = res.data;
        })
      },
      getRecently() {
        //localStorage.removeItem('recently')
        this.recently = localStorage.getItem('recently') ? JSON.parse(localStorage.getItem('recently')) : [];
        console.log(this.recently)
      }
    }
  }
</script>
