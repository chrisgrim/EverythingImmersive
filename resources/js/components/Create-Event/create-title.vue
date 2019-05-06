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
	            <input type="text" class="floating-input" v-model="eventTitle" placeholder=" " required>
	            <label>Title</label>
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

			submitTitle() {
				let data = {};
				data.eventTitle = this.eventTitle;

				axios.patch(`${this.eventUrl}/title`, data)
				.then(response => {
                    window.location.href = `/create-your-event/${response.data.event.slug}/images`;
                })
			}
		}
    };

</script>