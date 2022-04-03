<template>
    <v-container>
        <v-card :loading="loading" class="mb-3" elevation="7">
          <v-alert v-if="error" text color="error">{{error}}</v-alert>
            <v-card-title>
              <h3> Kommande Arrangemang </h3>
            </v-card-title>
            <v-card-text>
              Varje läsperiod så sker Chilla med HD i läsvecka 2 & 6 medan Spelpuben sker i läsvecka 4.
            </v-card-text>
            <v-card-text v-if="!events[0] && !loading">
              <span>Inga arrangemang är just nu inlagda</span>
            </v-card-text>
        </v-card>
      <v-card v-if="loading" class="mb-3">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-card>
                    <event-card v-for="event in events" v-bind:key="event.id" class="mb-3"
                                :title="event.title" :date="event.date" :description="event.description" :facebook="event.facebook_event_link" :location="event.location">

                    </event-card>
      <footer-card class="elevation-6"/>
    </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { EventType } from '@/assets/interfaces'
import footerCard from '@/components/common/footerCard.vue'

@Component({
      components: {
        footerCard
      }
    })
    export default class EventPage extends Vue {
      constructor () {
        super();

        performance.mark('eventLoadStart')
        this.getEvents()
      }

      events: EventType[] = []
      error = ''
      loading = true
      getEvents (): void {
        this.loading = true
        fetch(process.env.NUXT_ENV_API_URL + '/events').then(res =>res.text()).then(res => {
          this.error = ''
          this.events = JSON.parse(res, (key: string, value: any) => {
            if (key === 'date') {
              return new Date(value)
            }
            return value
          })
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
    }
</script>
