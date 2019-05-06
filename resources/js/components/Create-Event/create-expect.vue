<template>
	<div>
        <div>
    		<h2> What can your guests expect?</h2>
	    </div>
	    <div>
	    	<flash></flash>
	    </div>
	    <div>
	    	<p>Let the guests know what they can expect. Will there be scary noises or bright flashes?</p>
	    	<p>Some common ones include: 
				* strong language
				* fog/haze
				* flashing lights
				* simulated gun shots/violence
				* themes around racism, homophobia, mental health, suicide, etc.
				* discussions of sex and intimacy
				* moments of darkness
				* strong smells
			</p>
	    </div>
	    <div class="floating-form">
		    <div class="floating-label area">
	            <textarea 
	            v-model="eventExpect.contentAdvisories" 
	            class="floating-input area" 
	            rows="8" 
	            placeholder=" " 
	            required 
	            autofocus>
	            </textarea>
	            <label class="area"> Content Advisory </label>
	        </div>
	        <br>
	        <div>
				<div>
					Level of Contact w/ Audience (Touch Advisory)
					<multiselect 
					v-model="contactLevel" 
					:options="contactLevelOptions" 
					:multiple="true" 
					:close-on-select="false" 
					:clear-on-select="false" 
					:preserve-search="true" 
					placeholder="Choose All That Apply"
					open-direction="bottom"
					label="level" 
					track-by="id" 
					:preselect-first="false">
  					</multiselect>
				</div>
			</div>
			<div>
				<div class="floating-label area">
		            <textarea 
		            v-model="eventExpect.contactAdvisoryDescription" 
		            class="floating-input area" 
		            rows="8" 
		            placeholder=" " 
		            required 
		            autofocus></textarea>
		            <label class="area"> Explain a bit about your contact with the audience </label>
	        	</div>
			</div>
			<div>
				<div>
					Advisory for Sexual Violence?
					<multiselect 
					v-model="eventExpect.sexualViolence" 
					deselect-label="Can't remove this value" 
					placeholder="Select one" 
					:options="sexualViolenceOptions" 
					open-direction="bottom"
					:searchable="false" 
					:allow-empty="false">
	  				</multiselect>
				</div>
			</div>
			<div v-if="eventExpect.sexualViolence">
				<div class="floating-label area">
		            <textarea v-model="eventExpect.sexualViolenceDescription" class="floating-input area" rows="8" placeholder=" " required autofocus></textarea>
		            <label class="area"> Explain more about the sexual violence </label>
	        	</div>
			</div>
			<br>
	        <div>
				<div>
					Is this experience wheelchair accessible?
					<multiselect 
					v-model="eventExpect.wheelchairReady" 
					deselect-label="Can't remove this value" 
					placeholder="Select one" 
					:options="wheelchairOptions" 
					open-direction="bottom"
					:searchable="false" 
					:allow-empty="false">
	  				</multiselect>
				</div>
			</div>
			<div><br>
					Any Other Mobility Advisories?<br>
					* Can you accommodate someone who can't stand/walk for long periods of time? <br>
* Can the show accommodate someone who uses a walker? <br>
* Does the show take place on uneven ground or in a venue with staircases?
			</div>
			<div class="floating-label area">
	            <textarea 
	            v-model="eventExpect.mobilityAdvisories" 
	            class="floating-input area" 
	            rows="8" 
	            placeholder=" " 
	            required 
	            autofocus></textarea>
	            <label class="area"> Mobility Advisories </label>
	        </div>
	        <div class="">
	            <button @click.prevent="submitExpectations()" class="create"> Save and Continue </button>
	        </div>
	    </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    import _ from 'lodash'

	export default {
        components: {
            Multiselect
        },

		props: {
			event: { type:Object },
			contact: { type:Array },
			pivots: { type:Array },
		},

		data() {
			return {
				eventExpect: this.initializeEventObject(),
				contactLevelOptions: this.contact,
				contactLevel: '',
				sexualViolenceOptions: [ 'Yes', 'No' ],
				wheelchairOptions: [ 'Yes', 'No' ],
				eventUrl:_.has(this.event, 'slug') ? `/create-your-event/${this.event.slug}` : null
			}
		},


		methods: {
			initializeEventObject() {
				return {
					contentAdvisories: '',
					contactAdvisoryDescription: '',
					sexualViolence: '',
					sexualViolenceDescription: '',
					wheelchairReady: '',
					mobilityAdvisories: '',
				}
			},

			updateEventFields(input) {
	            if ((input !== null) && (typeof input === "object") && (input.id !== null)) {
	                this.eventExpect = _.pick(input, _.intersection( _.keys(this.eventExpect), _.keys(input) ));
	            }
	        },

			submitExpectations() {
                
               	let data =this.eventExpect;
               	data.contactLevel = this.contactLevel.map(a => a.id);

               	console.log(data);

				axios.patch(`${this.eventUrl}/expect`, data)
				.then(response => {
                    // all is well. move on to the next page
                    window.location.href = `${this.eventUrl}/title`;
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
		},

        mounted() {
        	this.updateEventFields(this.event);
        },
    };



</script>