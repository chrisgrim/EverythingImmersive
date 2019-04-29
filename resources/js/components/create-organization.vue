<template>
<div>
    <div>
        <br>
        <h4>Production Company Name</h4>
    </div>
    <!-- TODO:: use better/3rd party autocomplete package instead of custom code. -->
    <div class="autocomplete floating-form">
        <div class="floating-label">
            <input type="text"
            v-model="organizationNameModel"
            @input="onChange"
            @keydown.down="onArrowDown"
            @keydown.up="onArrowUp"
            @keydown.enter.prevent="onEnter"
            @click="onChange"
            class="floating-input"
            placeholder=" "
            />
                <div
                v-show="showAutoComplete"
                class="autocomplete-results">
                    <div
                    v-for="(result, i) in autocompleteResults"
                    :key="i"
                    @click="onSelect(result)"
                    class="autocomplete-result"
                    :class="{ 'is-active': i === arrowCounter }"
                    >
                        {{ result.organizationName }}
                    </div>
                </div>
            <label>Production Company name</label>
        </div>
    </div>

    <div v-show="showFormFields">
        <label class="image-upload-wrapper"
                :style="{ backgroundImage: `url('${organizationImageModel ? organizationImageModel : defaultImage}')` }" >
            <span class="image-upload-layover">
                <div class="text-center">{{ organizationImageModel ? 'Change' : 'Upload' }}</div>
            </span>
            <image-upload name="avatar" @loaded="onImageUpload"></image-upload>
        </label>

        <div class="floating-form">
            <div class="floating-label">
                <textarea type="text" class="floating-input" v-model="organizer.organizationDescription" placeholder=" " rows="8"></textarea>
                <label>Description of Production Company</label>
            </div>
            <div class="floating-label">
                <input class="floating-input" type="url" v-model="organizer.organizationWebsite" placeholder=" ">
                <label>Enter Production Website</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="organizer.twitterHandle" placeholder=" ">
                <label>enter twitter handle</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="organizer.facebookHandle" placeholder=" ">
                <label>enter facebook handle</label>
            </div>
            <div class="floating-label">
                <input type="text" class="floating-input" v-model="organizer.instagramHandle" placeholder=" ">
                <label>enter instagram handle</label>
            </div>
        </div>
    </div>

    <div>
        <button type="submit" class="create" @click.prevent="createOrganizer"> Save and Continue </button>
    </div>
</div>
</template>

<script>
import _ from 'lodash';
import ImageUpload from './imageupload.vue';
export default {
    components: {
        ImageUpload
    },
    props: {
        organizers: { type: Array },
        event: { type: Object },
    },
    data() {
        return {
            arrowCounter: -1,
            autocompleteResults: [],
            showAutoComplete:false,
            showFormFields: false,
            organizationNameModel: '',
            organizationImageModel: '',
            defaultImage: '/storage/website-files/upload.png',
            organizer: this.initializeOrganizerObject(),
        };
    },
    mounted() {
        this.updateOrganizerFields(this.event.organizer)
    },
    methods: {
        initializeOrganizerObject() {
            return {
                id: '',
                organizationName: '',
                organizationDescription: '',
                organizationWebsite: '',
                organizationImagePath: '',
                twitterHandle: '',
                instagramHandle: '',
                facebookHandle: '',
            };
        },
        onArrowDown() {
            if (this.arrowCounter < this.autocompleteResults.length) {
                this.arrowCounter = this.arrowCounter + 1;
            }
        },
        onArrowUp() {
            if (this.arrowCounter > 0) {
                this.arrowCounter = this.arrowCounter - 1;
            }
        },
        onEnter() {
            this.updateOrganizerFields(this.autocompleteResults[this.arrowCounter]);
        },
        onSelect(result) {
            this.updateOrganizerFields(result);
        },
        onChange() {
            this.showFormFields = true;
            this.showAutoComplete = true;
            this.organizationImageModel = null;
            this.organizer = this.initializeOrganizerObject();
            this.filterResults();
        },
        onImageUpload(image) {
            this.organizationImageModel = image.src;
            this.organizer.organizationImagePath = image.file;
        },
        filterResults() {
            this.autocompleteResults = this.organizers.filter(organizer =>
                organizer.organizationName.toLowerCase().indexOf(this.organizationNameModel.toLowerCase()) > -1
            );
        },
        updateOrganizerFields(input) {
            if ((input !== null) && (typeof input === "object") && (input.id !== null)) {
                this.showAutoComplete = false;
                this.showFormFields = true;

                // if input object has organizer fields then updated organizer object with their values
                this.organizer = _.pick(input, _.intersection( _.keys(this.organizer), _.keys(input) ));
                this.organizationNameModel = input.organizationName;
                this.organizationImageModel = this.organizer.organizationImagePath ? `/storage/${this.organizer.organizationImagePath}` : '';
            }
        },
        // post the form data to server
        createOrganizer() {
            const params  = new FormData();
            const headers = {'Content-Type': 'application/x-www-form-urlencoded'};

            this.organizer.organizationName = this.organizationNameModel;
            for (var field in this.organizer) {
                params.append(field, this.organizer[field]);
            }

            // TODO:: add client side validations
            axios.post('/create-your-event/' + this.event.slug + '/organizer', params, headers).catch(error => {
                module.status = error.response.data.status;
            });
            // TODO:: process server side errors instead of moving on by default
            window.location.href = '/create-your-event/' + this.event.slug + '/dates';
        },
    },
};
</script>
