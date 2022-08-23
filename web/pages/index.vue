<template>
    <v-container>
      <v-row dense>
        <v-col cols="12" v-if="error">
          <v-card>
            <v-alert text color="error"> {{error}} </v-alert>
          </v-card>
        </v-col>

        <v-col cols="12" v-if="$vuetify.breakpoint.xsOnly && eventPreviews[0]">
          <v-card @click="$router.push('/events')" elevation="7">
            <v-alert style="margin: 0" color="primary" text>
              <strong>Nästa Event: </strong> {{eventPreviews[0].title + ' - ' + new Date(eventPreviews[0].date).toLocaleDateString('sv-SE', {weekday:'long', hour: '2-digit', minute: '2-digit', day: '2-digit', month: '2-digit'})}}
            </v-alert>
          </v-card>
        </v-col>

        <v-col cols="12" md="7" xl="6" align-self="stretch" style="display: flex; flex-flow: column;">

          <door-card v-model="doorInterval"/>

          <v-card :style=" $vuetify.breakpoint.xsOnly ? 'margin-bottom: 6px; order: -1; flex-grow: 1;' : 'margin-top: 6px; flex-grow: 1;'" elevation="6">
            <v-progress-circular indeterminate v-if="loading" color="primary" style="margin: 5px; width: 100%;"></v-progress-circular>
            <v-img v-bind:src="frontpageImg" v-if="!twitchLive" lazy-src="/img/unknown_group.webp" alt="unknown_group" height="100%" width="100%"></v-img>
            <iframe
              style="width: 100%; height: 100%; min-height: 500px;"
              v-if="twitchLive"
              src="https://player.twitch.tv/?channel=hdatorforening&parent=hd.chalmers.se&muted=false&autoplay=true"
              height="720"
              width="1280"
              allowfullscreen>
            </iframe>
          </v-card>
        </v-col>

        <v-col align-self="stretch">
          <v-card style="height: 100%;" elevation="6">
            <!--div class='embedsocial-stories' data-ref="38a5e7a2a8cfad426c0309f8b980fb9e23ca4fe9" style="display: inline-block; filter: drop-shadow(0 0 2px white); margin-top: 7px;"></div-->
            <v-card-title>
              <strong>Vad är <span style="color: #E0218A">H</span><span style="
                            color: black;
                            -webkit-text-stroke-width: 0.5px;
                            -webkit-text-stroke-color: white;
                          ">D</span>?</strong>
            </v-card-title>
            <v-card-text>
              <p>Vi arrar dator- och spelrelaterade (självklart även datorspelrelaterade) aktiviteter. Vårt paradnummer är 'Chilla med HD', ett event som hålls minst två gånger per läsperiod. Då spelar vi spel (brädspel, tv-spel,
                datorspel)
                och intar socker i olika former.</p>
              <p>Vi tillhandahåller även hjälp i diverse datorrelaterade kurser.</p>
              <p>Vi leverar socker samt högupplöst kärlek till alla och några till. Våra arr är alkoholfria, med undantag för våra spelpubar som vi har några gånger per år.</p>
              <p>Så om ni vill spela spel, ha hjälp med programmering eller bara få er en sockerchock är det oss ni ska vända er till.</p>
              <p>Vårt tillhåll är vid lilla FöreningsTorget i källaren av Svea-huset.</p>
              <!----<p>Vi håller till i katakomberna under Lindholmen.</p>----->
              <p><strong>TL;DR:</strong> Socker, spel, datorer, kakor, läsk, SOCKER!!1!</p>
            </v-card-text>
          </v-card>
          </v-col>

        <v-col cols="12" xl="3" align-self="stretch">
          <v-card id="eventCard" elevation="6">
            <v-card-title>
              <calendar-icon size="1x" style="margin-right: 5px;"/>
              Kommande Evenemang
            </v-card-title>
            <v-card-text>
              <v-card v-if="eventLoading" class="mb-3">
                <v-skeleton-loader type="article"></v-skeleton-loader>
              </v-card>
              <div v-if="!eventPreviews.length" style="margin-bottom: 30px;">
                Det finns inga evenemang inlagda just nu
              </div>
                <event-card v-for="event in eventPreviews" :key="event.id" style="margin: 10px 0;" elevation="5" compact
                        :title="event.title" :date="new Date(event.date)" :description="event.description" :facebook="event.facebook_event_link" :location="event.location"></event-card>
            </v-card-text>
              <v-btn style=" position: absolute; bottom: 0; width: 100%;" tile elevation="6" @click="$router.push('/events')">
                {{ eventPreviews.length ? `Se alla ${eventPreviews.length} evenemang`: 'Gå till evenemangs sidan'}}
                <arrow-right-icon style="margin-left: 5px;"/>
              </v-btn>
          </v-card>
        </v-col>

        <v-col cols="12">
          <footer-card class="elevation-6"/>
        </v-col>
      </v-row>
    </v-container>
