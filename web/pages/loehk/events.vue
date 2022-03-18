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
  <v-card :loading="loading">
    <v-card-title>
      <v-row>
        <v-col cols="12" md="7">
          <v-select v-model="event" :items="allEvents" :loading="this.isLoading('newEvent')" item-text="title"
                    item-value="id" label="Event" return-object @input="reset" outlined>
            <template v-slot:prepend-inner> <ListIcon size="1.4x"/> </template>
            <template v-slot:item="
                          // eslint-disable-next-line vue/no-unused-vars
                          {parent, item, on, attrs}">
              {{ item.date }} {{ item.time }} - {{ item.title }}
            </template>
            <template v-slot:selection="
                          /* eslint-disable-next-line vue/no-unused-vars */
                          {parent, item, index, select, selected, disabled}">
              {{ item.date }} {{ item.time }} - {{ item.title }}
            </template>
          </v-select>
        </v-col>
        <v-col style="min-width: 215px;">
          <v-switch v-if="event && event.id !== -1" v-model="event.show_on_frontpage" :error-messages="hasError('show_on_frontpage')"
                    :loading="isLoading('show_on_frontpage')"
                    :success-messages="hasSuccessMessage('show_on_frontpage')"
                    class="my-auto mr-1" label="Visa på sidan"
                    style="display: inline-block;"
                    @change="updateField('show_on_frontpage')"></v-switch>
          <v-btn v-if="event && event.id !== -1" :color="hasError('deleteEvent')? 'error' : 'inherit'" :loading="isLoading('deleteEvent')"
                 class="mr-2" icon @click="deleteEvent">
            <trash-icon/>
            <span v-if="hasError('deleteEvent')"
                  :style="`color: ${$vuetify.theme.currentTheme.error}; position: absolute; bottom: -30px;`">{{ hasError('deleteEvent') }}</span>
          </v-btn>
        </v-col>
        <v-col>
          <v-btn :color="hasError('newEvent')? 'error' : 'inherit'" :loading="isLoading('newEvent')"
                 @click="addNewEvent()" style="width: 100%; margin: 0;">
            Nytt Event
            <span v-if="hasError('newEvent')"
                  :style="`color: ${$vuetify.theme.currentTheme.error}; position: absolute; bottom: -30px;`">{{ hasError('newEvent') }}</span>
          </v-btn>
        </v-col>
      </v-row>
    </v-card-title>
    <v-card-text v-if="event && event.id !== -1">
      <v-row>
        <v-col cols="12" md="4" lg>
          <v-text-field v-model="event.title" :error-messages="hasError('title')" :loading="isLoading('title')"
                        :success-messages="hasSuccessMessage('title')"
                        label="Titel" @input="updateField('title')">
            <template v-slot:prepend> <type-icon/> </template>
          </v-text-field>
        </v-col>
        <v-col cols="12" md="4" lg>
          <v-menu
            ref="dateMenu"
            v-model="dateMenu"
            :close-on-content-click="false"
            :return-value.sync="event.date"
            max-width="290px"
            offset-y
            transition="scale-transition"
            @update:return-value="saveDate"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="event.date"
                :error-messages="hasError('date')"
                :loading="isLoading('date')"
                :success-messages="hasSuccessMessage('date')"
                label="Datum"
                readonly
                v-bind="attrs"
                v-on="on"
              >
                <template v-slot:prepend> <CalendarIcon/> </template>
              </v-text-field>
            </template>
            <v-date-picker
              v-model="event.date"
              no-title
              scrollable
              type="date"
            >
              <v-spacer></v-spacer>
              <v-btn color="primary" text @click="dateMenu = ''">Cancel</v-btn>
              <v-btn color="primary" text @click="$refs.dateMenu.save(event.date)">OK</v-btn>
            </v-date-picker>
          </v-menu>
        </v-col>
        <v-col cols="12" md="4" lg>
          <v-menu
            ref="timeMenu"
            v-model="timeMenu"
            :close-on-content-click="false"
            :return-value.sync="event.time"
            max-width="290px"
            offset-y
            transition="scale-transition"
            @update:return-value="saveTime"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="event.time"
                :error-messages="hasError('time')"
                :loading="isLoading('time')"
                :success-messages="hasSuccessMessage('time')"
                label="Tid"
                readonly
                v-bind="attrs"
                v-on="on"
              >
                <template v-slot:prepend> <clock-icon/> </template>
              </v-text-field>
            </template>
            <v-time-picker
              v-model="event.time"
              format="24hr"
              no-title
              scrollable
            >
              <v-spacer></v-spacer>
              <v-btn color="primary" text @click="timeMenu = ''">Cancel</v-btn>
              <v-btn color="primary" text @click="$refs.timeMenu.save(event.time)">OK</v-btn>
            </v-time-picker>
          </v-menu>
        </v-col>
        <v-col cols="12" md="6" lg>
          <v-text-field v-model="event.location" :error-messages="hasError('location')" :loading="isLoading('location')"
                        :success-messages="hasSuccessMessage('location')" label="Plats"
                        @input="updateField('location')">
            <template v-slot:prepend> <map-pin-icon/> </template>
          </v-text-field>
        </v-col>
        <v-col cols="12" md="6" lg>
          <v-text-field v-model="event.facebook_event_link" :error-messages="hasError('facebook_event_link')" :loading="isLoading('facebook_event_link')"
                        :success-messages="hasSuccessMessage('facebook_event_link')"
                        label="Facebook Länk"
                        @input="updateField('facebook_event_link')">
            <template v-slot:prepend> <facebook-icon/> </template>
          </v-text-field>
        </v-col>
        <v-col cols="12">
          <v-textarea v-model="event.description" :error-messages="hasError('description')" :loading="isLoading('description')"
                      :success-messages="hasSuccessMessage('description')" label="Beskrivning"
                      @input="updateField('description')" outlined>
            <template v-slot:prepend> <align-left-icon/> </template>
          </v-textarea>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script lang="ts">

