<template>
    <div>
        Opening Date of the Event
        <div class="datepicker-trigger">
          <input
            type="text"
            id="datepicker-trigger"
            placeholder="Opening Date"
            :value="formatDates(dateOne)"
          >

          <AirbnbStyleDatepicker
            :trigger-element-id="'datepicker-trigger'"
            :mode="'single'"
            :start-open="true"
            :key="1"
            :months-to-show="1"
            :fullscreen-mobile="true"
            :date-one="dateOne"
            @date-one-selected="val => { dateOne = val }"
          />
        </div>

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
            dateTwo: ''
        }
    },

    methods: {
        submit() {
            let data = {
            'openingDate': this.dateOne,
            'closingDate': this.dateTwo,
            };

            axios.patch('/create-your-event/' + this.event.slug + '/dates', data).catch(error => {
            console.log(error.response.data.errors);
            });

            window.location.href = '/create-your-event/' + this.event.slug + '/category'; 
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