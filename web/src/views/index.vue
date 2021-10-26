<template>
    <v-container>
      <v-row dense>
        <v-col cols="12">
          <v-card>
          <v-alert v-ripple v-if="eventObj" text color="#e0218a" tile elevation="6" style="margin-bottom: 0; cursor: pointer; padding: 10px;" @click="$router.push('/events')">
            <v-row dense align="center">
              <v-col>
                <div style="margin: 0; display: inline-flex;" class="flex align-center">
                  <strong style="margin: 0; display: inline-block">Nästa Event: </strong>
                  <div style="display: inline-block; margin: 0 5px;" class="hidden-lg-and-up">
                    <p style="font-size: 0.75em; margin: 0; padding: 0;">{{ eventObj.title }}</p>
                    <p style="font-size: 0.75em; margin: 0; padding: 0;">{{ eventObj.date.toLocaleDateString('sv-SE', {weekday:'long', hour: '2-digit', minute: '2-digit', day: '2-digit', month: '2-digit'}) }}</p>
                  </div>
                  <p style="display: inline-block; margin: 0 5px; padding: 6px 0;" class="hidden-md-and-down">{{ eventObj.title + ' - ' + eventObj.date.toLocaleDateString('sv-SE', {weekday:'long', hour: '2-digit', minute: '2-digit', day: '2-digit', month: '2-digit'}) }}</p>
                </div>
              </v-col>
              <v-col v-if="eventAfter" class="hidden-xs-only">
                <div style="margin: 0; display: inline-flex;" class="flex align-center">
                  <strong style="margin: 0; display: inline-block">Därefter: </strong>
                  <div style="display: inline-block; margin: 0 5px;" class="hidden-lg-and-up">
                    <p style="font-size: 0.75em; margin: 0; padding: 0;">{{ eventAfter.title }}</p>
                    <p style="font-size: 0.75em; margin: 0; padding: 0;">{{ eventAfter.date.toLocaleDateString('sv-SE', {weekday:'long', hour: '2-digit', minute: '2-digit', day: '2-digit', month: '2-digit'}) }}</p>
                  </div>
                  <p style="display: inline-block; margin: 0 5px; padding: 6px 0;" class="hidden-md-and-down">{{ eventAfter.title + ' - ' + eventAfter.date.toLocaleDateString('sv-SE', {weekday:'long', hour: '2-digit', minute: '2-digit', day: '2-digit', month: '2-digit'}) }}</p>
                </div>
              </v-col>
              <v-col cols="2" sm="2"  v-if="eventCount || (eventAfter && $vuetify.breakpoint.xsOnly)" style="text-align: right">
                {{"+" + ($vuetify.breakpoint.xsOnly ? eventCount + 1: eventCount)}}
              </v-col>
            </v-row>
          </v-alert>
          <v-alert v-if="error" text color="error" style="margin-bottom: 0"> {{error}} </v-alert>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6" align-self="stretch" style="display: flex; flex-flow: column;">
          <v-card style="margin-bottom: 6px;" elevation="4">
            <v-progress-circular indeterminate v-if="loading" color="primary" style="margin: 5px; width: 100%;"></v-progress-circular>
            <v-img v-bind:src="frontpageImg" alt="unknown_group" contain></v-img>
          </v-card>
              <v-card @click="showDate()" style="cursor: default;" elevation="4">
                <v-card-text class="flex justify-space-between align-content-center" style="display: flex; align-items: center; transition: color 1s ease" id="doorCard">
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
              <footer-card class="hidden-xl-only hidden-xs-only" style="flex-grow: 1; margin-top: 6px;"/>
        </v-col>
        <v-col align-self="stretch">
          <v-card style="height: 100%;" elevation="4">
            <div class='embedsocial-stories' data-ref="38a5e7a2a8cfad426c0309f8b980fb9e23ca4fe9" style="display: inline-block;"></div>
            <v-card-title style="padding-top: 0;">
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

        <v-col cols="12" class="hidden-sm-only hidden-md-only hidden-lg-only">
          <footer-card/>
        </v-col>
        <v-col cols="12" align-self="start">
          <v-card id="feedCard" style="height: 100%;" elevation="3">
            <!--v-card-title style="transform: scaleY(2) translateY(5%);">
            <h3 style="display: flex; align-items: center;"><instagram-icon style="margin-right: 5px;"/> Instagram</h3>
            </v-card-title-->
            <v-card-text>
              <div class="embedsocial-hashtag" data-ref="7d09843251254063d8791fb6e0acc5f768a7d41a"></div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
</template>

