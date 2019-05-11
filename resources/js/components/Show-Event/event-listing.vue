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
		        @keyup="filteredEvents"
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
		}
    };
</script>