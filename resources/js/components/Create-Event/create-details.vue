<template>
	<div>
		<div>
	    	<h2> Event Details</h2>
	    </div>
	    <div>
	    	<p>Give us the specifics!</p>
	    </div>
        <div class="floating-form">
            
            <input type="checkbox" v-model="studentCost" @click="zeroOut()"> Student Cost<br>
            <input type="checkbox" v-model="VIPCost" @click="zeroOut()"> VIP Cost<br>
            <input type="checkbox" v-model="seniorCost" @click="zeroOut()"> Senior Cost<br>
            <input type="checkbox" v-model="militaryCost" @click="zeroOut()"> Military Cost<br>
            <input type="checkbox" v-model="allOtherCost" @click="zeroOut()"> Any other type of ticket<br>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="eventDetails.eventGeneralCost" placeholder=" " required>
                <label>General Cost</label>
            </div>
            <div class="floating-label" v-if="studentCost">
                <input type="text" class="floating-input" v-model="eventDetails.eventStudentCost" placeholder=" " required>
                <label>Student Cost</label>
            </div>
            <div class="floating-label" v-if="VIPCost">
                <input type="text" class="floating-input" v-model="eventDetails.eventVIPCost" placeholder=" " required>
                <label>VIP Cost</label>
            </div>
            <div class="floating-label" v-if="seniorCost">
                <input type="text" class="floating-input" v-model="eventDetails.eventSeniorCost" placeholder=" " required>
                <label>Senior Cost</label>
            </div>
            <div class="floating-label" v-if="militaryCost">
                <input type="text" class="floating-input" v-model="eventDetails.eventMilitaryCost" placeholder=" " required>
                <label>Military Cost</label>
            </div>
            <div class="floating-label" v-if="allOtherCost">
                <input type="text" class="floating-input" v-model="eventDetails.eventAllOtherCost" placeholder=" " required>
                <label>Any Other Cost</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="eventDetails.eventWebsite" placeholder=" " required>
                <label>Event Website</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="eventDetails.eventTicketUrl" placeholder=" " required>
                <label>Ticket URL</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="eventDetails.ageRestriction" placeholder=" " required>
                <label>Age Restriction</label>
            </div>
            <div class="">
                <button @click.prevent="submitDetails()" class="create"> Save and Continue </button>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';

	export default {
		props: {
			event: {
				type:Object,
			},
		},

		data() {
			return {
                eventDetails: this.initializeEventObject(),
                eventUrl:_.has(this.event, 'slug') ? `/create-your-event/${this.event.slug}` : null,
                studentCost: this.event.eventStudentCost,
                seniorCost: this.event.eventSeniorCost,
                VIPCost: this.event.eventVIPCost,
                allOtherCost: this.event.eventAllOtherCost,
                militaryCost: this.event.eventMilitaryCost,
			}
		},

		methods: {
            initializeEventObject() {
                return {
                    eventWebsite: '',
                    eventTicketUrl: '',
                    ageRestriction: '',
                    eventGeneralCost: '',
                    eventStudentCost: '',
                    eventVIPCost: '',
                    eventSeniorCost: '',
                    eventMilitaryCost: '',
                    eventAllOtherCost: '',
                    eventStudentCost: '',
                    eventVIPCost: '',
                    eventSeniorCost: '',
                    eventMilitaryCost: '',
                    eventAllOtherCost: '',
                }
            },

			submitDetails() {
                console.log(this.eventDetails);
                axios.patch(`${this.eventUrl}/details`, this.eventDetails)
                .then(response => {
                    // all is well. move on to the next page
                    window.location.href = `${this.eventUrl}/description`;
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

            updateEventFields(input) {
                if ((input !== null) && (typeof input === "object") && (input.id !== null)) {
                    this.eventDetails = _.pick(input, _.intersection( _.keys(this.eventDetails), _.keys(input) ));
                }
            },

            zeroOut() {
                
            },
		},

        mounted() {
        this.updateEventFields(this.event)
        },

    };



</script>