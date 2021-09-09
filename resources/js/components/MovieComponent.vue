<template>
  <v-container>
    <movie-card-component :movie="movie" :loading="loading" :errors="errors"></movie-card-component>
  </v-container>
</template>

<script>
  export default {
    data: () => ({
      movie: {},
      loading: true,
      errors: []
    }),
    mounted() {
      this.getMovie();
    },
    methods: {
      getMovie() {
        axios.get('/api/movies/'+this.$route.params.id).then(res=>{
          this.movie = res.data;
          this.addToRecent();
        })
      },
      getYtId(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        var match = url.match(regExp);
        return (match&&match[7].length==11)? match[7] : false;
      },
      addToRecent() {
        let recently = localStorage.getItem('recently') ? JSON.parse(localStorage.getItem('recently')) : [];
        let exist = false;
        recently.forEach(e => {
          exist = (e.id == this.movie.id);
        });
        if(!exist) { recently = [this.movie].concat(recently) }
        console.log(recently)
        localStorage.setItem('recently', JSON.stringify(recently))
      }
    }
  }
</script>