import Vue from 'vue'
import Component from "vue-class-component";
import {EventPropsData} from "@/assets/interfaces";
import { TypeIcon, CalendarIcon, ClockIcon, MapPinIcon, FacebookIcon, AlignLeftIcon, ListIcon, TrashIcon } from "vue-feather-icons";
import {SessionStore} from "@/store/sessionStore";

@Component({
  components:{
    TypeIcon,
    CalendarIcon,
    ClockIcon,
    MapPinIcon,
    FacebookIcon,
    AlignLeftIcon,
    ListIcon,
    TrashIcon
  },
  layout: "loehk"
})
export default class LoehkEvents extends Vue {
  constructor() {
    super()
    this.getEvents()
  }

  loading = false
  //state = import('@/assets/ts/sessionStore')
  defaultEvent: EventPropsData = {
    title: 'Nytt Event',
    description: '',
    location: '',
    show_on_frontpage: false,
    facebook_event_link: '',
    date: new Date().toISOString().substr(0, 10),
    time: '17:00',
  }
  event: EventPropsData = {
    id: -1,
    title: 'Nytt Event',
    description: '',
    location: '',
    show_on_frontpage: false,
    facebook_event_link: '',
    date: new Date().toISOString().substr(0, 10),
    time: '17:00',
  }
  load: boolean[] = []
  message: string[] = []
  errors: string[] = []
  allEvents: EventPropsData[] = []
  dateMenu: string | null = null
  timeMenu: string | null = null
  _updateField: NodeJS.Timeout | undefined

  saveTime(): void {
    this.$set(this.load, 'time', true);
    this.$set(this.errors, 'time', '')
    //this.state.then((obj) => {
      fetch(process.env.NUXT_ENV_API_URL + `/loehk/events/${this.event.id}`, {

        // Adding method type
        method: "PATCH",

        // Adding body or contents to send
        body: JSON.stringify({
          time: this.event.time
        }),

        // Adding headers to the request
        headers: {
          "Content-type": "application/json; charset=UTF-8",
          Authorization: SessionStore.getSessionId() ?? ""
        }
      })
        // Convey success
        .then(res => {
          if (res.ok) {
            this.$set(this.message, 'time', 'Success!');
          } else {
            if (res.status === 403) {
              this.$set(this.errors, 'time', 'utloggad, refresh?')
            } else {
              this.$set(this.errors, 'time', 'servern stötte på ett problem när den försökte hantera datan')
            }
          }
        }).catch(() => {
        this.$set(this.errors, 'time', 'kunde inte nå servern')
      }).finally(() => {
        this.$set(this.load, 'time', false);
      })
    //})
  }

  saveDate(): void {
    this.$set(this.load, 'date', true);
    this.$set(this.errors, 'date', '')
    //this.state.then(obj => {
      fetch(process.env.NUXT_ENV_API_URL + `/loehk/events/${this.event.id}`, {

        // Adding method type
        method: "PATCH",

        // Adding body or contents to send
        body: JSON.stringify({
          date: this.event.date
        }),

        // Adding headers to the request
        headers: {
          "Content-type": "application/json; charset=UTF-8",
          Authorization: SessionStore.getSessionId() ?? ""
        }
      })
        // Convey success
        .then(res => {
          if (res.ok) {
            this.$set(this.message, 'date', 'Success!');
          } else {
            if (res.status === 403) {
              this.$set(this.errors, 'date', 'utloggad, refresh?')
            } else {
              this.$set(this.errors, 'date', 'servern stötte på ett problem när den försökte hantera datan')
            }
          }
        }).catch((err) => {
        this.$set(this.errors, 'date', 'kunde inte nå servern')
        console.error(err)
      }).finally(() => {
        this.$set(this.load, 'date', false);
      })
    //})
  }

  isLoading(id: any): boolean {
    if (this.load[id]) {
      return this.load[id]
    }
    return false;
  }

  hasSuccessMessage(id: any): string {
    if (this.message[id]) {
      return this.message[id]
    }
    return '';
  }

  hasError(id: any): string {
    if (this.errors[id]) {
      return this.errors[id]
    }
    return ''
  }

