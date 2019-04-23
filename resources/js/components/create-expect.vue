<template>
	<div>
        <div>
    		<h2> What can your guests expect?</h2>
	    </div>
	    <div>
	    	<p>Let the guests know what they can expect. Will there be scary noises or bright flashes?</p>
	    </div>
	    <div class="floating-form">
		    <div class="floating-label area">
	            <textarea v-model="content" name="eventExpectations" id="eventExpectations" class="floating-input area" rows="8" placeholder=" " required autofocus></textarea>
	            <label class="area"> Content Advisory </label>
	        </div>
	        <div>
				<div>
					Is this experience wheelchair accessible?
					<multiselect 
					v-model="wheelchair" 
					deselect-label="Can't remove this value" 
					track-by="name" 
					label="name" 
					placeholder="Select one" 
					:options="wheelchairOptions" 
					open-direction="bottom"
					:searchable="false" 
					:allow-empty="false">
	  				</multiselect>
				</div>
			</div>
			<div class="floating-label area">
	            <textarea v-model="mobility" name="eventExpectations" id="eventExpectations" class="floating-input area" rows="8" placeholder=" " required autofocus></textarea>
	            <label class="area"> Any Other Mobility Advisories? <br>* Can you accommodate someone who can't stand/walk for long periods of time? <br>
* Can the show accommodate someone who uses a walker? <br>
* Does the show take place on uneven ground or in a venue with staircases? </label>
	        </div>
	        <div class="">
	            <button type="submit" class="create"> Save and Continue </button>
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
		},

		data() {
			return {
                description: '',
                mobility: '',
                content: '',
                wheelchair: '',
                wheelchairOptions: [
                	{ name: 'Yes' },
       				{ name: 'No' },
        		],
                level: [],
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