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
			<multiselect 
			v-model="eventLocation.specificLocation" 
			deselect-label="Can't remove this value" 
			placeholder="Is the location is being withheld?" 
			:options="eventLocationOptions" 
			open-direction="bottom"
			:searchable="false" 
			:allow-empty="false">
			</multiselect>
	    </div>
	    <div class="floating-form">
	    	<div class="floating-label area" v-if="showSpecificLocation">
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
		        <input type="text" class="floating-input" v-model="eventLocation.eventStreetAddress" placeholder=" " name="streetAddress" v-validate="'required|max:100'" data-vv-as="Street Address">
		        <label>Street</label>
		        <span class="text-sm text-danger">{{ errors.first('streetAddress') }}</span>
		    </div>
		    <div class="floating-label">
		        <input type="text" class="floating-input" v-model="eventLocation.eventCity" name="city" v-validate="'required|max:80'" data-vv-as="City Address" placeholder=" ">
		        <label>City</label>
		        <span class="text-sm text-danger">{{ errors.first('city') }}</span>

		    </div>
		    <div class="floating-label">
		        <input type="text" class="floating-input" v-model="eventLocation.eventState" name="state" v-validate="'required|max:50'" data-vv-as="State Address" placeholder=" ">
		        <label>State</label>
		        <span class="text-sm text-danger">{{ errors.first('state') }}</span>
		    </div>
		    <div class="floating-label">
		        <input type="text" class="floating-input" v-model="eventLocation.eventZipcode" name="zip" v-validate="'required|max:5|numeric'" data-vv-as="Zip Address" placeholder=" ">
		        <label>Zip</label>
		        <span class="text-sm text-danger">{{ errors.first('zip') }}</span>
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

		computed: {
			showSpecificLocation: function() {
				if( this.eventLocation.specificLocation === 'Yes' ) { 
					return '1'; } else { return ''}
			}
		},

		data() {
			return {
				eventLocation:this.initializeEventObject(),
				specificLocation: 'false',
				regionOptions:this.regions,
				selectedRegions: this.pivots,
				eventLocationOptions: [ 'Yes', 'No' ],
				countryData: '',
				selectedCountry: 'United States of America',
				eventUrl:_.has(this.event, 'slug') ? `/create-your-event/${this.event.slug}` : null,
				lat: '',
				lon: ''
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
	                eventLat: '',
	                eventLong: '',
				}
			},

			updateEventFields(input) {
                if ((input !== null) && (typeof input === "object") && (input.id !== null)) {
                    this.eventLocation = _.pick(input, _.intersection( _.keys(this.eventLocation), _.keys(input) ));
                }
            },

			async submitLocation() {
				if (!await this.$validator.validate()) { return false; }
				let url = `https://cors-anywhere.herokuapp.com/https://us1.locationiq.com/v1/search.php?key=af4b25e28c2b00&q=` + this.eventLocation.eventStreetAddress + ' ' + this.eventLocation.eventCity + ' ' + this.eventLocation.eventState + ' ' + this.eventLocation.eventZipcode + `&format=json`;

				axios.get(url)
		    	.then(response => {
                	this.eventLocation.eventLat = response.data[0].lat;
                	this.eventLocation.eventLong = response.data[0].lon;
                	let data = this.eventLocation;
					data.eventCountry = this.selectedCountry;
	           		data.eventRegion = this.selectedRegions.map(a => a.id);

					axios.patch(`${this.eventUrl}/location`, data)
					.then(response => {
	                    console.log(response)
	                    //window.location.href = `${this.eventUrl}/category`;
	                })
	                .catch(errorResponse => {
	                    // show if there are server side validation errors
	                    this.validationErrors = errorResponse.response.data.errors
	             	});
            	})
            	.catch(errorResponse => {
                // show if there are server side validation errors
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
			if (this.event.specificLocation == 1) {
				this.specificLocation = 'true';
			}
		},

    };



</script>