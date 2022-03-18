<router>
{
  beforeEnter:
    (to, from, next) => {
      import('@/store/sessionStore').then(c => {
        if (c.SessionStore.getSessionId() === null) {
          next("/login")
        } else {
          next()
        }
      })
    }
}
</router>

<template>
  <v-container fluid>
    <v-toolbar
      flat
    >
      <v-btn
        outlined
        class="mr-4"
        @click="setToday"
      >
        Idag
      </v-btn>
      <v-btn
        fab
        text
        x-small
        @click="prev"
      >
        <v-icon small>
          mdi-chevron-left
        </v-icon>
      </v-btn>
      <v-btn
        fab
        text
        x-small
        @click="next"
      >
        <v-icon small>
          mdi-chevron-right
        </v-icon>
      </v-btn>
      <!--v-toolbar-title v-if="$refs.calendar">
        {{ $refs.calendar.title }}
      </v-toolbar-title-->
      <v-text-field outlined label="Kalender zoom" v-model="zoom" type="number" suffix="px" style="margin:  25px 5px 0 5px;" dense></v-text-field>
      <v-select :items="types" v-model="type" item-text="name" item-value="value" outlined label="Kalender intervall" dense style="margin-top: 25px;"></v-select>
    </v-toolbar>
    <v-calendar :events="logs" :type="type" v-model="focus" locale="sv" :weekdays="[1,2,3,4,5,6,0]" ref="calendar" :interval-height="zoom" locale-first-day-of-year="4"></v-calendar>
    <v-btn text outlined style="width: 100%; margin-top: 5px;" @click="getData" :loading="loading"> Ladda in mer data</v-btn>
  </v-container>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import {SessionStore} from "@/store/sessionStore";
import {LoehkDoorData, VCalendarEvent} from "@/assets/interfaces";

@Component({
  layout: "loehk"
})
export default class LoehkDoor extends Vue{
  constructor() {
    super()
    this.getData()
  }

  logs: VCalendarEvent[] = []
  offset = 0
  loading = true
  type = '4day'
  focus = ''
  zoom = 24
  types = [
    {name: 'Heldag', value: 'day'},
    {name: '4 Dagar', value: '4day'},
    {name: 'Vecka', value: 'week'},
    {name: 'Månad', value: 'month'}
  ]

  getData(): void {
    this.loading = true
    fetch(process.env.NUXT_ENV_API_URL + '/loehk/door' + (this.offset ? '/' + this.offset: ''),{
      headers:{
        Authorization: SessionStore.getSessionId() ?? ''
      }
    }).then(res => res.json()).then( (res: LoehkDoorData[]) => {
      for(const e of res){
        let end: Date
        if(this.logs.length === 0) {
          end = new Date()
        } else {
          end = this.logs[this.logs.length - 1].start
        }

        this.$set(this.logs, this.logs.length, {
          name: this.getStatus(e.status),
          start: new Date(e.timestamp),
          end: end,
          color: this.getColor(e.status),
          timed: true
        })
      }
    })
      .catch(() => this.$router.push('/login'))
    .finally(() => {
      this.offset++
      this.loading = false
    })
  }

  getStatus(s: boolean| null): string{
    if(s){
      return 'Öppen'
    } else if(s === false){
      return  'Stängd'
    } else {
      return 'Fick error'
    }
  }

  getColor(s: boolean| null): string{
    if(s){
      return 'success'
    } else if(s === false){
      return  'error'
    } else {
      return 'warning'
    }
  }

  viewDay (date: string): void {
    this.focus = date
    this.type = 'day'
  }
  setToday (): void {
    this.focus = ''
  }
  prev (): void {
    (this.$refs as any).calendar.prev()
  }
  next (): void {
    (this.$refs as any).calendar.next()
  }
}
</script>

<style scoped>

</style>
