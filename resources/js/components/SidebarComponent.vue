<template>
  <v-list>
    <v-list-item link to="/">
      <v-list-item-icon>
        <v-icon>mdi-home</v-icon>
      </v-list-item-icon>

      <v-list-item-content>
        <v-list-item-title>Home</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item v-for="category in categories" :key="category.id" link :to="'/categories/'+category.id">
      <v-list-item-icon>
        <v-icon v-text="category.icon"></v-icon>
      </v-list-item-icon>

      <v-list-item-content>
        <v-list-item-title v-text="category.name"></v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </v-list>
</template>

<script>
  export default {
    data: () => ({
      categories: []
    }),
    mounted() {
      this.getCategories();
    },
    methods: {
      getCategories() {
        axios.get('/api/categories').then(res=>{
          this.categories = res.data;
        })
      }
    }
  }
</script>
