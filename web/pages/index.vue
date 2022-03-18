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
            <v-alert style="margin: 0" color="accent" text>
              <strong>Nästa Event: </strong> {{eventPreviews[0].title + ' - ' + new Date(eventPreviews[0].date).toLocaleDateString('sv-SE', {weekday:'long', hour: '2-digit', minute: '2-digit', day: '2-digit', month: '2-digit'})}}
            </v-alert>
          </v-card>
        </v-col>

        <v-col cols="12" md="7" xl="6" align-self="stretch" style="display: flex; flex-flow: column;">
          <v-card @click="showDate()" style="cursor: default;" elevation="6">
            <v-card-text class="flex justify-space-between align-content-center" style="display: flex; align-items: center; transition: color 1s ease; height: 100%;" id="doorCard">
              <template v-if="!doorLoading">
                <v-scroll-x-transition leave-absolute>
                  <lock-icon v-if="doorIcon === 'lock'"/>
                </v-scroll-x-transition>
                <v-scroll-x-transition leave-absolute>
                  <unlock-icon v-if="doorIcon === 'unlock'"/>
                </v-scroll-x-transition>
                <v-scroll-x-transition leave-absolute>
                  <alert-circle-icon v-if="doorIcon === 'alert'"/>
                </v-scroll-x-transition>
                <v-scroll-x-transition leave-absolute>
                  <span v-if="!doorShowDate">Hoppas du har en bra dag :)</span>
                </v-scroll-x-transition>
                <v-scroll-x-transition leave-absolute>
                  <span v-if="doorShowDate" style="line-height: 12px; font-size: 11px; text-align: right;">{{doorOpenTimestamp}} <br> ca {{doorDuration}} sedan</span>
                </v-scroll-x-transition>
              </template>
              <template v-if="doorLoading">
                <v-progress-circular indeterminate color="primary"></v-progress-circular>
                <v-skeleton-loader style="width: 20vw;" type="text"></v-skeleton-loader>
              </template>
            </v-card-text>
          </v-card>

          <v-card :style=" $vuetify.breakpoint.xsOnly ? 'margin-bottom: 6px; order: -1; flex-grow: 1;' : 'margin-top: 6px; flex-grow: 1;'" elevation="6">
            <v-progress-circular indeterminate v-if="loading" color="primary" style="margin: 5px; width: 100%;"></v-progress-circular>
            <v-img v-bind:src="frontpageImg" lazy-src="/img/unknown_group.webp" alt="unknown_group" height="100%" width="100%"></v-img>
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
                <v-card v-for="event in eventPreviews" :key="event.id" style="margin: 10px 0;" elevation="5">
                  <v-card-title>
                    <h5>
                      {{event.title}}

                      <v-btn v-if="event.facebook_event_link" style="background-color: transparent;" icon color="blue" target="_blank" v-bind:href="event.facebook_event_link" @click="$analytics.trackEvent('Events', 'Frontpage Facebook click')">
                        <facebook-icon/>
                      </v-btn>
                    </h5>
                  </v-card-title>
                  <v-card-subtitle style="padding-bottom: 0;">
                    <h3>
                      {{ new Date(event.date).toLocaleString('sv', {
                      year: 'numeric',
                      month: 'numeric',
                      day: 'numeric',
                      hour: '2-digit',
                      minute: '2-digit'
                    })}}
                    </h3>
                  </v-card-subtitle>
                    <v-list v-if="event.location || event.description">
                                <v-list-item v-if="event.location || event.description">
                                  <v-list-item-subtitle>
                                    <span v-if="event.location" style="margin-right: 10px;">
                                      <map-pin-icon size="1x"/>
                                        Plats: {{event.location}}
                                    </span>

                                    <span v-if="event.description">
                                      <align-left-icon size="1x" style="margin-right: 5px;"/>
                                      {{event.description}}
                                    </span>
                      </v-list-item-subtitle>
                    </v-list-item>
                    </v-list>
                </v-card>
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
    max-height: 550px;
  }

  @media  screen and (min-width: 2450px){
    #eventCard{
      max-height: 50vw;
    }
  }

</style>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import {EventType, FrontpageData} from '@/assets/interfaces'
import { AlertCircleIcon, LockIcon, UnlockIcon, FacebookIcon, MapPinIcon, AlignLeftIcon, ArrowRightIcon, CalendarIcon } from 'vue-feather-icons'
import footerCard from '@/components/common/footerCard.vue'
import {NavigationGuardNext, Route} from "vue-router";

