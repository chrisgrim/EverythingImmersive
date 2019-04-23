<template>
	<div>
		<div>
	    	<h2> Event Details</h2>
	    </div>
	    <div>
	    	<p>Give us the specifics!</p>
	    </div>
        <div class="floating-form">
            
            <input type="checkbox" v-model="studentCostCheck" @click="zeroOut()"> Student Cost<br>
            <input type="checkbox" v-model="vipCostCheck" @click="zeroOut()"> VIP Cost<br>
            <input type="checkbox" v-model="seniorCostCheck" @click="zeroOut()"> Senior Cost<br>
            <input type="checkbox" v-model="militaryCostCheck" @click="zeroOut()"> Military Cost<br>
            <input type="checkbox" v-model="anyOtherCostCheck" @click="zeroOut()"> Any other type of ticket<br>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="generalCost" placeholder=" " required>
                <label>General Cost</label>
            </div>
            <div class="floating-label" v-if="studentCostCheck">
                <input type="text" class="floating-input" v-model="studentCost" placeholder=" " required>
                <label>Student Cost</label>
            </div>
            <div class="floating-label" v-if="vipCostCheck">
                <input type="text" class="floating-input" v-model="vipCost" placeholder=" " required>
                <label>VIP Cost</label>
            </div>
            <div class="floating-label" v-if="seniorCostCheck">
                <input type="text" class="floating-input" v-model="seniorCost" placeholder=" " required>
                <label>Senior Cost</label>
            </div>
            <div class="floating-label" v-if="militaryCostCheck">
                <input type="text" class="floating-input" v-model="militaryCost" placeholder=" " required>
                <label>Military Cost</label>
            </div>
            <div class="floating-label" v-if="anyOtherCostCheck">
                <input type="text" class="floating-input" v-model="anyOtherCost" placeholder=" " required>
                <label>Any Other Cost</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="website" placeholder=" " required>
                <label>Event Website</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="ticketUrl" placeholder=" " required>
                <label>Ticket URL (if different from Website url above)</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="ageRestriction" placeholder=" " required>
                <label>Age Restriction</label>
            </div>
            <div class="">
                <button @click.prevent="submit()" class="create"> Save and Continue </button>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		props: {
			event: {
				type:Object,
			},
		},

		data() {
			return {
				website: '',
				ticketUrl: '',
				ageRestriction: '',
				generalCost: '',
                seniorCost: '',
                vipCost: '',
                studentCost: '',
                militaryCost: '',
                anyOtherCost: '',
                seniorCostCheck: '',
                vipCostCheck: '',
                studentCostCheck: '',
                militaryCostCheck: '',
                anyOtherCostCheck: '',

			}
		},

		methods: {
			submit() {
				let data = {
                'eventWebsite': this.website,
                'eventTicketUrl': this.ticketUrl,
                'ageRestriction': this.ageRestriction,
                'eventGeneralCost': this.generalCost,
                'eventStudentCost': this.studentCost,
                'eventMilitaryCost': this.militaryCost,
                'eventSeniorCost': this.seniorCost,
                'eventVIPCost': this.vipCost,
                'eventAllOtherCost': this.anyOtherCost,
           		};
				axios.patch('/create-your-event/' + this.event.slug + '/details', data).catch(error => {
                module.status = error.response.data.status;
            	});
                window.location.href = '/create-your-event/' + this.event.slug + '/description'; 
			},

            zeroOut() {
                this.studentCost = null
                this.vipCost = null
                this.seniorCost = null
                this.militaryCost = null
                this.anyOtherCost = null
            },

            init() {
                    this.website = this.event.eventWebsite
                    this.ticketUrl = this.event.eventTicketUrl
                    this.ageRestriction = this.event.ageRestriction
                    this.generalCost = this.event.eventGeneralCost
                    this.studentCostCheck = this.event.eventStudentCost
                    this.vipCostCheck = this.event.eventVIPCost
                    this.seniorCostCheck = this.event.eventSeniorCost
                    this.militaryCostCheck = this.event.eventMilitaryCost
                    this.anyOtherCostCheck = this.event.eventAllOtherCost
                    this.studentCost = this.event.eventStudentCost
                    this.vipCost = this.event.eventVIPCost
                    this.seniorCost = this.event.eventSeniorCost
                    this.militaryCost = this.event.eventMilitaryCost
                    this.anyOtherCost = this.event.eventAllOtherCost
            },

		},

        mounted() {
            this.init();
        },
    };



</script>