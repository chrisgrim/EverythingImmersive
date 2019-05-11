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
                <textarea class="floating-input area" v-model="description" rows="8" name="description" v-validate="'required|max:400'" data-vv-as="Event Description" placeholder=" "></textarea>
                <label class="area"> Let your guests know what to expect with the event/performance </label>
                <span class="text-sm text-danger">{{ errors.first('description') }}</span>
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
			async submitDescription() {
                if(!await this.$validator.validate()) { return false; }
                
				let data = {
                    'eventDescription': this.description,
           		};
                data.eventGenre = this.genreName.map(a => a.genre);

				axios.patch(`${this.eventUrl}/description`, data)
                .then(response => {
                    // all is well. move on to the next page
                    window.location.href = `${this.eventUrl}/expect`;
                })
                .catch(errorResponse => {
                    // show if there are server side validation errors
                    this.validationErrors = errorResponse.response.data.errors
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