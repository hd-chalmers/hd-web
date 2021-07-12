<template>
    <v-container>
        <v-card tile>
                <v-alert v-if="eventObj.title" text color="#e0218a" tile elevation="2">
                    <strong>Nästa Event: </strong>
                    {{
                      eventObj.date.toLocaleDateString('sv-SE', {weekday:'long', day: '2-digit', month: 'long'})
                      + ' - ' + eventObj.title
                  }}
                </v-alert>
            <v-card-text>
                <v-row>
                    <v-col class="hidden-sm-and-down" cols="2" md="1" lg="2" xl="3"></v-col>
                    <v-col cols="12" md="10" lg="8" xl="6">
                        <v-img v-bind:src="frontpageImg" alt="unknown_group" contain></v-img>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col>
                        <h2><strong>Vad är <span style="color: #E0218A">H</span><span style="
                            color: black;
                            -webkit-text-stroke-width: 0.5px;
                            -webkit-text-stroke-color: white;
                          ">D</span>?</strong></h2>
                        <p>Vi arrar dator- och spelrelaterade (självklart även datorspelrelaterade) aktiviteter. Vårt paradnummer är 'Chilla med HD', ett event som hålls minst två gånger per läsperiod. Då spelar vi spel (brädspel, tv-spel,
                            datorspel)
                            och intar socker i olika former.</p>
                        <p>Vi tillhandahåller även hjälp i diverse datorrelaterade kurser.</p>
                        <p>Vi leverar socker samt högupplöst kärlek till alla och några till. Våra arr är alkoholfria, med undantag för våra spelpubar som vi har några gånger per år.</p>
                        <p>Så om ni vill spela spel, ha hjälp med programmering eller bara få er en sockerchock är det oss ni ska vända er till.</p>
                        <p>Vårt tillhåll är vid lilla FöreningsTorget i källaren av Svea-huset.</p>
                        <!----<p>Vi håller till i katakomberna under Lindholmen.</p>----->
                        <p><strong>TL;DR:</strong> Socker, spel, datorer, kakor, läsk, SOCKER!!1!</p>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { eventType } from '@/assets/ts/interfaces'

@Component
export default class IndexPage extends Vue {
  constructor () {
    super();
    this.getData()
  }
  eventObj: eventType = {
    date: new Date(),
    description: '',
    facebookLink: '',
    id: 0,
    location: '',
    title: ''
  }
  frontpageImg = ''
  async getData(): Promise<void>{
    fetch(process.env.VUE_APP_API_URL + '/frontpage').then(res =>res.json()).then(res => {
        this.eventObj = {
          title: res.event.title,
          date: new Date(res.event.date),
          description: '',
          facebookLink: '',
          id: 0,
          location: ''
      }
      this.frontpageImg = res.frontpageImg ?? '/img/unknown_group.png'
    })
  }
}
</script>
