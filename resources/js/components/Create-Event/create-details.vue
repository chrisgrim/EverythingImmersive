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
                <input type="text" class="floating-input" v-model="eventDetails.eventGeneralCost" name="generalCost" v-validate="'required|numeric'" data-vv-as="General Ticket Cost" placeholder=" ">
                <label>General Cost</label>
                <span class="text-sm text-danger">{{ errors.first('generalCost') }}</span>
            </div>
            <div class="floating-label" v-if="studentCost">
                <input type="text" class="floating-input" v-model="eventDetails.eventStudentCost" name="studentCost" v-validate="'numeric'" data-vv-as="Student Ticket Cost" placeholder=" ">
                <label>Student Cost</label>
                <span class="text-sm text-danger">{{ errors.first('studentCost') }}</span>
            </div>
            <div class="floating-label" v-if="VIPCost">
                <input type="text" class="floating-input" v-model="eventDetails.eventVIPCost" name="VIPCost" v-validate="'numeric'" data-vv-as="VIP Ticket Cost" placeholder=" ">
                <label>VIP Cost</label>
                <span class="text-sm text-danger">{{ errors.first('VIPCost') }}</span>
            </div>
            <div class="floating-label" v-if="seniorCost">
                <input type="text" class="floating-input" v-model="eventDetails.eventSeniorCost" name="seniorCost" v-validate="'numeric'" data-vv-as="Senior Ticket Cost" placeholder=" ">
                <label>Senior Cost</label>
                <span class="text-sm text-danger">{{ errors.first('seniorCost') }}</span>
            </div>
            <div class="floating-label" v-if="militaryCost">
                <input type="text" class="floating-input" v-model="eventDetails.eventMilitaryCost" name="militaryCost" v-validate="'numeric'" data-vv-as="Military Ticket Cost" placeholder=" ">
                <label>Military Cost</label>
                <span class="text-sm text-danger">{{ errors.first('militaryCost') }}</span>
            </div>
            <div class="floating-label" v-if="allOtherCost">
                <input type="text" class="floating-input" v-model="eventDetails.eventAllOtherCost" name="anyOtherCost" v-validate="'required'" data-vv-as="Any Other Ticket Cost" placeholder=" ">
                <label>Any Other Cost</label>
                <span class="text-sm text-danger">{{ errors.first('anyOtherCost') }}</span>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="eventDetails.eventWebsite" name="eventUrl" v-validate="'required|url'" data-vv-as="Event Website" placeholder=" ">
                <label>Event Website</label>
                <span class="text-sm text-danger">{{ errors.first('eventUrl') }}</span>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="eventDetails.eventTicketUrl" name="ticketUrl" v-validate="'required|url'" data-vv-as="Ticker Website" placeholder=" ">
                <label>Ticket URL</label>
                <span class="text-sm text-danger">{{ errors.first('ticketUrl') }}</span>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="eventDetails.ageRestriction" name="ageRestriction" v-validate="'required|numeric'" data-vv-as="Age Restriction" placeholder=" ">
                <label>Age Restriction</label>
                <span class="text-sm text-danger">{{ errors.first('ageRestriction') }}</span>
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

			async submitDetails() {
                if (!await this.$validator.validate()) { return false; }

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