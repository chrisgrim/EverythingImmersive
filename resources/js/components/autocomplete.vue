<template>
  <div>
    <template>
      <div class="autocomplete">
        <input type="text" v-model="search" @input="onChange" />
        <ul v-show="isOpen" class="autocomplete-results">
          <li v-for="(result, i) in results" :key="i" class="autocomplete-result">
            {{ result }}
          </li>
        </ul>
      </div>
    </template>
  </div>
</template>
<script>
  export default {
    name: 'autocomplete',

    props: {
      items: {
        type: Array,
      },
    },
    data() {
      return {
        search: '',
        results: [],
        isOpen: false,
      };
    },
    methods: {
      onChange() {
        this.isOpen = true;
        this.filterResults();
      },
      filterResults(){
        this.results = this.items.filter(item => item.toLowerCase().indexOf(this.search.toLowerCase()) > -1);
      },
    },
  };
</script>