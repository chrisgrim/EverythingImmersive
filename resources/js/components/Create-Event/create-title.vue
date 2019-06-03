<template>
	<div>
		<div class="create-guide-title">
    	<h2> What is the Title of your Event?</h2>
	    </div>
	    <div>
	    	<p>Make it a good one!</p>
	    </div>
	    <div class="floating-form">
		    <div class="floating-label">
	            <input type="text" class="floating-input" v-model="eventTitle" name="eventTitle" v-validate="'required|max:40'" data-vv-as="Event Title" placeholder=" ">
	            <label>Title</label>
	            <span class="text-sm text-danger">{{ errors.first('eventTitle') }}</span>
	        </div>
	    </div>
	    <div class="">
	        <button @click.prevent="submitTitle()" class="create"> Next </button>
	    </div>
    </div>
</template>

<script>

	export default {
		props: {
			event: { type:Object },
		},

		data() {
			return {
				eventTitle: this.event.eventTitle,
				eventUrl:_.has(this.event, 'slug') ? `/create-your-event/${this.event.slug}` : null
			}
		},

		methods: {

			async submitTitle() {
				if(!await this.$validator.validate()) { return false; }
				let data = {};
				data.eventTitle = this.eventTitle;
				console.log(data);
				axios.patch(`${this.eventUrl}/title`, data)
				.then(response => {
                // all is well. move on to the next page
                	console.log(response);
                	window.location.href = `/create-your-event/${response.data.event.slug}/images`;
            	})
            	.catch(error => {
            		console.log(error.response);
            		this.validationErrors = error.response.data.errors
            	});
			}
		}
    };

</script>