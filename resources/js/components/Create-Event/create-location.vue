<template>
	<div>
		<div class="create-guide-title">
    		<h2> Location</h2>
    	</div>
	    <div>
	    	<p>Lets start with an address</p>
	    	<br>
	    </div>
	    <div>
	    	<input type="checkbox" v-model="specificLocation"> The specific location is withheld until closer to the date<br>
	    </div>
	    <div class="floating-form">
	    	<div class="floating-label area" v-if="specificLocation">
	            <textarea 
	            v-model="eventLocation.eventStreetAddress" 
	            class="floating-input area" 
	            rows="8" 
	            placeholder=" " 
	            required 
	            autofocus>
	            </textarea>
	            <label class="area"> Please enter how participants will be notified </label>
	        </div>
	    	<div class="floating-label" v-else="specificLocation">
		        <input type="text" class="floating-input" v-model="eventLocation.eventStreetAddress" value=" " placeholder=" " required>
		        <label>Street</label>
		    </div>
		    <div class="floating-label">
		        <input type="text" class="floating-input" v-model="eventLocation.eventCity" value=" " placeholder=" " required>
		        <label>City</label>
		    </div>
		    <div class="floating-label">
		        <input type="text" class="floating-input" v-model="eventLocation.eventState" value=" " placeholder=" " required>
		        <label>State</label>
		    </div>
		    <div class="floating-label">
		        <input type="text" class="floating-input" v-model="eventLocation.eventZipcode" value=" " placeholder=" " required>
		        <label>Zip</label>
		    </div>
		    <div class="floating-label">
		    	Country
				<multiselect 
				v-model="selectedCountry" 
				:options="this.countryData ? countryData : []" 
				:searchable="true" 
				placeholder="Select Country" 
				open-direction="bottom" 
				autocomplete="off"
				></multiselect>
			</div>
		</div>
	    <div>
			<div>
				  <label class="typo__label">Regions</label>
				  <multiselect 
				  v-model="selectedRegions" 
				  :options="this.regions ? regionOptions : []" 
				  :multiple="true" 
				  placeholder="Select Region. You may select more than one." 
				  track-by="id"
				  open-direction="bottom"
				  required 
				  label="region">

				  <span slot="noResult">Please select from our list of approved Regions</span></multiselect>
			</div>
		</div>
	    <div class="">
	        <button @click.prevent="submitLocation()" class="create"> Next </button>
	    </div>
    </div>
</template>

<script>
	import Multiselect from 'vue-multiselect';
	import _ from 'lodash'

	export default {
		props: {
			event: { type:Object },
			regions: { type:Array },
			pivots: { type:Array },
		},

		components: { 
			Multiselect 
		},

		data() {
			return {
				eventLocation:this.initializeEventObject(),
				specificLocation: '',
				regionOptions:this.regions,
				selectedRegions: this.pivots,
				countryData: '',
				selectedCountry: 'United States of America',
				eventUrl:_.has(this.event, 'slug') ? `/create-your-event/${this.event.slug}` : null
			}
		},

		methods: {
			initializeEventObject() {
				return {
					eventStreetAddress: '',
	                eventCity: '',
	                eventState: '',
	                eventCountry: '',
	                eventZipcode: '',
	                specificLocation: '',
				}
			},

			updateEventFields(input) {
                if ((input !== null) && (typeof input === "object") && (input.id !== null)) {
                    this.eventLocation = _.pick(input, _.intersection( _.keys(this.eventLocation), _.keys(input) ));
                }
            },

			submitLocation() {
				let data = this.eventLocation;
				data.eventCountry = this.selectedCountry;
           		data.eventRegion = this.selectedRegions.map(a => a.id);

				axios.patch(`${this.eventUrl}/location`, data)
				.then(response => {
                    // all is well. move on to the next page
                    // window.location.href = `${this.eventUrl}/category`;
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
			        location: newTag,
			        id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
			    }
			    this.regionOptions.push(tag)
      			this.selectedRegions.push(tag)
			},
			toggle() {
				this.specificLocation = !this.specificLocation;
			},
		},

		created() {
			axios.get('https://restcountries.eu/rest/v2/all?fields=name')
				.then(axiosResult => this.countryData = axiosResult.data.map(a => a.name));
		},		

		mounted() {
			this.updateEventFields(this.event);
			if (this.event.eventCountry) {
				this.selectedCountry = this.event.eventCountry;
			}
		},
    };



</script>