</template>

<style>

  #eventCard{
    height: 100%;
    overflow-y: hidden;
    max-height: 650px;
  }

  @media  screen and (min-width: 2450px){
    #eventCard{
      max-height: 50vw;
    }
  }

</style>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import {EventType, FrontpageData, LiveStatus} from '@/assets/interfaces'
import { ArrowRightIcon, CalendarIcon } from 'vue-feather-icons'
import footerCard from '@/components/common/footerCard.vue'
import {NavigationGuardNext, Route} from "vue-router";

/**
 * The frontpage which shows group photos, description and events.
 */
@Component({
  components: {
    footerCard,
    ArrowRightIcon,
    CalendarIcon
  }
})
export default class IndexPage extends Vue {

  created(){
    this.timeout = undefined
    this.doorInterval = undefined
  }

  /**
   * The constructor. Gets the group photo and events from the server.
   */
  mounted() {
    performance.mark('frontLoadStart')
    this.getData()
    performance.mark('frontEventLoadStart')
    this.getLiveStatus()
    this.getEvents()

    //this.initSocialEmbed(document, "script", "EmbedSocialHashtagScript", "https://embedsocial.com/cdn/ht.js")
    //this.initSocialEmbed(document, "script", "EmbedSocialStoriesScript", "https://embedsocial.com/embedscript/st.js")
  }

  // The group photo link.
  frontpageImg = ''
  // Error message if any api call fails.
  error = ''
  // loading state for group photo
  loading = true
  // timeout if group photo is not loaded
  timeout: NodeJS.Timeout | undefined = 0 as any
  // interval for getting door status
  doorInterval: NodeJS.Timer | undefined = 0 as any

  // If HD is live
  twitchLive = false

  // Events to be displayed on the frontpage.
  eventPreviews: EventType[] = []
  // Loading state for events
  eventLoading = true

  /**
   * Cleans up the interval and timeout. When the user navigates away from the page.
   * @param to Route to the next page.
   * @param from Route navigated from.
   * @param next Function to call to navigate to the next page.
   */
  beforeRouteLeave(to: Route, from: Route, next: NavigationGuardNext): void {
    clearTimeout(this.timeout!)
    clearInterval(this.doorInterval!)
    next()
  }

  /**
   * Gets the group photo from the server.
   * @public
   */
  async getData(): Promise<void> {
    this.loading = true
    fetch(process.env.NUXT_ENV_API_URL + '/frontpage').then(res => res.json()).then((res: FrontpageData) => {
      this.error = ''

      this.frontpageImg = res.front_image ?? '/img/unknown_group.webp'
    })
      .catch((err: Error) => {
        this.error = 'Sidan hade svårigheter att nå servern'
        this.timeout = setTimeout(() => this.getData(), 3000)
        this.$ga.exception('(Front) ' + err.message)
      })
      .finally(() => {
        this.loading = false

        performance.mark('frontLoadEnd')
        performance.measure('frontLoad', 'frontLoadStart', 'frontLoadEnd')
        this.$ga.time('API Load', 'Frontpage', Math.round(performance.getEntriesByName('frontLoad')[0].duration))
        performance.clearMarks('frontLoadEnd')
        performance.clearMarks('frontLoadStart')
        performance.clearMeasures('frontLoad')
      })
  }

  async getLiveStatus(): Promise<void> {
    fetch(process.env.NUXT_ENV_API_URL + '/live').then(res => res.json()).then((res: LiveStatus) => {
      this.twitchLive = res.live
    })
  }

  /**
   * Gets the events from the server.
   * @public
   */
  getEvents(): void{
    this.eventLoading = true

    fetch(process.env.NUXT_ENV_API_URL + '/events')
    .then(res => res.json()).then((res: EventType[]) => {
      this.eventPreviews = res
    }).catch((err: Error) => this.$ga.exception('(Front-event) ' + err.message))
      .finally( () => {
        this.eventLoading = false

        performance.mark('frontEventLoadEnd')
        performance.measure('frontEventLoad', 'frontEventLoadStart', 'frontEventLoadEnd')
        this.$ga.time('API Load', 'Events', Math.round(performance.getEntriesByName('frontEventLoad')[0].duration))
        performance.clearMarks('frontEventLoadStart')
        performance.clearMarks('frontEventLoadEnd')
        performance.clearMeasures('frontEventLoad')
      })
  }
}
</script>
