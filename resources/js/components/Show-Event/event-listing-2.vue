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
				<!-- What is this filter by name? -->
				<!-- <div>
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
			    </div> -->
			    <div>Event Cost
			    	<vue-slide-bar @input="filterPrice"/>
				</div>
				<div>
					<input type="text" placeholder="Location" @change="filterEvent" name="eventCity">
					<button @click="getEvents()">Go</button>
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
				        @date-one-selected="val => filterDateOne(val)"
				        @date-two-selected="val => filterDateTwo(val)"
				        @apply="getDates"
				      />
				    </div>
				</div>
			</div>
			
			<div id="grid-section">
				<!-- <div v-for="event in allEvents">
					<event-listing-item :user="user" :event="event"></event-listing-item>
				</div> -->
				<ul v-if="events.length">
					<li v-for="event in events" :key="event.id">
						{{event.eventTitle}}
					</li>
				</ul>
				<p v-else>No Data</p>
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
    import VueSlideBar from 'vue-slide-bar';
    import {mapState,mapMutations} from 'vuex';


	export default {
		mixins: [
			usersMixin,
		],

		components: {
            Multiselect,
            InfiniteLoading,
            VueSlideBar,
        },
        computed:{
            ...mapState({
                events:state => state.events.all
            })
        },

        mounted(){
            this.$store.dispatch('events/index');
        },

		data() {
			return {
				dateFormat: 'D MMM',
	            dateOne: '',
	            dateTwo: '',
      			list: [],
      			price: '',
      			eventName: '',
      			location: '',
			}
		},

		methods: {
			getEvents(){
				this.$store.dispatch('events/index');
			},
			...mapMutations({
				'filterEvent':'events/filterEvent',
			}),
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
			/**
			 * Filter the price slider, 
			 * and then dispatch the value and name to our events state
			 * @param {int} val
			 * @return void
			 */
			filterPrice(val){
				const event = {
					target:{
						value:val,
						name:'eventGeneralCost'
					}
				}
				this.$store.commit('events/filterEvent',event);
			},
			filterDateOne(val){
				this.dateOne = val;
				const event = {
					target:{
						value:val,
						name:'openingDate'
					}
				}
				this.$store.commit('events/filterEvent',event);
			},
			filterDateTwo(val){
				this.dateTwo = val;
				const event = {
					target:{
						value:val,
						name:'closingDate'
					}
				}
				this.$store.commit('events/filterEvent',event)
			},
			getDates(){
				//you can trigger the query into this method
				console.log('tes')
			}
		},
    };
</script>