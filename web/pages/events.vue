<template>
    <v-container>
        <v-card :loading="loading" class="mb-3" elevation="7">
          <v-alert v-if="error" text color="error">{{error}}</v-alert>
            <v-card-title>
              <h3> Kommande Arrangemang </h3>
            </v-card-title>
            <v-card-text v-if="!events[0] && !loading">
              <span>Inga arrangemang är just nu inlagda</span>
            </v-card-text>
        </v-card>
      <v-card v-if="loading" class="mb-3">
        <v-skeleton-loader type="article"></v-skeleton-loader>
      </v-card>
                    <v-card v-for="event in events" v-bind:key="event.id" class="mb-3" elevation="6">
                        <v-card-title>
                          <h5>
                             {{event.title}}


                                <v-btn v-if="event.facebook_event_link" style="background-color: transparent;" icon color="blue" target="_blank" @click="$analytics.trackEvent('Events', 'Events Facebook click')" v-bind:href="event.facebook_event_link">
                                    <facebook-icon/>
                                </v-btn>
                          </h5>
                        </v-card-title>
                        <v-card-subtitle>
                          <h3>
                            {{event.date.toLocaleString('sv', {
                            year: 'numeric',
                            month: 'numeric',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                          })}}
                          </h3>
                        </v-card-subtitle>
                        <v-card-text v-if="event.location || event.description">
                                <span v-if="event.location">
                                  <map-pin-icon size="1x"/>
                                    Plats: {{event.location}}<br/><br/>
                                </span>
                              <span v-if="event.description" style="display: flex; align-items: center;">
                                <align-left-icon size="1x" style="margin-right: 5px;"/>
                                {{event.description}}
                              </span>
                        </v-card-text>
                    </v-card>
      <footer-card class="elevation-6"/>
    </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { EventType } from '@/assets/interfaces'
import footerCard from '@/components/common/footerCard.vue'
import {FacebookIcon, MapPinIcon, AlignLeftIcon} from 'vue-feather-icons'

@Component({
      components: {
        footerCard,
        FacebookIcon,
        MapPinIcon,
        AlignLeftIcon
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
        .catch(() => {
          this.error = 'Sidan kunde inte nå servern'
          setTimeout(() => this.getEvents(), 5000)
        })
        .finally(() => {
          this.loading = false

          performance.mark('eventLoadEnd')
          performance.measure('eventLoad', 'eventLoadStart', 'eventLoadEnd')
          //this.$analytics.trackTiming('API Load', 'Events', Math.round(performance.getEntriesByName('eventLoad')[0].duration))
          performance.clearMarks()
          performance.clearMeasures()
        })
      }
    }
</script>
