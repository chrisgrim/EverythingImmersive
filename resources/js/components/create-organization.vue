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
            class="floating-input"
            placeholder=" "
            />
                <div
                v-show="showAutoComplete"
                class="autocomplete-results">
                    <div
                    v-for="(result, i) in results"
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

    <div id="New Organizer" v-if="isNewOrganizer">
        <div style="backgroundImage: url('/storage/website-files/upload.png'); background-repeat:no-repeat; display:inline-block; background-size: contain;" >
            <label class="imgclick float" :style="organizer.tempImage && { backgroundImage: 'url(' + organizer.tempImage + ')' }">
                <image-upload name="avatar" @loaded="onImageUpload"></image-upload>
            </label>
        </div>
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

    <div id="Exisiting Organizer" v-if="isExistingOrganizer">
        <div :style="organizer.organizationImagePath && { backgroundImage: 'url(' + '/storage/' + organizer.organizationImagePath + ')' }"
            class="profile-image">
        </div>
        <h4>Organization Details</h4>
        <div>
            {{ organizer.organizationDescription }}
        </div>
        <div>
            facebook: {{ organizer.facebookHandle }}
        </div>
        <div>
            instgram: {{ organizer.instagramHandle }}
        </div>
        <div>
            twitter: {{ organizer.twitterHandle }}
        </div>
        <div>
            Website: {{ organizer.organizationWebsite }}
        </div>
    </div>

    <div class="">
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
            results: [],
            isNewOrganizer: false,
            isExistingOrganizer: false,
            showAutoComplete:false,
            arrowCounter: -1,
            organizationNameModel: null,
            organizer: this.initializeOrganizerObject(),
         };
    },
    mounted() {
        this.updateOrganizerFields(this.event.organizer)
    },
    methods: {
        initializeOrganizerObject() {
            return {
                id: null,
                organizationName: null,
                organizationDescription: null,
                organizationWebsite: null,
                tempImage: null,
                organizationImagePath: null,
                twitterHandle: null,
                instagramHandle: null,
                facebookHandle: null,
            };
        },
        onArrowDown() {
            if (this.arrowCounter < this.results.length) {
                this.arrowCounter = this.arrowCounter + 1;
            }
        },
        onArrowUp() {
            if (this.arrowCounter > 0) {
                this.arrowCounter = this.arrowCounter - 1;
            }
        },
        onEnter() {
            this.updateOrganizerFields(this.results[this.arrowCounter]);
        },
        onSelect(result) {
            this.updateOrganizerFields(result);
        },
        onChange() {
            this.isNewOrganizer = true;
            this.isExistingOrganizer = false;
            this.showAutoComplete = true;
            this.organizer = this.initializeOrganizerObject();
            this.filterResults();
        },
        onImageUpload(image) {
            this.organizer.tempImage = image.src;
            this.organizer.organizationImagePath = image.file;
        },
        filterResults() {
            this.results = this.organizers.filter(organizer =>
                organizer.organizationName.toLowerCase().indexOf(this.organizationNameModel.toLowerCase()) > -1
            );
        },
        updateOrganizerFields(input) {
            if ((input !== null) && (typeof input === "object") && (input.id !== null)) {
                this.showAutoComplete = false;
                this.isNewOrganizer = false;
                this.isExistingOrganizer = true;
                this.organizationNameModel = input.organizationName;

                // if input object has organizer fields then updated organizer object with their values
                this.organizer = _.pick(input, _.intersection( _.keys(this.organizer), _.keys(input) ));

            }
        },
        // post the form data to server
        createOrganizer() {
            const params  = new FormData();
            const headers = {'Content-Type': 'application/x-www-form-urlencoded'};

            this.organizer.organizationName = this.organizationNameModel;
            for (var field in this.organizer) {
                if(field === 'tempImage') { continue; }
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
