<template>
    <span>
        <a href="#" v-if="isFavorited" @click.prevent="unFavorite(event)">
            <i  class="fa fa-heart"></i>
        </a>
        <a href="#" v-else @click.prevent="favorite(event)">
            <i  class="fa fa-heart-o"></i>
            
        </a>
    </span>
</template>

<script>
    export default {
        props: ['event', 'favorited', 'all'],

        data: function() {
            return {
                isFavorited: '',
            }
        },

        mounted() {
            this.isFavorited = this.isFavorite ? true : false;
        },

        computed: {
            isFavorite() {
                return this.favorited;
            },
        },

        methods: {
            favorite(event) {
                axios.post('/like/'+event)
                    .then(response => this.isFavorited = true)
                    .catch(response => console.log(response.data));
            },

            unFavorite(event) {
                axios.post('/unlike/'+event)
                    .then(response => this.isFavorited = false)
                    .catch(response => console.log(response.data));
            }
        }
    }
</script>