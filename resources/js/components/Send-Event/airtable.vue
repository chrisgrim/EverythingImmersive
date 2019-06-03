<template>
	<div>
	    <button @click.prevent="postEventAirtable()">Post To Airtable</button>
    </div>
</template>

<script>

	export default {
		props: {
			event: { type:Object },
		},

		methods: {

			postEventAirtable() {
				axios.defaults.headers = {
					'Content-Type': 'application/json',
					Authorization: 'Bearer keyFh096OT6FXNB3x'
			    }
			    let data = {
					  fields: {
					  	Title: this.event.eventTitle,
					  	Description: this.event.eventDescription,
					  	EventWebsite: this.event.eventWebsite,
					  	TicketURL: this.event.eventTickerUrl,
					  	Expectations: this.event.eventExpectations,
					  	City: this.event.eventCity,
					}};
				console.log(data);
				axios.post(`https://api.airtable.com/v0/applHDrxw5M9KzTWT/events`, data)
				.then(response => {
					console.log(response);
				})
			},
		}
    };

</script>