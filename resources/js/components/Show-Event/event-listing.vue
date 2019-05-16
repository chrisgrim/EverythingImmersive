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
			        v-model="eventName" 
			        placeholder="Filter by name"
			        label="eventTitle" 
			        track-by="eventTitle" 
			        deselectLabel=''
			        @input="nameFilter()"
			        :allow-empty="false"  
			        :options="searchOptions" 
			        >
				    </multiselect>
			    </div>
			    <div>
					<input type="text" placeholder="Filter by Price" v-model="price">
					<button @click="priceFilter()">Go</button>
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
				<div v-for="displayEvent in filteredEvents">
					<event-listing-item :user="user" :event="displayEvent"></event-listing-item>
				</div>
			</div>
			<div id="grid-section">
				<div v-for="event in list">
					<event-listing-item :user="user" :event="event"></event-listing-item>
				</div>
				<infinite-loading @infinite="infiniteHandler"></infinite-loading>
			</div>
		</div>
    </div>
</template>

<script>
	import _ from 'lodash';
    import Multiselect from 'vue-multiselect';
    import format from 'date-fns/format';
    import usersMixin from '../../mixins/users.js';
    import InfiniteLoading from 'vue-infinite-loading';


	export default {
		props: {
			events: { type:Array },
			user: { type:Object },
		},

		mixins: [
			usersMixin,
		],

		components: {
            Multiselect,
            InfiniteLoading,
        },

		data() {
			return {
				allEvents: this.events,
				value: '',
				searchOptions: this.events,
				dateFormat: 'D MMM',
	            dateOne: '',
	            dateTwo: '',
      			list: [],
      			price: '',
      			eventName: '',
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

			infiniteHandler($state) {
					const data = this.events;
					if (data) {
				      this.list = this.list.concat(data);
				      $state.loaded();
				    } else {
				      $state.complete();
				    };
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

		    priceFilter() {
		    	let money = {var: this.price};
		    	console.log(money);
		    	axios.post('/eventsFilter/price', money)
		    	.then(response => {
                console.log(response);
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

		    nameFilter() {
		    	let params = {var: this.eventName.eventTitle};
		    	console.log(params);
		    	axios.post('/eventsFilter/price', params)
		    	.then(response => {
                console.log(response);
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
    };
</script>