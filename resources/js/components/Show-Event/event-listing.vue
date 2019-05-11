<template>
	<div>
		<h2>Our Latest Events</h2>
		<div id="app">
			<div>
				<multiselect 
		        v-model="value" 
		        placeholder="Search by name"
		        label="eventTitle" 
		        track-by="eventTitle" 
		        deselectLabel=''
		        :allow-empty="false"  
		        :options="searchOptions" 
		        >
			    </multiselect>
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

	export default {
		props: {
			events: { type:Array },
			user: { type:Object },
		},

		components: {
            Multiselect
        },

		data() {
			return {
				allEvents: this.events,
				value: '',
				searchOptions: this.events
			}
		},

		computed: {
			filteredEvents(){
				return this.events.filter(event => {
					return event.eventTitle.toLowerCase().indexOf(this.value.toLowerCase()) > -1
				})
			}
		},

		methods: {

			initializeEventObject() {
            	return {
	                id: '',
	               	eventTitle: '',
            	}
        	},
		}
    };
</script>