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

    @Component
    export default class eventPage extends Vue{
      events: Array<eventType> = [
        {
        id: 1,
        date: new Date('2021-11-24 20:43'),
        title: 'Chilla med HD x3000',
        description: 'description',
        location: '',
        facebookLink: ''
      },
        {
          id: 2,
          date: new Date('2021-11-24 20:43'),
          title: 'Chilla med HD x3000',
          description: 'description',
          location: 'svea',
          facebookLink: 'link'
        },
        {
          id: 3,
          date: new Date('2021-11-24 20:43'),
          title: 'Chilla med HD x3000',
          description: 'description',
          location: 'inte svea',
          facebookLink: ''
        }
      ]
    }
</script>
