<template>
	<div>
        <div>
            <h2> Event Description</h2>
        </div>
        <div>
            <p>What can your guests expect with the event?</p>
        </div>
        <div class="floating-form">
            <div class="floating-label area">
                <textarea class="floating-input area" v-model="description" rows="8" placeholder=" " required autofocus></textarea>
                <label class="area"> Let your guests know what to expect with the event/performance </label>
            </div>
            <div>
                <label class="typo__label">Tagging</label>
                <multiselect 
                v-model="genreName" 
                tag-placeholder="Add this as new tag" 
                placeholder="Search or add a tag" 
                label="genre" 
                track-by="id" 
                :options="options" 
                :multiple="true" 
                :taggable="true" 
                tag-position="bottom"
                @tag="addTag"
                ></multiselect>
            </div>
            <div class="">
                <button @click.prevent="submit()" class="create"> Save and Continue </button>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

	export default {
        components: {
            Multiselect
        },

		props: {
			event: {
				type:Object,
			},
            genres: {
                type:Array,
            },
            pivots: {
                type:Array,
            },
		},

		data() {
			return {
                description: '',
                genreName: [],
                options: [],
			}
		},

		methods: {
			submit() {
				let data = {
                    'eventDescription': this.description,
           		};
                
                data.eventGenre = this.genreName.map(a => a.genre);

				axios.patch('/create-your-event/' + this.event.slug + '/description', data).catch(error => {
                module.status = error.response.data.status;
            	});

                window.location.href = '/create-your-event/' + this.event.slug + '/expect'; 
			},
            addTag (newTag) {
                const tag = {
                    genre: newTag,
                    id: newTag.substring(0, 0) + Math.floor((Math.random() * 10000000))
                }
                this.options.push(tag)
                this.genreName.push(tag)
            },

            init() {
                this.description = this.event.eventDescription
                this.genreName = this.pivots
                this.options = this.genres
            },

		},

        mounted() {
            this.init();
        },
    };



</script>