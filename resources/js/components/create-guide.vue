<template>
	<div>
        <a :href="'/create-your-event/'+ this.event.slug +'/location'">
        <div class="guide-section" >
            Location 
                <svg v-if="eventCity" viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
        </div>
        </a>
        <a :href="'/create-your-event/'+ this.event.slug +'/category'">
        <div class="guide-section">
            Category
            <svg v-if="categoryId" viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
        </div>
        </a>

        <a :href="'/create-your-event/'+ this.event.slug +'/organizer'">
        <div class="guide-section">
            Who is Putting it On?
            <svg v-if="organizerId" viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
        </div>
        </a>

        <a :href="'/create-your-event/'+ this.event.slug +'/dates'">
        <div class="guide-section">
            Dates
            <svg v-if="openingDate" viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
        </div>
        </a>

        <a :href="'/create-your-event/'+ this.event.slug +'/details'">
        <div class="guide-section">
            Event Details?
            <svg v-if="eventWebsite" viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
        </div>
        </a>


        <a :href="'/create-your-event/'+ this.event.slug +'/description'">
        <div class="guide-section">
            Event Description
            <svg v-if="eventDescription" viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
        </div>
        </a>

        <a :href="'/create-your-event/'+ this.event.slug +'/expect'">
        <div class="guide-section">
            What Guests should expect
            <svg v-if="eventContentAdvisories" viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
        </div>
        </a>

        <a :href="'/create-your-event/'+ this.event.slug +'/title'">
        <div class="guide-section">
            Title
            <svg v-if="eventTitle" viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
        </div>
        </a>

        <a :href="'/create-your-event/'+ this.event.slug +'/images'">
        <div class="guide-section">
            Photo
            <svg v-if="eventImagePath" viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
        </div>
        </a>

        
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

	export default {
		props: {
			event: {
				type:Object,
			},
		},

		data() {
			return {
                eventCity: '',
                categoryId: '',
                organizerId: '',
                openingDate: '',
                eventWebsite: '',
                eventDescription: '',
                eventContentAdvisories: '',
                eventTitle: '',
                eventImagePath: '',
                
			}
		},

		methods: {
            init() {
                this.eventCity = this.event.eventCity
                this.categoryId = this.event.category_id
                this.organizerId = this.event.organizer_id
                this.openingDate = this.event.openingDate
                this.eventWebsite = this.event.eventWebsite
                this.eventDescription = this.event.eventDescription
                this.eventContentAdvisories = this.event.contentAdvisories
                this.eventTitle = this.event.eventTitle
                this.eventImagePath = this.event.eventImagePath

            },

		},

        mounted() {
            this.init();
        },
    };



</script>