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
			        @input="filterEvent()"
			        :allow-empty="false"  
			        :options="searchOptions" 
			        >
				    </multiselect>
			    </div>
			    <div>Event Cost
			    	<vue-slide-bar @dragEnd="filterEvent()" v-model="price"/>
				</div>
				<div>
					<input type="text" placeholder="Location" v-model="location">
					<button @click="filterEvent()">Go</button>
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
				        @apply="filterEvent()"
				      />
				    </div>
				</div>
			</div>
			
			<div id="grid-section">
				<div v-for="event in allEvents">
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
import usersMixin from '../../mixins/users.js';
import InfiniteLoading from 'vue-infinite-loading';
import VueSlideBar from 'vue-slide-bar'


export default {
	props: {
		events: {
			type: Array
		},
		user: {
			type: Object
		},
	},

	mixins: [
		usersMixin,
	],

	components: {
		Multiselect,
		InfiniteLoading,
		VueSlideBar,
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
			location: '',
		}
	},

	computed: {

	},

	methods: {

		initializeEventObject() {
			return {
				id: '',
				eventTitle: '',
			}
		},

		infiniteHandler($state) {
			const data = this.allEvents;
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

		filterEvent() {
			let data = {};

			if(this.price) {
				Vue.set(data, "money", this.price);
			}

			if(this.eventName.eventTitle) {
				Vue.set(data, "eventTitle", this.eventName.eventTitle);
			}

			if(this.dateOne) {
				Vue.set(data, "from_date", this.dateOne);
				Vue.set(data, "to_date", this.dateTwo);
			}

			if(this.location) {
				var self = this;

				Vue.set(data, "location", this.location);

				this.locationPromise().then(function(locationData) {
					Vue.set(data, "eventLat", locationData.eventLat);
					Vue.set(data, "eventLong", locationData.eventLong);

					self.getFilteredEvents(data);
				});

			} else {
				this.getFilteredEvents(data);
			}
		},

		locationPromise() {
			return new Promise((resolve, reject) => {
				let params = {
					key: 'af4b25e28c2b00',
					q: this.location,
				};
				let url = `https://cors-anywhere.herokuapp.com/https://us1.locationiq.com/v1/search.php?key=af4b25e28c2b00&q=` + this.location + `&format=json`;
				axios.get(url)
					.then(response => {
						console.log(response.data[0].lat);
						let params = {
							eventLat: response.data[0].lat,
							eventLong: response.data[0].lon,
							locationName: this.location
						};
						resolve(params);
					});
			});
		},

		getFilteredEvents(data) {
			axios.post('/eventsFilter/eventfilter', data)
				.then(response => {
					this.allEvents = response.data;
console.log(response.data);
				})
				.catch(errorResponse => {
					// show if there are server side validation errors
					if (!_.has(errorResponse, 'response.data.errors')) {
						return false;
					}
					for (const [field, errors] of Object.entries(errorResponse.response.data.errors)) {
						for (const error in errors) {
							this.errors.add({
								field: field,
								msg: errors[error]
							});
						}
					}
				});
		},

		priceFilter() {
			let money = {
				var: this.price
			};
			console.log(money);
			axios.post('/eventsFilter/costfilter', money)
				.then(response => {
					this.allEvents = response.data;
				})
				.catch(errorResponse => {
					// show if there are server side validation errors
					if (!_.has(errorResponse, 'response.data.errors')) {
						return false;
					}
					for (const [field, errors] of Object.entries(errorResponse.response.data.errors)) {
						for (const error in errors) {
							this.errors.add({
								field: field,
								msg: errors[error]
							});
						}
					}
				});
		},

		nameFilter() {
			let params = {
				var: this.eventName.eventTitle
			};
			axios.post('/eventsFilter/namefilter', params)
				.then(response => {
					this.allEvents = response.data;
				})
				.catch(errorResponse => {
					// show if there are server side validation errors
					if (!_.has(errorResponse, 'response.data.errors')) {
						return false;
					}
					for (const [field, errors] of Object.entries(errorResponse.response.data.errors)) {
						for (const error in errors) {
							this.errors.add({
								field: field,
								msg: errors[error]
							});
						}
					}
				});
		},

		dateFilter() {
			let params = {
				from_date: this.dateOne,
				to_date: this.dateTwo,
			};
			axios.post('/eventsFilter/datefilter', params)
				.then(response => {
					this.allEvents = response.data;
				})
				.catch(errorResponse => {
					// show if there are server side validation errors
					if (!_.has(errorResponse, 'response.data.errors')) {
						return false;
					}
					for (const [field, errors] of Object.entries(errorResponse.response.data.errors)) {
						for (const error in errors) {
							this.errors.add({
								field: field,
								msg: errors[error]
							});
						}
					}
				});
		},

		locationSearch() {
			let params = {
				key: 'af4b25e28c2b00',
				q: this.location,
			};
			let url = `https://cors-anywhere.herokuapp.com/https://us1.locationiq.com/v1/search.php?key=af4b25e28c2b00&q=` + this.location + `&format=json`;
			axios.get(url)
				.then(response => {
					console.log(response.data[0].lat);
					let params = {
						eventLat: response.data[0].lat,
						eventLong: response.data[0].lon,
						locationName: this.location
					};
					axios.post('/eventsFilter/locationfilter', params)
						.then(response => {
							this.allEvents = response.data;
						})
						.catch(errorResponse => {
							// show if there are server side validation errors
							if (!_.has(errorResponse, 'response.data.errors')) {
								return false;
							}
							for (const [field, errors] of Object.entries(errorResponse.response.data.errors)) {
								for (const error in errors) {
									this.errors.add({
										field: field,
										msg: errors[error]
									});
								}
							}
						});

				})
				.catch(errorResponse => {
					// show if there are server side validation errors
					if (!_.has(errorResponse, 'response.data.errors')) {
						return false;
					}
					for (const [field, errors] of Object.entries(errorResponse.response.data.errors)) {
						for (const error in errors) {
							this.errors.add({
								field: field,
								msg: errors[error]
							});
						}
					}
				});
		},
	},
};
</script>