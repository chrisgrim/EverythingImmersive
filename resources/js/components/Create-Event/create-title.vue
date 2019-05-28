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
	            <input type="text" class="floating-input" v-model="eventTitle" name="title" v-validate="'required|max:40'" data-vv-as="Event Title" placeholder=" ">
	            <label>Title</label>
	            <span class="text-sm text-danger">{{ errors.first('title') }}</span>
	        </div>
	    </div>
	    <div class="">
	        <button @click.prevent="submitTitle()" class="create"> Next </button>
	    </div>
	    <input type="text" name="Name">
	    <textarea name="notes" id="" cols="30" rows="10">Test</textarea>
	    <button @click.prevent="postTable()">Post table</button>
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

			getTable() {
				axios.defaults.headers = {
					Authorization: 'Bearer keyFh096OT6FXNB3x'
			    }
				axios.get('https://api.airtable.com/v0/applHDrxw5M9KzTWT/tasks')
				.then(response => {
					console.log(response);
				})
			},
			postTable() {
				axios.defaults.headers = {
					'Content-Type': 'application/json',
					Authorization: 'Bearer keyFh096OT6FXNB3x'
			    }
			    let Name = {Name:'name'};
			    let Notes = {Notes:'MoreNotes'};
			    let data = {
					  fields: {
					  	Name:'name',
					  	Notes:'MoreNotes'
					}};
				console.log(data);
				axios.post('https://api.airtable.com/v0/applHDrxw5M9KzTWT/tasks', data)
				.then(response => {
					console.log(response);
				})
			},

			async submitTitle() {
				if(!await this.$validator.validate()) { return false; }
				let data = {};
				data.eventTitle = this.eventTitle;

				axios.patch(`${this.eventUrl}/title`, data)
				.then(response => {
                // all is well. move on to the next page
                window.location.href = `/create-your-event/${response.data.event.slug}/images`;
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
			}
		}
    };

</script>