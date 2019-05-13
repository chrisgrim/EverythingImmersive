<template>
	<div>
		<a v-if="isGuest" class="btn" href="/login">Please login</a>
        <div v-if="isLoggedIn">
            <button @click="setUserEmail(`updated-${loggedInUser.email}`)"> Update Email </button>
            <div>user email : {{ loggedInUser.email }}</div>
        </div>	
		<h2>Our Latest Events</h2>
		<div id="app">
			<div id="grid-section">
				<div>
					<multiselect 
			        v-model="value" 
			        placeholder="Filter by name"
			        label="eventTitle" 
			        track-by="eventTitle" 
			        deselectLabel=''
			        @keyup="filteredEvents"
			        :allow-empty="false"  
			        :options="searchOptions" 
			        >
				    </multiselect>
			    </div>
			    <div>
					<input type="text" placeholder="Filter by Price">
					<button>Go</button>
				</div>
				<div>
					 <div class="datepicker-trigger">
				      <input
				        type="text"
				        id="datepicker-trigger"
				        placeholder="Select dates"
				        :value="formatDates(dateOne, dateTwo)"
				      >

				      <AirbnbStyleDatepicker
				        :trigger-element-id="'datepicker-trigger'"
				        :mode="'range'"
				        :fullscreen-mobile="true"
				        :date-one="dateOne"
				        :date-two="dateTwo"
				        @date-one-selected="val => { dateOne = val }"
				        @date-two-selected="val => { dateTwo = val }"
				      />
				    </div>
				</div>
			</div>
			
			<div id="grid-section">
				<div v-for="event in filteredEvents">
					<event-listing-item :user="user" :event="event"></event-listing-item>
				</div>
			</div>
		</div>
    </div>
</template>

<script>
	import _ from 'lodash';
    import Multiselect from 'vue-multiselect';
    import format from 'date-fns/format';
    import usersMixin from '../../mixins/users.js'

	export default {
		props: {
			events: { type:Array },
			user: { type:Object },
		},

		mixins: [
			usersMixin,
		],

		components: {
            Multiselect
        },

		data() {
			return {
				allEvents: this.events,
				value: '',
				searchOptions: this.events,
				 dateFormat: 'D MMM',
	            dateOne: '',
	            dateTwo: '',
			}
		},

		computed: {
			filteredEvents(){
				if( !this.value ) {return this.allEvents;}
					const search = this.value.eventTitle.toLowerCase().trim();
					return this.events.filter(c => c.eventTitle.toLowerCase().indexOf(search) > -1);
			}
		},

		methods: {

			initializeEventObject() {
            	return {
	                id: '',
	               	eventTitle: '',
            	}
        	},

        	formatDates(dateOne, dateTwo) {
		    	let formattedDates = ''
		    	if (dateOne) {
		      		formattedDates = format(dateOne, this.dateFormat)
		    	}
		      	if (dateTwo) {
		     	 	formattedDates += ' - ' + format(dateTwo, this.dateFormat)
		    	}
		      		return formattedDates
		    },

		}
    };
</script>