  updateField(fieldname: "title" | "description" | "location" | "facebook_event_link" | "show_on_frontpage"): void {
    this.$set(this.message, fieldname, '')
    this.$set(this.errors, fieldname, '')
    this.$set(this.load, fieldname, true);
    clearTimeout(this._updateField!);
    this._updateField = setTimeout(() => {
      this.doUpdateField(fieldname)
    }, 500)
  }

  doUpdateField(fieldname: "title" | "description" | "location" | "facebook_event_link" | "show_on_frontpage"): void {
    this.$set(this.load, fieldname, true);
    this.$set(this.message, fieldname, '')
    this.$set(this.errors, fieldname, '')
    let value = this.event[fieldname];
    if (value === null || value === 'null') {
      return;
    }

    // Prepare for conversion to json
    let dataObj = {} as any;
    dataObj[fieldname] = this.event[fieldname]
    /*
      if (fieldname === 'image') {
          data.append(fieldname, this.event[fieldname], fieldname);
      } else {
          data.append(fieldname, this.event[fieldname]);
      }*/
    //this.state.then(obj => {
      fetch(process.env.NUXT_ENV_API_URL + `/loehk/events/${this.event.id}`, {

        // Adding method type
        method: "PATCH",

        // Convert to JSON and send
        body: JSON.stringify(dataObj),

        // Adding headers to the request
        headers: {
          "Content-type": "application/json; charset=UTF-8",
          Authorization: SessionStore.getSessionId() ?? ""
        }
      })
        // Convey success
        .then(res => {
          if (res.ok) {
            this.$set(this.message, fieldname, 'Success!')
          } else {
            if (res.status === 403) {
              this.$set(this.errors, fieldname, 'utloggad, refresh?')
            } else {
              this.$set(this.errors, fieldname, 'servern stötte på ett problem när den försökte hantera datan')
            }
          }
        }).catch((err) => {
        this.$set(this.errors, fieldname, 'kunde inte nå servern')
        console.error(err)
      }).finally(() => {
        this.$set(this.load, fieldname, false);
      })
    //})
  }

  getEvents(): void {
    this.loading = true
    //this.state.then((obj) => {
      fetch(process.env.NUXT_ENV_API_URL + '/loehk/events', {
        headers: {
          Authorization: SessionStore.getSessionId() ?? ""
        }
      })
        .then(res => res.json()).then((res: EventPropsData[]) => {
        this.allEvents = res
        this.event = this.allEvents[this.allEvents.length - 1];
      }).catch(() => {
        console.log('login failed')
        this.$router.push('/login')
      }).finally(() => {
        this.$set(this, "loading", false);
      })
    //})
  }

  deleteEvent(): void {
    this.$set(this.load, "deleteEvent", true);
    this.$set(this.message, "deleteEvent", '');
    this.$set(this.errors, 'deleteEvent', '')
    //this.state.then(obj => {
      fetch(process.env.NUXT_ENV_API_URL + `/loehk/events/${this.event.id}`, {

        // Adding method type
        method: "DELETE",

        // Adding headers to the request
        headers: {
          "Content-type": "application/json; charset=UTF-8",
          Authorization: SessionStore.getSessionId() ?? ""
        }
      })
        // Convey success
        .then(res => {
          if (res.ok) {
            this.$set(this.message, "deleteEvent", 'Success!');
            this.getEvents();
          } else {
            if (res.status === 403) {
              this.$set(this.errors, 'deleteEvent', 'utloggad, refresh?')
            } else {
              this.$set(this.errors, 'deleteEvent', 'servern stötte på ett problem när den försökte hantera datan')
            }
          }
        }).catch(() => {
        this.$set(this.errors, 'deleteEvent', 'kunde inte nå servern')
      }).finally(() => {
        this.$set(this.load, "deleteEvent", false);
      })
   //})
  }

  addNewEvent(): void {
    this.$set(this.errors, 'newEvent', '')

    //this.state.then(obj => {
      fetch(process.env.NUXT_ENV_API_URL + `/loehk/events`, {

        // Adding method type
        method: "POST",

        // Convert to JSON and send
        body: JSON.stringify(this.defaultEvent),

        // Adding headers to the request
        headers: {
          "Content-type": "application/json; charset=UTF-8",
          Authorization: SessionStore.getSessionId() ?? ""
        }
      })
        // Convert to JSON and convey success
        .then(res => {
          if (res.ok) {
            this.$set(this.message, "newEvent", 'Success!');
            return res.json()
          } else {
            if (res.status === 403) {
              this.$set(this.errors, 'newEvent', 'utloggad, refresh?')
            } else {
              this.$set(this.errors, 'newEvent', 'servern stötte på ett problem när den försökte hantera datan')
            }
            return null
          }
        })
        .then(res => {
          if (res) {
            let i = this.allEvents.push(res);
            this.event = this.allEvents[i - 1];
          }
        })
        .catch((err) => {
          this.$set(this.errors, 'newEvent', 'servern kunde inte nås')
          console.error(err)
        })
        .finally(() => {
          this.$set(this.load, "newEvent", false);
        })
    //})
  }

  reset(): void {
    this.load = []
    this.message = []
  }
}
</script>

<style scoped>

</style>
