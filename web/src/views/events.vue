<template>
    <v-container>
        <v-card>
            <v-card-title>
                Kommande Arrangemang
            </v-card-title>
            <v-card-text>
                    <v-card v-for="event in events" v-bind:key="event.id" class="mb-3" elevation="5">
                        <v-card-title>
                            {{event.date.toLocaleDateString('sv-SE', {
                              year: 'numeric',
                              month: 'numeric',
                              day: 'numeric',
                              hour: '2-digit',
                              minute: '2-digit'
                            })}} - {{event.title}}


                                <v-btn v-if="event.facebookLink" icon v-bind:href="event.facebookLink">
                                    <v-icon>mdi-facebook</v-icon>
                                </v-btn>
                        </v-card-title>
                        <v-card-text>
                            <span v-if="event.location">
                                Plats: {{event.location}}<br/><br/>
                            </span>
                            {{event.description}}
                        </v-card-text>
                    </v-card>
                <span v-if="!events[0]">Inga arrangemang är just nu inlagda</span>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { eventType } from '@/assets/ts/interfaces'
//import axios from 'axios'

    @Component
    export default class EventPage extends Vue {
      constructor () {
        super();
        this.getEvents()
      }
      events: eventType[] = []
      getEvents (): void {
        fetch('http://localhost:8000/events').then(res =>res.text()).then(res => {
          this.events = JSON.parse(res, (key: string, value: any) => {
            if (key == 'date') {
              return new Date(value)
            }
            return value
          }) as eventType[]
        })
      }
    }
</script>
