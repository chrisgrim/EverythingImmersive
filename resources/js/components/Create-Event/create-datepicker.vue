<template>
    <div>
        <div class="dates-grid">
            <div>
                Opening Date of the Event
                <div class="datepicker-trigger ">
                  <input
                    type="text"
                    id="datepicker-trigger"
                    placeholder="Opening Date"
                    :value="formatDates(dateOne)"
                  >

                  <AirbnbStyleDatepicker
                    :trigger-element-id="'datepicker-trigger'"
                    :mode="'single'"
                    :key="1"
                    :months-to-show="1"
                    :fullscreen-mobile="true"
                    :date-one="dateOne"
                    @date-one-selected="val => { dateOne = val }"
                  />
                </div>
            </div>
            <div>
            Closing Date
                <div class="datepicker-trigger">
                  <input
                    type="text"
                    id="datepicker-trigger1"
                    placeholder="Closing Date"
                    :value="formatDatesA(dateTwo)"
                  >

                  <AirbnbStyleDatepicker
                    :trigger-element-id="'datepicker-trigger1'"
                    :mode="'single'"
                    :key="2"
                    :months-to-show="1"
                    :fullscreen-mobile="true"
                    :date-one="dateTwo"
                    @date-one-selected="val => { dateTwo = val }"
                  />
                </div>
            </div>
        </div>
        <div class="">
            <button @click.prevent="submit()" class="create"> Next </button>
        </div>


    </div>
</template>

<script>
import format from 'date-fns/format'


export default {
    props: {
        event: {
            type:Object,
        },
    },  

    data() {
        return {
            dateFormat: 'D MMM',
            dateOne: '',
            dateTwo: '',
            eventUrl:_.has(this.event, 'slug') ? `/create-your-event/${this.event.slug}` : null,
        }
    },

    methods: {
        submit() {
            let data = {
            'openingDate': this.dateOne,
            'closingDate': this.dateTwo,
            };

            axios.patch(`${this.eventUrl}/dates`, data)
                .then(response => {
                    // all is well. move on to the next page
                    window.location.href = `${this.eventUrl}/details`;
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

        formatDates(dateOne) {
            let formattedDates = ''

            if (dateOne) {
                    formattedDates = format(dateOne, this.dateFormat)
            }
                return formattedDates
        },

        formatDatesA(dateTwo) {
            let formattedDates = ''
                if (dateTwo) {
                    formattedDates = format(dateTwo, this.dateFormat)
                }
                    return formattedDates
        },

        init() {
                this.dateOne = this.event.openingDate;
                this.dateTwo = this.event.closingDate;
        },

    },

    mounted() {
        this.init()
    },
}  
</script>