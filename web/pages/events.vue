<template>
    <v-container>
      <v-card class="mb-3" elevation="7" style="overflow: hidden">
        <v-toolbar flat>
          <v-btn icon @click="calendar.prev()"> <chevron-left-icon/></v-btn>
          <v-spacer/>
          <v-toolbar-title> {{observedDate.toLocaleString('sv', {month: "long", year: "numeric"}) }} </v-toolbar-title>
          <v-spacer/>
          <v-btn icon @click="calendar.next()"> <chevron-right-icon/> </v-btn>
        </v-toolbar>
        <v-calendar color="primary" :weekdays="[1, 2, 3, 4, 5, 6, 0]" :events="getCalendarData()" :event-timed="() => $vuetify.breakpoint.mdAndUp" show-week
                    @click:event="onEventClick" locale="sv" locale-first-day-of-year="4" style="border: none;" v-model="observedDate" ref="calendar"/>
      </v-card>

        <v-card :loading="loading" class="mb-3" elevation="7">
          <v-alert v-if="error" text color="error">{{error}}</v-alert>
            <v-card-title>
              <h3> Kommande Arrangemang </h3>
            </v-card-title>
            <v-card-text>
              Varje läsperiod så sker Chilla med HD i läsvecka 2 & 6 medan Spelpuben sker i läsvecka 4.
            </v-card-text>
        </v-card>

      <v-card class="mb-3" elevation="6" v-if="!events[0] && !loading">
        <v-card-text>
          <span>Inga arrangemang är just nu inlagda</span>
        </v-card-text>
      </v-card>

      <v-card v-if="loading" class="mb-3">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-card>
      <event-card v-for="event in events" v-bind:key="event.id" :id="'event' + event.id" class="mb-3"
                  :title="event.title" :date="event.date" :description="event.description" :facebook="event.facebook_event_link" :location="event.location">

      </event-card>
      <footer-card class="elevation-6"/>
    </v-container>
</template>

<script lang="ts">
import { Component, Ref, Vue } from 'vue-property-decorator'
import footerCard from "~/components/common/footerCard.vue";
import { EventType } from '@/assets/interfaces'
import { ChevronLeftIcon, ChevronRightIcon } from "vue-feather-icons";


/**
 * The events page that has a calendar and a list of events.
 */
@Component({
      components: {
        ChevronLeftIcon,
        ChevronRightIcon,
        footerCard
      }
    })
    export default class EventPage extends Vue {

      /**
       * The constructor of the events page.
       */
      mounted() {
        performance.mark('eventLoadStart')
        this.getEvents()
      }

      // List of events to display
      events: EventType[] = []
      // Error message to display if API call fails
      error = ''
      // loading state of the page
      loading = true
      // The date to display in the calendar
      observedDate = new Date()
      // The calendar component and its reference function
      @Ref() readonly calendar!: {next: (amount?: number) => void, prev: (amount?: number) => void}

      /**
       * Gets the events from the API.
       * @public
       */
      getEvents (): void {
        this.loading = true
        fetch(process.env.NUXT_ENV_API_URL + '/events').then(res =>res.text()).then(res => {
          this.error = ''
          this.events = JSON.parse(res, (key: string, value: string) => {
            if (key === 'date') {
              return new Date(value)
            }
            return value
          })

          if(this.events[0]){
            this.observedDate = this.events[0].date
          }
        })
        .catch((err: Error) => {
          this.error = 'Sidan kunde inte nå servern'
          this.$ga.exception('(Events) ' + err.message)
          setTimeout(() => this.getEvents(), 5000)
        })
        .finally(() => {
          this.loading = false

          performance.mark('eventLoadEnd')
          performance.measure('eventLoad', 'eventLoadStart', 'eventLoadEnd')
          this.$ga.time('API Load', 'Events', Math.round(performance.getEntriesByName('eventLoad')[0].duration))
          performance.clearMarks()
          performance.clearMeasures()
        })
      }

      /**
       * Converts the events to a format that the calendar component can understand.
       * @public
       */
      getCalendarData(){
        const data: {start: Date, name?:string, id: number, timed?: boolean}[] = []

        for (const event of this.events) {
          data.push({
            id: event.id,
            start: event.date,
            name: event.title
          })
        }

        return data
      }

    /**
     * Scrolls to the event with the given id in the list. Is called when the calendar component has a click event.
     * @param event The clicked event to scroll to.
     * @public
     */
    onEventClick(event: {event: {id: number}}){
        this.$vuetify.goTo('#event' + event.event.id, {offset: 200})
      }
    }
</script>
