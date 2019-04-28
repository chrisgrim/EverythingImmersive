<template>
	<div>
        <div>
    		<h2> What can your guests expect?</h2>
	    </div>
	    <div>
	    	<flash></flash>
	    </div>
	    <div>
	    	<p>Let the guests know what they can expect. Will there be scary noises or bright flashes?</p>
	    	<p>Some common ones include: 
* strong language
* fog/haze
* flashing lights
* simulated gun shots/violence
* themes around racism, homophobia, mental health, suicide, etc.
* discussions of sex and intimacy
* moments of darkness
* strong smells</p>
	    </div>
	    <div class="floating-form">
		    <div class="floating-label area">
	            <textarea v-model="content" name="eventExpectations" id="eventExpectations" class="floating-input area" rows="8" placeholder=" " required autofocus></textarea>
	            <label class="area"> Content Advisory </label>
	        </div>
	        <br>
	        <div>
				<div>
					Level of Contact w/ Audience (Touch Advisory)
					<multiselect 
					v-model="contactLevel" 
					:options="contactLevelOptions" 
					:multiple="true" 
					:close-on-select="false" 
					:clear-on-select="false" 
					:preserve-search="true" 
					placeholder="Pick some" 
					label="level" 
					track-by="id" 
					:preselect-first="true">
  					</multiselect>
				</div>
			</div>
			<div>
				<div class="floating-label area">
		            <textarea v-model="touchAdvisory" class="floating-input area" rows="8" placeholder=" " required autofocus></textarea>
		            <label class="area"> Explain a bit about your contact with the audience </label>
	        	</div>
			</div>
			<div>
				<div>
					Advisory for Sexual Violence?
					<multiselect 
					v-model="sexualViolence" 
					deselect-label="Can't remove this value" 
					track-by="boo" 
					label="name" 
					placeholder="Select one" 
					:options="sexualViolenceOptions" 
					open-direction="bottom"
					:searchable="false" 
					:allow-empty="false">
	  				</multiselect>
				</div>
			</div>
			<div v-show="sexualViolence.boo">
				<div class="floating-label area">
		            <textarea v-model="sexualViolenceDescription" class="floating-input area" rows="8" placeholder=" " required autofocus></textarea>
		            <label class="area"> Explain more about the sexual violence </label>
	        	</div>
			</div>
			<br>
	        <div>
				<div>
					Is this experience wheelchair accessible?
					<multiselect 
					v-model="wheelchair" 
					deselect-label="Can't remove this value" 
					track-by="boo" 
					label="name" 
					placeholder="Select one" 
					:options="wheelchairOptions" 
					open-direction="bottom"
					:searchable="false" 
					:allow-empty="false">
	  				</multiselect>
				</div>
			</div>
			<div><br>
					Any Other Mobility Advisories?<br>
					* Can you accommodate someone who can't stand/walk for long periods of time? <br>
* Can the show accommodate someone who uses a walker? <br>
* Does the show take place on uneven ground or in a venue with staircases?
			</div>
			<div class="floating-label area">
	            <textarea v-model="mobility" name="eventExpectations" id="eventExpectations" class="floating-input area" rows="8" placeholder=" " required autofocus></textarea>
	            <label class="area"> Mobility Advisories </label>
	        </div>
	        <div class="">
	            <button @click.prevent="submit()" class="create"> Save and Continue </button>
	        </div>
	    </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

	export default {
        components: {
            Multiselect
        },

		props: {
			event: {
				type:Object,
			},
			contact: {
				type:Array,
			},
			pivots: {
				type:Array,
			},
		},

		data() {
			return {
                description: '',
                mobility: '',
                content: '',
                wheelchair: '',
                wheelchairOptions: [
                	{ name: 'Yes', boo: 1 },
       				{ name: 'No', boo: 0 },
        		],
                level: [],
                options: [],
                keyword: '',
                touchAdvisory: '',
                contactLevel: '',
                contactLevelOptions: this.contact,
                sexualViolence: '',
                sexualViolenceDescription: '',
                sexualViolenceOptions: [
                	{ name: 'Yes', boo: true },
       				{ name: 'No', boo: false },
        		],

			}
		},


		methods: {
			submit() {
				let data = {
                    'contentAdvisories': this.content,
                    'touchAdvisoryDescription': this.touchAdvisory,
                    'sexualViolence': this.sexualViolence.boo,
                    'sexualViolenceDescription': this.sexualViolenceDescription,
                    'wheelchairReady': this.wheelchair.boo,
                    'mobilityAdvisories': this.mobility,
           		};
                
                data.contactLevel = this.contactLevel.map(a => a.id);

                console.log(data);

				axios.patch('/create-your-event/' + this.event.slug + '/expect', data).catch(error => {
                module.status = error.response.data.status;
            	});

            	window.location.href = '/create-your-event/' + this.event.slug + '/title'; 
 
			},

			

            init() {
                this.touchAdvisory = this.event.touchAdvisoryDescription
                this.sexualViolenceDescription = this.event.sexualViolenceDescription
                this.mobility = this.event.mobilityAdvisories
                this.content = this.event.contentAdvisories
                this.contactLevel = this.pivots
                this.keyword = this.event.wheelchairReady
            },
            loadWheelChair() {
				if (this.event.wheelchairReady == null) {
					// 
				} else {
					if(this.event.wheelchairReady == 1) {
						return this.wheelchair ={ name: 'Yes', boo: true };
					} else {
						return this.wheelchair ={ name: 'No', boo: false };
					}
				}
			},

			loadSexualViolence() {
				if (this.event.sexualViolence == null) {
					// 
				} else {
					if(this.event.sexualViolence == 1) {
						return this.sexualViolence ={ name: 'Yes', boo: true };
					} else {
						return this.sexualViolence ={ name: 'No', boo: false };
					}
				}
			},

		},


		watch: {
			

		},


        mounted() {
            this.init();
            this.loadWheelChair();
            this.loadSexualViolence();
        },
    };



</script>