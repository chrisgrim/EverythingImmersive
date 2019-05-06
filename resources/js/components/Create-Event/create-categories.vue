<template>
	<div>
		<div class="create-guide-title">
    	<h2> What type of Event are you hosting?</h2>
	    </div>
	    <div>
	    	<p>Choose the category that best describes your event</p>
	    </div>
		 <div class="organization-form">
	        <multiselect 
	        v-show="categories.length > 0" 
	        v-model="selectedCategory" 
	        placeholder="Select or Create Organizer"
	        label="categoryName" 
	        track-by="categoryName" 
	        deselectLabel=''
	        :allow-empty="false"  
	        :options="categoryOptions" 
	        open-direction="bottom" 
	        >
	            <template slot="option" slot-scope="props">
	                <img class="option__image" :src="props.option.categoryImagePath ? `/storage/${props.option.categoryImagePath}` : defaultImage"
	                alt="defaultImage">
	                <div class="option__desc">
	                    <span class="option__title">{{ props.option.categoryName }}</span>
	                    <span class="option__small">{{ props.option.categoryDescription }}</span>
	                </div>
	            </template>
	        </multiselect>
	    </div>
	    <img v-if="this.selectedCategory" class="option__image" :src="'/storage/' + selectedCategory.categoryImagePath " alt="defaultImage">
	    <div>
	    	<h2 v-text="this.selectedCategory ? selectedCategory.categoryName : ''"></h2>
	    </div>

	    <div class="">
	        <button @click.prevent="submitCategory()" class="create"> Next </button>
	    </div>
    </div>
</template>

<script>
	import Multiselect from 'vue-multiselect';
	import _ from 'lodash'

	export default {
		props: {
			event: { type:Object },
			categories: { type:Array }
		},

		components: { 
			Multiselect 
		},

		data() {
			return {
				defaultImage: '/storage/website-files/upload.png',
				selectedCategory: this.event.category,
				eventUrl:_.has(this.event, 'slug') ? `/create-your-event/${this.event.slug}` : null,
				categoryOptions: this.categories
			}
		},

		methods: {

			submitCategory() {

				axios.patch(`${this.eventUrl}/category`, this.selectedCategory)
				.then(response => {
                    // all is well. move on to the next page
                    window.location.href = `${this.eventUrl}/organizer`;
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