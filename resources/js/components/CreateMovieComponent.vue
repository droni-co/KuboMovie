<template>
  <v-container>
    <h1>Create a new movie</h1>
    <v-row>
      <v-col cols="6" class="mx-auto" v-if="!preview">
        <v-text-field label="Name" v-model="newMovie.name"></v-text-field>
        <v-select
          v-model="newMovie.storeCategories"
          :items="categories"
          item-text="name"
          item-value="id"
          label="Categories"
          multiple
          hint="Pick categories"
          attach
          chips
        ></v-select>
        <v-file-input
          accept="image/*"
          label="Cover"
           @change="previewCover"
        ></v-file-input>
        <v-textarea
          v-model="newMovie.description"
          label="Description"
        ></v-textarea>
        <v-subheader>Duration (mins)</v-subheader>
        <v-slider v-model="newMovie.duration" max="200" min="20" thumb-label></v-slider>
        <v-text-field v-model="newMovie.trailer" label="Youtube Trailer"></v-text-field>
        <v-text-field type="date" v-model="newMovie.launch" label="Release date"></v-text-field>
        <v-btn block @click="previewMovie()">
          Preview
        </v-btn>
      </v-col>
      <v-col cols="6" class="mx-auto"  v-if="preview">
        <movie-card-component :movie="movieCard" :loading="loading" :errors="errors"></movie-card-component>
        <v-row>
          <v-col cols="6"><v-btn @click="preview = false">Back</v-btn></v-col>
          <v-col cols="6" class="text-end"><v-btn color="deep-purple lighten-2" @click="save()">Save</v-btn></v-col>
        </v-row>
      </v-col>
    </v-row>
    
  </v-container>
</template>

<script>
  export default {
    data: () => ({
      newMovie: {
        name: '',
        storeCategories: [],
        categories: [],
        description: '',
        duration: 150,
        trailer: '',
        launch: 2020,
        tempCover: '',
        cover: ''
      },
      categories: [],
      loading: false,
      preview: false,
      errors: [],
      movieCard: {}
    }),
    mounted() {
      this.getCategories();
    },
    methods: {
      getCategories() {
        axios.get('/api/categories').then(res=>{
          this.categories = res.data;
        })
      },
      getYtId(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        var match = url.match(regExp);
        return (match&&match[7].length==11)? match[7] : false;
      },
      previewCover(e) {
        this.newMovie.tempCover = URL.createObjectURL(e)
        this.newMovie.cover = e
      },
      previewMovie() {
        this.movieCard = this.newMovie;
        this.movieCard.categories = this.categories.filter(e=>{
          return this.movieCard.categories.includes(e.id)
        })
        this.preview = true;
        this.errors = [];
      },
      save() {
        this.loading = true;
        let form_data = new FormData();
        Object.keys(this.newMovie).forEach(key => {
          form_data.append(key, this.newMovie[key]);
        });
        axios.post('/api/movies', form_data, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
        }).then(res=>{
          this.$router.push('/')
        }).catch(error=>{
          this.errors = error.response.data.errors;
          this.loading = false;
        })
      }
    }
  }
</script>