<style>
.embedsocial-stories iframe {
  max-height: 80px;
}
/*
@media screen and (max-width: 1904px) and (min-width: 600px){
  #feedCard{
    width: 100%;
    max-width: 576px;
    transform: scale(1, 0.5) translateY(-50%);
    position: absolute;
    overflow: auto;
  }
  #feedCard .embedsocial-hashtag, #feedCard .embedsocial-stories{
    width: 200%;
    transform: scale(0.5, 1) translate(-50%, 0);
  }
}
@media screen and (max-width: 1264px) and (min-width: 600px){
  #feedCard{
    max-width: 434px;
  }
}

@media screen and (max-width: 960px) and (min-width: 600px){
  #feedCard{
    max-width: calc(50% - 16px);
    margin-right: 12px;
    max-height: calc(1200px * 2);
  }
}*/
</style>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import {FrontpageData, SimpleEventData} from '@/assets/ts/interfaces'
import { AlertCircleIcon, LockIcon, UnlockIcon, InstagramIcon } from 'vue-feather-icons'
import footerCard from '@/components/footerCard.vue'
import {NavigationGuardNext, Route} from "vue-router";

@Component({
  components: {
    LockIcon,
    UnlockIcon,
    AlertCircleIcon,
    footerCard,
    InstagramIcon
  }
})
export default class IndexPage extends Vue {
  constructor () {
    super()
    this.getData()
    this.getStatus()
    this.interval = setInterval(this.getStatus, 10000)

    this.initSocialEmbed(document, "script", "EmbedSocialHashtagScript", "https://embedsocial.com/cdn/ht.js")
    this.initSocialEmbed(document, "script", "EmbedSocialStoriesScript", "https://embedsocial.com/embedscript/st.js")
  }

  eventObj: SimpleEventData | null = null
  eventAfter: SimpleEventData | null = null
  eventCount = 0
  frontpageImg = ''
  error = ''
  loading = true
  interval: number
  timeout: number | undefined

  doorShowDate = false
  doorLoading = true
  doorState: boolean | null = null
  doorDuration = ''
  doorOpenTimestamp = '0000-00-00 00:00:00'
  doorIcon = 'mdi-alert-circle'
  doorColor: string | undefined = 'black'

  beforeRouteLeave(to: Route, from: Route, next: NavigationGuardNext): void {
    clearInterval(this.interval)
    clearTimeout(this.timeout)
    next()
  }

  async getData(): Promise<void>{
    this.loading = true
    fetch(process.env.VUE_APP_API_URL + '/frontpage').then(res =>res.json()).then((res: FrontpageData) => {
        this.error = ''
        this.eventObj = res.event ? {
          title: res.event.title,
          date: new Date(res.event.date)
      } : null

      this.eventAfter = res.event_after ? {
        title: res.event_after.title,
        date: new Date(res.event_after.date)
      } : null

      this.eventCount = res.event_count

      this.frontpageImg = res.front_image ?? '/img/unknown_group.png'
    })
    .catch(() => {
      this.error = 'Sidan hade svårigheter att nå servern'
      this.timeout = setTimeout(() => this.getData(), 3000)
    })
    .finally(() => this.loading = false)
  }

  initSocialEmbed(d: Document, s: string, id: string, src: string): void {
    let js
    const existing = d.getElementById(id)
    if (existing) {
      d.head.removeChild(existing)
      //console.log('removed')
    }
    js = d.createElement(s) as any
    js.id = id
    js.src = src
    d.getElementsByTagName("head")[0].appendChild(js)
  }

  getStatus (): void {
    fetch(process.env.VUE_APP_API_URL + '/door')
      .then(res => {
        if(res.ok) {
          return res.json()
        }
        else {
          this.doorState = null
          this.doorIcon = 'alert'
          this.doorColor = this.$vuetify.theme.currentTheme.warning?.toString()
          return null
        }
      }).then((res: {status: boolean | null, updated: string, duration_str: string, duration: number}) => {
      if(res) {
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
    }).catch(() => {
      this.doorState = null
      this.doorIcon = 'alert'
      this.doorColor = this.$vuetify.theme.currentTheme.warning?.toString()
    }).finally(() => {
      this.doorLoading = false
      this.setColor()
    })
  }

  showDate (): void {
    this.getStatus()
    this.doorShowDate = true
    setTimeout(() => this.doorShowDate = false, 3000)
  }

  setColor(): void {
      const door = document.getElementById('doorCard') as HTMLElement
      door.style.color = this.doorColor as string
  }

  checkStoryExist(): boolean{
    const result = (document.getElementsByClassName('embedsocial-iframe-story')[0]?.clientHeight ?? 0) > 0
    if(!document.getElementsByClassName('embedsocial-iframe-story')[0]){
      setTimeout(() => {
        //console.log('timeout tick')
        this.$forceUpdate()
      }, 500)
    }
    console.log(result)
    return result
  }
}
</script>
