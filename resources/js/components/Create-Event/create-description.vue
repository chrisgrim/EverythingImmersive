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
                Event Genre
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
                <button @click.prevent="submitDescription()" class="create"> Save and Continue </button>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import _ from 'lodash';

	export default {
        components: {
            Multiselect
        },

		props: {
			event: {type:Object},
            genres: {type:Array},
            pivots: {type:Array}
		},

		data() {
			return {
                description: _.has(this.event, 'eventDescription') ? this.event.eventDescription : '',
                genreName: this.pivots,
                options: this.genres,
                eventUrl:_.has(this.event, 'slug') ? `/create-your-event/${this.event.slug}` : null,
			}
		},

		methods: {
			submitDescription() {
				let data = {
                    'eventDescription': this.description,
           		};
                data.eventGenre = this.genreName.map(a => a.genre);

				axios.patch(`${this.eventUrl}/description`, data)
                .then(response => {
                    // all is well. move on to the next page
                    window.location.href = `${this.eventUrl}/dates`;
                })
                .catch(errorResponse => {
                    // show if there are server side validation errors
                    if (!_.has(errorResponse, 'response.data.errors')) { return false; }
                    for (const [field, errors] of Object.entries(errorResponse.response.data.errors)) {
                        for (const error in errors) {
                            this.errors.add({ field: field, msg: errors[error] });
                        }
                    }
                });
			},

            addTag (newTag) {
                const tag = {
                    genre: newTag,
                    id: newTag.substring(0, 0) + Math.floor((Math.random() * 10000000))
                }
                this.options.push(tag)
                this.genreName.push(tag)
            },

		},
    };



</script>