@Component({
  components: {
    LockIcon,
    UnlockIcon,
    AlertCircleIcon,
    footerCard,
    FacebookIcon,
    MapPinIcon,
    AlignLeftIcon,
    ArrowRightIcon,
    CalendarIcon
  }
})
export default class IndexPage extends Vue {
  constructor() {
    super()
    performance.mark('frontLoadStart')
    this.getData()
    performance.mark('frontEventLoadStart')
    this.getEvents()
    this.getStatus()

    this.interval = setInterval(this.getStatus, 10000);

    //this.initSocialEmbed(document, "script", "EmbedSocialHashtagScript", "https://embedsocial.com/cdn/ht.js")
    //this.initSocialEmbed(document, "script", "EmbedSocialStoriesScript", "https://embedsocial.com/embedscript/st.js")
  }


  frontpageImg = ''
  error = ''
  loading = true
  interval: NodeJS.Timer
  timeout: NodeJS.Timeout | undefined

  doorShowDate = false
  doorLoading = true
  doorState: boolean | null = null
  doorDuration = ''
  doorOpenTimestamp = '0000-00-00 00:00:00'
  doorIcon = 'mdi-alert-circle'
  doorColor: string | undefined = 'black'

  eventPreviews: EventType[] = []
  eventRemaining = 0
  eventLoading = true

  beforeRouteLeave(to: Route, from: Route, next: NavigationGuardNext): void {
    clearInterval(this.interval)
    clearTimeout(this.timeout!)
    next()
  }

  async getData(): Promise<void> {
    this.loading = true
    fetch(process.env.NUXT_ENV_API_URL + '/frontpage').then(res => res.json()).then((res: FrontpageData) => {
      this.error = ''

      this.frontpageImg = res.front_image ?? '/img/unknown_group.webp'
    })
      .catch((err: Error) => {
        this.error = 'Sidan hade svårigheter att nå servern'
        this.timeout = setTimeout(() => this.getData(), 3000)
        // this.$analytics.trackException('(Front) ' + err.message)
      })
      .finally(() => {
        this.loading = false

        performance.mark('frontLoadEnd')
        performance.measure('frontLoad', 'frontLoadStart', 'frontLoadEnd')
        // this.$analytics.trackTiming('API Load', 'Frontpage', Math.round(performance.getEntriesByName('frontLoad')[0].duration))
        performance.clearMarks('frontLoadEnd')
        performance.clearMarks('frontLoadStart')
        performance.clearMeasures('frontLoad')
      })
  }

  getStatus(): void {
    fetch(process.env.NUXT_ENV_API_URL + '/door')
      .then(res => {
        if (res.ok) {
          return res.json()
        } else {
          this.doorState = null
          this.doorIcon = 'alert'
          this.doorColor = this.$vuetify.theme.currentTheme.warning?.toString()
          return null
        }
      }).then((res: { status: boolean | null, updated: string, duration_str: string, duration: number }) => {
      if (res) {
        this.doorState = res.status
        this.doorOpenTimestamp = res.updated
        this.doorDuration = res.duration_str
        if (res.status) {
          this.doorIcon = 'unlock'
          this.doorColor = this.$vuetify.theme.currentTheme.success?.toString()
        } else if (res.status === null) {
          this.doorState = null
          this.doorIcon = 'alert'
          this.doorColor = this.$vuetify.theme.currentTheme.warning?.toString()
        } else {
          this.doorIcon = 'lock'
          this.doorColor = this.$vuetify.theme.currentTheme.error?.toString()
        }
      }
    }).catch((err: Error) => {
      this.doorState = null
      this.doorIcon = 'alert'
      this.doorColor = this.$vuetify.theme.currentTheme.warning?.toString()

      // this.$analytics.trackException('(Door) ' + err.message)
    }).finally(() => {
      this.doorLoading = false
      this.setColor()
    })
  }

  getEvents(): void{
    this.eventLoading = true

    fetch(process.env.NUXT_ENV_API_URL + '/events')
    .then(res => res.json()).then((res: EventType[]) => {
      this.eventPreviews = res
    })//.catch((err: Error) => this.$analytics.trackException('(Front-event) ' + err.message))
      .finally( () => {
        this.eventLoading = false

        performance.mark('frontEventLoadEnd')
        performance.measure('frontEventLoad', 'frontEventLoadStart', 'frontEventLoadEnd')
        // this.$analytics.trackTiming('API Load', 'Events', Math.round(performance.getEntriesByName('frontEventLoad')[0].duration))
        performance.clearMarks('frontEventLoadStart')
        performance.clearMarks('frontEventLoadEnd')
        performance.clearMeasures('frontEventLoad')
      })
  }

  showDate(): void {
    this.getStatus()
    this.doorShowDate = true
    setTimeout(() => this.doorShowDate = false, 3000)

    // this.$analytics.trackEvent('Door', 'Reveal timestamp')
  }

  setColor(): void {
    const door = document.getElementById('doorCard') as HTMLElement
    door.style.color = this.doorColor as string

  }
}
</script>
