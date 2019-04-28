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
	    	<div v-if="specificLocation">
	    		<div class="floating-label">
			        <input type="text" class="floating-input" v-model="street" value=" " placeholder=" " required>
			        <label>Please enter how participants will be notified</label>
		    	</div>
	    	</div>
	    	<div class="floating-label" v-else="specificLocation">
		        <input type="text" class="floating-input" v-model="street" value=" " placeholder=" " required>
		        <label>Street</label>
		    </div>
		    <div class="floating-label">
		        <input type="text" class="floating-input" v-model="city" value=" " placeholder=" " required>
		        <label>City</label>
		    </div>
		    <div class="floating-label">
		        <input type="text" class="floating-input" v-model="state" value=" " placeholder=" " required>
		        <label>State</label>
		    </div>
		    <div class="floating-label">
		        <input type="text" class="floating-input" v-model="zip" value=" " placeholder=" " required>
		        <label>Zip</label>
		    </div>
		    <div class="floating-label">
		    	Country
				<multiselect 
				v-model="selectedCountry" 
				:options="countryData" 
				:searchable="true" 
				placeholder="Select Country" 
				label="name" 
				open-direction="bottom" 
				track-by="name"
				autocomplete="off"
				></multiselect>
			</div>
	
		</div>
	    <div>
			<div>
				  <label class="typo__label">Regions</label>
				  <multiselect 
				  v-model="region" 
				  :options="options" 
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
	        <button @click.prevent="submit()" class="create"> Next </button>
	    </div>
    </div>
</template>

<script>
	import Multiselect from 'vue-multiselect'
	export default {
		props: {
			event: {
				type:Object,
			},
			regions: {
				type:Array,
			},
			pivots: {
				type:Array,
			},
		},

		components: { 
			Multiselect 
		},

		data() {
			return {
				eventPivot: this.pivots,
				specificLocation: '',
				street: '',
				city: '',
				state: '',
				zip: '',
				selectedCountry: '',
			    countryData: [],
			    isLoading: false,
			    regvalue: [],
				region: [],
				options:this.regions,
				regs: [],
				keyword: this.event.eventCountry,
				selectedArray: '',
				united: 'United States of America',
				tempCountry: '',
			}
		},

		computed: {

		},

		methods: {
			submit() {
				let data = {
                'eventStreetAddress': this.street,
                'eventCity': this.city,
                'eventState': this.state,
                'eventCountry': this.selectedCountry.name,
                'eventZipcode': this.zip,
                'specificLocation': this.specificLocation,
           		};
   				
           		data.eventRegion = this.region.map(a => a.id);

				axios.patch('/create-your-event/' + this.event.slug + '/location', data).catch(error => {
                console.log(error.response.data.errors);
            	});

            	window.location.href = '/create-your-event/' + this.event.slug + '/category'; 
			},

			addTag (newTag) {
		    	const tag = {
			        location: newTag,
			        id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
			    }
			    this.options.push(tag)
      			this.region.push(tag)
			},
			toggle() {
				this.specificLocation = !this.specificLocation;
			},
			getCountriesList() {
				axios.get('https://restcountries.eu/rest/v2/all?fields=name')
				.then(axiosResult => this.countryData = axiosResult.data) 
			},
			init() {
				this.street = this.event.eventStreetAddress,
				this.city = this.event.eventCity,
				this.state = this.event.eventState,
				this.zip = this.event.eventZipcode,
				this.specificLocation = this.event.specificLocation,
				this.placeholder = this.event.eventCountry,
				this.region = this.pivots
				
			},
			

		},
		watch: {
            countryData: {
                handler(data) {
                    if (data.length) {
                    	if (this.keyword) {
                    		this.tempCountry = data.filter((country) => {
                        		return this.keyword.toLowerCase().split(' ').every(v => country.name.toLowerCase().includes(v));});
                        	this.selectedCountry = this.tempCountry[0]
                    	} else {
                    		return this.selectedCountry = data[239]
                    	}
                    }
                },
                immediate: true   
            },

			// selectedArray: function(data) {
			// 	if (data.length) {
			// 		return this.selectedCountry = this.selectedArray[0];
			// 	}
			// }
		},

		created() {
			this.getCountriesList();
		},

		mounted() {
			this.init();
			
		}



    };



</script>